<?php

namespace App\Http\Controllers\Admin\Coupons;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Coupons\StoreCouponRequest;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);

        return view('admin.coupons.index' , compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(StoreCouponRequest $request)
    {
        $request->validated();

        $this->createCoupon($request);

        alert()->success('ایجاد کد تخفیف',"کد تخفیف $request->name با موفقیت ایجاد شد")->showConfirmButton('تایید');
        return redirect()->route('admin.coupons.index');
    }

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show' , compact('coupon'));
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        alert()->success('حذف کد تخفیف',"کد تخفیف $coupon->name با موفقیت حذف شد")->showConfirmButton('تایید');
        return redirect()->back();
    }

    private function createCoupon($request)
    {
        Coupon::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'amount' => $request->amount,
            'percentage' => $request->percentage,
            'max_percentage_amount' => $request->max_percentage_amount,
            'description' => $request->description,
            'expired_at' => convertShamsiDateToGregorian($request->expire_at),
        ]);
    }
}
