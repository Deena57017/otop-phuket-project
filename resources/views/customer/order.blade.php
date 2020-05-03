@extends('customer.layout')
@section('title', 'รายการสินค้าทั้งหมด')

<style>
    h2 {
        text-align: center;
    }

    table caption {
        padding: .5em 0;
    }

    @media screen and (max-width: 767px) {
        table caption {
            border-bottom: 1px solid #ddd;
        }
    }

    .p {
        text-align: center;
        padding-top: 140px;
        font-size: 14px;
    }
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
                    <h3 class="breadcrumb-header">รายการสั่งสินค้าทั้งหมด</h3>
                    <ul class="breadcrumb-tree">
                        <li><a>หน้าหลัก</a></li>
                        <li class="active">รายการสั่งสินค้าทั้งหมด</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if(isset($payments))
            <div class="container bootstrap snippet">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info panel-shadow">
                            <div class="panel-heading">
                                <h3>
                                    รายการสั่งสินค้าทั้งหมด
                                </h3>
                            </div>
                            <div class="panel-body">
                                @if(count($payments) > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead >
                                            <tr>
                                                <th>Payment Id</th>
                                                <th>Payment Detail</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Option</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($payments as $index => $payment)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $payment->payment_id }}</strong>
                                                    </td>
                                                    <td>
                                                        รายการสินค้าที่สั่งซื้อ
                                                        @foreach($paymentDetails as $paymentDetail)
                                                            @if ($paymentDetail->payment_id == $payment->payment_id)
                                                                <li>
                                                                    {{ $paymentDetail->product_name }} ( {{ $paymentDetail->order_detail_quantity }} รายการ )
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td align="center">
                                                        {{ $payment->payment_total }} บาท
                                                    </td>
                                                    <td>
                                                        @if($payment->payment_status === 'PENDING PAYMENT')
                                                            <span class="label label-warning">
                                                                {{ $payment->payment_status }}
                                                            </span><br><br>
                                                            <span class="label label-danger">
                                                                ชำระเงินภายในเวลา {{ $paymentPendingTime[$payment->payment_id]['date'] }}
                                                            </span>
                                                        @else
                                                            <span class="label label-success">
                                                                {{ $payment->payment_status }} ( วันที่จ่าย : {{ $payment->payment_date }} )
                                                            </span>
                                                            <br><br>
                                                            @if(!empty($payment->reference_id))
                                                                <span class="label label-success">
                                                                {{ $payment->reference_id }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form action="{{url('checkout/')}}/{{$payment->payment_id}}" method="GET">
                                                            @if($payment->payment_status === 'PENDING PAYMENT')
                                                                <button class="btn btn-danger btn-update">
                                                                <i class="fab fa-paypal"></i> Check out
                                                                </button>
                                                            @endif
                                                        </form>
                                                        <form action="{{url('payment/')}}/{{$payment->payment_id}}" method="GET">
                                                            @if($payment->payment_status === 'PAID')
                                                                <button class="btn btn-info btn-update">
                                                                    <i class="fa fa-eye"></i> Detail
                                                                </button>
                                                            @endif
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    ไม่มีรายการสั่งซื้อสินค้า
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div style="float: right;">
            {{ $payments->links() }}
        </div>
    </div>
@endsection