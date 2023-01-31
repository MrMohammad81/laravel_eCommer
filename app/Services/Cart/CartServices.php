<?php

namespace App\Services\Cart;

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
}
