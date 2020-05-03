<?php

namespace App\Http\Controllers\District;

use App\Model\District;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\SubDistrict;
use DB;

class SubDistrictController extends Controller {
    public function index () {
        $districts = District::all();
        $subDistricts = DB::table('sub_districts')
                          ->join('districts', 'sub_districts.district_id', '=', 'districts.district_id')
                          ->select('*')
                          ->get();

        return view('admin.district.sub-district')->with('districts', $districts)
                                                       ->with('subDistricts', $subDistricts);
    }

    public function addSubDistrict (Request $request) {
        $validate = Validator::make($request->all(),
            [
                'district_id' => 'required',
                'subdistrict_name' => 'required|unique:sub_districts',
            ],
            [
                'district_id.required' => 'กรุณาเลือกอำเภอ',
                'subdistrict_name.required' => 'กรุณากรอกตำบล',
                'subdistrict_name.unique' => 'ตำบลนี้มีอยู่แล้ว กรุณากรอกใหม่',
            ]);

        if($validate->passes()) {
            SubDistrict::create($request->all());
            SubDistrict::all()->last();

            return redirect()->back()->with('success', 'บันทึกสำเร็จ');
        } else {
            return back()->withErrors($validate)->withInput();
        }
    }

    public function getSubDistrict () {
        $subDistricts = DB::table('sub_districts')
                          ->join('districts', 'sub_districts.district_id', '=', 'districts.district_id')
                          ->select('*')
                          ->get();

        return response()->json(['subDistricts' => $subDistricts]);
    }

    public function editSubDistrict ($subdistrict_id) {
        $districts = District::all();
        $subDistrict = SubDistrict::findOrFail($subdistrict_id);

        return view('admin.district.edit-sub-district')->with('districts', $districts)
                                                            ->with('subDistrict', $subDistrict);
    }

    public function updateSubDistrict (Request $request) {
        $subdistrict_id = $request->get('subdistrict_id');
        $validate = Validator::make($request->all(),
            [
                'subdistrict_name' => 'required|unique:sub_districts,subdistrict_name,'.$subdistrict_id.',subdistrict_id',
                'district_id' => 'required'
            ],
            [
                'subdistrict_name.required' => 'กรุณากรอกตำบล',
                'subdistrict_name.unique' => 'ตำบลนี้มีอยู่แล้ว กรุณากรอกใหม่',
                'district_id' => 'กรุณาเลือกจังหวัด'
            ]);

        if($validate->passes()) {
            $data = $request->all();
            $subDistrict = SubDistrict::findOrFail($subdistrict_id);
            $subDistrict->subdistrict_name =  $data['subdistrict_name'];
            $subDistrict->district_id =  $data['district_id'];
            $subDistrict->update();

            return redirect('sub-district');
        }
        else {
            return back()->withErrors($validate)->withInput();
        }
    }

    public function deleteSubDistrict ($subdistrict_id) {
        $products = Product::where('subdistrict_id', $subdistrict_id)->get();
        $countProduct = $products->count();

        if ($countProduct === 0) {
            SubDistrict::destroy($subdistrict_id);
            return redirect('sub-district');
        }

        return redirect()->back()->with('fail', 'ไม่สามารถลบได้');
    }

}
