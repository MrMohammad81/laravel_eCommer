<?php

namespace App\Services\Coupons;

use App\Models\Coupon;
use App\Models\Order;
use App\Services\Cart\CartServices;
use App\Services\Sessions\SessionService;
use App\Utilities\Validators\Auth\AuthValidator;
use Carbon\Carbon;

class CouponServices
{
    public static function checkCoupon($code)
    {
        $coupon = self::getCoupon($code);

        if ($coupon == null)
        {
            SessionService::forgetSession('coupon');
            return ['error' => 'کد تخفیف وارد شده صحیح نمیباشد'];
        }
    }

    public static function checkUsedCouponForThisUser($code)
    {
        $coupon = self::getCoupon($code);

        if (Order::where('user_id' , AuthValidator::getUserId())->where('coupon_id' , $coupon->id)->where('payment_status' , 1)->exists())
        {
            SessionService::forgetSession('coupon');
            return ['error' => ' شما قبلا از این کد تخفیف استفاده کرده اید'];
        }
    }

    public static function applyCouponCode($code)
    {
        $coupon = self::getCoupon($code);

        if ($coupon->getRawOriginal('type') == 'amount')
        {
            SessionService::storeSession('coupon' ,  ['code' => $coupon->code , 'amount' => $coupon->amount]);
            return ['success' => 'کد تخفیف با موفقیت اعمال شد'];
        }

        $total = CartServices::getTotal();

        $amount = (($total * $coupon->percentage) / 100 ) > $coupon->max_percentage_amount
            ? $coupon->max_percentage_amount
            : ($total * $coupon->percentage) / 100 ;

        SessionService::storeSession('coupon' , ['code' => $coupon->code , 'amount' => $amount]);

        return ['success' => 'کد تخفیف با موفقیت اعمال شد'];
    }

    public static function getCoupon($code)
    {
        return Coupon::where('code' , $code)->where('expired_at' , '>' , Carbon::now())->first();
    }
}
