<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Utilities\Validators\Auth\AuthValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController
{
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
