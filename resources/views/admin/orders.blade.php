@extends('admin.layout')
@section('title', 'รายการสั่งซื้อทั้งหมด')
@section('content')
    <style media="screen">
        .table-wrapper-scroll-y {
            display: block;
            max-height: 500px;
            overflow-y: auto;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }
    </style>
    <br>
    <div class="w3-container w3-section">
        @if(isset($paymentDetails))
            <div class="table-wrapper-scroll-y">
                <table class="table table-bordered table-dark">
                    <thead>
                    <td colspan="9"><h6>รายการสั่งซื้อทั้งหมด</h6>
                    </td>
                    <tr>
                        <th scope="col">เลขที่บิล</th>
                        <th scope="col">สถานะการชำระเงิน</th>
                        <th scope="col">ยอดเงิน</th>
                        <th scope="col">เลขที่อ้างอิงใน paypal</th>
                        <th scope="col">ตัวเลือก</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($paymentDetails as  $index => $payment)
                        <tr>
                            <td scope="row">{{ $payment->payment_id }}</td>
                            <td>{{ $payment->payment_status }}</td>
                            <td>{{ $payment->payment_total }} THB</td>
                            <td>{{ $payment->reference_id }}</td>
                            <td>
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
        @endif
    </div>
    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
        <h4>FOOTER</h4>
        <p>Powered by w3.css</p>
    </footer>
@endsection
