{{-- หน้าเพิ่มหมวดหมู่่และหมวดหมู่ย่อย ฝั่งผู้ดูแลระบบ--}}
<style media="screen">
    .table-wrapper-scroll-y {
        display: block;
        max-height: 270px;
        overflow-y: auto;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
</style>
@extends('admin.layout')
@section('title', 'หน้าหมวดหมู่สินค้า')
@section('content')
    <div class="w3-container w3-section">
        <div align="right">
            <a href="{{ url('sub-category') }}" class="w3-btn" style="background-color:red; color:white">เพิ่มหมวดหมู่ย่อย
                <i class="fa fa-plus-circle"></i></a>
        </div>
        <br>
        <div class="card text-black ">
            <div class="card-header bg-info mb-3"><h6><i class="fa fa-th-list  fa-fw"></i> เพิ่มหมวดหมู่</h6></div>
            <form action="{{url('category/add')}}" method="POST">
                {{ csrf_field() }}
                <div class="card-body">
                    <b style="margin-left: 70px">
                        @if ($errors->has('category_name'))
                            <span class="text-danger">{{ $errors->first('category_name') }}</span>
                        @else(session()->has('success'))
                            <span class="text-success">{{ session()->get('success') }}</span>
                        @endif
                    </b>
                    <div class="input-group mb-3">
                        หมวดหมู่ : <br>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="หมวดหมู่สินค้า" name="category_name"
                               aria-describedby="basic-addon1" value="{{ old('category_name') }}">
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

        @if(isset($categories))
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
                    <td colspan="4"><h6>หมวดหมู่สินค้าทั้งหมด</h6>
                    </td>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ชื่อหมวดหมู่</th>
                        <th colspan="2" scope="col">ตัวเลือก</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $index => $category)
                        <tr>
                            <td scope="row">{{ $index + 1 }}</td>
                            <td>{{ $category->category_name }} </td>
                            <td>
                                <form action="{{url('category/edit')}}/{{$category->category_id}}" method="GET">
                                    <button class="btn btn-warning btn-xs">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{url('category/delete')}}/{{$category->category_id}}" method="POST">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash-alt fa-fw" onclick="return confirm('คุณต้องการลบหมวดหมู่ {{$category->category_name}} ?')"></i>
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
    <!-- Footer -->
        <footer class="w3-container w3-padding-16 w3-light-grey">
            <h4>FOOTER</h4>
            <p>Powered by w3.css</p>
        </footer>
@endsection
