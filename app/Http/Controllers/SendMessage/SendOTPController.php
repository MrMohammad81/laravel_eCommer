<?php

namespace App\Http\Controllers\SendMessage;

use App\Models\User;
use App\Notifications\OTPSms;
use App\Notifications\ResetPasswordWithOTP;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function response;

class SendOTPController
{
    public static function sendOTP($request , $notifyType = 'OTPSms')
    {
        $otpCode =  mt_rand(100000, 999999);
        $loginToken = Hash::make(Str::random());

        $user = User::where('email' , $request->email)->first();

        $user->update(['otp' => $otpCode , 'login_token' => $loginToken]);

        if ($notifyType = 'OTPSms')
        {
            $user->notify(new OTPSms($user->otp));
        }
        elseif ($notifyType = 'ResetPassword')
        {
            $user->notify(new ResetPasswordWithOTP($user->otp));
        }else{
            return response(['errors' => 'Notify service not found'] , 404);
        }

        return response(['login_token' => $loginToken] , 200);
    }

    public static function resendOTP($request , $messegIfFalse , $messegIfTrue , $notifyType = 'OTPSms')
    {
        $request->validate(['loginToken' => 'required']);

        $user = User::where('login_token' , $request->loginToken)->first() ?? false;

        if (!$user)
        {
            return response(['errors' => $messegIfFalse , 422]);
        }

        $otpCode =  mt_rand(100000, 999999);

        $user->update(['otp' => $otpCode]);

        if ($notifyType = 'OTPSms')
        {
            $user->notify(new OTPSms($user->otp));
        }
        elseif ($notifyType = 'ResetPassword')
        {
            $user->notify(new ResetPasswordWithOTP($user->otp));
        }else{
            return response(['errors' => 'Notify service not found'] , 404);
        }

        return response($messegIfTrue , 200);
    }
}
