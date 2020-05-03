<!Doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <script src="{{ asset('js/angular.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/jquery-slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/dashboard.css') }}" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="{{ asset('js/Chart.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@8.js') }}" charset="UTF-8"></script>
    <title>@yield('title')</title>
</head>
<body class="w3-light-grey">

    <!-- Top container -->
    <div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
        <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
        <span class="w3-right">OTOP PHUKET</span>
    </div>

    <!-- Sidenav/menu -->
    <nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
        <div class="w3-container w3-row">
            <div class="w3-col s4">
                <img src="{{ asset('image/user.png') }}" class="w3-circle w3-margin-right" style="width:46px">
            </div>
            <div class="w3-col s8">
                <span>Welcome, <strong>{{ Auth::user()->name }}</strong></span><br>
                <a href="#" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-envelope"></i></a>
                <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block"><i class="fa fa-user"></i></a>
                <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog"></i></a>
            </div>
        </div>
        <hr>
        <a href="{{url('district')}}" class="{{ (request()->segment(1) == 'district') ? 'w3-padding w3-blue' : 'w3-padding' }}"><i class="fa fa-city fa-fw"></i>  รายการอำเภอ/ตำบล</a>
        <a href="{{url('category')}}" class="{{ (request()->segment(1) == 'category') ? 'w3-padding w3-blue' : 'w3-padding' }}"><i class="fa fa-list fa-fw"></i>  รายการหมวดหมู่/หมวดหมู่ย่อยสินค้า</a>
        <a href="{{url('product')}}" class="{{ (request()->segment(1) == 'product') ? 'w3-padding w3-blue' : 'w3-padding' }}"><i class="fa fa-archive fa-fw"></i>  รายการสินค้า</a>
        <a href="{{url('change-password')}}" class="{{ (request()->segment(1) == 'change-password') ? 'w3-padding w3-blue' : 'w3-padding' }}"><i class="fa fa-cog fa-fw"></i>  เปลี่ยนรหัสผ่านผู้ใช้งาน</a>
        <a href="{{url('home')}}" class="w3-padding"><i class="fa fa-arrow-right"></i>  ไปยังหน้าแรกของเว็บไซต์</a>
        <a class="w3-padding" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out-alt"></i> {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </nav>
            <!-- Overlay effect when opening sidenav on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
        <!-- Header -->
        <header class="w3-container" style="padding-top:22px">
            <h5><b><i class="fa fa-dashboard"></i> Hello {{ Auth::user()->name }}</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom">
            <a href="{{url('statistic/year')}}" style="text-decoration: none" class="w3-quarter">
                <div class="w3-container w3-red w3-padding-16">
                    <div class="w3-left"><i class="fa fa-chart-bar w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>สถิติสั่งซื้อรายปี</h4>
                </div>
            </a>
            <a href="{{url('statistic/month')}}" style="text-decoration: none" class="w3-quarter">
                <div class="w3-container w3-blue w3-padding-16">
                    <div class="w3-left"><i class="fa fa-chart-bar w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>สถิติสั่งซื้อรายเดือน</h4>
                </div>
            </a>
            <a href="{{ url('user/setting') }}" style="text-decoration: none" class="w3-quarter">
                <div class="w3-container w3-orange w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>จำนวนผู้ใช้ทั้งหมด</h4>
                </div>
            </a>
            <a href="{{ url('orders') }}" style="text-decoration: none" class="w3-quarter">
                <div class="w3-container w3-teal w3-padding-16">
                    <div class="w3-left"><i class="fa fa-list w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>รายการสั่งซื้อทั้งหมด</h4>
                </div>
            </a>
        </div>
        <!-- !PAGE CONTENT! -->
        @yield('content')
        <!-- End page content -->
    </div>
</body>
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
</html>
