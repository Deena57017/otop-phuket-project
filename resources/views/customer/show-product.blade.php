{{--show product--}}
@extends('customer.layout')
@section('title', 'หน้าแสดงรายละเอียดสินค้า')

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
                        <li class="active">{{ $product->product_name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- Product main img -->
            <form action="{{url('cart/add')}}" method="POST">
                <div class="col-md-6 ">
                    <div class="product-preview">
                        @if (is_file(public_path().'/upload/product/'.$product->product_image))
                            <img src="{{ asset('upload/product') }}/{{ $product->product_image }}" style="width: 80%; margin-left: 10%;" class="img-responsive" alt="">
                        @else
                            <img src="{{ asset('upload/product/image-not-found.png') }}" style="width: 80%; margin-left: 10%;" class="img-responsive" alt="">
                        @endif
                    </div>
                </div>
                <!-- Product details -->
                <div class="col-md-6">
                    <div class="product-details">
                        <h2 class="product-name">{{ $product->product_name }}</h2>
                        <div>
{{--                            <div class="product-rating">--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star-o"></i>--}}
{{--                            </div>--}}
{{--                            <a class="review-link" href="#">10 Review(s) | Add your review</a>--}}
                        </div>
                        <div>
                            <h3 class="product-price">฿ {{ $product->product_price }}
                                {{--<del class="product-old-price">$990.00</del>--}}
                            </h3>
                            <span class="product-available">
                                @if($product->product_quantity === 0)
                                    Out of Stock
                                @else
                                    In Stock
                                @endif
                            </span>
                        </div>
                        <p>
                            <b> Sub Category : </b> {{ $product->subcategory_name }}<br>
                            <b> SubDistrict : </b> {{ $product->subdistrict_name }}<br>
                            <b> Description : </b>{{ $product->product_detail }}<br>
                        </p>
                        <div class="add-to-cart">
                            @if($product->product_quantity === 0)
                                <div class="qty-label" style="width: 100%;">
                                    <div class="input-number" style="width: 100%;">
                                        <input type="number" name="quantity" value="0" min="0" max="{{ $product->product_quantity }}" style="width: 100%;" disabled>
                                    </div>
                                </div>
                            @else
                                <div class="qty-label" style="width: 100%;">
                                    <div class="input-number" style="width: 100%;">
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->product_quantity }}" style="width: 100%;">
                                        <span class="qty-up">+</span>
                                        <span class="qty-down">-</span>
                                    </div>
                                </div>
                            @endif

                            <input type="hidden" value="{{ $product->product_id }}" name="product_id"><br><br>
                            <button class="add-to-cart-btn" style="width: 100%;" @if($product->product_quantity === 0) disabled @endif>
                                <i class="fa fa-shopping-cart"></i> add to cart
                            </button>

                            {{ csrf_field() }}
                        </div>

                    </div>
                </div>
            <!-- /Product details -->
            </form>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
@endsection

