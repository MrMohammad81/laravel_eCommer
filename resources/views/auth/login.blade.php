@extends('home.layouts.home')

@section('title')
     ورود
@endsection

@section('script')
    <script>

         let loginToken;

        $('#resendOTPButton').hide();
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
            }, function (response)
            {
                window.localStorage.setItem('login_token' , response.login_token)
                loginToken = response.login_token;
                Swal.fire({
                    icon : 'success',
                    text : 'ثبت نام شما با موفقیت انجام شد',
                    doneButtonText : 'تایید',
                    timer : 5000
                });

                $(location).attr('href' , "{{ route('home.index') }}");

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

        $('#loginForm').submit(function (event){
            event.preventDefault();

            var logEmail = $('#loginEmail').val();
            var logPassword = $('#loginPassword').val();

            $.post("{{ route('auth.login') }}" ,
                {
                    '_token' : "{{ csrf_token() }}",
                    'email' : logEmail,
                    'password' : logPassword,
                } , function (response)
                {
                    //console.log(response)
                    console.log(window.localStorage.getItem('login_token'));

                    Swal.fire({
                        icon : 'success',
                        text : 'رمز یکبار مصرف برای شما ارسال شد',
                        doneButtonText : 'تایید',
                        timer : 5000
                    });

                    $('#loginForm').fadeOut();
                    $('#checkOTPForm').fadeIn();
                    timer();

                }).fail(function (response)
            {
                console.log(response)
                $('#loginEmail').addClass('mb-1 mt-3');
                $('#loginEmailError').fadeIn();
                $('#loginEmailInputError').html(response.responseJSON.errors ['email'] ?? '');

                $('#loginPassword').addClass('mb-1 mt-3');
                $('#loginPasswordError').fadeIn();
                $('#loginPasswordInputError').html(response.responseJSON.errors ['password'] ?? '');

                $('#loginPassword').addClass('mb-1 mt-3');
                $('#loginPasswordError').fadeIn();
                $('#loginPasswordInputError').html(response.responseJSON.errors);
            })
        })

        $('#checkOTPForm').submit(function (event){
            event.preventDefault();
            var otp = $('#checkOTPInput').val();

            $.post( "{{ route('auth.checkOTP') }}" ,
                {
                    '_token' : "{{ csrf_token() }}",
                    'otp' : otp,

                } , function (response)
                {
                    $(location).attr('href' , "{{ route('home.index') }}");

                    Swal.fire({
                        icon : 'success',
                        text : 'ورود با موفقیت انجام شد',
                        doneButtonText : 'تایید',
                        timer : 5000
                    });

                }).fail(function (response)
            {
                $('#checkOTPInput').addClass('mb-1 mt-3');
                $('#checkOTPInputError').fadeIn();
                $('#checkOTPInputErrorText').html(response.responseJSON.errors['otp']);
            });
        })

         $('#resendOTPButton').click(function (event)
         {
             event.preventDefault();

             $.post("{{ route('auth.resendOTP') }}" , {
                 '_token' : "{{ csrf_token() }}" ,
                 'login_token' : window.localStorage.getItem('login_token')
             } , function (response)
             {
                 console.log(response);

                 Swal.fire({
                     icon : 'success',
                     text : 'رمز یکبار مصرف برای شما ارسال شد',
                     doneButtonText : 'تایید',
                     timer : 5000
                 });

                 $('#resendOTPButton').fadeOut();
                 $('#resendOTPTimer').fadeIn();
                 timer();

             }).fail(function (response)
             {
                 console.log(response)
                 // Swal.fire({
                 //     icon : 'error',
                 //     text : 'خطا در ارسال رمز یکبار مصرف ، مجدادا تلاش نمایید',
                 //     doneButtonText : 'تایید',
                 //     timer : 5000
                 // });
                 //$('#resendOTPTimer').html(response.responseJSON.errors);
             })
         })


         function timer()
         {
             let time = "0:3";
             let interval = setInterval(function() {
                 let countdown = time.split(':');
                 let minutes = parseInt(countdown[0], 10);
                 let seconds = parseInt(countdown[1], 10);
                 --seconds;
                 minutes = (seconds < 0) ? --minutes : minutes;
                 if (minutes < 0)
                 {
                     clearInterval(interval);
                     $('#resendOTPTimer').hide();
                     $('#resendOTPButton').fadeIn();
                 }
                 seconds = (seconds < 0) ? 59 : seconds;
                 seconds = (seconds < 10) ? '0' + seconds : seconds;
                 //minutes = (minutes < 10) ?  minutes : minutes;
                 $('#resendOTPTimer').html(minutes + ':' + seconds);
                 time = minutes + ':' + seconds;
             }, 1000);
         }

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
                                        <form id="loginForm">

                                            <input type="email" id="loginEmail" placeholder="ایمیل" value="{{ old('email') }}">
                                            <div id="loginEmailError" class="input-error-validation">
                                                <strong id="loginEmailInputError"></strong>
                                            </div>


                                            <input type="password" id="loginPassword" placeholder="رمز عبور">
                                            <div id="loginPasswordError" class="input-error-validation">
                                                <strong id="loginPasswordInputError"></strong>
                                            </div>

                                            <div class="button-box">
                                                <div class="login-toggle-btn d-flex justify-content-between">
                                                    <div>
                                                        <input name="remember" type="checkbox" {{ old('remember') ? 'checked' : ''}}>
                                                        <label> مرا بخاطر بسپار </label>
                                                    </div>
                                                    <a href="{{ route('password.request') }}"> فراموشی رمز عبور ! </a>
                                                </div>
                                                <button type="submit">ارسال</button>
                                            </div>
                                        </form>

                                        <form id="checkOTPForm" method="post">

                                            <input id="checkOTPInput" placeholder="رمز یکبار مصرف" type="text">
                                            <div id="checkOTPInputError" class="input-error-validation">
                                                <strong id="checkOTPInputErrorText"></strong>
                                            </div>

                                            <div id="submitCheckOTPForm" class="button-box d-flex justify-content-between">
                                                <button type="submit">ورود</button>
                                                <div>
                                                    <button id="resendOTPButton" type="submit">ارسال مجدد</button>
                                                    <span id="resendOTPTimer"></span>
                                                </div>
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

