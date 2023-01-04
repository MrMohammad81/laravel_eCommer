
@extends('admin.layouts.admin')

@section('title')
    ویرایش تصاویر
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

        $('#images').change(function() {

            var fileName = $(this).val();

            $(this).next('.custom-file-label').html(fileName);
        });

    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">بروزرسانی تصاویر محصول {{ $product->name }}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')

            {{-- Show Primary Image --}}
            <div class="row">
                <div class="col-md-12 col-12 mb-5">
                    <h5>تصویر اصلی :</h5>
                </div>
                <div class="col-md-3 col-12 mb-5">
                    <div class="card">
                        <img class="card-img-top" src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATCH').$product->primary_image) }}"
                             alt="خطا در دریافت تصویر {{ $product->name }}">
                    </div>
                </div>
            </div>

            {{-- Show Images --}}
            <hr>
            <div class="row">
                <div class="col-md-12 col-12 mb-3">
                    <h5>تصاویر :</h5>
                </div>
                @foreach($product->images as $image)
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATCH') . $image->images) }}"
                                 alt="خطا در دریافت تصویر {{ $product->name }}">
                            <div class="card-body text-center">
                                <form action="{{ route('admin.product.images.destroy' , $product->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="image_id" value="{{$image->id}}">
                                    <button type="submit" onclick="return confirm('آیا از حذف این تصویر اطمینان دارید ؟')" class="btn btn-danger btn-sm mb-3">حذف</button>
                                </form>
                                <form action="{{ route('admin.product.images.set_primary' , $product->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="image_id" value="{{$image->id}}">
                                    <button type="submit" onclick="return confirm('آیا از ثبت این تصویر به عنوان تصویر اصلی محصول اطمینان دارید ؟')" class="btn btn-primary btn-sm mb-3">انتخاب به عنوان تصویر اصلی</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            <hr>

            {{-- upload images --}}
            <form action="{{ route('admin.products.images.add' , $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mt-6">
                    <div class="form-group col-md-4">
                        <label for="primary_image"> انتخاب تصویر اصلی </label>
                        <div class="custom-file">
                            <input type="file" name="primary_image" class="custom-file-input" id="primary_image">
                            <label class="custom-file-label" for="primary_image" title="">انتخاب فایل</label>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="images"> انتخاب تصاویر </label>
                        <div class="custom-file">
                            <input type="file" name="images[]" multiple class="custom-file-input" id="images">
                            <label class="custom-file-label" for="images"> انتخاب فایل ها </label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success mt-5" type="submit">بروزرسانی</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>



@endsection
