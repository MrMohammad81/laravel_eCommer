<?php

namespace App\Http\Controllers\Home\Comments;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use App\Utilities\Validators\Auth\AuthValidator;
use App\Utilities\Validators\Comments\CommentValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request , Product $product)
    {
        $validatedData = CommentValidator::storeCommentValidator($request->all());

        if ($validatedData->fails())
        {
            return redirect()->to(url()->previous() . '#comments')->withErrors($validatedData);
        }

        if (!AuthValidator::checkUserLogin())
        {
            alert()->warning('' , 'برای ثبت نظر ابتدا وارد سایت شوید')->showConfirmButton('تایید');
            return  redirect()->route('auth.index');
        }

        try
        {
            DB::beginTransaction();

            $this->createComment($request,$product);

            if ($product->rates()->where('user_id' , auth()->id())->exists())
            {
                $productRate = $product->rates()->where('user_id' , auth()->id())->first();
                $this->updateProductRate($productRate , $request);
            }else{
                $this->createProductRate($request,$product);
            }
            DB::commit();

            alert()->success('با تشکر' , "نظر ارزشمند شما برای محصول $product->name با موفقیت ثبت شد")->showConfirmButton('تایید');
            return redirect()->back();
        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('' , $exception->getMessage())->showConfirmButton('تایید');
            return redirect()->back();
        }
    }

    public function usersProfileIndex()
    {
        $comments = Comment::where('user_id' , auth()->id())->where('approved' , 1)->get();

        return view('home.user_profile.comments' , compact('comments'));
    }

    private function createComment($request , $product)
    {
       $createdData = Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'text' => $request->text,
        ]);

       return $createdData;
    }

    private function createProductRate($request , $product)
    {
       $createdData =  ProductRate::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rate' => $request->rate
        ]);
       return $createdData;
    }

    private function updateProductRate( $productRate , $request)
    {
        $updatedData = $productRate->update(['rate' => $request->rate]);

        return $updatedData;
    }

}
