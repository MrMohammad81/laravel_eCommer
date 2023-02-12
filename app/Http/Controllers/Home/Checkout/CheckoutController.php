<?php

namespace App\Http\Controllers\Home\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\UserAddress;
use App\Services\Cart\CartServices;
use App\Utilities\Validators\Auth\AuthValidator;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!AuthValidator::checkUserLogin())
        {
            alert()->warning('' , 'برای ثبت سفارش ابتدا وارد سایت شوید')->showConfirmButton('تایید');
            return  redirect()->route('auth.index');
        }
        if (CartServices::isEmpty())
        {
            alert()->warning('' , 'سبد خرید شما خالی است')->showConfirmButton('تایید');
            return redirect()->back();
        }

        $addresses = UserAddress::where('user_id' , auth()->id())->get();
        $provinces = Province::all();

        return view('home.checkout.index' , compact('addresses' , 'provinces'));
    }
}
