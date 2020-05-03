@extends('customer.layout')
@section('title', 'ตระกร้าสินค้า')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style>
    #top-header {
        padding-bottom: 0 !important;
    }
    .img-cart {
        display: block;
        max-width: 50px;
        height: auto;
        margin-left: auto;
        margin-right: auto;
    }
    table tr td{
        border:1px solid #FFFFFF;
    }

    table tr th {
        background:#eee;
    }

    .panel-shadow {
        box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
    }

    .qty-label {
        width: max-content;
    }

    .proceed_check_out_btn {
        box-shadow:inset 0px 1px 0px 0px #ffc208;
        background-color: #ffc208;
        border:1px solid #ffc208;
        display:inline-block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:13px;
        font-weight:bold;
        padding:10px 12px;
        text-decoration:none;
    }

    .proceed_check_out_btn:disabled {
        box-shadow:inset 0px 1px 0px 0px #c6c6ca;
        background-color: #c6c6ca;
        border:1px solid #fbfbfb;
    }

    .proceed_check_out_btn:hover:not([disabled]) {
        background-color: #ff851a;
        color:#ffffff;
    }
    .proceed_check_out_btn:active {
        position:relative;
        top:1px;
    }

    .continue_shop_btn {
        box-shadow:inset 0px 1px 0px 0px #27b72e;
        background-color: #27b72e;
        border:1px solid #27b72e;
        display:inline-block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:13px;
        font-weight:bold;
        padding:10px 12px;
        text-decoration:none;
    }
    .continue_shop_btn:hover {
        background-color: #62d816;
        color:#ffffff;

    }
    .continue_shop_btn:active {
        position:relative;
        top:1px;
    }

    .order-submit:disabled {
        box-shadow: inset 0px 1px 0px 0px #c6c6ca;
        background-color: #c6c6ca;
        border: 1px solid #fbfbfb;
    }

    .btn .btn-warning:disabled {
        box-shadow: inset 0px 1px 0px 0px #c6c6ca;
        background-color: #c6c6ca;
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
                    <h3 class="breadcrumb-header">ตะกร้าสินค้า</h3>
                    <ul class="breadcrumb-tree">
                        <li><a disabled>หน้าหลัก</a></li>
                        <li  class="active">ตระกร้าสินค้า</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->
    <div class="container">
        @if(isset($carts))
            <div class="container bootstrap snippet">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info panel-shadow">
                            <div class="panel-heading">
                                <h3>
                                    ตะกร้าสินค้า
                                </h3>
                            </div>
                            <div class="panel-body">
                                @if(count($carts) > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead >
                                            <tr>
                                                <th>Option</th>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($carts as $index => $cart)
                                                    <form action="{{url('cart/manage')}}" method="POST">
                                                        {{ csrf_field() }}
                                                        <tr>
                                                            <td style="width: 10%;">
                                                                <div style="float: left;">
                                                                    <input type="hidden" name="cart_id" value="{{ $cart->cart_id }}">
                                                                    <input type="hidden" name="product_id" value="{{ $cart->product_id }}">
                                                                    <button class="btn btn-warning btn-update" type="submit" name="action" value="update" style="background-color: #ff6614">
                                                                        <i class="fa fa-edit fa-fw"></i>
                                                                    </button>
                                                                </div>
                                                                <div style="float: right;">
                                                                    <button class="btn btn-danger" type="submit" name="action" value="delete" style="background-color: red">
                                                                        <i class="fa fa-trash fa-fw"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td width="5%">{{ $index + 1 }}</td>
                                                            <td>
                                                                <strong>{{ $cart->product_name }}</strong>
                                                            </td>
                                                            <td>
                                                                <div class="qty-label" style="width: 100%">
                                                                    <div class="input-number" >
                                                                        <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->quantity + $cart->product_quantity }}">
                                                                        <span class="qty-up">+</span>
                                                                        <span class="qty-down">-</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{ $cart->total / $cart->quantity }} ฿
                                                            </td>
                                                            <td>{{ $cart->total }} ฿</td>
                                                        </tr>
                                                    </form>
                                                @endforeach
                                                <td colspan="6">
                                                    <hr>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td>Price Total</td>
                                                    <td>{{ $totalCart }} ฿</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td colspan="2">
                                                        <hr>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    ไม่มีสินค้าในตระกร้า
                                @endif
                            </div>
                        </div>

                        <div style="float: left;">
                            <form action="{{ URL('home') }}" method="get">
                                <button class="primary-btn order-submit" style="background-color: #6cb300">
                                    <i class="fa fa-arrow-left"></i>
                                    Continue Shopping
                                </button>
                            </form>

                        </div>

                        <div style="float: right;">
                            <form action="{{ url('checkout') }}" method="GET">
                                <button class="primary-btn order-submit" @if(count($carts) === 0) disabled @endif>
                                    <i class="fab fa-paypal"></i> Proceed to Check Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <br><br><br><br>
@endsection
