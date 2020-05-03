@extends('admin.layout')
@section('title', 'หน้าแก้ไขหมวดหมู่ย่อยสินค้า')
@section('content')
    <br>
    <div class="w3-container w3-section">
        <div class="card text-black">
            @if($subcategory)
                <div class="card-header bg-warning mb-3"><h6><i class="fa fa-list fa-fw"></i> แก้ไขหมู่ย่อย</h6></div>
                <form action="{{ url('sub-category/update') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-6">
                                <b>
                                    @if ($errors->has('category_id'))
                                        <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                    @endif
                                </b><br>
                                <div class="input-group mb-3">
                                    หมวดหมู่ : <br>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                                    </div>
                                    <select class="form-control" name="category_id" placeholder="เลือกหมวดหมู่">
                                        @foreach($categories as $category)
                                            @if(old('category_id', '') ==  '')
                                            <option value="{{ $category->category_id }}"
                                                @if($category->category_id == $subcategory->category_id) {{ 'selected' }} @endif>
                                                {{ $category->category_name }}
                                            </option>
                                            @elseif(old('category_id', '') !=  '')
                                                <option value="{{ $category->category_id }}" @if(old('category_id') == $category->category_id) {{ 'selected' }} @endif>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col md-6">
                                <b>
                                    @if ($errors->has('subcategory_name'))
                                        <span class="text-danger">{{ $errors->first('subcategory_name') }}</span>
                                    @endif
                                </b><br>
                                <div class="input-group mb-3">
                                    หมวดหมู่ย่อย : <br>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                    class="fa fa-list  fa-fw"></i></span>
                                    </div>
                                    <input type="hidden" name="subcategory_id" value="{{$subcategory->subcategory_id}}">
                                    <input type="text" class="form-control" placeholder="หมวดหมู่ย่อย"
                                           name="subcategory_name" value="{{old('subcategory_name', $subcategory->subcategory_name)}}" aria-describedby="basic-addon1">
                                </div>
                            </div>
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