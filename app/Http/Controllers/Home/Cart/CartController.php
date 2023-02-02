<?php

namespace App\Http\Controllers\Home\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Services\Cart\CartServices;
use App\Http\Requests\Home\Cart\AddToCartRequest;
use App\Http\Requests\Home\Cart\UpdateCartRequest;
//use http\Env\Request;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index()
    {
        return view('home.cart.index');
    }

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

    public function update(UpdateCartRequest $request)
    {
        CartServices::checkUpdateMethodRequest($request);

        $request->validated();

        foreach ($request->qtybutton as $rowId => $quantity)
        {
            $item = CartServices::checkProductInCart($rowId);

            if (CartServices::checkQuantity($quantity , $item->attributes->quantity))
            {
                $productName = Product::findOrFail($item->attributes->product_id);

                alert()->error('' , "تعداد وارد شده $productName->name بیشتر از موجودی می باشد")->showConfirmButton('تایید');
                return redirect()->back();
            }

            CartServices::cartUpdate($rowId,$quantity);

        }
        alert()->success('' , 'سبد خرید شما بروزرسانی شد')->showConfirmButton('تایید');
        return redirect()->back();
    }

    public function remove($rowId)
    {
        $item = CartServices::checkProductInCart($rowId);

        $productName = Product::findOrFail($item->attributes->product_id);

        \Cart::remove($rowId);

        alert()->success('' , "$productName->name از سبد خرید شما حذف شد")->showConfirmButton('تایید');
        return redirect()->back();
    }

    public function clear()
    {
        CartServices::cartClear();

        alert()->warning('' , 'سبد خرید شما خالی شد')->showConfirmButton('تایید');
        return redirect()->back();
    }

}
