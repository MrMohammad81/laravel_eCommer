<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Services\Cart\CartServices;
use App\Services\Sessions\SessionService;
use App\Utilities\CheckPaymentInformation\CheckPaymentInformation;
use App\Utilities\Validators\Auth\AuthValidator;
use Illuminate\Http\Request;
use App\Utilities\Validators\Payments\PayGetWay\PayValidator;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $validator = PayValidator::checkPayData($request);

        if ($validator->fails())
        {
            alert()->warning('' , 'انتخاب آدرس تحویل سفارش الزامی میباشد')->showConfirmButton('تایید');
            return redirect()->back();
        }

        $checkCart = CartServices::checkCart();
        if (array_key_exists('error' , $checkCart ?? []))
        {
            alert()->warning('' , $checkCart['error']);
            return redirect()->back();
        }

        $amounts = CheckPaymentInformation::getAmounts();
        if (array_key_exists('error' , $amounts ?? []))
        {
            alert()->warning('' , $amounts['error']);
            return redirect()->back();
        }

        $api = 'test';
        $amount = $amounts['paying_amount'];
        $redirect = route('home.paymentVerify');
        $result = $this->send($api, $amount, $redirect);
        $result = json_decode($result);
        if($result->status) {

            $createdOrder = $this->createOrder($request->address_id,$amounts,$result->token,'pay');
            if (array_key_exists('error' , $createdOrder ?? []))
            {
                alert()->warning('' , $createdOrder['error']);
                return redirect()->back();
            }

            $go = "https://pay.ir/pg/$result->token";
            return redirect()->to($go);
        } else {
            echo $result->errorMessage;
        }

    }

    public function paymentVerify(Request $request)
    {
        $api = 'test';
        $token = $request->token;
        $result = json_decode($this->verify($api, $token));
        if(isset($result->status))
        {
            if($result->status == 1) {
                echo "<h1>تراکنش با موفقیت انجام شد</h1>";
            } else {
                echo "<h1>تراکنش با خطا مواجه شد</h1>";
            }
        } else {
            if ($_GET['status'] == 0) {
                echo "<h1>تراکنش با خطا مواجه شد</h1>";
            }
        }
    }

    private function send($api, $amount, $redirect)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api' => $api,
            'amount' => $amount,
            'redirect' => $redirect,
        ]);
    }

    private  function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    private  function verify($api, $token) {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' => $api,
            'token' => $token,
        ]);
    }

    private function createOrder($addressId , $amount , $token , $gatewayName)
    {
        try {
            DB::beginTransaction();

           $order = Order::create([
                'user_id' => AuthValidator::getUserId(),
                'user_ip' => AuthValidator::getUserIp(),
                'address_id' => $addressId,
                'coupon_id' => SessionService::findSession('coupon') ? SessionService::getSession('coupon.id') : null,
                'total_amount' => $amount['total_amount'],
                'delivery_amount' => $amount['delivery_amount'],
                'paying_amount' => $amount['paying_amount'],
                'payment_type' => 'online'
            ]);

           foreach (\Cart::getContent() as $item)
           {
               OrderItem::create([
                   'order_id' => $order->id,
                   'product_id' =>  $item->associatedModel->id,
                   'product_variation_id' => $item->attributes->id,
                   'price' => $item->price,
                   'quantity' => $item->quantity,
                   'subtotal' => $item->quantity * $item->price,
            ]);

               Transaction::create([
                   'user_id' => AuthValidator::getUserId(),
                   'user_ip' => AuthValidator::getUserIp(),
                   'order_id' => $order->id,
                   'amount' => $amount['paying_amount'],
                   'token' => $token,
                   'gateway_name' => $gatewayName
               ]);
           }

            DB::commit();
        }catch (\Exception $exception)
        {
            DB::rollBack();

            return ['error' => $exception->getMessage()];
        }
        return ['success' => 'success!!'];
    }
}
