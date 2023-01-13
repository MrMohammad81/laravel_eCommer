<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title')</title>

    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('home/img/favicon.png') }}" />
    <!-- Custom styles for this template-->

    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('home/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('home/css/_testimonial.css') }}" >
    <link href="{{ asset('home/css/_slider.css') }}" >
    <link href="{{ asset('home/css/_blog.css') }}" >
    <link href="{{ asset('home/css/_about-us.css') }}">
    <link href="{{ asset('home/rating-star/awesomeRating.min.css') }}">

    @yield('style')

</head>
<body>

<div class="wrapper">

    {{-- Header --}}
    @include('home.sections.header')

    {{-- mobile-off-canvas --}}
    @include('home.sections.mobile_off_canvas')

    @yield('content')

    {{-- Footer --}}
    @include('home.sections.footer')


</div>


<!-- JavaScript-->
<script src="{{ asset('home/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('home/js/popper.min.js') }}"></script>
<script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('home/js/plugins.js') }}"></script>
<script src="{{ asset('home/js/ajax-mail.js') }}"></script>
<script src="{{ asset('home/js/main.js') }}"></script>
<script src="{{ asset('home/rating-star/dist/rating.js') }}"></script>

@yield('script')
@include('sweetalert::alert')

</body>

</html>
