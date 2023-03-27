<?php

namespace App\PaymentGateway;

use App\Services\Cart\CartServices;
use App\Utilities\Payments\OrderFeatures\OrderFeatures;

class zarinpal
{
    public function send($amount , $addressId)
    {
        $data = array(
            'MerchantID' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'Amount' => $amount['paying_amount'] ,
            'CallbackURL' => route('home.paymentVerify' , ['gatewayName' => 'zarinpal']),
            'Description' => 'online'
        );


        $jsonData = json_encode($data);
        $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));


        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true);
        curl_close($ch);
       // dd($result);
        if ($err) {
            return ['error' => 'cURL Error #:' . $err];
        } else {
            if ($result["Status"] == 100)
            {
                $createdOrder = OrderFeatures::createOrder($addressId,$amount,$result['Authority'],'zarinpal');
                if (array_key_exists('error' , $createdOrder ?? []))
                {
                    return $createdOrder;
                }
                return ['success' => 'https://sandbox.zarinpal.com/pg/StartPay/' . $result["Authority"]];
            } else {
                return ['error' => 'ERR: ' . $result["Status"]];
            }
        }

    }

    public function verify($authority , $amount)
    {
        $MerchantID = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $data = array('MerchantID' => $MerchantID, 'Authority' => $authority, 'Amount' => $amount);
        $jsonData = json_encode($data);
        $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if ($err) {
            return ['error' =>  "cURL Error #:" . $err];
        } else {
            if ($result['Status'] == 100)
            {
                $updateOrder = OrderFeatures::updateOrder($authority , $result['RefID']);
                if (array_key_exists('error' , $updateOrder ?? []))
                {
                    return $updateOrder;
                }

                CartServices::cartClear();
                return ['success' => 'تراکنش با موفقیت انجام شد. کد پیگیری:' . $result['RefID']];
            } else {
                return ['error' =>  'خطا در انجام تراکنش. وضعیت:' . $result['Status']];
            }
        }
    }
}
