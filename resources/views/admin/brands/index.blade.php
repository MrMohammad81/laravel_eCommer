@extends('admin.layouts.admin')

@section('title')
    لیست برندها
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست برندها ({{ $brands->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.brands.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد برند
                </a>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($brands as $key => $brand)
                        <tr>
                            <th>{{ $brands->firstItem() + $key }}</th>
                            <th>{{ $brand->name }}</th>
                            <th>
                                <span class="{{ $brand->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                    {{ $brand->is_active }}
                                </span>
                            </th>
                            <th>
                                <a class="btn btn-sm btn-outline-success" href="{{ route('admin.brands.show' , $brand->id) }}">نمایش</a>
                                <a class="btn btn-sm btn-outline-info mr-3" href="{{ route('admin.brands.edit' , $brand->id) }}">ویرایش</a>
                                <form action="{{ route('admin.brands.destroy' , $brand->id) }}" method="post" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('آیا از حذف برند {{ $brand->name }} اطمینان دارید ؟')"  class="btn btn-sm btn-outline-danger mr-3"  type="submit">حذف</button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $brands->render() }}
            </div>
        </div>
@endsection
