<?php

namespace App\Http\Controllers\User;

use App\Model\Cart;
use App\Model\OrderDetail;
use App\Model\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Order\OrderController;

class UserCustomerController extends Controller {
    public function __construct() {
        $this->carts = new CartController();
        $this->paymentPending = new OrderController();
    }

    public function updateUserDetail(Request $request) {
        $paymentId = $request->get('payment_id');

        $validate = Validator::make($request->all(),[
            'user_address' => 'required',
            'user_district' => 'required',
            'user_province' => 'required',
            'user_country' => 'required',
            'user_postcode' => 'required'
        ], [
            'user_address.required' => 'กรุณากรอกที่อยู่',
            'user_district.required' => 'กรุณากรอกตำบล',
            'user_province.required' => 'กรุณากรอกจังหวัด',
            'user_country.required' => 'กรุณากรอกประเทศ',
            'user_postcode.required' => 'กรุณากรอกรหัสไปรษณีย์',
        ]);

        if($validate->passes()) {
            $data = $request->all();
            $userDetail = UserDetail::where('user_id', Auth::id())->first();
            $userDetail->user_address =  $data['user_address'];
            $userDetail->user_district =  $data['user_district'];
            $userDetail->user_province =  $data['user_province'];
            $userDetail->user_country =  $data['user_country'];
            $userDetail->user_postcode =  $data['user_postcode'];
            $userDetail->update();
            return redirect('checkout/' . $paymentId);
        }
        else {
            return redirect('checkout/' . $paymentId)->withErrors($validate)->withInput();
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

    public function userDetail () {
        if (Auth::id() !== null) {
            $this->paymentPending->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        $userDetail  = DB::table('user_details')
                         ->join('users', 'user_details.user_id', '=', 'users.id')
                         ->where('users.id', Auth::id())
                         ->select('*')
                         ->first();

        return view('customer.user-detail')->with('userDetail', $userDetail);
    }

    public function updateUserAddress (Request $request) {
        $validate = Validator::make($request->all(),[
            'user_address' => 'required',
            'user_district' => 'required',
            'user_province' => 'required',
            'user_country' => 'required',
            'user_postcode' => 'required'
        ], [
            'user_address.required' => 'กรุณากรอกที่อยู่',
            'user_district.required' => 'กรุณากรอกตำบล',
            'user_province.required' => 'กรุณากรอกจังหวัด',
            'user_country.required' => 'กรุณากรอกประเทศ',
            'user_postcode.required' => 'กรุณากรอกรหัสไปรษณีย์',
        ]);

        if($validate->passes()) {
            $data = $request->all();
            $userDetail = UserDetail::where('user_id', Auth::id())->first();
            $userDetail->user_address =  $data['user_address'];
            $userDetail->user_district =  $data['user_district'];
            $userDetail->user_province =  $data['user_province'];
            $userDetail->user_country =  $data['user_country'];
            $userDetail->user_postcode =  $data['user_postcode'];
            $userDetail->update();
            return back();
        }
        else {
            return back()->withErrors($validate)->withInput();
        }
    }

}
