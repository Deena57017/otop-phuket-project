@extends('admin.layout')
@section('title', 'หน้าเปลี่ยนรหัสผ่าน')
@section('content')
    <div class="w3-container w3-section">
        <br>
        <div class="card text-black ">
            <div class="card-header bg-danger mb-3"><h6><i class="fa fa-cog fa-fw"></i> เปลี่ยนรหัสผ่านผู้ใช้งาน</h6></div>
            <form action="{{url('change-password')}}" method="POST">
                {{ csrf_field() }}
                <div class="card-body">
                    <b>
                        @if (Session::has('failure'))
                            <span class="text-danger">{!! Session::get('failure') !!}</span>
                        @elseif(Session::has('success'))
                            <span class="text-success">{!! Session::get('success') !!}</span>
                        @endif
                    </b><br>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            @if ($errors->has('oldPassword'))
                                <span class="text-danger">
                                    <b>{{ $errors->first('oldPassword') }}</b>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            รหัสผ่านเก่า :
                        </div>
                        <div class="col-md-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-cog fa-fw"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="oldPassword">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            @if ($errors->has('password'))
                                <span class="text-danger">
                                    <b>{{ $errors->first('password') }}</b>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            รหัสผ่านใหม่ :
                        </div>
                        <div class="col-md-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-cog fa-fw"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">
                                    <b>{{ $errors->first('password_confirmation') }}</b>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            ยืนยันรหัสผ่าน :
                        </div>
                        <div class="col-md-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-cog fa-fw"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <p class="card-text">
                        <div align="right">
                            <button class="w3-btn" style="background-color:#a91402" onclick="return confirm('แน่ใจหรือไม่ว่าจะเปลี่ยนรหัสผ่าน ?')">เปลี่ยนแปลงรหัสผ่าน <i class="fa fa-edit "></i>
                            </button>
                        </div>
                    </p>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br>
    </div>
    <hr>
    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
        <h4>FOOTER</h4>
        <p>Powered by w3.css</p>
    </footer>
@endsection