{{-- หน้าแรกของเว็บไซต์ในฝั่งลูกค้า --}}
@extends('customer.layout')
@section('title', 'หน้าหลัก')

@section('content')

    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">หน้าหลัก</h3>
                    <ul class="breadcrumb-tree">
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            {{--<marquee behavior="scroll" direction="left" scrollamount="5"><a class="primary-btn cta-btn" href="#">Promotion Code </a></marquee>--}}
            <!-- row -->
            <div class="row">
                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="./img/otop.png" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Thalang<br>PHUKET</h3>
                            <a href="{{ URL('product/district/thalang') }}" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{ asset('img/otop.png') }}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Muang<br>PHUKET</h3>
                            <a href="{{ URL('product/district/muang') }}" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{ asset('img/otop.png') }}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Kathu<br>PHUKET</h3>
                            <a href="{{ URL('product/district/kathu') }}" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">New Products</h3>
                        {{--<div class="section-nav">--}}
                            {{--<ul class="section-tab-nav tab-nav">--}}
                                {{--<li class="active"><a data-toggle="tab" href="#tab1">Laptops</a></li>--}}
                                {{--<li><a data-toggle="tab" href="#tab1">Smartphones</a></li>--}}
                                {{--<li><a data-toggle="tab" href="#tab1">Cameras</a></li>--}}
                                {{--<li><a data-toggle="tab" href="#tab1">Accessories</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <!-- /section title -->

                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <!-- product -->
                                    @if(isset($products))
                                        @foreach($products as $product)
                                            <div class="product">
                                                <form action="{{url('cart/add')}}" method="POST">
                                                    <div class="product-img">
                                                        @if (is_file(public_path().'/upload/product/'.$product->product_image))
                                                            <img src="{{ asset('upload/product') }}/{{ $product->product_image }}" class="img-responsive" alt="">
                                                        @else
                                                            <img src="{{ asset('upload/product/image-not-found.png') }}" class="img-responsive" alt="">
                                                        @endif
                                                        <div class="product-label">
                                                        <span style="background-color: #00bcd4; border-color: #00bcd4; color: white"  class="tooltipp">
                                                            <a href="{{ URL('product') }}/{{ $product->product_id }}" style="color: white">
                                                                SHOW DETAIL
                                                            </a>
                                                        </span> &nbsp; &nbsp;
                                                            <span class="new">NEW</span>
                                                        </div>
                                                    </div>
                                                    <div class="product-body">
                                                        <p class="product-category">{{ $product->subcategory_name }}</p>
                                                        <h3 class="product-name"><a href="#">{{ $product->product_name }}</a></h3>

                                                            @if($product->product_quantity === 0)
                                                                <p class="product-name" style="color: red;">
                                                                    Out Of Stock
                                                                </p>
                                                            @else
                                                                <p class="product-name">
                                                                    {{ $product->product_quantity }} ชิ้น
                                                                </p>
                                                            @endif

                                                        <h4 class="product-price">฿ {{ $product->product_price }}</h4>
                                                        <div class="product-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </div>

                                                        @if($product->product_quantity === 0)
                                                            <div class="qty-label">
                                                                <div class="input-number" >
                                                                    <input type="number" name="quantity" value="0" min="0" max="{{ $product->product_quantity }}" disabled>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="qty-label">
                                                                <div class="input-number" >
                                                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->product_quantity }}">
                                                                    <span class="qty-up">+</span>
                                                                    <span class="qty-down">-</span>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        {{--<div class="product-btns">--}}
                                                        {{--<input class="input" value="1" placeholder="Quantity" type="number" max="{{ $product->product_quantity }}" min="1">--}}

                                                        {{--<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>--}}
                                                        {{--</div>--}}
                                                    </div>
                                                    <input type="hidden" value="{{ $product->product_id }}" name="product_id">

                                                    <div class="add-to-cart">
                                                        <button class="add-to-cart-btn" @if($product->product_quantity === 0) disabled @endif>
                                                            <i class="fa fa-shopping-cart"></i> add to cart
                                                        </button>
                                                    </div>
                                                    {{ csrf_field() }}
                                                </form>
                                            </div>
                                        @endforeach
                                    @endif
                                    <!-- /product -->
                                </div>
                                {{--<div id="slick-nav-1" class="products-slick-nav"></div>--}}
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- HOT DEAL SECTION -->
    {{--<div id="hot-deal" class="section">--}}
        {{--<!-- container -->--}}
        {{--<div class="container">--}}
            {{--<!-- row -->--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<div class="hot-deal">--}}
                        {{--<ul class="hot-deal-countdown">--}}
                            {{--<li>--}}
                                {{--<div>--}}
                                    {{--<h3>02</h3>--}}
                                    {{--<span>Days</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<div>--}}
                                    {{--<h3>10</h3>--}}
                                    {{--<span>Hours</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<div>--}}
                                    {{--<h3>34</h3>--}}
                                    {{--<span>Mins</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<div>--}}
                                    {{--<h3>60</h3>--}}
                                    {{--<span>Secs</span>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                        {{--<h2 class="text-uppercase">hot deal this week</h2>--}}
                        {{--<p>Promotion Code Up to 50% OFF</p>--}}
                        {{--<a class="primary-btn cta-btn" href="#">Shop now</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /row -->--}}
        {{--</div>--}}
        {{--<!-- /container -->--}}
    {{--</div>--}}
    <!-- /HOT DEAL SECTION -->

    <!-- SECTION -->
    {{--<div class="section">--}}
        {{--<!-- container -->--}}
        {{--<div class="container">--}}
            {{--<!-- row -->--}}
            {{--<div class="row">--}}

                {{--<!-- section title -->--}}
                {{--<div class="col-md-12">--}}
                    {{--<div class="section-title">--}}
                        {{--<h3 class="title">Top selling</h3>--}}
                        {{--<div class="section-nav">--}}
                            {{--<ul class="section-tab-nav tab-nav">--}}
                                {{--<li class="active"><a data-toggle="tab" href="#tab2">Laptops</a></li>--}}
                                {{--<li><a data-toggle="tab" href="#tab2">Smartphones</a></li>--}}
                                {{--<li><a data-toggle="tab" href="#tab2">Cameras</a></li>--}}
                                {{--<li><a data-toggle="tab" href="#tab2">Accessories</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <!-- /section title -->

                <!-- Products tab & slick -->
                {{--<div class="col-md-12">--}}
                    {{--<div class="row">--}}
                        {{--<div class="products-tabs">--}}
                            {{--<!-- tab -->--}}
                            {{--<div id="tab2" class="tab-pane fade in active">--}}
                                {{--<div class="products-slick" data-nav="#slick-nav-2">--}}
                                    {{--<!-- product -->--}}
                                    {{--<div class="product">--}}
                                        {{--<div class="product-img">--}}
                                            {{--<img src="./img/product06.png" alt="">--}}
                                            {{--<div class="product-label">--}}
                                                {{--<span class="sale">-30%</span>--}}
                                                {{--<span class="new">NEW</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="product-body">--}}
                                            {{--<p class="product-category">Category</p>--}}
                                            {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                            {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                            {{--<div class="product-rating">--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="product-btns">--}}
                                                {{--<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>--}}
                                                {{--<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>--}}
                                                {{--<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="add-to-cart">--}}
                                            {{--<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /product -->--}}

                                    {{--<!-- product -->--}}
                                    {{--<div class="product">--}}
                                        {{--<div class="product-img">--}}
                                            {{--<img src="./img/product07.png" alt="">--}}
                                            {{--<div class="product-label">--}}
                                                {{--<span class="new">NEW</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="product-body">--}}
                                            {{--<p class="product-category">Category</p>--}}
                                            {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                            {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                            {{--<div class="product-rating">--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star-o"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="product-btns">--}}
                                                {{--<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>--}}
                                                {{--<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>--}}
                                                {{--<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="add-to-cart">--}}
                                            {{--<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /product -->--}}

                                    {{--<!-- product -->--}}
                                    {{--<div class="product">--}}
                                        {{--<div class="product-img">--}}
                                            {{--<img src="./img/product08.png" alt="">--}}
                                            {{--<div class="product-label">--}}
                                                {{--<span class="sale">-30%</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="product-body">--}}
                                            {{--<p class="product-category">Category</p>--}}
                                            {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                            {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                            {{--<div class="product-rating">--}}
                                            {{--</div>--}}
                                            {{--<div class="product-btns">--}}
                                                {{--<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>--}}
                                                {{--<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>--}}
                                                {{--<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="add-to-cart">--}}
                                            {{--<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /product -->--}}

                                    {{--<!-- product -->--}}
                                    {{--<div class="product">--}}
                                        {{--<div class="product-img">--}}
                                            {{--<img src="./img/product09.png" alt="">--}}
                                        {{--</div>--}}
                                        {{--<div class="product-body">--}}
                                            {{--<p class="product-category">Category</p>--}}
                                            {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                            {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                            {{--<div class="product-rating">--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="product-btns">--}}
                                                {{--<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>--}}
                                                {{--<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>--}}
                                                {{--<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="add-to-cart">--}}
                                            {{--<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /product -->--}}

                                    {{--<!-- product -->--}}
                                    {{--<div class="product">--}}
                                        {{--<div class="product-img">--}}
                                            {{--<img src="./img/product01.png" alt="">--}}
                                        {{--</div>--}}
                                        {{--<div class="product-body">--}}
                                            {{--<p class="product-category">Category</p>--}}
                                            {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                            {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                            {{--<div class="product-rating">--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="product-btns">--}}
                                                {{--<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>--}}
                                                {{--<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>--}}
                                                {{--<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="add-to-cart">--}}
                                            {{--<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /product -->--}}
                                {{--</div>--}}
                                {{--<div id="slick-nav-2" class="products-slick-nav"></div>--}}
                            {{--</div>--}}
                            {{--<!-- /tab -->--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <!-- /Products tab & slick -->
            {{--</div>--}}
            {{--<!-- /row -->--}}
        {{--</div>--}}
        {{--<!-- /container -->--}}
    {{--</div>--}}
    <!-- /SECTION -->

    {{--<!-- SECTION -->--}}
    {{--<div class="section">--}}
        {{--<!-- container -->--}}
        {{--<div class="container">--}}
            {{--<!-- row -->--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-4 col-xs-6">--}}
                    {{--<div class="section-title">--}}
                        {{--<h4 class="title">Top selling</h4>--}}
                        {{--<div class="section-nav">--}}
                            {{--<div id="slick-nav-3" class="products-slick-nav"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="products-widget-slick" data-nav="#slick-nav-3">--}}
                        {{--<div>--}}
                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product07.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product08.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product09.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- product widget -->--}}
                        {{--</div>--}}

                        {{--<div>--}}
                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product01.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product02.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product03.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- product widget -->--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-md-4 col-xs-6">--}}
                    {{--<div class="section-title">--}}
                        {{--<h4 class="title">Top selling</h4>--}}
                        {{--<div class="section-nav">--}}
                            {{--<div id="slick-nav-4" class="products-slick-nav"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="products-widget-slick" data-nav="#slick-nav-4">--}}
                        {{--<div>--}}
                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product04.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product05.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product06.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- product widget -->--}}
                        {{--</div>--}}

                        {{--<div>--}}
                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product07.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product08.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product09.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- product widget -->--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="clearfix visible-sm visible-xs"></div>--}}

                {{--<div class="col-md-4 col-xs-6">--}}
                    {{--<div class="section-title">--}}
                        {{--<h4 class="title">Top selling</h4>--}}
                        {{--<div class="section-nav">--}}
                            {{--<div id="slick-nav-5" class="products-slick-nav"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="products-widget-slick" data-nav="#slick-nav-5">--}}
                        {{--<div>--}}
                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product01.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product02.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product03.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- product widget -->--}}
                        {{--</div>--}}

                        {{--<div>--}}
                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product04.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product05.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- /product widget -->--}}

                            {{--<!-- product widget -->--}}
                            {{--<div class="product-widget">--}}
                                {{--<div class="product-img">--}}
                                    {{--<img src="./img/product06.png" alt="">--}}
                                {{--</div>--}}
                                {{--<div class="product-body">--}}
                                    {{--<p class="product-category">Category</p>--}}
                                    {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                                    {{--<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- product widget -->--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
            {{--<!-- /row -->--}}
        {{--</div>--}}
        {{--<!-- /container -->--}}
    {{--</div>--}}
    {{--<!-- /SECTION -->--}}

    <!-- NEWSLETTER -->
    <br><br>
    <!-- /NEWSLETTER -->
@endsection
