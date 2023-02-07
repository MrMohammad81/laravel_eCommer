<?php

namespace App\Http\Controllers\Home\Address;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        return view('home.user_profile.address');
    }
}
