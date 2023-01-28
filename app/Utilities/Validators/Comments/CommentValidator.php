<?php

namespace App\Utilities\Validators\Comments;

use Illuminate\Support\Facades\Validator;

class CommentValidator
{
    public static function storeCommentValidator($request)
    {
        $validator = Validator::make($request ,
            [
                'text' => 'required|min:5|max:7000',
                'rate' => 'required|numeric|digits_between:0,5'
            ]);

        return $validator;
    }

    public static function checkUserLogin()
    {
        if (!auth()->check())
           return  false;

        return true;

    }
}
