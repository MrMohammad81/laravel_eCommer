<?php

namespace App\Http\Controllers\Home\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Services\Cart\CartServices;
use App\Http\Requests\Home\Cart\AddToCartRequest;


class CartController extends Controller
{
    public function add(AddToCartRequest $request)
    {
        $request->validated();

        $product = Product::findOrFail($request->product_id);
        $productVariation = ProductVariation::findOrFail(json_decode($request->variation)->id);

        if ($request->qtybutton > $productVariation->quantity)
        {
            alert()->error('' , 'تعداد وارد شده بیشتر از موجودی کالا می باشد')->showConfirmButton('تایید');
            return redirect()->back();
        }

        $rowId = $product->id . '-' . $productVariation->id;

        if (CartServices::checkProductInCart($rowId) != null)
        {
            $massage = " محصول $product->name  قبلا به سبد خرید شما اضافه شده است. جهت بروزرسانی سبد خرید به پروفایل خود مراجعه کنید";

            alert()->warning('' , "$massage")->showConfirmButton('تایید');
            return redirect()->back();
        }

        CartServices::addToCart($rowId,$product,$productVariation,$request);

        alert()->success('' , "محصول $product->name به سبد خرید شما اضافه شد")->showConfirmButton('تایید');
        return redirect()->back();
    }


}
