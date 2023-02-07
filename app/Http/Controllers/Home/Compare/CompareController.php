<?php

namespace App\Http\Controllers\Home\Compare;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Sessions\SessionService;
use function GuzzleHttp\Promise\all;

class CompareController extends Controller
{
    public function index()
    {
        if (!SessionService::findSession('compareProducts'))
        {
            alert()->warning('' , 'در ابتدا باید محصولی به لیست مقایسه اضافه کنید')->showConfirmButton('تایید');
            return redirect()->back();
        }

        $products = Product::findOrFail(SessionService::getSession('compareProducts'));

        return view('home.compare.index' , compact('products'));
    }

    public function add(Product $product)
    {
       if (!SessionService::findSession('compareProducts'))
       {
           SessionService::storeSession('compareProducts' , [$product->id]);

           alert()->success('' , 'محصول به مقایسه اضافه شد')->showConfirmButton('تایید');
           return redirect()->back();
       }

       if (SessionService::checkSession($product->id , 'compareProducts'))
       {
           alert()->warning('' , 'این محصول قبلا به لیست مقایسه اضافه شده است')->showConfirmButton('تایید');
           return redirect()->back();
       }

         SessionService::addToSession('compareProducts' ,  $product->id);

         alert()->success('' , 'محصول به لیست مقایسه اضافه شد')->showConfirmButton('تایید');
         return redirect()->back();
    }

    public function remove($productId)
    {
        if (!SessionService::findSession('compareProducts'))
        {
            alert()->warning('' , 'در ابتدا باید محصولی به لیست مقایسه اضافه کنید')->showConfirmButton('تایید');
            return redirect()->back();
        }

        foreach (SessionService::getSession('compareProducts') as $key => $item)
        {
            if ($item == $productId)
            {
                SessionService::pullSession('compareProducts' , $key);
            }
        }

        if (SessionService::getSession('compareProducts') == [])
        {
            SessionService::forgetSession('compareProducts');

            alert()->success('' , 'محصول با موفقیت از لیست  مقایسه حذف شد')->showConfirmButton('تایید');
            return redirect()->route('home.index');
        }

        alert()->success('' , 'محصول با موفقیت از لیست  مقایسه حذف شد')->showConfirmButton('تایید');
        return redirect()->back();
    }
}
