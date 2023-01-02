@extends('admin.layouts.admin')

@section('title')
    ویرایش محصول
@endsection

@section('style')
    <link href="{{ asset('admin/dateTimePicker/css/jalalidatepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/dateTimePicker/css/jquery.md.bootstrap.datetimepicker.style.css') }}" rel="stylesheet">
@endsection

@section('script')

    <script type="text/javascript" src="{{ asset('admin/dateTimePicker/js/jalalidatepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/dateTimePicker/js/jquery.md.bootstrap.datetimepicker.js') }}"></script>

    <script type="text/javascript">
        $('#brandSelect').selectpicker();
        $('#tagSelect').selectpicker();

        var variations = @json($productVariations);

        variations.forEach( variation => {
            $(`#variationDateSaleOnFrom-${ variation.id }`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateSaleOnFrom-${variation.id}`,
                englishNumber: true,
                enableTimePicker: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss',
            });
            $(`#variationDateSaleOnTo-${ variation.id }`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateSaleOnTo-${variation.id}`,
                englishNumber: true,
                enableTimePicker: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss',
            });
        });
    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                @include('admin.sections.errors')
                <h5 class="font-weight-bold">محصول : {{ $product->name }}</h5>
            </div>
            <hr>
            <form action="{{ route('admin.products.update' , $product->id) }}" method="post">
                @csrf
                @method('put')

               <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input class="form-control" name="name" value="{{ $product->name }}" >
                </div>

                <div class="form-group col-md-3">
                    <label for="brand_id">برند</label>
                    <select id="brandSelect" name="brand_id" class="selectpicker form-control " data-live-search="true" title="انتخاب برند">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brand->id == $product->brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="is_active">وضعیت</label>
                    <select class="form-control" id="is_active" name="is_active">
                        <option value="1" {{ $product->getRawOriginal('is_active') ? 'selected' : '' }}>فعال</option>
                        <option value="0" {{ $product->getRawOriginal('is_active') ? '' : 'selected' }}>غیرفعال</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="tag_ids">تگ</label>
                    <select id="tagSelect" name="tag_ids[]" class="selectpicker form-control " multiple data-live-search="true" title="انتخاب تگ">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id , $ProductTagId) ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label for="name">توضیحات</label>
                    <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                </div>
              </div>

               <hr>

                <h5>هزینه ارسال : ( تومان )</h5>
              <div class="form-row mt-3">
                <div class="form-group col-md-3">
                    <label for="name">هزینه ارسال</label>
                    <input class="form-control" name="delivery_amount" value="{{ $product->delivery_amount  }}">
                </div>
                <div class="form-group col-md-3 mr-3">
                    <label for="name">هزینه ارسال به ازای محصول اضافی</label>
                    <input class="form-control" name="delivery_amount_per_product" value="{{ $product->delivery_amount_per_product  }}">
                </div>
               </div>

              <hr>

               {{-- attributes --}}

              <h5>ویژگی ها</h5>

              <div class="form-row mt-3">
                @foreach($productAttributes as $productAttribute)
                    <div class="form-group col-md-3">
                        <label>{{ $productAttribute->attribute->name }}</label>
                        <input class="form-control" name="attribute_values[{{ $productAttribute->id }}]" value="{{ $productAttribute->value }}">
                    </div>
                @endforeach

                @foreach($productVariations as $variation)
                    <div class="col-md-12">
                        <hr>
                        <div class="d-flex">
                            <p class="mb-0"> قیمت و موجودی برای متغیر ( {{ $variation->value }} ) : </p>
                            <p class="mb-0 mr-3">
                                <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                        data-target="#collapse-{{ $variation->id }}">
                                    نمایش
                                </button>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="collapse mt-2" id="collapse-{{ $variation->id }}">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label> قیمت : (تومان) </label>
                                        <input type="text" name="variation_values[{{ $variation->id }}][price]" class="form-control" value="{{ $variation->price }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تعداد </label>
                                        <input type="text" name="variation_values[{{ $variation->id }}][quantity]" class="form-control" value="{{ $variation->quantity }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> sku </label>
                                        <input type="text" name="variation_values[{{ $variation->id }}][sku]" class="form-control" value="{{ $variation->sku }}">
                                    </div>

                                    {{-- Sale Section --}}
                                    <div class="col-md-12">
                                        <p> حراج : </p>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>قیمت حراجی : (تومان)</label>
                                        <input type="text" name="variation_values[{{ $variation->id }}][sale_price]" value="{{ $variation->sale_price }}"
                                               class="form-control">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تاریخ شروع حراجی </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend order-2">
                                                <span class="input-group-text" id="variationDateSaleOnFrom-{{ $variation->id }}">
                                                    <i class="fa fa-clock"></i>
                                                </span>
                                            </div>
                                            <input data-jdp autocomplete="off" type="text" id="variationInputDateSaleOnFrom-{{ $variation->id }}"
                                                   class="form-control"
                                                   name="variation_values[{{ $variation->id }}][date_on_sale_from]"
                                                   value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تاریخ پایان حراجی </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend order-2">
                                                <span class="input-group-text" id="variationDateSaleOnTo-{{ $variation->id }}">
                                                    <i class="fa fa-clock"></i>
                                                </span>
                                            </div>
                                            <input data-jdp autocomplete="off" type="text" id="variationInputDateSaleOnTo-{{ $variation->id }}"
                                                   class="form-control"
                                                   name="variation_values[{{ $variation->id }}][date_on_sale_to]"
                                                   value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <button class="btn btn-success mt-5" type="submit">بروزرسانی</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
              </div>
            </form>
        </div>
    </div>

@endsection
