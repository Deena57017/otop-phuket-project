<?php

namespace App\Http\Controllers\Category;

use App\Model\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    public function index () {
        $categories = Category::all();

        return view('admin.category.category')->with('categories', $categories);
    }

    public function addCategory (Request $request) {
        $validate = Validator::make($request->all(),
            [
                'category_name' => 'required|unique:categories',
            ],
            [
                'category_name.required' => 'กรุณากรอกหมวดหมู่',
                'category_name.unique' => 'หมวดหมู่นี้มีอยู่แล้ว กรุณากรอกใหม่',
            ]);

        if($validate->passes()) {
            Category::create($request->all());
            Category::all()->last();

            return redirect()->back()->with('success', 'บันทึกสำเร็จ');
        } else {
            return back()->withErrors($validate)->withInput();
        }
    }

    public function getCategory () {
        $categories = Category::get();
        return response()->json(['categories' => $categories]);
    }

    public function editCategory ($category_id) {
        $category = Category::findOrFail($category_id);

        return view('admin.category.edit-category')->with('category', $category);
    }

    public function updateCategory( Request $request) {
        $category_id = $request->get('category_id');
        $validate = Validator::make($request->all(),
          [
              'category_name' => 'required|unique:categories,category_name,'.$category_id.',category_id',
          ],
          [
              'category_name.required' => 'กรุณากรอกหมวดหมู่',
              'category_name.unique' => 'หมวดหมู่นี้มีอยู่แล้ว กรุณากรอกใหม่',
          ]);

        if($validate->passes()) {
            $data = $request->all();
            $category = Category::findOrFail($category_id);
            $category->category_name =  $data['category_name'];
            $category->update();

            return redirect('category');
        }
        else {
            return back()->withErrors($validate)->withInput();
        }
    }
    public function deleteCategory ($category_id) {
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        $countSubcategory = $subcategories->count();

        if ($countSubcategory === 0) {
            Category::destroy($category_id);
            return redirect('category');
        }

        return redirect()->back()->with('fail', 'ไม่สามารถลบได้');
    }
}
