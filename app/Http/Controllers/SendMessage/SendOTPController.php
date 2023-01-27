<?php

namespace App\Http\Controllers\SendMessage;

use App\Exceptions\SmsServiceNotFound;
use App\Models\User;
use App\Notifications\OTPSms;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function response;

class SendOTPController
{
    public static function sendOTP($request , $smsService = OTPSms::class )
    {
        $otpCode =  mt_rand(100000, 999999);
        $loginToken = Hash::make(Str::random());

        $user = User::where('email' , $request->email)->first();

        $user->update(['otp' => $otpCode , 'login_token' => $loginToken]);

        if(!new $smsService($otpCode))
        {
            throw new SmsServiceNotFound('Sms service not found' , 404);
        }

       // $user->notify(new $smsService($otpCode));

        return response(['login_token' => $loginToken] , 200);
    }

    public static function resendOTP($request , $messegIfFalse , $messegIfTrue , $smsService = OTPSms::class)
    {
        $request->validate(['loginToken' => 'required']);

        $user = User::where('login_token' , $request->loginToken)->first() ?? false;

        if (!$user)
        {
            return response(['errors' => $messegIfFalse , 422]);
        }

        $otpCode =  mt_rand(100000, 999999);

        $user->update(['otp' => $otpCode]);

        if (!new $smsService($otpCode))
        {
            throw new SmsServiceNotFound('Sms service not found' , 404);
        }

        //$user->notify(new $smsService($otpCode));

        return response($messegIfTrue , 200);
    }
}
