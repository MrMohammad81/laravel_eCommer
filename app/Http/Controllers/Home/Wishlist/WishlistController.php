<?php

namespace App\Http\Controllers\Home\Wishlist;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use App\Utilities\Validators\Auth\AuthValidator;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(Product $product)
    {
        if (!AuthValidator::checkUserLogin())
        {
            alert()->warning('' , 'برای افزودن محصول به لیست علاقه مندی ها ابتدا وارد سایت شوید')->showConfirmButton('تایید');
            return  redirect()->route('auth.index');
        }

        if ($product->checkUserWishlist(auth()->id()))
        {
            alert()->warning('' , 'این محصول قبلا به لیست علاقه مندی ها اضافه شده است')->showConfirmButton('تایید');
            return  redirect()->back();
        }

        $this->addToWishlist($product);

        alert()->success('' , 'محصول به لیست علاقه مندی ها اضافه شد')->showConfirmButton('تایید');
        return  redirect()->back();
    }

    public function remove(Product $product)
    {
        $wishlist = Wishlist::where('product_id' , $product->id)->where('user_id' , auth()->id())->firstOrFail();

        if ($wishlist)
            Wishlist::where('product_id' , $product->id)->where('user_id' , auth()->id())->delete();

        alert()->success('' , 'محصول از لیست علاقه مندی های شما حذف شد')->showConfirmButton('تایید');
        return  redirect()->back();
    }

    public function usersProfileIndex()
    {
        $wishlist = Wishlist::where('user_id' , auth()->id())->get();

        return view('home.user_profile.wishlist' , compact('wishlist'));
    }

    private function addToWishlist($product)
    {
        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id
        ]);
    }
}
