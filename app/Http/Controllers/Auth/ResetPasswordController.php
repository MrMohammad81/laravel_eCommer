<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\SendMessage\SendOTPController;
use App\Models\User;
use App\Notifications\ResetPasswordWithOTP;
use App\Utilities\Validators\Auth\AuthValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController
{
    public function checkUserForResetPassword(Request $request)
    {
        AuthValidator::validatedEmailForResetPassword($request);

        return SendOTPController::sendOTP($request,ResetPasswordWithOTP::class);
    }

    public function checkOtpResetPass(Request $request)
    {
        AuthValidator::checkOtpResetPass($request);

        return response('کد بازیابی تایید شد' , 200);
    }

    public function resendOTPResetPass(Request $request)
    {
        $messegIfFalse = 'خطا در ارسال کد بازیابی';
        $messegIfTrue = 'کد بازیابی ارسال شد';

        SendOTPController::resendOTP($request , $messegIfFalse , $messegIfTrue , ResetPasswordWithOTP::class );
    }

    public function changePassword(Request $request)
    {
        AuthValidator::validateNewPassword($request);

        DB::beginTransaction();

        $user = User::where('login_token' , $request->loginToken)->first() ?? false;

        if (!$user)
        {
            return response(['errors' => 'خطا در تغیر رمز عبور'] , 401);
        }

        $newPassword = Hash::make($request->password);

        $user->update(['password' => $newPassword]);

        auth()->login($user ,  $remember = true);

        DB::commit();

        return response('رمز عبور شما با موفقیت تغیر کرد' , 200);
    }

}
