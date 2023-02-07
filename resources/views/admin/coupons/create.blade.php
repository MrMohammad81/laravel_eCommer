@extends('admin.layouts.admin')

@section('title')
ایجاد کوپن
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
                <h5 class="font-weight-bold">ایجاد کد تخفیف</h5>
            </div>
            <div class="container-fluid">
                <span class="font-weight-bold alert alert-warning" style="margin-right: 20px; display: inline-block">
                    در صورتی که کد تخفیف مبلغی را انتخاب کردید فیلد درصد و حداکثر مبلغ برای نوع درصدی را پر نکنید.
                    و درصورتی که نوع درصدی را انتخاب کردید ، فیلد مبلغ را پر نکنید.
                </span>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام </label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="code">کد </label>
                        <input class="form-control" id="code" name="code" type="text" value="{{ old('code') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="type">کد </label>
                        <select class="form-control" id="type" name="type" type="text">
                            <option id="amount_type" value="amount">مبلغی</option>
                            <option id="percentage_type" value="percentage">درصدی</option>
                        </select>
                    </div>

                    <div id="amount" class="form-group col-md-3">
                        <label for="amount">مبلغ </label>
                        <input class="form-control"  name="amount" type="text" value="{{ old('amount') }}">
                    </div>

                    <div id="percentage" class="form-group col-md-3">
                        <label for="percentage">درصد </label>
                        <input class="form-control" name="percentage" type="text" value="{{ old('percentage') }}">
                    </div>

                    <div id="max_percentage_amount" class="form-group col-md-3">
                        <label for="max_percentage_amount">حداکثر مبلغ برای نوع درصدی </label>
                        <input class="form-control"  name="max_percentage_amount" type="text" value="{{ old('max_percentage_amount') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label> تاریخ تاریخ انقضا </label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                                <span class="input-group-text" id="expiredDate">
                                    <i class="fa fa-clock"></i>
                                </span>
                            </div>
                            <input data-jdp autocomplete="off" type="text" id="expiredInput"
                                   class="form-control"
                                   name="expire_at">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    </div>
                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
