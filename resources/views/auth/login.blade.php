@extends('home.layouts.home')

@section('title')
     ورود
@endsection

@section('script')
    <script>

        $('#checkOTPForm').hide();

        $('#registerForm').submit(function (event){
            event.preventDefault();

            var name = $('#registerName').val();
            var cellphone = $('#phone').val();
            var email = $('#registerEmail').val();
            var password = $('#registerPassword').val();

            $.post("{{ route('auth.register') }}" , {
                '_token' : "{{ csrf_token() }}",
                'name' : name,
                'cellphone' : cellphone,
                'email' : email,
                'password' : password
            }, function (response , status)
            {
                console.log(response , status)
                Swal.fire({
                    icon : 'success',
                    text : 'رمز یکبار مصرف برای شما ارسال شد',
                    doneButtonText : 'تایید',
                    timer : 5000
                });

                $('#registerForm').fadeOut();

                $('#checkOTPForm').fadeIn();
            }).fail(function (response)
            {

                    $('#phone').addClass('mb-1 mt-3');
                    $('#phoneError').fadeIn();
                    $('#phoneInputError').html(response.responseJSON.errors ['cellphone'] ?? '');

                    $('#registerName').addClass('mb-1 mt-3');
                    $('#registerNameError').fadeIn();
                    $('#registerNameInputError').html(response.responseJSON.errors ['name'] ?? ['']);

                    $('#registerPassword').addClass('mb-1 mt-3');
                    $('#registerPasswordError').fadeIn();
                    $('#registerPasswordInputError').html(response.responseJSON.errors ['password'] ?? ['']);

                    $('#registerEmail').addClass('mb-1 mt-3');
                    $('#registerEmailError').fadeIn();
                    $('#registerEmailInputError').html(response.responseJSON.errors ['email'] ?? ['']);

            })
        })

        $('#checkOTPForm').submit(function (event){
            event.preventDefault();

            var otp = $('#checkOTPInput').val();

            $.post( "{{ url('/check-otp') }}" ,
                {
                    '_token' : "{{ csrf_token() }}",
                    'otp' : otp,

                } , function (data , status)
                {
                    console.log(data , status)
                }).fail(function (response)
            {
                $('#checkOTPInput').addClass('mb-1 mt-3');
                $('#checkOTPInputError').fadeIn();
                $('#checkOTPInputErrorText').html(response.responseJSON.errors[0]);
            });
        })

    </script>
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> ورود </li>
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
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> ورود </h4>
                            </a>
                            <a data-toggle="tab" href="#lg2">
                                <h4> عضویت </h4>
                            </a>
                        </div>
                        <div class="tab-content">

                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf

                                            @error('email')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <input type="email" name="email" placeholder="ایمیل" value="{{ old('email') }}">

                                            @error('password')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <input type="password" name="password" placeholder="رمز عبور">

                                            <div class="button-box">
                                                <div class="login-toggle-btn d-flex justify-content-between">
                                                    <div>
                                                        <input name="remember" type="checkbox" {{ old('remember') ? 'checked' : ''}}>
                                                        <label> مرا بخاطر بسپار </label>
                                                    </div>
                                                    <a href="{{ route('password.request') }}"> فراموشی رمز عبور ! </a>
                                                </div>
                                                <button type="submit">ورود</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="lg2" class="tab-pane">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form id="registerForm" method="post">

                                            <input id="registerName" placeholder="نام" type="text">
                                            <div id="registerNameError" class="input-error-validation">
                                                <strong id="registerNameInputError"></strong>
                                            </div>


                                            <input id="phone" placeholder="شماره موبایل" type="text">
                                            <div id="phoneError" class="input-error-validation">
                                                <strong id="phoneInputError"></strong>
                                            </div>


                                            <input id="registerEmail" placeholder="ایمیل" type="email">
                                            <div id="registerEmailError" class="input-error-validation">
                                                <strong id="registerEmailInputError"></strong>
                                            </div>


                                            <input type="Password" id="registerPassword" placeholder="رمز عبور">
                                            <div id="registerPasswordError" class="input-error-validation">
                                                <strong id="registerPasswordInputError"></strong>
                                            </div>

                                            <div id="submitRegisterForm" class="button-box">
                                                <button type="submit">ارسال</button>
                                            </div>

                                        </form>

                                        <form id="checkOTPForm" method="post">

                                            <input id="checkOTPInput" placeholder="رمز یکبار مصرف" type="text">
                                            <div id="checkOTPInputError" class="input-error-validation">
                                                <strong id="checkOTPInputErrorText"></strong>
                                            </div>

                                            <div id="submitCheckOTPForm" class="button-box">
                                                <button type="submit">عضویت</button>
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

