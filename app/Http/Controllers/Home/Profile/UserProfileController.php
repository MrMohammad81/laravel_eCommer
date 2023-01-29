<?php

namespace App\Http\Controllers\Home\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('home.user_profile.index');
    }
}
