<?php

namespace App\Http\Controllers\Product;

use App\Model\Cart;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Category;
use App\Model\SubCategory;
use App\Model\District;
use App\Model\SubDistrict;
use Illuminate\Support\Facades\Validator;
use DB;

class ProductAdminController extends Controller {
    public function index () {
        /*  เก็ทค่า Category, SubCategory, District, SubDistrict แล้วส่งไปหน้า [ admin/product/product.blade.php ] */
        $categories = Category::get();
        $subcategories = SubCategory::get();
        $districts = District::get();
        $subDistricts = SubDistrict::get();
        $products = Product::get();

        return view('admin.product.product')->with('categories',$categories)
                                                  ->with('subcategories',$subcategories)
                                                  ->with('districts',$districts)
                                                  ->with('subDistricts',$subDistricts)
                                                  ->with('products', $products);
    }

    public function addProduct (Request $request) {
        /* เพิ่มสินค้าลงในระบบ */
        $validate = Validator::make($request->all(),[
            'product_name' => 'required|unique:products',
            'product_quantity' => 'required',
            'product_price' => 'required',
            'subcategory_id' => 'required',
            'subdistrict_id' => 'required',
            'product_cost' => 'required',
            'product_image' => 'mimes:jpeg,jpg,png,gif|required'

        ], [
            'product_name.required' => 'กรุณากรอกชื่อสินค้า',
            'product_name.unique' => 'สินค้านี้มีอยู่แล้ว กรุณากรอกใหม่',
            'product_quantity.required' => 'กรุณากรอกจำนวนสินค้า',
            'product_price.required' => 'กรุณากรอกราคาสินค้า',
            'product_cost.required' => 'กรุณากรอกราคาทุน',
            'subcategory_id.required' => 'กรุณาเลือกหมวดหมู่ย่อย',
            'subdistrict_id.required' => 'กรุณาเลือกตำบล',
            'product_image.required' => 'กรุณาเลือกรูปภาพ',
            'product_image.mimes' => 'กรุณาเลือกรูปภาพที่มีนามสกุลไฟล์ jpeg,jpg,png,gif'
        ]);

        if($validate->passes()) {
            Product::create($request->all());
            $product = Product::all()->last();
            if ($request->hasFile('product_image')) {
                echo 'Uploaded <br>';
                $file = $request->file('product_image');
                $fileName = "product_" . $product->product_id . "." . $file->getClientOriginalExtension();
                $file->move('upload/product', $fileName);
                $path = 'upload/product/' . $fileName;
                echo '<a href="' . $path . '" target="_blank">ดาวน์โหลดรูปภาพ</a>';
                $created_product = Product::findOrFail($product->product_id);
                $created_product->update(array('product_image' => $fileName));
            }
            else {
                echo 'Can not Upload';
            }

            return redirect('home');
        }
        else {
            return back()->withErrors($validate)->withInput();
        }
    }

    public function editProduct ($product_id) {
        $categories = Category::get();
        $subcategories = SubCategory::get();
        $districts = District::get();
        $subDistricts = SubDistrict::get();
        $product = Product::findOrFail($product_id);

        return view('admin.product.edit-product')->with('categories',$categories)
                                                      ->with('subcategories',$subcategories)
                                                      ->with('districts',$districts)
                                                      ->with('subDistricts',$subDistricts)
                                                      ->with('product', $product);
    }

    public function updateProduct (Request $request) {
        $product_id = $request->get('product_id');
        $product = Product::findOrFail($product_id);

        $validate = Validator::make($request->all(),[
            'product_name' => 'required|unique:products,product_name,'.$product_id.',product_id',
            'product_quantity' => 'required',
            'product_price' => 'required',
            'subcategory_id' => 'required',
            'subdistrict_id' => 'required',
            'product_cost' => 'required',
            'product_image' => 'mimes:jpeg,jpg,png,gif'
        ], [
            'product_name.required' => 'กรุณากรอกชื่อสินค้า',
            'product_name.unique' => 'สินค้านี้มีอยู่แล้ว กรุณากรอกใหม่',
            'product_quantity.required' => 'กรุณากรอกจำนวนสินค้า',
            'product_price.required' => 'กรุณากรอกราคาสินค้า',
            'product_cost.required' => 'กรุณากรอกราคาทุน',
            'subcategory_id.required' => 'กรุณาเลือกหมวดหมู่ย่อย',
            'subdistrict_id.required' => 'กรุณาเลือกตำบล',
            'product_image.mimes' => 'กรุณาเลือกรูปภาพที่มีนามสกุลไฟล์ jpeg,jpg,png,gif'
        ]);

        if($validate->passes()) {
            $data = $request->all();

            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $fileName = "product_" . $product->product_id . "." . $file->getClientOriginalExtension();
                $file->move('upload/product', $fileName);
                $created_product = Product::findOrFail($product->product_id);
                $created_product->update(array('product_image' => $fileName));
            }
            else {
                echo 'Can not Upload';
            }

            $product->product_name =  $data['product_name'];
            $product->product_quantity =  $data['product_quantity'];
            $product->product_price =  $data['product_price'];
            $product->subcategory_id =  $data['subcategory_id'];
            $product->subdistrict_id =  $data['subdistrict_id'];
            $product->product_cost =  $data['product_cost'];
            $product->update();

            return redirect('product');
        } else {
            return back()->withErrors($validate)->withInput();
        }
    }

    public function deleteProduct ($product_id) {
        $carts = Cart::where('product_id', $product_id)->get();
        $countCart = $carts->count();

        $order_details = OrderDetail::where('product_id',  $product_id)->get();
        $countOrderDetail = $order_details->count();

        if ($countCart === 0 && $countOrderDetail === 0) {
            Product::destroy($product_id);
            return redirect('product');
        }

        return redirect()->back()->with('fail', 'ไม่สามารถลบได้');
    }

}
