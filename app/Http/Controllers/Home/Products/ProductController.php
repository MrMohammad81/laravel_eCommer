<?php

namespace App\Http\Controllers\Home\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use function view;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $similarProducts = Product::where('category_id' , $product->category_id)->take(5)->get();

        return view('home.products.show' , compact('product' , 'similarProducts'));
    }
}
