@extends('home.layouts.home')

@section('title')
صفحه اصلی
@endsection

@section('script')
    <script>
        $('.variation-select').on('change' ,function (){
            var variation = JSON.parse(this.value);
            var variationPriceDiv = $('.variation-price');

            variationPriceDiv.empty();

            if(variation.is_sale)
            {
                var saleSpan = $('<span/>' , {
                    class : 'new',
                    text : toPersianNum(number_format(variation.sale_price)) + ' تومان'
                })
                var spanOldPrice = $('<span/>' ,{
                    class : 'old',
                    text : toPersianNum(number_format(variation.price)) + ' تومان'
                })

                variationPriceDiv.append(saleSpan);
                variationPriceDiv.append(spanOldPrice);

            } else {
                var spanPrice = $('<span/>' , {
                    class : 'new',
                    text : toPersianNum(number_format(variation.price)) + ' تومان'
                })
                variationPriceDiv.append(spanPrice);
            }

            var quantitySKU = variation.quantity;
            console.log()



            $('.quantity-input').attr('data-max' , quantitySKU);
            $('.quantity-input').val(1);
        })
    </script>
@endsection

@section('content')
    <div class="slider-area section-padding-1">
        <div class="slider-active owl-carousel nav-style-1">
            @foreach($sliders as $slider)
            <div class="single-slider slider-height-1 bg-paleturquoise">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6 text-right">
                            <div class="slider-content slider-animated-1">
                                <h1 class="animated">{{ $slider->title }}</h1>
                                <p class="animated">
                                  {{ $slider->text }}
                                </p>
                                <div class="slider-btn btn-hover">
                                    <a class="animated" href="{{ $slider->button_link }}">
                                        <i class="{{ $slider->button_icon }}"></i>
                                        {{ $slider->button_text }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6">
                            <div class="slider-single-img slider-animated-1">
                                <img class="animated" src="{{ asset(env('BANNER_IMAGE_UPLOAD_PATCH') . $slider->image) }}" alt="{{ $slider->image }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="banner-area pt-100 pb-65">
        <div class="container">
            <div class="row">
                @foreach( $indexTopBanner->chunk(3)->first() ?? [] as $banner)
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mb-30 scroll-zoom">
                        <a href="{{ $banner->button_link }}">
                            <img class="animated" src="{{ asset(env('BANNER_IMAGE_UPLOAD_PATCH') . $banner->image) }}"
                                 alt="{{ $banner->image }}" /></a>
                        <div class="banner-content-2 banner-position-5">
                            <h4>{{ $banner->title }}</h4>
                        </div>
                    </div>
                </div>
                @endforeach

                    @foreach( $indexTopBanner->chunk(3)->last() ?? [] as $banner)
                    <div class="col-lg-6 col-md-6">
                    <div class="single-banner mb-30 scroll-zoom">
                        <a href="{{ $banner->button_link }}">
                            <img class="animated" src="{{ asset(env('BANNER_IMAGE_UPLOAD_PATCH') . $banner->image) }}" alt="{{ $banner->image }}" /></a>
                        <div class="{{ $loop->first ? 'banner-content banner-position-6 text-right' : 'banner-content-3 banner-position-7'  }}">
                            <h2>{{ $banner->title }}</h2>
                            <a href="{{ $banner->button_link }}">{{ $banner->button_text }}</a>
                        </div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
    </div>

    <div class="product-area pb-70">
        <div class="container">
            <div class="section-title text-center pb-40">
                <h2> لورم ایپسوم </h2>
                <p>
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون
                    بلکه روزنامه و مجله
                </p>
            </div>
            <div class="product-tab-list nav pb-60 text-center flex-row-reverse">
                <a class="active" href="#product-1" data-toggle="tab">
                    <h4>محصولات پیشنهادی</h4>
                </a>
            </div>
            <div class="tab-content jump-2">
                <div id="product-1" class="tab-pane active">
                    <div class="ht-products product-slider-active owl-carousel">
                        <!--Product Start-->
                        @foreach($products as $product)
                        <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                            <div class="ht-product-inner">
                                <div class="ht-product-image-wrap">
                                    <a href="{{ route('home.products.show' , $product->slug) }}" class="ht-product-image">
                                        <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATCH') . $product->primary_image) }}" alt="{{ $product->image }}" />
                                    </a>
                                    <div class="ht-product-action">
                                        <ul>
                                            <li>
                                                <a href="#" data-toggle="modal" data-target="#productModal-{{ $product->id }}"><i
                                                        class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع</span>
                                                </a>
                                            </li>
                                            <li>
                                                @auth
                                                    @if($product->checkUserWishlist(auth()->id()))
                                                        <a href="{{ route('home.wishlist.remove'  , $product->id) }}"><i class="fas fa-heart" style="color: red"></i>
                                                            <span class="ht-product-action-tooltip">حذف از لیست علاقه مندی ها </span>
                                                        </a>
                                                    @else
                                                    <a href="{{ route('home.wishlist.add'  , $product->id) }}"><i class="sli sli-heart"></i>
                                                        <span class="ht-product-action-tooltip">افزودن به علاقه مندی ها </span>
                                                    </a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('home.wishlist.add'  , $product->id) }}"><i class="sli sli-heart"></i>
                                                        <span class="ht-product-action-tooltip">افزودن به علاقه مندی ها </span>
                                                    </a>
                                                @endauth
                                            </li>
                                            <li>
                                                <a href="{{ route('home.compare.add' , $product->id) }}"><i class="sli sli-refresh"></i>
                                                    <span class="ht-product-action-tooltip"> افزودن به لیست مقایسه</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ht-product-content">
                                    <div class="ht-product-content-inner">
                                        <div class="ht-product-categories">
                                            <a href="#">{{ $product->category->name }}</a>
                                        </div>
                                        <h4 class="ht-product-title text-right">
                                            <a href="{{ route('home.products.show' , $product->slug) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="ht-product-price">
                                            @if($product->QuantityCheckeProduct())

                                                @if($product->SaleCheckeProduct())
                                                    <span class="new">{{ number_format($product->SaleCheckeProduct()->sale_price) }} تومان</span>
                                                    <span class="old">{{ number_format($product->SaleCheckeProduct()->price) }} تومان </span>
                                                @else
                                                    <span class="new">{{ number_format($product->MinPriceCheckeProduct()->price) }} تومان</span>
                                                @endif
                                            @else
                                                <div class="not-in-stock">
                                                    <p class="text-white">ناموجود</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ht-product-ratting-wrap">
                                            <div data-rating-stars="5"
                                                 data-rating-readonly="true"
                                                 data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Product End-->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="testimonial-area pt-80 pb-95 section-margin-1" style="background-image: url(assets/img/bg/bg-1.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 ml-auto mr-auto">
                    <div class="testimonial-active owl-carousel nav-style-1">
                        <div class="single-testimonial text-center">
                            <img src="assets/img/testimonial/testi-1.png" alt="" />
                            <p>
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و
                                متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                                کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و
                                آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
                            </p>
                            <div class="client-info">
                                <img src="assets/img/icon-img/testi.png" alt="" />
                                <h5>لورم ایپسوم</h5>
                            </div>
                        </div>
                        <div class="single-testimonial text-center">
                            <img src="assets/img/testimonial/testi-2.png" alt="" />
                            <p>
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و
                                متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                                کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و
                                آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
                            </p>
                            <div class="client-info">
                                <img src="assets/img/icon-img/testi.png" alt="" />
                                <h5>لورم ایپسوم</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-area pt-95 pb-70">
        <div class="container">
            <div class="section-title text-center pb-60">
                <h2>جدیدترین محصولات</h2>
                <p>
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون
                    بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                </p>
            </div>
            <div class="arrivals-wrap scroll-zoom">
                <div class="ht-products product-slider-active owl-carousel">
                    @php
                     $newestProducts = \App\Models\Product::where('is_active' , 1)->latest()->take(5)->get();
                    @endphp

                    @foreach($newestProducts as $newestProduct)
                    <!--Product Start-->
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <a href="{{ route('home.products.show' , $newestProduct->slug ) }}" class="ht-product-image">
                                    <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATCH') . $newestProduct->primary_image ) }}" alt="Universal Product Style" />
                                </a>
                                <div class="ht-product-action">
                                    <ul>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#productModal-{{ $newestProduct->id }}"><i
                                                    class="sli sli-magnifier"></i><span class="ht-product-action-tooltip"> مشاهده سریع</span>
                                            </a>
                                        </li>
                                        <li>
                                            @auth
                                                @if($newestProduct->checkUserWishlist(auth()->id()))
                                                    <a href="{{ route('home.wishlist.remove'  , $newestProduct->id) }}"><i class="fas fa-heart" style="color: red"></i>
                                                        <span class="ht-product-action-tooltip">حذف از لیست علاقه مندی ها </span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('home.wishlist.add'  , $newestProduct->id) }}"><i class="sli sli-heart"></i>
                                                        <span class="ht-product-action-tooltip">افزودن به علاقه مندی ها </span>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ route('home.wishlist.add'  , $newestProduct->id) }}"><i class="sli sli-heart"></i>
                                                    <span class="ht-product-action-tooltip">افزودن به علاقه مندی ها </span>
                                                </a>
                                            @endauth
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-refresh"></i><span class="ht-product-action-tooltip"> مقایسه</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-bag"></i><span class="ht-product-action-tooltip"> افزودن به سبد خرید </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <div class="ht-product-categories">
                                        <a href="{{ route('home.categories.show' , $newestProduct->category->slug ) }}">{{ $newestProduct->category->name }}</a>
                                    </div>
                                    <h4 class="ht-product-title text-right">
                                        <a href="{{ route('home.products.show' , $newestProduct->slug ) }}">{{ $newestProduct->name }}</a>
                                    </h4>
                                    <div class="ht-product-price">
                                        @if($newestProduct->QuantityCheckeProduct())

                                            @if($newestProduct->SaleCheckeProduct())
                                                <span class="new">{{ number_format($newestProduct->SaleCheckeProduct()->sale_price) }} تومان</span>
                                                <span class="old">{{ number_format($newestProduct->SaleCheckeProduct()->price) }} تومان </span>
                                            @else
                                                <span class="new">{{ number_format($newestProduct->MinPriceCheckeProduct()->price) }} تومان</span>
                                            @endif
                                        @else
                                            <div class="not-in-stock">
                                                <p class="text-white">ناموجود</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                                        <div data-rating-stars="5"
                                             data-rating-readonly="true"
                                             data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Product End-->
                        @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="banner-area pb-120">
        <div class="container">
            <div class="row">
                @foreach($indexBottomBanner as $banner)
                <div class="col-lg-6 col-md-6 text-right">
                    <div class="single-banner mb-30 scroll-zoom">
                        <a href="product-details.html"><img
                                src="{{ asset(env('BANNER_IMAGE_UPLOAD_PATCH') . $banner->image) }}" alt="{{ $banner->image }}" /></a>
                        <div class="banner-content {{ $loop->first ? ' banner-position-3' : 'banner-position-4' }}">
                            <h3>{{ $banner->title }}</h3>
                            <h2>{{ $banner->title }}</h2>
                            <a href="{{ $banner->button_link }}">{{ $banner->button_text }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach($products as $product)
        <div class="modal fade" id="productModal-{{ $product->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                                <div class="product-details-content quickview-content">
                                    <h2 class="text-right mb-4">{{ $product->name }}</h2>
                                    <div class="product-details-price variation-price">
                                        @if($product->QuantityCheckeProduct())

                                            @if($product->SaleCheckeProduct())
                                                <span class="new">{{ number_format($product->SaleCheckeProduct()->sale_price) }} تومان</span>
                                                <span class="old">{{ number_format($product->SaleCheckeProduct()->price) }} تومان </span>
                                            @else
                                                <span class="new">{{ number_format($product->MinPriceCheckeProduct()->price) }} تومان</span>
                                            @endif
                                        @else
                                            <div class="not-in-stock">
                                                <p class="text-white">ناموجود</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="pro-details-rating-wrap">
                                            <div data-rating-stars="5"
                                                 data-rating-readonly="true"
                                                 data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                            </div>
                                        <span class="mx-3">|</span>
                                        <span>{{ $product->approvedComments()->count() }} دیدگاه</span>
                                    </div>
                                    <p class="text-right">
                                        {{ $product->description }}
                                    </p>
                                    <div class="pro-details-list text-right">
                                        <ul class="text-right">
                                            @foreach($product->attributes()->with('attribute')->get() as $attribute)
                                            <li>
                                                - {{ $attribute->attribute->name }}
                                                :
                                                  {{ $attribute->value }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    @if($product->QuantityCheckeProduct())

                                        @php
                                             if ($product->SaleCheckeProduct())
                                              {
                                                  $variationProductSelected = $product->SaleCheckeProduct();
                                              }else{
                                                      $variationProductSelected = $product->MinPriceCheckeProduct();
                                              }
                                        @endphp
                                    <div class="pro-details-size-color text-right">
                                        <div class="pro-details-size w-50">
                                            <span>{{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}</span>
                                                <select class="form-control variation-select">
                                              @foreach($product->variations()->where('quantity' , '>' , 0)->get() as $variation)
                                                  <option value="{{ json_encode($variation->only('id' , 'sale_price' , 'quantity' , 'is_sale' , 'price')) }}"
                                                  {{ $variationProductSelected->id == $variation->id ? 'selected' : '' }}
                                                      >{{ $variation->value }}</option>
                                                @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="pro-details-quality">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton" value="1" data-max="5" />
                                        </div>
                                        <div class="pro-details-cart">
                                            <a href="#">افزودن به سبد خرید</a>
                                        </div>
                                        <div class="pro-details-wishlist">
                                            @auth
                                                @if($product->checkUserWishlist(auth()->id()))
                                                    <a href="{{ route('home.wishlist.remove'  , $product->id) }}"><i class="fas fa-heart" style="color: red"></i></a>
                                                @else
                                                    <a href="{{ route('home.wishlist.add'  , $product->id) }}"><i class="sli sli-heart"></i></a>
                                                @endif
                                            @else
                                                <a href="{{ route('home.wishlist.add'  , $product->id) }}"><i class="sli sli-heart"></i>
                                                    <span class="ht-product-action-tooltip">افزودن به علاقه مندی ها </span>
                                                </a>
                                            @endauth
                                        </div>
                                        <div class="pro-details-compare">
                                            <a title="Add To Compare" href="#"><i class="sli sli-refresh"></i></a>
                                        </div>
                                    </div>
                                    @else
                                        <div class="not-in-stock">
                                            <p class="text-white">ناموجود</p>
                                        </div>
                                    @endif


                                    <div class="pro-details-meta">
                                        <span>دسته بندی :</span>
                                        <ul>
                                            <li><a href="{{ route('home.categories.show' , $product->category->slug) }}">{{ $product->category->parent->name }} - {{ $product->category->name }} </a></li>
                                        </ul>
                                    </div>
                                    <div class="pro-details-meta">
                                        <span>تگ ها :</span>
                                        <ul>
                                            @foreach($product->tags as $tag)
                                            <li><a href="#">{{ $tag->name }}{{ $loop->last ? '' : ' ، ' }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="tab-content quickview-big-img">
                                    <div id="pro-primary-{{ $product->id }}" class="tab-pane fade show active">
                                        <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATCH').$product->primary_image) }}" alt="{{ $product->name }}" />
                                    </div>
                                    @foreach($product->images as $image)
                                    <div id="pro-{{ $image->id }}" class="tab-pane fade">
                                        <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATCH').$image->images) }}" alt="{{ $image->images }}" />
                                    </div>
                                    @endforeach
                                </div>
                                <!-- Thumbnail Large Image End -->
                                <!-- Thumbnail Image End -->
                                <div class="quickview-wrap mt-15">
                                    <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                        <a class="active" data-toggle="tab" href="#pro-{{ $product->id }}">
                                            <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATCH').$product->primary_image) }}"
                                                 alt="{{ $product->name }}" /></a>

                                        @foreach($product->images as $image)
                                            <a data-toggle="tab" href="#pro-{{ $image->id }}">
                                                <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATCH').$image->images) }}" alt="{{ $image->images }}" />
                                            </a>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Modal end -->

@endsection

@section('script')

@endsection

