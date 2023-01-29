@extends('admin.layouts.admin')

@section('title')
     نظر   {{ $comment->user->name }}
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">نظر برای محصول : {{ $comment->product->name }}</h5>
            </div>
            <hr>
            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="name">نام کاربر</label>
                    <input class="form-control" value="{{ $comment->user->name }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="name">نام محصول</label>
                    <input class="form-control" value="{{ $comment->product->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">وضعیت</label>
                    <input class="form-control" value="{{ $comment->approved }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">تاریخ ثبت نظر</label>
                    <input class="form-control" value="{{ verta($comment->created_at)->format('%d %B %Y   H:i') }}" disabled>
                </div>
                     <div class="form-group col-md-12">
                         <label for="name">متن نظر</label>
                         <textarea class="form-control" disabled>{{ $comment->text }}</textarea>
                     </div>
            </div>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-dark mt-5">بازگشت</a>

            @if(!$comment->getRawOriginal('approved'))
                <a href="{{ route('admin.comments.changeApprove' , $comment->id) }}" class="btn btn-success mt-5 mr-3">تایید نظر</a>
            @else
                <a href="{{ route('admin.comments.changeApprove' , $comment->id) }}" class="btn btn-danger mt-5 mr-3">عدم تایید نظر</a>
            @endif
        </div>
    </div>

@endsection
