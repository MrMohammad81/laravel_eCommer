<?php

namespace App\Http\Controllers\Home\About_Us;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $indexBottom = Banner::where('type' , 'index-bottom')->where('is_active' , 1)->orderBy('priority')->get();
        $bottomBanner = !is_null($indexBottom) ? $indexBottom : [];

        return view('home.about-us.index' , compact('bottomBanner'));
    }
}
