@extends('admin.layouts.admin')

@section('title')
    لیست تگ ها
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تگ ها  ({{ $tags->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.brands.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد تگ
                </a>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $key => $tag)
                        <tr>
                            <th>{{ $tags->firstItem() + $key }}</th>
                            <th>{{ $tag->name }}</th>
                            <th>
                                <a class="btn btn-sm btn-outline-success" href="{{ route('admin.tags.show' , $tag->id) }}">نمایش</a>
                                <a class="btn btn-sm btn-outline-info mr-3" href="{{ route('admin.tags.edit' , $tag->id) }}">ویرایش</a>
                                <form action="{{ route('admin.tags.destroy' , $tag->id) }}" method="post" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('آیا از حذف برند {{ $tag->name }} اطمینان دارید ؟')"  class="btn btn-sm btn-outline-danger mr-3"  type="submit">حذف</button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
