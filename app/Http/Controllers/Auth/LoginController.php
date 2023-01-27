<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\SendMessage\SendOTPController;
use App\Models\User;
use App\Notifications\OTPSms;
use App\Utilities\Validators\AuthValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController
{
    public function login(Request $request)
    {
        AuthValidator::checkMethodRequest($request);

        AuthValidator::validateUserForLogin($request);

        $user = User::where('email' , $request->email)->first();

        if (!Hash::check($request->password , $user->password ))
        {
            return response(['errors' => 'اطلاعات وارد شده صحیح نمیباشد'] , 403);
        }

        return SendOTPController::sendOTP($request);
    }

    public function checkOtp(Request $request)
    {
        AuthValidator::checkMethodRequest($request);

        AuthValidator::validatedOTPCode($request);

        $user = User::where('otp' , $request->otp)->where('login_token' , $request->loginToken)->first() ?? false;

        if (!$user)
        {
            return response(['errors' => ['otp' => ['کد تاییدیه نادرست است']]], 422);
        }

        auth()->login($user, $remember = true);
        return response(['ورود با موفقیت انجام شد'], 200);
    }

    public function resendOTP(Request $request)
    {
        $messegIfFalse = 'خطا در ارسال رمز یکبار مصرف';
        $messegIfTrue = 'رمز یکبار مصرف با موفقیت ارسال شد';

        SendOTPController::resendOTP($request , $messegIfFalse , $messegIfTrue);
    }
}
