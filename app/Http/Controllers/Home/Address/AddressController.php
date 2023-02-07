<?php

namespace App\Http\Controllers\Home\Address;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\UserAddress;
use App\Utilities\Validators\Addresses\AddressValidator;
use App\Utilities\Validators\Auth\AuthValidator;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $provinces = Province::all();

        return view('home.user_profile.address' , compact('provinces'));
    }

    public function store(Request $request)
    {
        if (!AuthValidator::checkUserLogin())
        {
            alert()->warning('' , 'برای ثبت آدرس ابتدا وارد سایت شوید')->showConfirmButton('تایید');
            return  redirect()->route('auth.index');
        }

        AddressValidator::validateStoreAddress($request);

        $this->createUserAddress($request);

        alert()->success('ثبت آدرس' , 'آدرس شما با موفقیت ثبت شد')->showConfirmButton('تایید');
        return  redirect()->back();

    }

    public function getProvinceCitiesList(Request $request)
    {
        $cities = City::where('province_id' , $request->province_id)->get();

        return $cities;
    }

    private function createUserAddress($request)
    {
        UserAddress::create([
            'title' => $request->store_title,
            'user_id' => auth()->id(),
            'cellphone' => $request->mobile,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
        ]);
    }
}
