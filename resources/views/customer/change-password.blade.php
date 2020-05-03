@extends('customer.layout')
@section('title', 'เปลี่ยนรหัสผ่านผู้ใช้งาน')
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
                    <h3 class="breadcrumb-header">เปลี่ยนแปลงรหัสผ่าน</h3>
                    <ul class="breadcrumb-tree">
                        <li><a disabled>หน้าหลัก</a></li>
                        <li class="active">เปลี่ยนแปลงรหัสผ่านผู้ใช้งาน</li>
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
                        <form action="{{ URL('change-password') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="section-title">
                                <h3 class="title">เปลี่ยนแปลงรหัสผ่านผู้ใช้งาน</h3>
                            </div>
                            <b>
                                @if (Session::has('failure'))
                                    <span class="text-danger">{!! Session::get('failure') !!}</span>
                                @elseif(Session::has('success'))
                                    <span class="text-success">{!! Session::get('success') !!}</span>
                                @endif
                            </b>
                            <br>
                            <div class="form-group">
                                @if ($errors->has('oldPassword'))
                                    <span class="text-danger">
                                        <b>{{ $errors->first('oldPassword') }}</b>
                                    </span>
                                @endif
                                <input class="input" type="password" name="oldPassword" placeholder="Old Password">
                            </div>
                            <div class="form-group">
                                @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <b>{{ $errors->first('password') }}</b>
                                    </span>
                                @endif
                                <input class="input" type="password" name="password" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">
                                        <b>{{ $errors->first('password_confirmation') }}</b>
                                    </span>
                                @endif
                                <input class="input" type="password" name="password_confirmation" placeholder="Confirm New Password">
                            </div>

                            <div style="float: left;">
                                <button class="primary-btn order-submit" style="background-color: #ffa714">
                                    <i class="fa fa-edit"></i> Change Password
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