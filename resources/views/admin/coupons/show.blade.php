@extends('admin.layouts.admin')

@section('title')
کوپن {{ $coupon->name }}
@endsection

@section('style')
    <link href="{{ asset('admin/dateTimePicker/css/jalalidatepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/dateTimePicker/css/jquery.md.bootstrap.datetimepicker.style.css') }}" rel="stylesheet">
@endsection

@section('script')

    <script type="text/javascript" src="{{ asset('admin/dateTimePicker/js/jalalidatepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/dateTimePicker/js/jquery.md.bootstrap.datetimepicker.js') }}"></script>

    <script type="text/javascript">
        $('#expiredDate').MdPersianDateTimePicker({
            targetTextSelector: '#expiredInput',
            englishNumber: true,
            enableTimePicker: true,
            textFormat: 'yyyy-MM-dd HH:mm:ss',
        });

    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">نمایش کد تخفیف</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.coupons.update' , $coupon->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام </label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ $coupon->name }}" disabled>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="code">کد </label>
                        <input class="form-control" id="code" name="code" type="text" value="{{ $coupon->code }}" disabled>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="type">نوع </label>
                        <input class="form-control" value="{{ $coupon->type }}" disabled>
                    </div>

                    <div id="amount" class="form-group col-md-3">
                        <label for="amount">مبلغ </label>
                        <input class="form-control"  name="amount" type="text" value="{{ $coupon->amount }}" disabled>
                    </div>

                    <div id="percentage" class="form-group col-md-3">
                        <label for="percentage">درصد </label>
                        <input class="form-control" name="percentage" type="text" value="{{ $coupon->percentage }}" disabled>
                    </div>

                    <div id="max_percentage_amount" class="form-group col-md-3">
                        <label for="max_percentage_amount">حداکثر مبلغ برای نوع درصدی </label>
                        <input class="form-control"  name="max_percentage_amount" type="text" value="{{ $coupon->max_percentage_amount }}" disabled>
                    </div>

                    <div class="form-group col-md-3">
                        <label> تاریخ تاریخ انقضا </label>
                        <div class="input-group">
                            <input class="form-control" value="{{ verta($coupon->expired_at)->format('%d %B %Y   H:i') }}" disabled>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description" disabled>{{ $coupon->description }}</textarea>
                    </div>
                </div>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
