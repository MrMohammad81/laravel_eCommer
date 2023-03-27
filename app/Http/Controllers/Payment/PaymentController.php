<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Cart\CartServices;
use App\Utilities\Payments\CheckPaymentInformation\CheckPaymentInformation;
use App\Utilities\Payments\OrderFeatures\OrderFeatures;
use App\Utilities\Validators\Payments\PayGetWay\PayValidator;
use Illuminate\Http\Request;

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
        $amount = $amounts['paying_amount'] * 10;
        $redirect = route('home.paymentVerify');
        $result = $this->send($api, $amount, $redirect);
        $result = json_decode($result);
        if($result->status) {

            $createdOrder = OrderFeatures::createOrder($request->address_id,$amounts,$result->token,'pay');

            if (array_key_exists('error' , $createdOrder ?? []))
            {
                alert()->warning('' , $createdOrder['error']);
                return redirect()->back();
            }

            $go = "https://pay.ir/pg/$result->token";
            return redirect()->to($go);
        } else {
            alert()->error('' , $result->errorMessage);
            return redirect()->back();
        }

    }

    public function paymentVerify(Request $request)
    {
        $api = 'test';
        $token = $request->token;
        $result = json_decode($this->verify($api, $token));
        if(isset($result->status))
        {
            if($result->status == 1)
            {
               $updateOrder = OrderFeatures::updateOrder($token , $result->transId);
                if (array_key_exists('error' , $updateOrder ?? []))
                {
                    alert()->warning('' , $updateOrder['error']);
                    return redirect()->back();
                }

                CartServices::cartClear();
                alert()->success('' , "پرداخت با موفقیت انجام شد. شماره تراکنش : $result->transId")->persistent('تایید');
                return redirect()->route('home.index');
            } else {
                alert()->error('' , 'تراکنش با خطا مواجه شد')->persistent('تایید');
                return redirect()->back();
            }
        } else {
            if ($request->status == 0) {
                alert()->error('' , 'تراکنش با خطا مواجه شد')->persistent('تایید');
                return redirect()->back();
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
}
