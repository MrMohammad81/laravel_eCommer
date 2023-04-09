@extends('admin.layouts.admin')

@section('title')
    لیست مجوزها
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست مجوزها ({{ $permissions->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.permissions.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد مجوز
                </a>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>نام نمایشی</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr>
                            <th>{{ $permissions->firstItem() + $key }}</th>
                            <th>{{ $permission->name }}</th>
                            <th>{{ $permission->display_name }}</th>
                            <th>
                                <a class="btn btn-sm btn-outline-info mr-3" href="{{ route('admin.permissions.edit' , $permission->id) }}">ویرایش</a>
                                <form action="{{ route('admin.permissions.destroy' , $permission->id) }}" method="post" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('آیا از حذف مجوز {{ $permission->display_name }} اطمینان دارید ؟')"  class="btn btn-sm btn-outline-danger mr-3"  type="submit">حذف</button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $permissions->render() }}
            </div>
        </div>
@endsection
