<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\PaymentGateway\Pay;
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

    public function paymentVerify(Request $request)
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
}
