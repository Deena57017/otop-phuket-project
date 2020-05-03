{{-- หน้าเพิ่มสินค้า ฝั่งผู้ดูแลระบบ --}}

@extends('admin.layout')
@section('title', 'แก้ไชรายการสินค้า OTOP')

@section('content')
    <br>
    <div class="w3-container w3-section">
        <div class="card text-black">
            <div class="card-header bg-warning mb-3" style="background-color:#66bc10"><h6><i class="fa fa-archive fa-fw"></i>
                    แก้ไขสินค้า</h6></div>
            <form action="{{url('product/update')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            @if ($errors->has('product_name'))
                                <span class="text-danger"><b>{{ $errors->first('product_name') }}</b></span>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            @if ($errors->has('product_quantity'))
                                <span class="text-danger"><b>{{ $errors->first('product_quantity') }}</b></span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            ชื่อสินค้า :
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="ชื่อสินค้า" name="product_name"
                                       value="{{ old('product_name', $product->product_name) }}"
                                       aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-2">
                            จำนวนสินค้า :
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                                </div>
                                <input type="number" class="form-control" placeholder="จำนวนสินค้า"
                                       name="product_quantity"
                                       value="{{ old('product_quantity', $product->product_quantity) }}"
                                       aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            @if ($errors->has('product_price'))
                                <span class="text-danger"><b>{{ $errors->first('product_price') }}</b></span>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            @if ($errors->has('product_cost'))
                                <span class="text-danger"><b>{{ $errors->first('product_cost') }}</b></span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            ราคาสินค้าต่อชิ้น :
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                                </div>
                                <input type="number" class="form-control" placeholder="ราคาสินค้าต่อชิ้น"
                                       name="product_price"
                                       value="{{ old('product_price', $product->product_price) }}"
                                       aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-2">
                            ราคาทุนต่อชิ้น :
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                                </div>
                                <input type="number" class="form-control" placeholder="ราคาทุนต่อชิ้น"
                                       name="product_cost"
                                       value="{{ old('product_cost', $product->product_cost) }}"
                                       aria-describedby="basic-addon1">
                            </div>
                        </div>

                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            @if ($errors->has('subdistrict_id'))
                                <span class="text-danger"><b>{{ $errors->first('subdistrict_id') }}</b></span>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            @if ($errors->has('subcategory_id'))
                                <span class="text-danger"><b>{{ $errors->first('subcategory_id') }}</b></span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            ตำบล :
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                                </div>
                                <select name="subdistrict_id" class="form-control">
                                    @foreach($districts as $district)
                                        <optgroup label="{{$district['district_name']}}">
                                            @foreach($subDistricts as $subDistrict)
                                                @if($district['district_id'] === $subDistrict['district_id'])
                                                    <option value="{{$subDistrict['subdistrict_id']}}"
                                                        @if(old('subdistrict_id'))
                                                            @if(old('subdistrict_id') == $subDistrict['subdistrict_id']) {{ 'selected' }} @endif>
                                                        @else
                                                            @if($product->subdistrict_id == $subDistrict['subdistrict_id']) {{ 'selected' }} @endif>
                                                        @endif
                                                        {{$subDistrict['subdistrict_name']}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            หมวดหมู่ย่อย :
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-th-list fa-fw"></i></span>
                                </div>
                                <select name="subcategory_id" class="form-control">
                                    @foreach($categories as $category)
                                        <optgroup label="{{$category['category_name']}}">
                                            @foreach($subcategories as $subcategory)
                                                @if($category['category_id'] == $subcategory['category_id'])
                                                    <option value="{{ $subcategory['subcategory_id'] }}"
                                                        @if(old('subcategory_id'))
                                                            @if(old('subcategory_id') == $subcategory['subcategory_id']) {{ 'selected' }} @endif>
                                                        @else
                                                            @if($product->subcategory_id == $subcategory['subcategory_id']) {{ 'selected' }} @endif>
                                                        @endif
                                                        {{ $subcategory['subcategory_name'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            @if ($errors->has('product_image'))
                                <span class="text-danger"><b>{{ $errors->first('product_image') }}</b></span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            รูปภาพสินค้า :
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" name="product_image" class="custom-file-input"
                                           id="validatedCustomFile">
                                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            รายละเอียดสินค้า :
                        </div>
                        <div class="col-md-4">
                            <textarea class="form-control" name="product_detail" id="exampleFormControlTextarea1" rows="3">{{ $product->product_detail }}</textarea>
                        </div>
                    </div>
                    <br>
                    <p class="card-text">
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
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
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
        <h4>FOOTER</h4>
        <p>Powered by w3.css</p>
    </footer>
@endsection
