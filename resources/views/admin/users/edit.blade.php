@extends('admin.layouts.admin')

@section('title')
    ویرایش کاربر
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">بروزرسانی کاربر {{ $user->name }}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.users.update' , $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" name="name" type="text" value="{{ $user->name }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">شماره تلفن</label>
                        <input class="form-control" name="cellphone" type="text" value="{{ $user->cellphone }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">ایمیل</label>
                        <input class="form-control" name="email" type="text" value="{{ $user->email }}">
                    </div>
                </div>
                <button class="btn btn-success mt-5" type="submit">بروزرسانی</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
