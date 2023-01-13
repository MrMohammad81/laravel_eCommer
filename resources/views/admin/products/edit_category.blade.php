@extends('admin.layouts.admin')

@section('title')
    ویرایش دسته بندی و ویژگی
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

    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">بروزرسانی دسته بندی محصول : {{ $product->name }}</h5>
            </div>
            @include('admin.sections.errors')
            <form action="{{ route('admin.products.category.update' , $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">

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
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category->id ? 'selected' : '' }}>{{ $category->name }} - {{ $category->parent->name }}</option>
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
                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
