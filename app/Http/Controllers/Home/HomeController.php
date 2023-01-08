<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $parentCategories = Category::where('parent_id' , 0)->get();

        $sliders = Banner::where('type' , 'slider')->where('is_active' , 1)->orderBy('priority')->get();

        $indexTop = Banner::where('type' , 'index-top')->where('is_active' , 1)->orderBy('priority')->get();
        $indexTopBanner = !is_null($indexTop) ? $indexTop : [];

        $indexBottom = Banner::where('type' , 'index-bottom')->where('is_active' , 1)->orderBy('priority')->get();
        $indexBottomBanner = !is_null($indexBottom) ? $indexBottom : [];

        return view('home.index' , compact('parentCategories' , 'sliders' , 'indexBottomBanner' , 'indexTopBanner'));
    }
}
