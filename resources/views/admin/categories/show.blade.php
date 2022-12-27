@extends('admin.layouts.admin')

@section('title')
    دسته بندی {{ $category->name }}
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">دسته بندی  : {{ $category->name }}</h5>
            </div>
            <hr>
            <div class="form-row">
                     <div class="form-group col-md-3">
                         <label for="name">نام</label>
                        <input class="form-control" value="{{ $category->name }}" disabled>
                     </div>
                <div class="form-group col-md-3">
                    <label for="name">نام والد</label>
                    <input class="form-control" value="@if($category->parent_id != 0){{ $category->parent->name }}@else{{ $category->name }}@endif" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="name">وضعیت</label>
                    <input class="form-control" value="{{ $category->is_active }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">تاریخ ایجاد</label>
                    <input class="form-control" value="{{ verta($category->created_at)->format('%d %B %Y   H:i') }}" disabled>
                </div>
                  </div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>

@endsection
