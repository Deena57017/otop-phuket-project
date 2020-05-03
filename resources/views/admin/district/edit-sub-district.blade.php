@extends('admin.layout')
@section('title', 'หน้าแก้ไขตำบล')
@section('content')
    <br>
    <div class="w3-container w3-section">
        <div class="card text-black ">
            @if($subDistrict)
                <div class="card-header bg-info mb-3"><h6><i class="fa fa-map-marked-alt fa-fw"></i> แก้ไขตำบล</h6></div>
                <form action="{{ url('sub-district/update') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-6">
                                <b>
                                    @if ($errors->has('district_id'))
                                        <span class="text-danger">{{ $errors->first('district_id') }}</span>
                                    @endif
                                </b><br>
                                <div class="input-group mb-3">
                                    อำเภอ : <br>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                    class="fa fa-city fa-fw"></i></span>
                                    </div>
                                    <select class="form-control" name="district_id" onchange="getSubDistrict(this)">
                                        @foreach($districts as $district)
                                            @if(old('district_id', '') ==  '')
                                                <option value="{{ $district->district_id }}"
                                                @if($district->district_id == $subDistrict->district_id) {{ 'selected' }} @endif>
                                                    {{ $district->district_name }}
                                                </option>
                                            @elseif(old('district_id', '') !=  '')
                                                <option value="{{ $district->district_id }}" @if(old('district_id') == $district->district_id) {{ 'selected' }} @endif>
                                                    {{ $district->district_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col md-6">
                                <b>
                                    @if ($errors->has('subdistrict_name'))
                                        <span class="text-danger">{{ $errors->first('subdistrict_name') }}</span>
                                    @endif
                                </b><br>
                                <div class="input-group mb-3">
                                    ตำบล : <br>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                    class="fa fa-map-marked-alt  fa-fw"></i></span>
                                    </div>
                                    <input type="hidden" name="subdistrict_id" value="{{$subDistrict->subdistrict_id}}">
                                    <select class="form-control" name="subdistrict_name">
                                        <option disabled selected> กรุณาเลือกตำบล </option>
                                    </select>
                                    {{--<input type="text" class="form-control" placeholder="ตำบล" name="subdistrict_name"--}}
                                           {{--value="{{old('subdistrict_name', $subDistrict->subdistrict_name)}}" aria-describedby="basic-addon1">--}}
                                </div>
                            </div>
                        </div>
                        <p class="card-text">
                        <div align="right">
                            <button class="w3-btn" style="background-color:#d65c00">บันทึก <i class="fa fa-save "></i>
                            </button>
                        </div>
                        <br>
                        </p>
                    </div>
                </form>
            @endif
        </div>

    </div>
    <script>
        let subDistrictList = [
            {
                districtId: 1,
                name: 'เชิงทะเล'
            },
            {
                districtId: 1,
                name: 'เทพกระษัตรี'
            },
            {
                districtId: 1,
                name: 'ไม้ขาว'
            },
            {
                districtId: 1,
                name: 'ป่าคลอก'
            },
            {
                districtId: 1,
                name: 'ศรีสุนทร'
            },
            {
                districtId: 2,
                name: 'เกาะแก้ว'
            },
            {
                districtId: 2,
                name: 'กะรน'
            },
            {
                districtId: 2,
                name: 'ฉลอง'
            },
            {
                districtId: 2,
                name: 'ตลาดเหนือ'
            },
            {
                districtId: 2,
                name: 'ตลาดใหญ่'
            },
            {
                districtId: 2,
                name: 'รัษฎา'
            },
            {
                districtId: 2,
                name: 'ราไวย์'
            },
            {
                districtId: 2,
                name: 'วิชิต'
            }
            ,
            {
                districtId: 3,
                name: 'กะทู้'
            },
            {
                districtId: 3,
                name: 'กมลา'
            },
            {
                districtId: 3,
                name: 'ป่าตอง'
            }
        ]
        $(document).ready(function () {
            let districtId = {!! json_encode($subDistrict->district_id) !!};
            var subDistrictNameEdit = {!! json_encode($subDistrict->subdistrict_name) !!};

            $('select[name=subdistrict_name]').find('option').remove().end();
            let filterSubDistrict = subDistrictList.filter((subDistrict) => {
                return subDistrict.districtId == districtId
            })

            for (let index = 0; index < filterSubDistrict.length; index++) {
                let value = filterSubDistrict[index].name;
                let subDistrictName = filterSubDistrict[index].name;
                let optionSubDistrictEle

                if (subDistrictNameEdit == subDistrictName) {
                    optionSubDistrictEle = $('<option></option>').attr('value', value).text(subDistrictName).attr('selected', 'selected');
                } else {
                    optionSubDistrictEle = $('<option></option>').attr('value', value).text(subDistrictName);
                }

                $('select[name=subdistrict_name]').append(optionSubDistrictEle);
            }
        })

        function getSubDistrict(district) {
            let districtId = district.value;

            $('select[name=subdistrict_name]').find('option').remove().end();
            let filterSubDistrict = subDistrictList.filter((subDistrict) => {
                return subDistrict.districtId == districtId
            })

            for (let index = 0; index < filterSubDistrict.length; index++) {
                let value = filterSubDistrict[index].name;
                let subDistrictName = filterSubDistrict[index].name;
                let optionSubDistrictEle = $('<option></option>').attr('value', value).text(subDistrictName);

                $('select[name=subdistrict_name]').append(optionSubDistrictEle);
            }
        }


    </script>
@endsection