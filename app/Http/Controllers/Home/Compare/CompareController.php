<?php

namespace App\Http\Controllers\Home\Compare;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Utilities\Sessions\Products\ProductSessions;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function add(Product $product)
    {
       if (!ProductSessions::findSession('compareProducts'))
       {
           ProductSessions::storeSession('compareProducts' , $product->id);

           alert()->success('' , 'محصول به مقایسه اضافه شد')->showConfirmButton('تایید');
           return redirect()->back();
       }

       if (ProductSessions::checkSession($product->id , 'compareProducts'))
       {
           alert()->warning('' , 'این محصول قبلا به لیست مقایسه اضافه شده است')->showConfirmButton('تایید');
           return redirect()->back();
       }

       ProductSessions::addToSession('compareProducts' ,  $product->id);

       alert()->success('' , 'محصول به لیست مقایسه اضافه شد')->showConfirmButton('تایید');
       return redirect()->back();
    }
}
