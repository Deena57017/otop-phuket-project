@extends('admin.layout')
@section('title', 'หน้าแก้ไขหมวดหมู่สินค้า')
@section('content')
    <br>
    <div class="w3-container w3-section">
        <div class="card text-black ">
            @if(isset($category))
                <div class="card-header bg-warning mb-3"><h6><i class="fa fa-th-list  fa-fw"></i> แก้ไขหมวดหมู่</h6></div>
                <form action="{{url('category/update')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <b style="margin-left: 70px">
                            @if ($errors->has('category_name'))
                                <span class="text-danger">{{ $errors->first('category_name') }}</span>
                            @endif
                        </b>
                        <div class="input-group mb-3">
                            หมวดหมู่ : <br>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                            </div>
                            <input name="category_id" type="hidden" value="{{$category->category_id}}">
                            <input type="text" class="form-control" placeholder="หมวดหมู่สินค้า" name="category_name"
                                   aria-describedby="basic-addon1" value="{{old('category_name', $category->category_name)}}">
                        </div>
                        <p class="card-text">
                        <div align="right">
                            <button class="w3-btn" style="background-color:#d65c00">อัพเดท <i class="fa fa-save "></i>
                            </button>
                        </div>
                        <br>
                        </p>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection