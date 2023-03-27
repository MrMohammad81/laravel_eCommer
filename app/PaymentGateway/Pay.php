<?php

namespace App\PaymentGateway;

use App\Services\Cart\CartServices;
use App\Utilities\Payments\OrderFeatures\OrderFeatures;

class Pay
{
    public function send($amounts , $addressId)
    {
        $api = 'test';
        $amount = $amounts['paying_amount'] * 10;
        $redirect = route('home.paymentVerify');
        $result = $this->sendRequest($api, $amount, $redirect);
        $result = json_decode($result);
        if($result->status) {

            $createdOrder = OrderFeatures::createOrder($addressId,$amounts,$result->token,'pay');

            if (array_key_exists('error' , $createdOrder ?? []))
            {
                return $createdOrder;
            }

            $go = "https://pay.ir/pg/$result->token";
            return ['success' => $go];
        } else {
            return ['error' => $result->errorMessage];
        }
    }
    public function verify($tokens , $status)
    {
        $api = 'test';
        $token = $tokens;
        $result = json_decode($this->verifyRequest($api, $token));
        if(isset($result->status))
        {
            if($result->status == 1)
            {
                $updateOrder = OrderFeatures::updateOrder($token , $result->transId);
                if (array_key_exists('error' , $updateOrder ?? []))
                {
                    return $updateOrder;
                }

                CartServices::cartClear();
                return ['success' => "پرداخت با موفقیت انجام شد. شماره تراکنش : $result->transId"];
            } else {
                return ['error' => 'تراکنش با خطا مواجه شد'];
            }
        } else {
            if ($status == 0) {
                return ['error' => 'تراکنش با خطا مواجه شد'];
            }
        }
    }

    private function sendRequest($api, $amount, $redirect)
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

    private function verifyRequest($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' => $api,
            'token' => $token,
        ]);
    }
}
