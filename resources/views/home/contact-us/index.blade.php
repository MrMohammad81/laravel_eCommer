@extends('home.layouts.home')

@section('title')
    تماس با ما
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active">فروشگاه </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row text-right" style="direction: rtl;">
                <div class="col-lg-5 col-md-6">
                    <div class="contact-info-area">
                        <h2> لورم ایپسوم متن </h2>
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                            است.
                        </p>
                        <div class="contact-info-wrap">
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-location-pin"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p> لورم ایپسوم متن ساختگی با تولید سادگی </p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-envelope"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p><a href="#">info@example.com</a> / <a href="#">info@example.com</a></p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-screen-smartphone"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p style="direction: ltr;"> 0910 000 0000 / 0910 000 0000 </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="contact-from contact-shadow">
                        <form action="{{ route('home.contact-us-form') }}" method="post">
                            @csrf

                            <input name="name" type="text" placeholder="نام شما" value="{{ old('name') }}">
                            @error( 'name')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror

                            <input name="cellphone" type="text" placeholder="شماره تماس" value="{{ old('cellphone') }}">
                            @error( 'cellphone')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror

                            <input name="email" type="email" placeholder="ایمیل شما" value="{{ old('email') }}">
                            @error( 'email')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror

                            <input name="subject" type="text" placeholder="موضوع پیام" value="{{ old('subject') }}">
                            @error( 'subject')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror

                            <textarea name="text" placeholder="متن پیام" >{{ old('text') }}</textarea>
                            @error( 'text')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror

                            <button class="submit" type="submit"> ارسال پیام </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="contact-map pt-100">
                <div id="map"></div>
            </div>
        </div>
    </div>
@endsection

