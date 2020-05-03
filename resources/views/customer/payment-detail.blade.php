@extends('customer.layout')
@section('title', 'รายการสินค้าที่สั่งซื้อ')
<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

    body {
        margin: 0;
        padding: 0;
        background: #e1e1e1;
    }

    #top-header {
        padding-bottom: 0 !important;
    }

    div, p, a, li, td {
        -webkit-text-size-adjust: none;
    }

    .ReadMsgBody {
        width: 100%;
        background-color: #ffffff;
    }

    .ExternalClass {
        width: 100%;
        background-color: #ffffff;
    }

    body {
        width: 100%;
        height: 100%;
        background-color: #e1e1e1;
        margin: 0;
        padding: 0;
        -webkit-font-smoothing: antialiased;
    }

    html {
        width: 100%;
    }

    p {
        padding: 0 !important;
        margin-top: 0 !important;
        margin-right: 0 !important;
        margin-bottom: 0 !important;
        margin-left: 0 !important;
    }

    .visibleMobile {
        display: none;
    }

    .hiddenMobile {
        display: block;
    }

    @media only screen and (max-width: 700px) {
        body {
            width: auto !important;
        }

        table[class=fullTable] {
            width: 96% !important;
            clear: both;
        }

        table[class=fullPadding] {
            width: 85% !important;
            clear: both;
        }

        table[class=col] {
            width: 45% !important;
        }

        .erase {
            display: none;
        }
    }

    @media only screen and (max-width: 420px) {
        table[class=fullTable] {
            width: 100% !important;
            clear: both;
        }

        table[class=fullPadding] {
            width: 85% !important;
            clear: both;
        }

        table[class=col] {
            width: 100% !important;
            clear: both;
        }

        table[class=col] td {
            text-align: left !important;
        }

        .erase {
            display: none;
            font-size: 0;
            max-height: 0;
            line-height: 0;
            padding: 0;
        }

        .visibleMobile {
            display: block !important;
        }

        .hiddenMobile {
            display: none !important;
        }
    }
</style>

@section('content')
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">รายการสินค้าที่สั่งซื้อ</h3>
                    <ul class="breadcrumb-tree">
                        <li><a>หน้าหลัก</a></li>
                        <li class="active">รายการสินค้าที่สั่งซื้อ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
        <tr>
            <td height="20"></td>
        </tr>
        <tr>
            <td>
                <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                       bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                    <tr class="hiddenMobile">
                        <td height="40"></td>
                    </tr>
                    <tr class="visibleMobile">
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td>
                            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center"
                                   class="fullPadding">
                                <tbody>
                                <tr>
                                    <td>
                                        <table width="220" border="0" cellpadding="0" cellspacing="0" align="left"
                                               class="col">
                                            <tbody>
                                            <tr>
                                                <td align="left">
                                                    <img src="http://ayutthaya.cdd.go.th/wp-content/uploads/sites/33/2017/06/Brand-OTOP.png" width="50%" alt="logo" border="0"/>
                                                </td>
                                            </tr>
                                            <tr class="hiddenMobile">
                                                <td height="40"></td>
                                            </tr>
                                            <tr class="visibleMobile">
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                    สวัสดี, {{ $userData->name }}
                                                    <br> ขอบคุณที่สั่งซื้อสินค้าจากทางร้านของเรา
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table width="220" border="0" cellpadding="0" cellspacing="0" align="right"
                                               class="col">
                                            <tbody>
                                            <tr class="visibleMobile">
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td height="5"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 21px; color: #ff0000; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;">
                                                    บิลรายการที่สั่งซื้อ
                                                </td>
                                            </tr>
                                            <tr>
                                            <tr class="hiddenMobile">
                                                <td height="50"></td>
                                            </tr>
                                            <tr class="visibleMobile">
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                                                    <small>เลขที่รายการสั่งซื้อ</small> {{ $payment->order_id }}<br/>
                                                    <small>วันที่ชำระเงิน: {{ $payment->payment_date }}</small>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- /Header -->
    <!-- Order Details -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
        <tbody>
        <tr>
            <td>
                <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                       bgcolor="#ffffff">
                    <tbody>
                    <tr>
                    <tr class="hiddenMobile">
                        <td height="60"></td>
                    </tr>
                    <tr class="visibleMobile">
                        <td height="40"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center"
                                   class="fullPadding">
                                <tbody>
                                <tr>
                                    <th colspan="2" style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;"
                                        width="52%" align="left">
                                        สินค้า
                                    </th>
                                    <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px; text-align: center"
                                        align="center">
                                        จำนวนสินค้า
                                    </th>
                                    <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px; text-align: right">
                                        ราคา
                                    </th>
                                </tr>
                                @foreach($orderData as $order)
                                    <tr>
                                        <td height="1" style="background: #bebebe;" colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td height="10" colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #ff0000;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                            class="article">
                                            {{ $order->product_name }}
                                        </td>
                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                            align="center"> {{ $order->order_detail_quantity }}
                                        </td>
                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                            align="right">{{ $order->order_detail_total }} ฿
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="20"></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- /Order Details -->
    <!-- Total -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
        <tbody>
        <tr>
            <td>
                <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                       bgcolor="#ffffff">
                    <tbody>
                    <tr>
                        <td>
                            <!-- Table Total -->
                            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center"
                                   class="fullPadding">
                                <tbody>
                                <tr>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                        ราคารวมทั้งหมด
                                    </td>
                                    <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                        width="80">
                                        {{ $payment->payment_total }} ฿
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- /Table Total -->
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- /Total -->
    <!-- Information -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
        <tbody>
        <tr>
            <td>
                <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                       bgcolor="#ffffff">
                    <tbody>
                    <tr>
                    <tr class="hiddenMobile">
                        <td height="60"></td>
                    </tr>
                    <tr class="visibleMobile">
                        <td height="40"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center"
                                   class="fullPadding">
                                <tbody>
                                <tr>
                                    <td>
                                        <table width="220" border="0" cellpadding="0" cellspacing="0" align="left"
                                               class="col">

                                            <tbody>
                                            <tr>
                                                <td style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                    <strong>ข้อมูลที่อยู่ผู้รับ</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="100%" height="10"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                    {{ $userData->name }}<br> {{ $userData->user_address }}, {{ $userData->user_district }}<br>  {{ $userData->user_province }}<br>
                                                    {{ $userData->user_province }}<br> {{ $userData->user_postcode }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr class="hiddenMobile">
                        <td height="60"></td>
                    </tr>
                    <tr class="visibleMobile">
                        <td height="30"></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- /Information -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">

        <tr>
            <td>
                <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                       bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                    <tr>
                        <td>
                            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center"
                                   class="fullPadding">
                                <tbody>
                                <tr>
                                    <td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                        Have a nice day.
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr class="spacer">
                        <td height="50"></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td height="20"></td>
        </tr>
    </table>

@endsection