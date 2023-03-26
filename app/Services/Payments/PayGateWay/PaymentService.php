<?php

namespace App\Services\Payments\PayGateWay;

class PaymentService
{
    public static function sendPayRequest($payAmount)
    {
        $api = 'test';
        $amount = $payAmount;
        $redirect = route('home.paymentVerify');
        $result = self::send($api, $amount, $redirect);
        $result = json_decode($result);
        if($result->status)
            return true;
        return $result->errorMessage;
    }

    public static function paymentVerify($request)
    {
        $api = 'test';
        $token = $request->token;
        $result = json_decode(self::verify($api, $token));
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

    public static function send($api, $amount, $redirect)
    {
        return self::curl_post('https://pay.ir/pg/send', [
            'api' => $api,
            'amount' => $amount,
            'redirect' => $redirect,
        ]);
    }

    public static function curl_post($url, $params)
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

    public static function verify($api, $token) {
        return self::curl_post('https://pay.ir/pg/verify', [
            'api' => $api,
            'token' => $token,
        ]);
    }
}
