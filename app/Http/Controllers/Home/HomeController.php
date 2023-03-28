<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Banner::where('type' , 'slider')->where('is_active' , 1)->orderBy('priority')->get();

        $indexTop = Banner::where('type' , 'index-top')->where('is_active' , 1)->orderBy('priority')->get();
        $indexTopBanner = !is_null($indexTop) ? $indexTop : [];

        $indexBottom = Banner::where('type' , 'index-bottom')->where('is_active' , 1)->orderBy('priority')->get();
        $indexBottomBanner = !is_null($indexBottom) ? $indexBottom : [];

        $products = Product::where('is_active' , 1)->get()->take(10);

        return view('home.index' , compact( 'sliders' , 'indexBottomBanner' , 'indexTopBanner' , 'products'));
    }
}
