@extends('admin.layouts.admin')

@section('title')
     سفارش شماره{{ $order->id }}
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">سفارش : {{ $order->user->name }}</h5>
            </div>
            <hr>
            <div class="form-row">
                     <div class="form-group col-md-3">
                         <label for="name">نام کاربر</label>
                        <input class="form-control" value="{{ $order->user->name == null ? 'کاربر' : $order->user->name }}" disabled>
                     </div>
                <div class="form-group col-md-3">
                    <label for="name">کد تخفیف</label>
                    <input class="form-control" value="{{ $order->coupon_id == null ? 'استفاده نشده' : $order->coupon->code }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">وضعیت</label>
                    <input class="form-control" value="{{ $order->status }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">مبلغ (تومان)</label>
                    <input class="form-control" value="{{ number_format($order->total_amount) }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name"> هزینه ارسال (تومان)</label>
                    <input class="form-control" value="{{ number_format($order->delivery_amount) }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name"> مبلغ کد تخفیف (تومان)</label>
                    <input class="form-control" value="{{ $order->coupon_id == null ? 'استفاده نشده' : number_format($order->coupon->amount) }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name"> مبلغ پرداختی (تومان)</label>
                    <input class="form-control" value="{{ number_format($order->paying_amount) }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">نوع پرداخت</label>
                    <input class="form-control" value="{{ $order->payment_type }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">وضعیت پرداخت</label>
                    <input class="form-control" value="{{ $order->payment_status }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">تاریخ ثبت سفارش</label>
                    <input class="form-control" value="{{ verta($order->created_at)->format('%d %B %Y') }}" disabled>
                </div>
                <div class="form-group col-md-12">
                    <label for="name">آدرس</label>
                    <textarea class="form-control" id="description" disabled name="description">{{ $order->address->address .'.    ' . ' کد پستی : '.$order->address->postal_code }}</textarea>
                </div>

                <div class="col-md-12">
                <hr>
                <h5>محصولات</h5>
                    <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th> تصویر محصول </th>
                        <th> نام محصول </th>
                        <th> فی </th>
                        <th> تعداد </th>
                        <th> قیمت کل </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td class="product-thumbnail">
                                <a href="{{ route('home.products.show' , $item->product->slug) }}">
                                    <img width="70" src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATCH') . $item->product->primary_image) }}"
                                         alt="">
                                </a>
                            </td>
                            <td class="product-name">
                                <a href="{{ route('home.products.show' , $item->product->slug) }}">{{ $item->product->name }}</a>
                            </td>
                            <td class="product-price-cart"><span class="amount">
                                                            {{ number_format($item->price) }}
                                                                تومان
                                                            </span></td>
                            <td class="product-quantity">
                                {{ $item->quantity }}
                            </td>
                            <td class="product-subtotal">
                                {{ number_format($item->subtotal + $item->product->delivery_amount) }}
                                تومان
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>

@endsection
