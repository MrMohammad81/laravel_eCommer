<?php

namespace App\Utilities\CheckPaymentInformation;

use App\Services\Cart\CartServices;
use App\Services\Coupons\CouponServices;
use App\Services\Sessions\SessionService;

class CheckPaymentInformation
{
   public static function getAmounts()
   {
       if (SessionService::findSession('coupon')) {
           $checkCoupon = CouponServices::checkCoupon(SessionService::getSession('coupon.code'));
           if (array_key_exists('error', $checkCoupon ?? [])) {
               return $checkCoupon;
           }
           return [
               'total_amount' => CartServices::getTotal() + cartTotalSameAmount(),
               'delivery_amount' => cartTotalDeliveryAmount(),
               'coupon_amount' => SessionService::findSession('coupon') ? SessionService::getSession('coupon.amount') : 0,
               'paying_amount' => cartTotalAmount(),
           ];
       }
   }
}
