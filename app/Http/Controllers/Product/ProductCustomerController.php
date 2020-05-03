<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\District;
use App\Model\Product;
use App\Model\SubCategory;
use App\Model\SubDistrict;
use DB;
use Illuminate\Support\Facades\Auth;
use View;
use Illuminate\Http\Request;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Order\OrderController;

class ProductCustomerController extends Controller {
    private $carts, $paymentPending;
    public function __construct () {
        $this->carts = new CartController();
        $this->paymentPending = new OrderController();
    }

    public function homepage () {
        if (Auth::id() !== null) {
            $this->paymentPending->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }
        /* เก็ท Product 4 ชิ้นล่าสุดที่ทำการเพิ่มลงไปในระบบ แล้วส่งไปหน้า [ customer/home.blade.php ] */

        $products = DB::table('products')->join('sub_categories', 'products.subcategory_id', '=', 'sub_categories.subcategory_id')
                                         ->orderBy('products.product_id', 'desc')
                                         ->orderBy('products.created_at', 'desc')
                                         ->select('products.*', 'sub_categories.*')
                                         ->limit(4)
                                         ->get();

        return view('customer.home')->with(compact('products'));
    }

    public function search (Request $request) {
        $searchKey = $request->get('search_key');

        if (Auth::id() !== null) {
            $this->paymentPending->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        $products = DB::table('products')->join('sub_categories', 'products.subcategory_id', '=', 'sub_categories.subcategory_id')
                                         ->orderBy('products.product_id', 'desc')
                                         ->orderBy('products.created_at', 'desc')
                                         ->select('products.*', 'sub_categories.*')
                                         ->where('products.product_name', 'LIKE', "%$searchKey%")
                                         ->get();

        return view('customer.product-by-search-key')->with(compact('products'))
                                                          ->with('searchKey', $searchKey);
    }

    public function show ($product_id) {
        if (Auth::id() !== null) {
            $this->carts->getCart(Auth::id());
            $this->paymentPending->getPaymentPending(Auth::id());
        }
        /* เก็ทรายละเอียดของ Product นั้น ๆ แล้วส่งไปแสดงผลในหน้า [ customer/show-product.blade.php ] */

        $product = DB::table('products')->join('sub_categories', 'products.subcategory_id', '=', 'sub_categories.subcategory_id')
                                        ->join('sub_districts', 'products.subdistrict_id', '=', 'sub_districts.subdistrict_id')
                                        ->where('products.product_id', $product_id)
                                        ->select('products.*', 'sub_categories.*', 'sub_districts.*')
                                        ->first();

        return view('customer.show-product')->with(compact('product'));
    }

    public function productByCategory (Request $request, $category_name) {
        if (Auth::id() !== null) {
            $this->paymentPending->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        $NUM_PAGE = 6;
        $page = $request->input('page');
        $page = ($page != null) ? $page : 1;

        $categoryName = [
            'food' => 'อาหาร',
            'beverage' => 'เครื่องดื่ม',
            'apparel' => 'เครื่องแต่งกาย',
            'accessories' => 'เครื่องประดับ',
            'herb' => 'สมุนไพร',
            'other' => 'หมวดหมู่อื่น'
        ];

        $findCategoryName = isset($categoryName[$category_name]) ? $categoryName[$category_name] : '';
        $products = array();

        if ($findCategoryName !== '') {
            $category = Category::where('category_name', $findCategoryName)
                                ->first();

            $subCategoriesId = array();

            if (isset($category->category_id)) {
                $subCategories = SubCategory::where('category_id', $category->category_id)
                                            ->get();

                foreach ($subCategories as $subCategory) {
                    $subCategoriesId[] = $subCategory->subcategory_id;
                }

                $products = Product::whereIn('subcategory_id', $subCategoriesId)
                                   ->paginate($NUM_PAGE);
            } else if($categoryName[$category_name] === 'หมวดหมู่อื่น') {
                $categories = Category::whereNotIn('category_name', ['อาหาร', 'เครื่องดื่ม', 'เครื่องแต่งกาย', 'เครื่องประดับ', 'สมุนไพร'])->get();
                $categoryIds = [];

                foreach ($categories as $item) {
                    $categoryIds[] = $item->category_id;
                }

                $subCategories = SubCategory::whereIn('category_id', $categoryIds)
                                            ->get();

                foreach ($subCategories as $subCategory) {
                    $subCategoriesId[] = $subCategory->subcategory_id;
                }

                $products = Product::whereIn('subcategory_id', $subCategoriesId)
                                   ->paginate($NUM_PAGE);
            }
        }

        return view('customer.product-by-category')->with('products', $products)
                                                        ->with('page',$page)
                                                        ->with('NUM_PAGE',$NUM_PAGE)
                                                        ->with('categoryName', $findCategoryName);
    }

    public function productByDistrict (Request $request, $district_name) {
        if (Auth::id() !== null) {
            $this->paymentPending->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        $NUM_PAGE = 6;
        $page = $request->input('page');
        $page = ($page != null) ? $page : 1;

        $categoryName = [
            'muang' => 'เมือง',
            'kathu' => 'กะทู้',
            'thalang' => 'ถลาง'
        ];

        $findDistrictName = isset($categoryName[$district_name]) ? $categoryName[$district_name] : '';
        $products = array();

        if ($findDistrictName !== '') {
            $district = District::where('district_name', $findDistrictName)
                                ->first();

            $subDistrictsId = array();

            if (isset($district->district_id)) {
                $subDistricts = SubDistrict::where('district_id', $district->district_id)
                                            ->get();

                foreach ($subDistricts as $subDistrict) {
                    $subDistrictsId[] = $subDistrict->subdistrict_id;
                }

                $products = Product::whereIn('subdistrict_id', $subDistrictsId)
                                    ->paginate($NUM_PAGE);
            }
        }

        return view('customer.product-by-district')->with('products', $products)
                                                        ->with('page',$page)
                                                        ->with('NUM_PAGE',$NUM_PAGE)
                                                        ->with('districtName', $findDistrictName);
    }

}
