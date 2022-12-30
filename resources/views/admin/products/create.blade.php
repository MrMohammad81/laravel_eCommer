@extends('admin.layouts.admin')

@section('title')
افزودن محصول
@endsection


@section('script')
    <script type="text/javascript">
        $('#brandSelect').selectpicker();
        $('#tagSelect').selectpicker();
        $('#categorySelect').selectpicker();

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

        $('#attributesContainer').hide();

        $('#categorySelect').on('changed.bs.select' , function () {
            var categoryID = $('#categorySelect').val();

            $.get( `{{ url('api/category-attributes/${categoryID}') }}` , function (response , status)
            {
                $('#attributesContainer').fadeIn();

                if(status == 'success')
                {
                    // Empty Attribute Container
                    $('#attributeInput').find('div').remove();

                    // Create and Append Attributes Input
                    response.attributes.forEach(attribute => {
                        let attributeFormGroup = $('<div/>', {
                            class: 'form-group col-md-3'
                        });
                        attributeFormGroup.append($('<label/>', {
                            for: attribute.name,
                            text: attribute.name
                        }));

                        attributeFormGroup.append($('<input/>', {
                            type: 'text',
                            class : 'form-control',
                            id : attribute.name,
                            name : `attribute_ids[${attribute.id}]`
                        }));

                        $('#attributeInput').append(attributeFormGroup);

                    });

                    $('#variationName').text(response.variations.name);

                }else {
                    alert('مشکل در دریافت لیست ویژگی ها')
                }

            }).fail(function (){
                alert('مشکل در دریافت لیست ویژگی ها')
            });
        });

        $('#czContainer').czMore();

        $('#delivery_amount').digts();

    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد محصول</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brand_id">برند</label>
                        <select id="brandSelect" name="brand_id" class="selectpicker form-control " data-live-search="true" title="انتخاب برند">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" selected>فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tag_ids">تگ</label>
                        <select id="tagSelect" name="tag_ids[]" class="selectpicker form-control " multiple data-live-search="true" title="انتخاب تگ">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    </div>

                    {{-- product image section --}}

                    <div class="col-md-12">
                        <hr>
                        <p>تصاویر محصول :</p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="primary_image"> انتخاب تصویر اصلی </label>
                        <div class="custom-file">
                            <input type="file" name="primary_image" class="custom-file-input" id="primary_image">
                            <label class="custom-file-label" for="primary_image" title="">انتخاب فایل</label>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="images"> انتخاب تصاویر </label>
                        <div class="custom-file">
                            <input type="file" name="images[]" multiple class="custom-file-input" id="images">
                            <label class="custom-file-label" for="images"> انتخاب فایل ها </label>
                        </div>
                    </div>

                    {{-- category attribute section --}}

                    <div class="col-md-12">
                        <hr>
                        <p> دسته بندی و ویژگی ها :</p>
                    </div>

                   <div class="col-md-12">
                       <div class="row justify-content-center">
                           <div class="form-group col-md-3">
                               <label for="category_id">دسته بندی</label>
                               <select id="categorySelect" name="category_id" class="selectpicker form-control " data-live-search="true" title="انتخاب دسته بندی">
                                   @foreach ($categories as $category)
                                       <option value="{{ $category->id }}">{{ $category->name }} - {{ $category->parent->name }}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                   </div>

                    <div id="attributesContainer" class="col-md-12">
                        <div id="attributeInput" class="row attributeInput"></div>
                            <div class="col-md-12">
                                <hr>
                                <p>افزودن قیمت و موجودی برای متغیر : <span class="font-weight-bold" id="variationName"></span></p>
                            </div>
                        <div id="czContainer">
                            <div id="first">
                                <div class="recordset">
                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <label for="value">نام</label>
                                            <input class="form-control"  name="variation_values[value][]" type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="price">قیمت</label>
                                            <input class="form-control"  name="variation_values[price][]" type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="quantity">تعداد</label>
                                            <input class="form-control"  name="variation_values[quantity][]" type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="sku">شناسه انبار</label>
                                            <input class="form-control"  name="variation_values[sku][]" type="text">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- delivery section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>هزینه ارسال : (تومان)</p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount">هزینه ارسال</label>
                        <input class="form-control" id="delivery_amount"  name="delivery_amount" type="text" value="{{ old('delivery_amount') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount_per_product" class="mr-5">هزینه ارسال به ازای محصول اضافی</label>
                        <input class="form-control mr-5" name="delivery_amount-per-product" type="text" value="{{ old('delivery_amount-per-product') }}">
                    </div>

                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
