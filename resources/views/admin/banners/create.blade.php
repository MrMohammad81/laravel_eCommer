@extends('admin.layouts.admin')

@section('title')
    افزودن بنر
@endsection

@section('script')
    <script>
        // Show File Name
        $('#primary_image').change(function() {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد بنر</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                        <input class="form-control" name="title" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">متن</label>
                        <input class="form-control" name="text" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">اولویت</label>
                        <input class="form-control" name="priority" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" name="is_active">
                            <option value="1" selected>فعال</option>
                            <option value="0">غیر فعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">نوع بنر</label>
                        <input class="form-control" name="type" type="text">
                    </div>


                    <div class="form-group col-md-3">
                        <label for="is_active">متن دکمه</label>
                        <input class="form-control" name="button_text" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">لینک دکمه</label>
                        <input class="form-control" name="button_link" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">آیکون دکمه</label>
                        <input class="form-control" name="button_icon" type="text">
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection

