@extends('home.layouts.home')

@section('title')
    ثبت نام
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active">ثبت نام</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg2">
                                <h4> ثبت نام </h4>
                            </a>
                        </div>
                        <div class="tab-content">

                            <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('register') }}" method="post">
                                            @csrf

                                            @error('name')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <input name="name" placeholder="نام" type="text" value="{{ old('name') }}">

                                            @error('email')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <input name="email" placeholder="ایمیل" type="email" value="{{ old('email') }}">

                                            @error('password')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <input type="password" name="password" placeholder="رمز عبور">

                                            @error('password_confirmation')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <input type="password" name="password_confirmation" placeholder="تکرار رمز عبور">

                                            <div class="button-box">
                                                <button type="submit">عضویت</button>
                                                <a href="{{ route('login') }}" style="margin-right: 270px; font-size: 15px;">حساب کاربری دارم...</a>
                                                <a href="index.html" class="btn btn-google btn-block mt-4">
                                                    <i class="sli sli-social-google"></i>
                                                    ایجاد اکانت با گوگل
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

