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

    public function changeApprove(Comment $comment)
    {
        if ($comment->getRawOriginal('approved')) {
            $this->updateCommentApproved($comment, 0);
        }
        else{
            $this->updateCommentApproved($comment,1);
        }

        alert()->success('' , 'وضعیت کامنت مورد نظر با موفقیت تغیر کرد')->persistent('تایید');
        return redirect()->route('admin.comments.index');

    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        alert()->success('' , "کامنت مورد نظر با موفقیت حذف شد")->persistent('تایید');
        return redirect()->back();
    }

    private function updateCommentApproved( $comment , $status)
    {
       $status = $comment->update([
            'approved' => $status
        ]);
       return $status;
    }
}
