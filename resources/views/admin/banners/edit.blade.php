@extends('admin.layouts.admin')

@section('title')
    ویرایش بنر
@endsection

@section('script')
    <script>
        $('#primary_image').change(function ()
        {
            // get image name
           var fileName = $(this).val();

           // show image name in input
           $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">بروزرسانی بنر : {{ $banner->image }}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.banners.update' , $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row justify-content-center ">
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="{{ url(env('BANNER_IMAGE_UPLOAD_PATCH').$banner->image ) }}">
                        </div>
                    </div>
                </div>

                <hr class="mt-3">

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">انتخاب تصویر</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="primary_image">
                            <label class="custom-file-label" for="primary_image" title="">انتخاب فایل</label>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">عنوان</label>
                        <input class="form-control" value="{{ $banner->title }}" name="title" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">متن</label>
                        <input class="form-control" value="{{ $banner->text }}" name="text" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">اولویت</label>
                        <input class="form-control" value="{{ $banner->priority }}" name="priority" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" name="is_active">
                            <option value="1" {{ $banner->getRawOriginal('is_active') ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ $banner->getRawOriginal('is_active') ? '' : 'selected' }}>غیر فعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">نوع بنر</label>
                        <input class="form-control" value="{{ $banner->type }}" name="type" type="text">
                    </div>


                    <div class="form-group col-md-3">
                        <label for="is_active">متن دکمه</label>
                        <input class="form-control" value="{{ $banner->button_text }}" name="button_text" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">لینک دکمه</label>
                        <input class="form-control" value="{{ $banner->button_link }}" name="button_link" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">آیکون دکمه</label>
                        <input class="form-control" value="{{ $banner->button_icon }}" name="button_icon" type="text">
                    </div>
                </div>
                <button class="btn btn-success mt-5" type="submit">بروزرسانی</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
