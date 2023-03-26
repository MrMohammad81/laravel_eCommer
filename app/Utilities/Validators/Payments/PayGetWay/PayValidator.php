<?php

namespace App\Utilities\Validators\Payments\PayGetWay;
use Illuminate\Support\Facades\Validator;

class PayValidator
{
    public static function checkPayData($request)
    {
        $validatedData = Validator::make($request->all() ,
            [
                'payment_method' => 'required',
                'address_id' => 'required|numeric'
        ]);
        return $validatedData;
    }
}
