<?php

namespace App\Utilities\Validators\Addresses;

use Illuminate\Support\Facades\Validator;

class AddressValidator
{
    public static function validateStoreAddress($request)
    {
       $validatedData =  $request->validateWithBag('addressStore' , [
            'store_title' => 'required|min:3',
            'mobile' => 'required|iran_mobile',
            'province_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address' => 'required|min:10',
            'postal_code' => 'required|iran_postal_code',
        ]);

       return $validatedData;
    }

    public static function validateUpdateAddress($request)
    {
        $validatedData = Validator::make($request->all() , [
            'store_title' => 'required|min:3',
            'mobile' => 'required|iran_mobile',
            'province_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address' => 'required|min:10',
            'postal_code' => 'required|iran_postal_code',
        ]);
        return $validatedData;
    }
}
