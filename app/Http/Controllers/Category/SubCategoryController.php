<?php

namespace App\Http\Controllers\Category;

use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\SubCategory;
use DB;

class SubCategoryController extends Controller {
    public function index () {
        $categories = Category::all();
        $subCategories = DB::table('sub_categories')
                           ->join('categories', 'sub_categories.category_id', '=', 'categories.category_id')
                           ->select('sub_categories.subcategory_name', 'categories.category_name','sub_categories.category_id', 'sub_categories.subcategory_id')
                           ->get();

        return view('admin.category.sub-category')->with('categories', $categories)
                                                       ->with('subCategories', $subCategories);
    }

    public function addSubCategory (Request $request) {
        $validate = Validator::make($request->all(),
          [
              'category_id' => 'required',
              'subcategory_name' => 'required|unique:sub_categories',
          ],
          [
              'category_id.required' => 'กรุณาเลือกหมวดหมู่',
              'subcategory_name.required' => 'กรุณากรอกหมวดหมู่ย่อย',
              'subcategory_name.unique' => 'หมวดหมู่ย่อยนี้มีอยู่แล้ว กรุณากรอกใหม่',
          ]);

        if($validate->passes()) {
          SubCategory::create($request->all());
          SubCategory::all()->last();

          return redirect()->back()->with('success', 'บันทึกสำเร็จ');
        } else {
          return back()->withErrors($validate)->withInput();
        }
    }

    public function getSubCategory () {
        $subCategories = DB::table('sub_categories')
                   ->join('categories', 'sub_categories.category_id', '=', 'categories.category_id')
                   ->select('sub_categories.subcategory_name', 'categories.category_name','sub_categories.category_id', 'sub_categories.subcategory_id')
                   ->get();
        return response()->json(['subCategories' => $subCategories]);
    }

    public function editSubCategory ($subcategory_id) {
        $categories = Category::all();
        $subcategory = SubCategory::findOrFail($subcategory_id);

        return view('admin.category.edit-sub-category')->with('categories', $categories)
                                                            ->with('subcategory', $subcategory);
    }

    public function updateSubCategory (Request $request) {
        $subcategory_id = $request->get('subcategory_id');
        $validate = Validator::make($request->all(),[
              'subcategory_name' => 'required|unique:sub_categories,subcategory_name,'.$subcategory_id.',subcategory_id',
              'category_id' => 'required'
        ], [
         'subcategory_name.required' => 'กรุณากรอกหมวดหมู่ย่อย',
         'subcategory_name.unique' => 'หมวดหมู่ย่อยนี้มีอยู่แล้ว กรุณากรอกใหม่',
         'category_id' => 'กรุณาเลือกหมวดหมู่'
        ]);

        if($validate->passes()) {
            $data = $request->all();
            $subcategory = SubCategory::findOrFail($subcategory_id);
            $subcategory->subcategory_name =  $data['subcategory_name'];
            $subcategory->category_id =  $data['category_id'];
            $subcategory->update();

            return redirect('sub-category');
        }
        else {
            return back()->withErrors($validate)->withInput();
        }
    }
    public function deleteSubCategory ($subcategory_id) {
        $products = Product::where('subcategory_id', $subcategory_id)->get();
        $countProduct = $products->count();

        if ($countProduct === 0) {
            SubCategory::destroy($subcategory_id);
            return redirect('sub-category');
        }

        return redirect()->back()->with('fail', 'ไม่สามารถลบได้');
    }

}
