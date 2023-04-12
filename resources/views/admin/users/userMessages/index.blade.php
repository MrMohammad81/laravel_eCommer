@extends('admin.layouts.admin')

@section('title')
    پیام ها
@endsection
@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست پیام ها</h5>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کابر</th>
                        <th>شماره موبایل</th>
                        <th>ایمیل</th>
                        <th>موضوع پیام</th>
                        <th>متن پیام</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $key => $message)
                        <tr>
                            <th>{{ $messages->firstItem() + $key }}</th>
                            <th>{{ $message->name == null ? 'کاربر' : $message->name }}</th>
                            <th>{{ $message->cellphone }}</th>
                            <th>{{ $message->email }}</th>
                            <th>{{ $message->subject }}</th>
                            <th>{{ $message->text }}</th>
                            <th>
                                <a class="fa fa-eye" href="{{ route('admin.user-messages.show' , $message ) }}"></a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $messages->render() }}
            </div>
        </div>
@endsection

