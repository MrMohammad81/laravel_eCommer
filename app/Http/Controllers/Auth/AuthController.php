<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OTPSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }


    public function userRegister(Request $request)
    {
        if ($request->method() != 'POST')
            return response(['UNDEFINED METHOD REQUEST' => 400]);
        try {
            DB::beginTransaction();

            $this->validatedRegisterParams($request);

            $otpCode = mt_rand(100000, 999999);

            $this->createUser($request, $otpCode);

            $user = User::where('cellphone', $request->cellphone)->first();

            $user->notify(new OTPSms($otpCode));

            DB::commit();
            //return response(['user_register' =>  200);

        }catch (\Exception $exception)
        {
            DB::rollBack();
            return response(['errors' => $exception->getMessage()], 422);
        }
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
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

    private function createUser($request , $otpCode)
    {
        $user = User::create([
            'name' => $request->name,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'otp' => $otpCode,
            'password' => $request->password,
        ]);
        return $user->id;
    }
}
