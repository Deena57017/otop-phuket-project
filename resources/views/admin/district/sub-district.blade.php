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
@section('title', 'หน้าตำบล')
@section('content')
    <div class="w3-container w3-section">
        <div align="right">
            <a href="{{ url('district') }}" class="w3-btn" style="background-color:red; color:white">กลับไปยังหน้าเพิ่มอำเภอ
                <i class="fa fa-arrow-left"></i></a>
        </div>
        <br>
        <div class="card text-black ">
            <div class="card-header bg-info mb-3"><h6><i class="fa fa-map-marked-alt fa-fw"></i> เพิ่มตำบล</h6></div>
            <form action="{{ url('sub-district/add') }}" method="POST">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row">
                        <div class="col md-6">
                            <b>
                                @if ($errors->has('district_id'))
                                    <span class="text-danger">{{ $errors->first('district_id') }}</span>
                                @else(session()->has('success'))
                                    <span class="text-success">{{ session()->get('success') }}</span>
                                @endif
                            </b><br>
                            <div class="input-group mb-3">
                                อำเภอ : <br>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                                class="fa fa-city fa-fw"></i></span>
                                </div>
                                <select class="form-control" name="district_id" placeholder="เลือกอำเภอ" onchange="getSubDistrict(this)">
                                    <option disabled selected> กรุณาเลือกอำเภอ </option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->district_id }}">
                                            {{ $district->district_name }}
                                        </option>
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
                                <select class="form-control" name="subdistrict_name">
                                    <option disabled selected> กรุณาเลือกตำบล </option>
                                </select>
                            </div>
                        </div>
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
        @if(isset($subDistricts))
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
                    <td colspan="5"><h6>ตำบล</h6>
                    </td>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ชื่อตำบล</th>
                        <th scope="col">ชื่ออำเภอ</th>
                        <th colspan="2" width="20%" scope="col">ตัวเลือก</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subDistricts as  $index => $subDistrict)
                        <tr>
                            <td scope="row">{{ $index + 1 }}</td>
                            <td>{{ $subDistrict->subdistrict_name }}</td>
                            <td>{{ $subDistrict->district_name }}</td>
                            <td>
                                <form action="{{url('sub-district/edit')}}/{{$subDistrict->subdistrict_id}}" method="GET">
                                    <button class="btn btn-warning btn-xs">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{url('sub-district/delete')}}/{{$subDistrict->subdistrict_id}}" method="POST">
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
    <script>
        function getSubDistrict(district) {
            let districtId = district.value;
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

            $('select[name=subdistrict_name]').find('option').remove().end();
            let filterSubDistrict = subDistrictList.filter((subDistrict) => {
                return subDistrict.districtId == districtId
            })

            for (let index = 0; index < filterSubDistrict.length; index++) {
                let value = filterSubDistrict[index].name;
                let subDistrictName = filterSubDistrict[index].name;
                let optionsubDistrictEle = $('<option></option>').attr('value', value).text(subDistrictName);

                $('select[name=subdistrict_name]').append(optionsubDistrictEle);
            }
        }
    </script>
@endsection
