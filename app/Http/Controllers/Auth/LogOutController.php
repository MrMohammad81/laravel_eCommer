<?php

namespace App\Http\Controllers\Auth;

class LogOutController
{
    public function logout()
    {
        auth()->logout();
        return redirect()->route('home.index');
    }
}
