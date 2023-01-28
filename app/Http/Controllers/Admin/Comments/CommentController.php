<?php

namespace App\Http\Controllers\Admin\Comments;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->paginate(15);
        return view('admin.comments.index' , compact('comments'));
    }

    public function show(Comment $comment)
    {
        return view('admin.comments.show' , compact('comment'));
    }
}
