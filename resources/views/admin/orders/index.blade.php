@extends('admin.layouts.admin')

@section('title')
    لیست سفارشات
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست سفارشات</h5>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کابر</th>
                        <th>وضعیت</th>
                        <th>مبلغ</th>
                        <th>نوع پرداخت</th>
                        <th>وضعیت پرداخت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key => $order)
                        <tr>
                            <th>{{ $orders->firstItem() + $key }}</th>
                            <th>{{ $order->user->name == null ? 'کاربر' : $order->user->name }}</th>
                            <th>{{ $order->status }}</th>
                            <th>{{ number_format($order->total_amount) }} تومان</th>
                            <th>{{ $order->payment_type }}</th>
                            <th>
                                <span class="{{ $order->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                     {{ $order->status }}
                                </span>
                            </th>
                            <th>
                                <a class="fa fa-eye" href="{{ route('admin.orders.show' , $order->id) }}"></a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $orders->render() }}
            </div>
        </div>
@endsection

