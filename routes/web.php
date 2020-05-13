<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', 'Product\\ProductCustomerController@homepage');                                                      /* Route หน้าแรกของเว็บไซต์ */
Route::get('home', 'Product\\ProductCustomerController@homepage');                                                  /* Route หน้าแรกของเว็บไซต์ */
Route::get('product/{product_id}', 'Product\\ProductCustomerController@show');
Route::get('product/category/{category_name}', 'Product\\ProductCustomerController@productByCategory');
Route::get('product/district/{district_name}', 'Product\\ProductCustomerController@productByDistrict');
Route::post('search', 'Product\\ProductCustomerController@search');
/* Route แสดงรายละเอียดสินค้านั้นๆ */

Auth::routes();

Route::group(['middleware' => ['auth', 'is_admin']], function() {
    /* Route เพิ่มหมวดหมู่ลงในระบบ ฝั่งผู้ดูแลระบบ */
    Route::get('category', 'Category\\CategoryController@index');
    Route::post('category/add', 'Category\\CategoryController@addCategory');
    Route::get('category/edit/{category_id}', 'Category\\CategoryController@editCategory');
    Route::post('category/update', 'Category\\CategoryController@updateCategory');
    Route::post('category/delete/{category_id}', 'Category\\CategoryController@deleteCategory');

    /* Route เพิ่มหมวดหมู่ย่อยลงในระบบ ฝั่งผู้ดูแลระบบ */
    Route::get('sub-category', 'Category\\SubCategoryController@index');
    Route::post('sub-category/add', 'Category\\SubCategoryController@addSubCategory');
    Route::get('sub-category/edit/{subcategory_id}', 'Category\\SubCategoryController@editSubCategory');
    Route::post('sub-category/update', 'Category\\SubCategoryController@updateSubCategory');
    Route::post('sub-category/delete/{subcategory_id}', 'Category\\SubCategoryController@deleteSubCategory');

    /* Route เพิ่มอำเภอในระบบ ฝั่งผู้ดูแลระบบ */
    Route::get('district', 'District\\DistrictController@index');
    Route::post('district/add', 'District\\DistrictController@addDistrict');
    Route::get('district/edit/{district_id}', 'District\\DistrictController@editDistrict');
    Route::post('district/update', 'District\\DistrictController@updateDistrict');
    Route::post('district/delete/{district_id}', 'District\\DistrictController@deleteDistrict');

    /* Route เพิ่มตำบลในระบบ ฝั่งผู้ดูแลระบบ */
    Route::get('sub-district', 'District\\SubDistrictController@index');
    Route::post('sub-district/add', 'District\\SubDistrictController@addSubDistrict');
    Route::get('sub-district/edit/{subdistrict_id}', 'District\\SubDistrictController@editSubDistrict');
    Route::post('sub-district/update', 'District\\SubDistrictController@updateSubDistrict');
    Route::post('sub-district/delete/{subdistrict_id}', 'District\\SubDistrictController@deleteSubDistrict');

    /* Route เพิ่มสินค้า ฝั่งผู้ดูแลระบบ */
    Route::get('product', 'Product\\ProductAdminController@index');                                                  /* Route แสดงหน้าเพิ่มสินค้า ฝั่งผู้ดูแลระบบ */
    Route::post('product/add', 'Product\\ProductAdminController@addProduct');
    Route::get('product/edit/{product_id}', 'Product\\ProductAdminController@editProduct');
    Route::post('product/update', 'Product\\ProductAdminController@updateProduct');
    Route::post('product/delete/{product_id}', 'Product\\ProductAdminController@deleteProduct');

    Route::get('statistic/year', 'Chart\\ChartController@orderChartByYear');
    Route::post('statistic/year', 'Chart\\ChartController@orderChartByYear');

    Route::get('statistic/month', 'Chart\\ChartController@orderChartByMonth');
    Route::post('statistic/month', 'Chart\\ChartController@orderChartByMonth');

    Route::get('user/setting', 'User\\UserAdminController@listUserSetting');
    Route::post('user/setting', 'User\\UserAdminController@updateUserSetting');

    Route::get('orders', 'User\\UserAdminController@orderList');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('cart', 'Cart\\CartController@index');
    Route::post('cart/add', 'Cart\\CartController@addToCart');
    Route::post('cart/manage', 'Cart\\CartController@manageCartOptionByAction');
    Route::get('checkout', 'Order\\OrderController@checkout');
    Route::get('checkout/{payment_id}', 'Order\\OrderController@checkoutByPaymentId');
    Route::post('payment', 'Payment\\PaypalController@payment');
    Route::get('payment/status/{payId}', 'Payment\\PaypalController@successPaypalCallback');
    Route::post('user/detail/update', 'User\\UserCustomerController@updateUserDetail');
    Route::get('order', 'Order\\OrderController@index');
    Route::get('order-history', 'Order\\OrderController@orderHistory');
    Route::get('change-password', 'Auth\\ChangePasswordController@index');
    Route::post('change-password', 'Auth\\ChangePasswordController@changePassword');
    Route::get('payment/{paymentId}', 'Payment\\PaypalController@paymentDetail');
    Route::get('user/address', 'User\\UserCustomerController@userDetail');
    Route::post('user/address/update', 'User\\UserCustomerController@updateUserAddress');
});

Route::get('reset', function (){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('key:generate');
});

