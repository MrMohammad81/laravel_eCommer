<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Cart\CartServices;
use App\Utilities\CheckPaymentInformation\CheckPaymentInformation;
use Illuminate\Http\Request;
use App\Utilities\Validators\Payments\PayGetWay\PayValidator;

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

        $amount = CheckPaymentInformation::getAmounts();
        if (array_key_exists('error' , $amount ?? []))
        {
            alert()->warning('' , $amount['error']);
            return redirect()->back();
        }
        dd($amount);

        $api = 'test';
        $amount = 10000;
        $redirect = route('home.paymentVerify');
        $result = $this->send($api, $amount, $redirect);
        $result = json_decode($result);
        if($result->status) {
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

    private  function send($api, $amount, $redirect)
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
