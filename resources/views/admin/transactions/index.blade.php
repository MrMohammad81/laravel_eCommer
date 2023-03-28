@extends('admin.layouts.admin')

@section('title')
    لیست تراکنش ها
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تراکنش ها</h5>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کابر</th>
                        <th>شماره سفارش</th>
                        <th>مبلغ</th>
                        <th>نوع پرداخت</th>
                        <th>نام درگاه پرداخت</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $key => $transaction)
                        <tr>
                            <th>{{ $transactions->firstItem() + $key }}</th>
                            <th>{{ $transaction->user->name == null ? 'کاربر' : $transaction->user->name }}</th>
                            <th>{{ $transaction->order->order_number }}</th>
                            <th>{{ number_format($transaction->amount) }} تومان</th>
                            <th>{{ $transaction->order->payment_type }}</th>
                            <th>{{ $transaction->gateway_name }}</th>
                            <th>
                                <span class="{{ $transaction->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                     {{ $transaction->status }}
                                </span>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $transactions->render() }}
            </div>
        </div>
@endsection

