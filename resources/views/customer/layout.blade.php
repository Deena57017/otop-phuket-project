<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>@yield('title')</title>
    <!-- Google font -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/customer/bootstrap.min.css') }}"/>
    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/customer/slick.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('css/customer/slick-theme.css') }}"/>
    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/customer/nouislider.min.css') }}"/>
    <!-- Font Awesome Icon -->
    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/customer/style.css') }}"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
</head>
<body>
<!-- HEADER -->
<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-right">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if(Auth::user()->type == 'ADMIN')
                        <li>
                            <a href="{{url('district')}}"><i class="fa fa-cog" style="color: white"></i>
                                {{ Auth::user()->type }}
                            </a>
                        </li>
                    @endif
                    <li><a href="{{ URL('user/address') }}"><i class="fa fa-user" style="color: white"></i> {{ Auth::user()->name }} </a></li>
                    @if(Auth::user()->type == 'CUSTOMER')
                        <li>
                            <a href="{{url('change-password')}}"><i class="fa fa-cog" style="color: white"></i>
                                Change Password
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{url('order-history')}}"><i class="fa fa-history" style="color: white"></i>
                            ประวัติการสั่งซื้อ
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            {{ __('Logout') }} <i class="fa fa-sign-out-alt" style="color: white"></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </li>
                @endguest

            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="{{ URL('home') }}">
                            <img src="{{ asset('img/otop.png') }}" alt="" width="40%">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-6">
                    <div class="header-search">
                        <form action="{{ URL('search') }}" method="POST">
                            {{ csrf_field() }}
                            <input class="input" name="search_key" placeholder="ค้นหาสินค้า">
                            <button class="search-btn">Search</button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        @auth
                            <div>
                                <a href="{{ URL('order') }}">
                                    <i class="fa fa-list"></i>
                                    <span>รอการชำระเงิน</span>
                                    <div class="qty">
                                        @if(isset($paymentPending))
                                            {{ $paymentPending }}
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endauth
                        <!-- /Wishlist -->
                        <!-- Cart -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <a href="{{ URL('cart') }}">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>ตระกร้าสินค้า</span>
                                    <div class="qty">
                                        @guest
                                            0
                                        @else
                                            @if(isset($cartItem))
                                                {{ $cartItem }}
                                            @endif
                                        @endguest
                                    </div>
                                </a>
                            </a>

                            {{--<div class="cart-dropdown">--}}
                            {{--<div class="cart-list">--}}
                            {{--<div class="product-widget">--}}
                            {{--<div class="product-img">--}}
                            {{--<img src="./img/product01.png" alt="">--}}
                            {{--</div>--}}
                            {{--<div class="product-body">--}}
                            {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                            {{--<h4 class="product-price"><span class="qty">1x</span>$980.00</h4>--}}
                            {{--</div>--}}
                            {{--<button class="delete"><i class="fa fa-close"></i></button>--}}
                            {{--</div>--}}

                            {{--<div class="product-widget">--}}
                            {{--<div class="product-img">--}}
                            {{--<img src="./img/product02.png" alt="">--}}
                            {{--</div>--}}
                            {{--<div class="product-body">--}}
                            {{--<h3 class="product-name"><a href="#">product name goes here</a></h3>--}}
                            {{--<h4 class="product-price"><span class="qty">3x</span>$980.00</h4>--}}
                            {{--</div>--}}
                            {{--<button class="delete"><i class="fa fa-close"></i></button>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="cart-summary">--}}
                            {{--<small>3 Item(s) selected</small>--}}
                            {{--<h5>SUBTOTAL: $2940.00</h5>--}}
                            {{--</div>--}}
                            {{--<div class="cart-btns">--}}
                            {{--<a href="#">View Cart</a>--}}
                            {{--<a href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></a>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <!-- /Cart -->

                        <!-- Menu Toogle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->

<!-- NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <li class="{{ (request()->segment(1) == 'home') ? 'active' : '' }}"><a href="{{ URL('home') }}">หน้าหลัก</a></li>
                <li class="{{ (request()->segment(3) == 'food') ? 'active' : '' }}"><a href="{{ URL('product/category/food') }}">อาหาร</a></li>
                <li class="{{ (request()->segment(3) == 'beverage') ? 'active' : '' }}"><a href="{{ URL('product/category/beverage') }}">เครื่องดื่ม</a></li>
                <li class="{{ (request()->segment(3) == 'apparel') ? 'active' : '' }}"><a href="{{ URL('product/category/apparel') }}">เครื่องแต่งกาย</a></li>
                <li class="{{ (request()->segment(3) == 'accessories') ? 'active' : '' }}"><a href="{{ URL('product/category/accessories') }}">เครื่องประดับ</a></li>
                <li class="{{ (request()->segment(3) == 'herb') ? 'active' : '' }}"><a href="{{ URL('product/category/herb') }}">สมุนไพร</a></li>
                <li class="{{ (request()->segment(3) == 'other') ? 'active' : '' }}"><a href="{{ URL('product/category/other') }}">หมวดหมู่อื่น</a></li>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->

<!-- !PAGE CONTENT! -->
<div class="content">
    @yield('content')
</div>

<!-- End page content -->
<!-- FOOTER -->
<footer id="footer">
    <!-- top footer -->
    <div class="section">
        <!-- container -->
        {{--<div class="container">--}}
            {{--<!-- row -->--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-3 col-xs-6">--}}
                    {{--<div class="footer">--}}
                        {{--<h3 class="footer-title">About Us</h3>--}}
                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>--}}
                        {{--<ul class="footer-links">--}}
                            {{--<li><a href="#"><i class="fa fa-map-marker-alt" style="color: white;"></i>Phuket</a></li>--}}
                            {{--<li><a href="#"><i class="fa fa-phone" style="color: white;"></i>+021-95-51-84</a></li>--}}
                            {{--<li><a href="#"><i class="fa fa-envelope" style="color: white;"></i>deena@email.com</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-md-3 col-xs-6">--}}
                    {{--<div class="footer">--}}
                        {{--<h3 class="footer-title">Categories</h3>--}}
                        {{--<ul class="footer-links">--}}
                            {{--<li><a href="{{ URL('product/category/food') }}">Food</a></li>--}}
                            {{--<li><a href="{{ URL('product/category/beverage') }}">Beverage</a></li>--}}
                            {{--<li><a href="{{ URL('product/category/apparel') }}">Apparel</a></li>--}}
                            {{--<li><a href="{{ URL('product/category/accessories') }}">Accessories</a></li>--}}
                            {{--<li><a href="{{ URL('product/category/herb') }}">Herb</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="clearfix visible-xs"></div>--}}

                {{--<div class="col-md-3 col-xs-6">--}}
                    {{--<div class="footer">--}}
                        {{--<h3 class="footer-title">Information</h3>--}}
                        {{--<ul class="footer-links">--}}
                            {{--<li><a href="#">About Us</a></li>--}}
                            {{--<li><a href="#">Contact Us</a></li>--}}
                            {{--<li><a href="#">Privacy Policy</a></li>--}}
                            {{--<li><a href="#">Orders and Returns</a></li>--}}
                            {{--<li><a href="#">Terms & Conditions</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-md-3 col-xs-6">--}}
                    {{--<div class="footer">--}}
                        {{--<h3 class="footer-title">Service</h3>--}}
                        {{--<ul class="footer-links">--}}
                            {{--<li><a href="#">My Account</a></li>--}}
                            {{--<li><a href="#">View Cart</a></li>--}}
                            {{--<li><a href="#">Wishlist</a></li>--}}
                            {{--<li><a href="#">Track My Order</a></li>--}}
                            {{--<li><a href="#">Help</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /row -->--}}
        {{--</div>--}}
        {{--<!-- /container -->--}}
    </div>
    <!-- /top footer -->

    <!-- bottom footer -->
    <div id="bottom-footer" class="section">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12 text-center">
                <span class="copyright">
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" style="color: white">Colorlib</a>
                </span>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bottom footer -->
</footer>
<!-- /FOOTER -->

<!-- jQuery Plugins -->


<script src="{{ asset('js/customer/jquery.min.js') }}"></script>
<script src="{{ asset('js/customer/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/customer/slick.min.js') }}"></script>
<script src="{{ asset('js/customer/nouislider.min.js') }}"></script>
<script src="{{ asset('js/customer/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('js/customer/main.js') }}"></script>

</body>
</html>
