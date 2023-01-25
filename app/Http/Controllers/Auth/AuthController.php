<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OTPSms;
use App\Notifications\ResetPasswordWithOTP;
use App\Utilities\Validators\AuthValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        AuthValidator::checkMethodRequest($request);

        DB::beginTransaction();

        AuthValidator::validatedRegisterParams($request);

        $otpCode = mt_rand(100000, 999999);
        $loginToken = Hash::make(Str::random());

        $user = $this->createUser($request, $otpCode , $loginToken);

        auth()->login($user ,  $remember = true);

        DB::commit();

        return response(['login_token' => $loginToken] , 200);
    }

    public function login(Request $request)
    {
        AuthValidator::checkMethodRequest($request);

        AuthValidator::validateUserForLogin($request);

        $user = User::where('email' , $request->email)->first();

        if (!Hash::check($request->password , $user->password ))
        {
            return response(['errors' => 'اطلاعات وارد شده صحیح نمیباشد'] , 403);
        }

        $otpCode = mt_rand(100000, 999999);
        $loginToken = Hash::make(Str::random());

        $user->update(['otp' => $otpCode , 'login_token' => $loginToken]);

        //$user->notify(new OTPSms($user->otp));

        return response(['login_token' => $loginToken] , 200);
    }

    public function checkOtp(Request $request)
    {
        AuthValidator::checkMethodRequest($request);

        AuthValidator::validatedOTPCode($request);

        $user = User::where('otp' , $request->otp)->where('login_token' , $request->loginToken)->first() ?? false;

        if ($user)
        {
            auth()->login($user, $remember = true);

            return response(['ورود با موفقیت انجام شد'], 200);
        } else {
            return response(['errors' => ['otp' => ['کد تاییدیه نادرست است']]], 422);
        }
    }

    public function resendOTP(Request $request)
    {
        AuthValidator::checkMethodRequest($request);

        $request->validate(['loginToken' => 'required']);

        $user = User::where('login_token' , $request->loginToken)->first() ?? false;

        if (!$user)
        {
            return response(['errors' => 'خطا در ارسال مجدد'], 422);
        }

        $otpCode = mt_rand(100000, 999999);

        $user->update(['otp' => $otpCode]);

     //   $user->notify(new OTPSms($user->otp));

        return response('کد تایید مجددا ارسال شد' , 200);
    }

    public function checkUserForResetPassword(Request $request)
    {
        AuthValidator::validatedEmailForResetPassword($request);

        $user = User::where('email' , $request->email)->first();

        $otpCode =  mt_rand(100000, 999999);
        $loginToken = Hash::make(Str::random());

        $user->update(['otp' => $otpCode , 'login_token' => $loginToken]);

      //  $user->notify(new ResetPasswordWithOTP($otpCode));

        return response(['login_token' => $loginToken] , 200);
    }

    public function checkOtpResetPass(Request $request)
    {
        AuthValidator::checkOtpResetPass($request);

        return response('کد بازیابی تایید شد' , 200);
    }

    public function resendOTPResetPass(Request $request)
    {
        $request->validate(['loginToken' => 'required']);

        $user = User::where('login_token' , $request->loginToken)->first() ?? false;

        if (!$user)
        {
            return response(['errors' => 'خطا در ارسال مجدد کد بازیابی'] , 422);
        }

        $otpCode =  mt_rand(100000, 999999);

        $user->update(['otp' => $otpCode]);

     //   $user->notify(new ResetPasswordWithOTP($user->otp));

        return response('کد بازیابی ارسال شد' , 200);
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

    private function createUser($request , $otpCode , $loginToken)
    {
        $user = User::create([
            'name' => $request->name,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'otp' => $otpCode,
            'login_token' => $loginToken,
            'password' => Hash::make($request->password)
        ]);
        return $user;
    }
}
