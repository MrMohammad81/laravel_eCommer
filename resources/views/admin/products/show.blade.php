@extends('admin.layouts.admin')

@section('title')
    محصول {{ $product->name }}
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">محصول : {{ $product->name }}</h5>
            </div>
            <hr>
            <div class="form-row">
                     <div class="form-group col-md-3">
                         <label for="name">نام</label>
                        <input class="form-control" value="{{ $product->name }}" disabled>
                     </div>
                <div class="form-group col-md-3">
                    <label for="name">نام برند</label>
                    <input class="form-control" value="{{ $product->brand->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">دسته بندی</label>
                    <input class="form-control" value="{{ $product->category->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">وضعیت</label>
                    <input class="form-control" value="{{ $product->is_active }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">تاریخ ایجاد</label>
                    <input class="form-control" value="{{ verta($product->updated_at)->format('%d %B %Y   H:i') }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">تاریخ آخرین بروزرسانی</label>
                    <input class="form-control" value="{{ verta($product->updated_at)->format('%d %B %Y   H:i') }}" disabled>
                </div>
                <div class="form-group col-md-12">
                    <label for="name">توضیحات</label>
                    <textarea class="form-control" id="description" disabled name="description">{{ $product->description }}</textarea>
                </div>
            </div>

            <hr>

                <h5>هزینه ارسال : ( تومان )</h5>
            <div class="form-row mt-3">
                <div class="form-group col-md-3">
                    <label for="name">هزینه ارسال</label>
                    <input class="form-control" value="{{ number_format($product->delivery_amount)  }}" disabled>
                </div>
                <div class="form-group col-md-3 mr-3">
                    <label for="name">هزینه ارسال به ازای محصول اضافی</label>
                    <input class="form-control" value="{{ number_format($product->delivery_amount_per_product)  }}" disabled>
                </div>
            </div>

            <hr>

            {{-- attributes --}}

            <h5>ویژگی ها</h5>
            <div class="form-row mt-3">
                @foreach($productAttributes as $productAttribute)
                <div class="form-group col-md-3">
                    <label>{{ $productAttribute->attribute->name }}</label>
                    <input class="form-control" value="{{ $productAttribute->value }}" disabled>
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
                                            <input type="text" disabled class="form-control" value="{{ number_format($variation->price) }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تعداد </label>
                                            <input type="text" disabled class="form-control" value="{{ $variation->quantity }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> sku </label>
                                            <input type="text" disabled class="form-control" value="{{ $variation->sku }}">
                                        </div>

                                        {{-- Sale Section --}}
                                        <div class="col-md-12">
                                            <p> حراج : </p>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> قیمت حراجی </label>
                                            <input type="text" value="{{ number_format($variation->sale_price) }}" disabled
                                                   class="form-control">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تاریخ شروع حراجی </label>
                                            <input type="text"
                                                   value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}"
                                                   disabled class="form-control">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تاریخ پایان حراجی </label>
                                            <input type="text"
                                                   value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}"
                                                   disabled class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Sale Section --}}

                    <div class="col-md-12">
                        <hr>
                        <p> تصاویر محصول : </p>
                    </div>
                <div class="col-md-3">
                    <div class="card>">
                        <img class="card-img-top" src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATCH') . $product->primary_image) }}" alt="{{ $product->name }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>
                    @foreach($images as $image)
                        <div class="col-md-3">
                            <div class="card>">
                                <img class="card-img-top" src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATCH') . $image->images) }}" alt="{{ $product->name }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>

@endsection
