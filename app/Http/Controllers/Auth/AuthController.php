<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $this->checkMethodRequest($request);

        DB::beginTransaction();

        $this->validatedRegisterParams($request);

        $otpCode = mt_rand(100000, 999999);
        $loginToken = Hash::make('DCDCojncd@cdjn%!!ghnjrgtn&&');

        $user = $this->createUser($request, $otpCode , $loginToken);

        auth()->login($user ,  $remember = true);
        DB::commit();
        return response(['login_token' => $loginToken], 200);

    }

    public function login(Request $request)
    {
        $this->checkMethodRequest($request);

        $this->validateUserForLogin($request);

        $user = User::where('email' , $request->email)->first();

        if (!Hash::check($request->password , $user->password ))
        {
            return response(['errors' => 'اطلاعات وارد شده صحیح نمیباشد'] , 403);
        }

        $OTPCode = mt_rand(100000, 999999);

        $user->update(['otp' => $OTPCode]);

       // $user->notify(new OTPSms($user->otp));
    }

    public function checkOtp(Request $request)
    {
        $this->checkMethodRequest($request);

        $this->validatedOTPCode($request);

        $user = User::where('otp' , $request->otp)->first() ?? false;

        if ($user == true)
        {
            auth()->login($user, $remember = true);
            return response(['ورود با موفقیت انجام شد'], 200);
        } else {
            return response(['errors' => ['otp' => ['کد تاییدیه نادرست است']]], 422);
        }
    }

    public function resendOTP(Request $request)
    {
        $request->validate([
            'login_token' => 'required'
        ]);
    }

    private function validatedRegisterParams($request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'cellphone' => 'required|iran_mobile|unique:users,cellphone',
            'email' => 'required|email|unique:users,email',
            'password' => ['required' , Password::min(8)->mixedCase()->numbers()],
        ]);
        return $this;
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

    private function validatedOTPCode($request)
    {
        $request->validate([
            'otp' => 'required|digits:6|numeric',
        ]);
        return $this;
    }

    private function validateUserForLogin($request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
        return $this;
    }

    private function checkMethodRequest($request)
    {
        if ($request->method() != 'POST')
            return response(['UNDEFINED METHOD REQUEST' => 400]);
    }
}
