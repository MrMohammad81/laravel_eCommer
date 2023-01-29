@extends('admin.layouts.admin')

@section('title')
    لیست نظرات
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-0">لیست نظرات ({{ $comments->total() }})</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>نام محصول</th>
                        <th>متن نظر</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $key => $comment)
                        <tr>
                            <th>{{ $comments->firstItem() + $key }}</th>
                            <th>{{ $comment->user->name }}</th>
                                <th>
                                    <a href="{{ route('admin.products.show' , $comment->product->id) }}">
                                    {{ $comment->product->name }}
                                    </a>
                                </th>
                            <th>{{ $comment->text }}</th>

                            <th>
                                <span class="{{ $comment->getRawOriginal('approved') ? 'text-success' : 'text-warning'}}">
                                    {{ $comment->approved }}
                                </span>
                            </th>
                            <th>
                                <a href="{{ route('admin.comments.show' , $comment->id) }}" class="btn btn-sm btn-outline-success">نمایش</a>
                                <form action="{{ route('admin.comments.destroy' , $comment->id) }}" method="post" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('آیا از حذف نظر {{ $comment->user->name }}  اطمینان دارید ؟')" class="btn btn-sm btn-outline-danger mr-3" type="submit">حذف</button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $comments->render() }}
            </div>
        </div>
@endsection
