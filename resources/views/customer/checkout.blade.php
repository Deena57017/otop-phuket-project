@extends('customer.layout')
@section('title', 'สั่งซื้อชำระเงิน')
<style>
    #top-header {
        padding-bottom: 0 !important;
    }
    .order-submit:disabled {
        box-shadow: inset 0px 1px 0px 0px #c6c6ca;
        background-color: #99999e;
        border: 1px solid #fbfbfb;
        opacity: .400;
    }
</style>
@section('content')
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">การชำระเงิน</h3>
                    <ul class="breadcrumb-tree">
                        <li><a disabled>หน้าหลัก</a></li>
                        <li><a disabled>ตระกร้าสินค้า</a></li>
                        <li class="active">ชำระเงิน</li>
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
            <!-- row -->
            <div class="row">

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <form action="{{url('user/detail/update')}}" method="POST">
                            {{ csrf_field() }}

                            <div class="section-title">
                                <h3 class="title">Billing address</h3>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="name" value="{{ $userDetail->name }}" placeholder="Username" readonly>
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" name="email" value="{{ $userDetail->email }}" placeholder="Email" readonly>
                            </div>
                            <div class="form-group">
                                @if ($errors->has('user_address'))
                                    <b><span style="color: red">{{ $errors->first('user_address') }}</span></b>
                                @endif
                                <input class="input" type="text" name="user_address" value="{{ old('user_address', $userDetail->user_address) }}" placeholder="Address">
                            </div>
                            <div class="form-group">
                                @if ($errors->has('user_district'))
                                    <b><span style="color: red">{{ $errors->first('user_district') }}</span></b>
                                @endif
                                <input class="input" type="text" name="user_district" value="{{ old('user_district', $userDetail->user_district) }}" placeholder="District">
                            </div>
                            <div class="form-group">
                                @if ($errors->has('user_province'))
                                    <b><span style="color: red">{{ $errors->first('user_province') }}</span></b>
                                @endif
                                <input class="input" type="text" name="user_province" value="{{ old('user_province', $userDetail->user_province) }}" placeholder="Province">
                            </div>
                            <div class="form-group">
                                @if ($errors->has('user_country'))
                                    <b><span style="color: red">{{ $errors->first('user_country') }}</span></b>
                                @endif
                                <input class="input" type="text" name="user_country" value="{{ old('user_country', $userDetail->user_country) }}" placeholder="Country">
                            </div>
                            <div class="form-group">
                                @if ($errors->has('user_postcode'))
                                    <b><span style="color: red">{{ $errors->first('user_postcode') }}</span></b>
                                @endif
                                <input class="input" type="text" name="user_postcode" value="{{ old('user_postcode', $userDetail->user_postcode) }}" placeholder="ZIP Code">
                            </div>

                            <div style="float: left;">
                                @if(!$hasAddress) <h6 style="color: red"> ** กรุณากรอกรายละเอียดที่อยู่ให้ครบถ้วน</h6> @endif
                            </div>

                            <div style="float: right;">
                                <input type="hidden" name="payment_id" value="{{ $paymentId }}">
                                <button class="primary-btn order-submit" style="background-color: #ffa714">
                                    <i class="fa fa-edit"></i> Update Address
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /Billing Details -->

                    <!-- Shiping Details -->
{{--                    <div class="shiping-details">--}}
{{--                        <div class="section-title">--}}
{{--                            <h3 class="title">Shiping address</h3>--}}
{{--                        </div>--}}
{{--                        <div class="input-checkbox">--}}
{{--                            <input type="checkbox" id="shiping-address">--}}
{{--                            <label for="shiping-address">--}}
{{--                                <span></span>--}}
{{--                                Ship to a diffrent address?--}}
{{--                            </label>--}}
{{--                            <div class="caption">--}}
{{--                                <div class="form-group">--}}
{{--                                    <input class="input" type="text" name="first-name" placeholder="First Name">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <input class="input" type="text" name="last-name" placeholder="Last Name">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <input class="input" type="email" name="email" placeholder="Email">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <input class="input" type="text" name="address" placeholder="Address">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <input class="input" type="text" name="city" placeholder="City">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <input class="input" type="text" name="country" placeholder="Country">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <input class="input" type="text" name="zip-code" placeholder="ZIP Code">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <input class="input" type="tel" name="tel" placeholder="Telephone">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- /Shiping Details -->

                    <!-- Order notes -->
{{--                    <div class="order-notes">--}}
{{--                        <textarea class="input" placeholder="Order Notes"></textarea>--}}
{{--                    </div>--}}
                    <!-- /Order notes -->
                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Your Order</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>PRODUCT</strong></div>
                            <div><strong>TOTAL</strong></div>
                        </div>
                        <div class="order-products">
                            @if(isset($products))
                                @foreach($products as $product)
                                    <div class="order-col">
                                        @if(isset($product->total))
                                            <div>{{ $product->product_name }} ({{ $product->quantity }} ชิ้น)</div>
                                            <div>{{ $product->total }} ฿</div>
                                        @else
                                            <div>{{ $product->product_name }} ({{ $product->order_detail_quantity }} ชิ้น)</div>
                                            <div>{{ $product->order_detail_total }} ฿</div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div>
                        @if(isset($totalPrice))
                            <div class="order-col">
                                <div><strong>TOTAL</strong></div>
                                <div><strong class="order-total"> {{ $totalPrice }} ฿</strong></div>
                            </div>
                        @endif
                    </div>
                    <div class="payment-method">
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-3" checked>
                            <label for="payment-3">
                                <span></span>
                                <i class="fab fa-paypal"></i> Paypal System
                            </label>
{{--                            <div class="caption">--}}
{{--                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>--}}
{{--                            </div>--}}
                        </div>
                    </div>
{{--                    <div class="input-checkbox">--}}
{{--                        <input type="checkbox" id="terms">--}}
{{--                        <label for="terms">--}}
{{--                            <span></span>--}}
{{--                            I've read and accept the <a href="#">terms & conditions</a>--}}
{{--                        </label>--}}
{{--                    </div>--}}

                    <form action="{{ URL('payment') }}" method="POST">
                        <input type="hidden" name="payment_id" value="{{ $paymentId }}">
                        {{ csrf_field() }}
                        <button class="primary-btn order-submit" @if(!$hasAddress || $totalPrice == 0) disabled @endif>
                            <i class="fab fa-paypal"></i> Payment With Paypal
                        </button>
                    </form>
                    <form action="{{ URL('home') }}" method="get">
                        <button class="primary-btn order-submit" style="background-color: red">
                            <i class="fa fa-arrow-left"></i>
                            Back To Shopping
                        </button>
                    </form>
                </div>
                <!-- /Order Details -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
@endsection