@extends('customer.layout')
@section('title', 'แก้ไขข้อมูลที่อยู่')
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

    input[disabled] {
        background-color: #fcf7f7 !important;
    }
</style>
@section('content')
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">แก้ไขข้อมูลที่อยู่</h3>
                    <ul class="breadcrumb-tree">
                        <li><a disabled>หน้าหลัก</a></li>
                        <li class="active"><a disabled>ข้อมูลที่อยู่</a></li>
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
                        <form action="{{url('user/address/update')}}" method="POST">
                            {{ csrf_field() }}

                            <div class="section-title">
                                <h3 class="title">Billing address</h3>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" value="{{ $userDetail->name }}" placeholder="Username" readonly disabled>
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" value="{{ $userDetail->email }}" placeholder="Email" readonly disabled>
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

                            <div style="float: right;">
                                <button class="primary-btn order-submit" style="background-color: #ffa714">
                                    <i class="fa fa-edit"></i> เปลี่ยนแปลงข้อมูลที่อยู่
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /Billing Details -->

                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
@endsection