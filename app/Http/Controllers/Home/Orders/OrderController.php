<?php

namespace App\Http\Controllers\Home\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id' , auth()->id())->get();
        return view('home.user_profile.orders' , compact('orders'));
    }
}
