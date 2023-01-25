@extends('home.layouts.home')

@section('title')
     ورود
@endsection

@section('script')
    <script>

         let loginToken;

        $('#resendOTPButton').hide();
        $('#checkOTPForm').hide();
        $('#resetPasswordForm').hide();
        $('#checkOTPResetPassForm').hide();
        $('#resendOTPResetPassButton').hide();
        $('#changePasswordForm').hide();

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
            }, function ()
            {
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
                    loginToken = response.login_token;

                    Swal.fire({
                        icon : 'success',
                        text : 'رمز یکبار مصرف برای شما ارسال شد',
                        doneButtonText : 'تایید',
                        timer : 5000
                    });

                    $('#loginForm').fadeOut();
                    $('#checkOTPForm').fadeIn();
                    timer($('#resendOTPTimer') , $('#resendOTPButton'));

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
                    'loginToken' : loginToken

                } , function ()
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
                 'loginToken' : loginToken
             } , function (response)
             {
                 console.log(response);

                 Swal.fire({
                     icon : 'success',
                     text : 'رمز یکبار مصرف به شماره ثبت شده شما ارسال شد',
                     doneButtonText : 'تایید',
                     timer : 5000
                 });

                 $('#resendOTPButton').fadeOut();
                 $('#resendOTPTimer').fadeIn();
                 timer($('#resendOTPTimer') , $('#resendOTPButton'));

             }).fail(function (response)
             {                 console.log(response);

                 Swal.fire({
                     icon : 'error',
                     text : 'خطا در ارسال رمز یکبار مصرف ، مجدادا تلاش نمایید',
                     doneButtonText : 'تایید',
                     timer : 5000
                 });
                 $('#resendOTPTimer').html(response.responseJSON.errors);
             })
         })

         $('#resetPassword').click(function (event)
         {
             $('#loginForm').fadeOut();
             $('#resetPasswordForm').fadeIn()
         })

         $('#resetPasswordForm').submit(function (event)
         {
             event.preventDefault();

             var emailForResPass = $('#inputEmailForResetPass').val();

             $.post("{{ route('auth.checkUser.resetPass') }}" ,
                 {
                     '_token' : "{{ csrf_token() }}",
                     'email' : emailForResPass
                 } , function (response)
                 {
                     loginToken = response.login_token;

                     Swal.fire({
                         icon : 'success',
                         text : 'کد بازیابی به شماره ثبت شده شما ارسال شد',
                         doneButtonText : 'تایید',
                         timer : 5000
                     });
                     $('#resetPasswordForm').fadeOut();
                     $('#checkOTPResetPassForm').fadeIn()
                     timer($('#resendOTPResetPassTimer') , $('#resendOTPResetPassButton'));

                 }).fail(function (response)
             {
                 $('#inputEmailForResetPass').addClass('mb-1 mt-3');
                 $('#inputEmailForResetPassError').fadeIn();
                 $('#inputEmailForResetPassErrorText').html(response.responseJSON.errors['email']);
             });

             $('#checkOTPResetPassForm').submit(function (event)
             {
                 event.preventDefault();

                 var resetPassOTP = $('#checkOTPResetPassInput').val();

                 $.post("{{ route('auth.checkOTP.resetPass') }}" ,
                     {
                         '_token' : "{{ csrf_token() }}",
                         'reset_pass_otp' : resetPassOTP,
                         'loginToken' : loginToken
                     } , function (response)
                     {
                         Swal.fire({
                             icon : 'success',
                             text : 'کد بازیابی تایید شد',
                             doneButtonText : 'تایید',
                             timer : 5000
                         });

                         $('#checkOTPResetPassForm').fadeOut();

                         $('#changePasswordForm').fadeIn();

                     }).fail(function (response)
                 {
                     $('#checkOTPResetPassInput').addClass('mb-1 mt-3');
                     $('#checkOTPResetPassInputError').fadeIn();
                     $('#checkOTPResetPassInputErrorText').html(response.responseJSON.errors['reset_pass_otp']);
                 })
             })
         })

         $('#resendOTPResetPassButton').click(function (event)
         {
             event.preventDefault();

             $.post("{{ route('auth.resendOTP.resetPass') }}" ,
                 {
                     '_token' : "{{ csrf_token() }}",
                     'loginToken' : loginToken
                 } , function ()
                 {
                     Swal.fire({
                         icon : 'success',
                         text : 'کد بازیابی مجددا ارسال شد',
                         doneButtonText : 'تایید',
                         timer : 5000
                     });

                     $('#resendOTPResetPassButton').fadeOut();
                     $('#resendOTPResetPassTimer').fadeIn();
                     timer($('#resendOTPResetPassTimer') , $('#resendOTPResetPassButton'));

                 }).fail(function (response)
             {
                 Swal.fire({
                     icon : 'error',
                     text : 'خطا در ارسال کد بازیابی ، مجدادا تلاش نمایید',
                     doneButtonText : 'تایید',
                     timer : 5000
                 });
                 $('#resendOTPResetPassTimer').html(response.responseJSON.errors);
             })
         })

         $('#changePasswordForm').submit(function (event)
         {
             event.preventDefault();

             var newPassword = $('#newPasswordInput').val();
             var confirmationPassword = $('#confirmationPasswordInput').val();

             $.post("{{ route('auth.change.password') }}" ,
                 {
                     '_token' : "{{ csrf_token() }}" ,
                     'loginToken' : loginToken,
                     'password' : newPassword,
                     'confirm_password' : confirmationPassword
                 }, function (response)
                 {
                     Swal.fire({
                         icon : 'success',
                         text : 'رمز عبو شما با موفقیت تغیر کرد',
                         doneButtonText : 'تایید',
                         timer : 5000
                     });

                     $(location).attr('href' , "{{ route('home.index') }}");

                 }).fail(function (response)
             {
                 $('#newPasswordInput').addClass('mb-1 mt-3');
                 $('#newPasswordError').fadeIn();
                 $('#newPasswordErrorText').html(response.responseJSON.errors ['password'] ?? '');

                 $('#confirmationPasswordInput').addClass('mb-1 mt-3');
                 $('#confirmPasswordError').fadeIn();
                 $('#confirmPasswordErrorText').html(response.responseJSON.errors ['confirm_password'] ?? '');
             });
         })

         function timer(timer , button)
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
                     timer.hide();
                     button.fadeIn();
                 }
                 seconds = (seconds < 0) ? 59 : seconds;
                 seconds = (seconds < 10) ? '0' + seconds : seconds;
                 //minutes = (minutes < 10) ?  minutes : minutes;
                 timer.html(minutes + ':' + seconds);
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
                                                    <a id="resetPassword"> فراموشی رمز عبور ! </a>
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

                                        <form id="resetPasswordForm" method="post">

                                            <input id="inputEmailForResetPass" placeholder="ایمیل" type="text">
                                            <div id="inputEmailForResetPassError" class="input-error-validation">
                                                <strong id="inputEmailForResetPassErrorText"></strong>
                                            </div>

                                            <div id="submitCheckOTPForm" class="button-box d-flex justify-content-between">
                                                <button type="submit">ارسال کد بازیابی</button>
                                            </div>
                                        </form>

                                        <form id="checkOTPResetPassForm" method="post">

                                            <input id="checkOTPResetPassInput" placeholder="کد بازیابی" type="text">
                                            <div id="checkOTPResetPassInputError" class="input-error-validation">
                                                <strong id="checkOTPResetPassInputErrorText"></strong>
                                            </div>

                                            <div id="submitCheckOTPForm" class="button-box d-flex justify-content-between">
                                                <button id="checkOTPResetPass" type="submit">تایید</button>
                                                <div>
                                                    <button id="resendOTPResetPassButton" type="submit">ارسال مجدد</button>
                                                    <span id="resendOTPResetPassTimer"></span>
                                                </div>
                                            </div>

                                        </form>

                                        <form id="changePasswordForm" method="post">

                                            <input id="newPasswordInput" placeholder="رمز عبور جدید" type="password">
                                            <div id="newPasswordError" class="input-error-validation">
                                                <strong id="newPasswordErrorText"></strong>
                                            </div>

                                            <input id="confirmationPasswordInput" placeholder="تایید رمز عبور" type="password" required>
                                            <div id="confirmPasswordError" class="input-error-validation">
                                                <strong id="confirmPasswordErrorText"></strong>
                                            </div>

                                            <div class="button-box d-flex justify-content-between">
                                                <button type="submit">تغیر رمز</button>
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

