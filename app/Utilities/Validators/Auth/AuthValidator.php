<?php

namespace App\Utilities\Validators\Auth;

use Illuminate\Validation\Rules\Password;
use function response;

class AuthValidator
{
    public static function checkMethodRequest($request)
    {
        if ($request->method() != 'POST')
            return response(['UNDEFINED METHOD REQUEST' => 400]);
    }

    public static function validatedRegisterParams($request)
    {
       $validatedDate = $request->validate([
            'name' => 'required|min:2',
            'cellphone' => 'required|iran_mobile|unique:users,cellphone',
            'email' => 'required|email|unique:users,email',
            'password' => ['required' , Password::min(8)->mixedCase()->numbers()],
        ]);
        return $validatedDate;
    }

    public static function validateUserForLogin($request)
    {
        $validatedDate =  $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
        return $validatedDate;
    }

    public static function validatedOTPCode($request)
    {
        $validatedDate =  $request->validate([
            'otp' => 'required|digits:6|numeric',
        ]);
        return $validatedDate ;
    }

    public static function validatedEmailForResetPassword($request)
    {
        $validatedDate =  $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        return $validatedDate ;
    }

    public static function checkOtpResetPass($request)
    {
        $validatedDate =  $request->validate([
            'reset_pass_otp' => 'required|digits:6|numeric|exists:users,otp',
            'loginToken' => 'required',
        ]);
        return $validatedDate;
    }

    public static function validateNewPassword($request)
    {
        $validatedDate = $request->validate([
            'loginToken' => 'required',
            'password' => ['required' , Password::min(8)->mixedCase()->numbers()],
            'confirm_password' => 'required_with:newPassword|same:password',
        ]);
        return $validatedDate;
    }

    public static function checkUserLogin()
    {
        if (!auth()->check())
            return  false;
        return true;

    }
}
