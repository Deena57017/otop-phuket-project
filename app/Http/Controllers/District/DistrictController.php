<?php

namespace App\Http\Controllers\District;

use App\Model\SubDistrict;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\District;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller {
    public function index () {
        $districts = District::all();

        return view('admin.district.district')->with('districts', $districts);
    }

    public function addDistrict (Request $request) {
        /* เพิ่มอำเภอในระบบ */

        $validate = Validator::make($request->all(),
          [
              'district_name' => 'required|unique:districts',
          ],
          [
              'district_name.required' => 'กรุณากรอกอำเภอ',
              'district_name.unique' => 'อำเภอนี้มีอยู่แล้ว กรุณากรอกใหม่',
          ]);

        if($validate->passes()) {
            District::create($request->all());
            $district = District::all()->last();

            return redirect()->back()->with('success', 'บันทึกสำเร็จ');
        } else {
            return back()->withErrors($validate)->withInput();
        }
    }

    public function getDistrict () {
        /* แสดงอำเภอในระบบ */

        $districts = District::get();
        return response()->json(['districts' => $districts]);
    }

    public function editDistrict($district_id) {
        $district = District::findOrFail($district_id);

        return view('admin.district.edit-district')->with('district', $district);
    }

    public function updateDistrict (Request $request) {
        /* อัพเดทอำเภอในระบบ */
        $district_id = $request->get('district_id');
        $validate = Validator::make($request->all(),
            [
                'district_name' => 'required|unique:districts,district_name,'.$district_id.',district_id',
            ],
            [
                'district_name.required' => 'กรุณากรอกอำเภอ',
                'district_name.unique' => 'อำเภอนี้มีอยู่แล้ว กรุณากรอกใหม่',
            ]);

        if($validate->passes()) {
            $data = $request->all();
            $district = District::findOrFail($district_id);
            $district->district_name =  $data['district_name'];
            $district->update();

            return redirect('district');
        } else {
            return back()->withErrors($validate)->withInput();
        }
    }
    public function deleteDistrict ($district_id) {
        $subDistricts = SubDistrict::where('district_id', $district_id)->get();
        $countSubDistrict = $subDistricts->count();

        if ($countSubDistrict === 0) {
            District::destroy($district_id);
            return redirect('district');
        }

        return redirect()->back()->with('fail', 'ไม่สามารถลบได้');
    }
}
