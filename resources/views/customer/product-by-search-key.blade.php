@extends('customer.layout')
@section('title', 'ค้นหาสินค้า')

@section('content')
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">สินค้า</h3>
                    <ul class="breadcrumb-tree">
                        <li><a>หน้าหลัก</a></li>
                        <li class="active">ค้นหาสินค้าที่มีคำว่า " {{ $searchKey }} "</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div id="store" class="col-md-10">
                    @if(isset($products))
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4 col-xs-6">
                                <form action="{{url('cart/add')}}" method="POST">
                                    <div class="product">
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
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">{{ $product->product_name }}</p>
                                            <h3 class="product-name"><a href="#">{{ $product->product_name }}</a></h3>
                                            <h4 class="product-price">฿ {{ $product->product_price }}</h4>
                                            @if($product->product_quantity === 0)
                                                <p class="product-name" style="color: red;">
                                                    Out Of Stock
                                                </p>
                                            @else
                                                <p class="product-name">
                                                    {{ $product->product_quantity }} ชิ้น
                                                </p>
                                            @endif

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
                                        </div>


                                        <input type="hidden" value="{{ $product->product_id }}" name="product_id">

                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn" @if($product->product_quantity === 0) disabled @endif>
                                                <i class="fa fa-shopping-cart"></i> add to cart
                                            </button>
                                        </div>
                                    </div>
                                    <br><br><br>
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        @endforeach
                        <div class="clearfix visible-sm visible-xs"></div>
                    </div>
                    @endif
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
@endsection