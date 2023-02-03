<?php

use Hekmatinasser\Verta\Facades\Verta;

function generatiFileNameWithDate($name)
 {
     $year =   Verta::now()->year;
     $month =  Verta::now()->month;
     $day =  Verta::now()->day;
     $hour =  Verta::now()->hour;
     $minute =  Verta::now()->minute;
     $second =  Verta::now()->second;
     $microsecond =  Verta::now()->micro;

     return $year.'_'.$month.'_'.$day.' '.$hour.'-'.$minute.'-'.$second.'-'.$microsecond.' '.$name;
 }


 function convertShamsiDateToGregorian($date)
 {
     if ($date == null)
     {
         return null;
     }
     $pattern = "/[-\s]/";

     $shamsiDateSplit = preg_split($pattern , $date);

     $arrayGregorian = Verta::jalaliToGregorian($shamsiDateSplit[0] , $shamsiDateSplit[1] , $shamsiDateSplit[2]);

     return implode('-' , $arrayGregorian) . ' ' . $shamsiDateSplit[3];
 }

 function cartTotalSameAmount()
 {
     $cartTotalSameAmount = 0;

     foreach (\Cart::getContent() as $item)
     {
         if ($item->attributes->is_sale)
         {
             $cartTotalSameAmount += $item->quantity * ($item->attributes->price - $item->attributes->sale_price );
         }
     }
     return $cartTotalSameAmount;
 }

 function cartTotalDeliveryAmount()
 {
     $cartTotalDeliveryAmount = 0;

     foreach (\Cart::getContent() as $item)
     {
         $cartTotalDeliveryAmount += $item->associatedModel->delivery_amount;
     }
     return $cartTotalDeliveryAmount;
 }

 function cartTotalAmount()
 {
     if (!session()->has('coupon'))
     {
         return \Cart::getTotal() + cartTotalDeliveryAmount();
     }
     else{
         if (session()->get('coupon.amount') > \Cart::getTotal() + cartTotalDeliveryAmount())
         {
             return cartTotalDeliveryAmount();
         }
         else{
             return \Cart::getTotal() + cartTotalDeliveryAmount() - session()->get('coupon.amount');
         }
     }
 }
