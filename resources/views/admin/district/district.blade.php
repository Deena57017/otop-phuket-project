{{-- หน้าเพิ่มอำเภอและตำบล ฝั่งผู้ดูแลระบบ --}}
<style media="screen">
    .table-wrapper-scroll-y {
        display: block;
        max-height: 270px;
        overflow-y: auto;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
</style>
@extends('admin.layout')
@section('title', 'หน้าอำเภอ')
@section('content')
    <div class="w3-container w3-section">
        <div align="right">
            <a href="{{ url('sub-district') }}" class="w3-btn" style="background-color:red; color:white">เพิ่มตำบล <i
                        class="fa fa-plus-circle"></i></a>
        </div>
        <br>
        <div class="card text-black ">
            <div class="card-header bg-info mb-3"><h6><i class="fa fa-city  fa-fw"></i> เพิ่มอำเภอ</h6></div>
            <form action="{{url('district/add')}}" method="POST">
                {{ csrf_field() }}
                <div class="card-body">
                    <b style="margin-left: 70px">
                        @if ($errors->has('district_name'))
                            <span class="text-danger">{{ $errors->first('district_name') }}</span>
                        @else(session()->has('success'))
                            <span class="text-success">{{ session()->get('success') }}</span>
                        @endif

                    </b>
                    <div class="input-group mb-3">
                        อำเภอ : <br>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-city fa-fw"></i></span>
                        </div>
                        <select class="form-control" name="district_name" placeholder="เลือกอำเภอ">
                            <option disabled selected> กรุณาเลือกอำเภอ </option>
                            <option value="กะทู้"> กะทู้ </option>
                            <option value="ถลาง"> ถลาง </option>
                            <option value="เมืองภูเก็ต"> เมืองภูเก็ต </option>
                        </select>
                    </div>
                    <p class="card-text">
                    <div align="right">
                        <button class="w3-btn" style="background-color:#8ad633">บันทึก <i class="fa fa-save "></i>
                        </button>
                    </div>
                    <br>

                    </p>
                </div>
            </form>
        </div>
        <br><br>

        @if(isset($districts))
            @if(session()->has('fail'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle">
                        <b class="text-danger">{{ session()->get('fail') }}</b>
                    </i>
                </div>
            @endif
            <div class="table-wrapper-scroll-y">
                <table class="table table-bordered table-dark">
                    <thead>
                    <td colspan="4"><h6>อำเภอ</h6>
                    </td>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ชื่ออำเภอ</th>
                        <th colspan="2" width="20%" scope="col">ตัวเลือก</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($districts as  $index => $district)
                        <tr>
                            <td scope="row">{{ $index + 1 }}</td>
                            <td>{{ $district->district_name }}</td>
                            <td>
                                <form action="{{url('district/edit')}}/{{$district->district_id}}" method="GET">
                                    <button class="btn btn-warning btn-xs">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{url('district/delete')}}/{{$district->district_id}}" method="POST">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash-alt fa-fw" onclick="return confirm('คุณต้องการลบอำเภอ {{$district->district_name}} ?')"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <hr>
    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
        <h4>FOOTER</h4>
        <p>Powered by w3.css</p>
    </footer>
@endsection
