<?php

namespace App\Services\Cart;

use App\Models\Product;
use App\Models\ProductVariation;

class CartServices
{
    public static function addToCart($rowId,$model,$productVariation,$request)
    {
        \Cart::add(array(
            'id' => $rowId,
            'name' => $model->name,
            'price' => $productVariation->getIsSaleAttribute() ? $productVariation->sale_price : $productVariation->price,
            'quantity' => $request->qtybutton,
            'attributes' => $productVariation->toArray(),
            'associatedModel' => $model
        ));
    }

    public static function checkProductInCart($rowId)
    {
        $data = \Cart::get($rowId);

        return $data;
    }

    public static function isEmpty()
    {
        return \Cart::isEmpty();

    }

    public static function getContent()
    {
        \Cart::getContent();
    }

    public static function checkUpdateMethodRequest($request)
    {
        if ($request->method() != 'PUT')
            return response(['errors' => 'UNDEFINED METHOD REQUEST' ] , 400);
    }

    public static function cartUpdate($rowId , $quantity)
    {
       $updatedData = \Cart::update($rowId ,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                )
            ));
       return $updatedData;
    }

    public static function checkQuantity($cartQuantity , $productQuantity)
    {
        if ($cartQuantity > $productQuantity)
           return true;
        return false;
    }

    public static function cartClear()
    {
        \Cart::clear();
    }

    public static function getTotal()
    {
        return \Cart::getTotal();
    }

    public static function checkCart()
    {
        if (\Cart::isEmpty())
        {
            return ['error' => 'سبد خرید شما خالی میباشد'];
        }

        foreach (\Cart::getContent() as $item)
        {
            $variation = ProductVariation::find($item->attributes->id);

            $price = $variation->is_sale ? $variation->sale_price : $variation->price;

            if ($item->price != $price)
            {
                return ['error' => "قیمت محصول $item->name تغیر یافته است.لطفا سفارش خود را دوباره ثبت کنید"];
            }

            if ($item->quantity > $variation->quantity)
            {
                return ['error' => "موجودی محصول  $item->name کمتر از سفارش شما می باشد.لطفا سفارش خود را بروزرسانی کنید"];
            }

            return ['success' => 'success'];
        }
    }

}
