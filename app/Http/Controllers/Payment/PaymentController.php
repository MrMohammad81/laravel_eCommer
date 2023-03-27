<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\PaymentGateway\Pay;
use App\PaymentGateway\zarinpal;
use App\Services\Cart\CartServices;
use App\Utilities\Payments\CheckPaymentInformation\CheckPaymentInformation;
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

        // Validation is ok And start payment
        if ($request->payment_method == 'pay')
        {
            $payGateway = new Pay();
            $payGatewayResult = $payGateway->send($amounts , $request->address_id);

            if (array_key_exists('error' , $payGatewayResult ?? []))
            {
                alert()->warning('' , $payGatewayResult['error'] ?? []);
                return redirect()->back();
            }else {
                return redirect()->to($payGatewayResult['success'] ?? []);
            }
        }

        if ($request->payment_method == 'zarinpal')
        {
            $zarinpalGateway = new zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->send($amounts ,  $request->address_id);

            if (array_key_exists('error' , $zarinpalGatewayResult ?? []))
            {
                alert()->warning('' , $zarinpalGatewayResult['error'] ?? []);
                return redirect()->back();
            }else {
                return redirect()->to($zarinpalGatewayResult['success'] ?? []);
            }
        }

        alert()->error('' , 'درگاه پرداخت انتخابی نامعتبر است');
        return redirect()->back();
     }

    public function paymentVerify(Request $request , $gatewayName)
    {
        if ($gatewayName == 'pay')
        {
            $payGateway = new Pay();
            $payGatewayResult = $payGateway->verify($request->token , $request->status);

            if (array_key_exists('error' , $payGatewayResult ?? []))
            {
                alert()->error('' , $payGatewayResult['error']);
                return redirect()->back();
            }else {
                alert()->success('' , $payGatewayResult['success']);
                return redirect()->route('home.index');
            }
        }

        if ($gatewayName == 'zarinpal')
        {
            $amounts = CheckPaymentInformation::getAmounts();
            if (array_key_exists('error' , $amounts ?? []))
            {
                alert()->warning('' , $amounts['error']);
                return redirect()->back();
            }

            $zarinpalGateway = new zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->verify($request->Authority , $amounts['paying_amount']);

            if (array_key_exists('error' , $zarinpalGatewayResult ?? []))
            {
                alert()->error('' , $zarinpalGatewayResult['error']);
                return redirect()->back();
            }else {
                alert()->success('' , $zarinpalGatewayResult['success']);
                return redirect()->route('home.index');
            }
        }

        alert()->error('' , 'خطا در انجام تراکنش');
        return redirect()->back();
    }
}
