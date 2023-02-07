@extends('admin.layouts.admin')

@section('title')
    لیست کوپن ها
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-0">لیست کوپن ها ({{ $coupons->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.coupons.create') }}">
                        <i class="fa fa-plus"></i>
                        ایجاد کد تخفیف
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>کد</th>
                        <th>نوع</th>
                        <th>تارخ انقضا</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupons as $key => $coupon)
                        <tr>
                            <th>{{ $coupons->firstItem() + $key }}</th>
                            <th>{{ $coupon->name }}</th>
                            <th>{{ $coupon->code }}</th>
                            <th>{{ $coupon->type }}</th>
                            <th>{{ verta($coupon->expired_at)->format('%d %B %Y   H:i') }} </th>
                            <th>
                                <a class="btn btn-sm btn-outline-primary mt-2"
                                   href="{{ route('admin.coupons.show' , $coupon->id) }}">نمایش</a>

                            <form action="{{ route('admin.coupons.destroy' , $coupon->id) }}" method="post" style="display: inline-block">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger mt-2 mr-2"  type="submit"
                                        onclick="return confirm('آیا از حذف کوپن {{ $coupon->name }} اطمینان دارید ؟')" >حذف</button>
                            </form>

                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $coupons->render() }}
            </div>
        </div>
@endsection
