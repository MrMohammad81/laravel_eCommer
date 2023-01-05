@extends('admin.layouts.admin')

@section('title')
    لیست بنرها
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست بنرها ({{ $banners->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.banners.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد بنر
                </a>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>متن</th>
                        <th>اولویت</th>
                        <th>وضعیت</th>
                        <th>نوع</th>
                        <th>متن دکمه</th>
                        <th>لینک دکمه</th>
                        <th>آیکون دکمه</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($banners as $key => $banner)
                        <tr>
                            <th>{{ $banners->firstItem() + $key }}</th>
                            <th>
                                <a target="_blank" href="{{ url(env('BANNER_IMAGE_UPLOAD_PATCH').$banner->image )}}">{{ $banner->image }}</a>
                            </th>
                            <th>{{ $banner->title }}</th>
                            <th>{{ $banner->text }}</th>
                            <th>{{ $banner->priority }}</th>
                            <th>
                                <span class="{{ $banner->getRawOriginal('is_active') ? 'text-success' : 'text-danger'}}">
                                    {{ $banner->is_active }}
                                </span>
                            </th>
                            <th>{{ $banner->type }}</th>
                            <th>{{ $banner->button_text }}</th>
                            <th>{{ $banner->button_link }}</th>
                            <th>{{ $banner->button_icon }}</th>
                            <th>
                                <form action="{{ route('admin.banners.destroy' , $banner->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger"  type="submit"
                                            onclick="return confirm('آیا از حذف بنر {{ $banner->title }} اطمینان دارید ؟')" >حذف</button>
                                </form>
                                <a class="btn btn-sm btn-outline-primary mt-2"
                                   href="{{ route('admin.banners.edit' , $banner->id) }}">ویرایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $banners->render() }}
            </div>
        </div>
@endsection
