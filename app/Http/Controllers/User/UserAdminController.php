<?php
namespace App\Http\Controllers\User;

use App\Model\Payment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class UserAdminController extends Controller {
    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function changePassword(Request $request) {
        $this->validate($request, [
            'oldPassword' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'oldPassword.required' => 'กรุณากรอกรหัสผ่านเก่า',
            'password.required' => 'กรุณากรอกรหัสผ่านใหม่',
            'password.min:6' => 'กรุณากรอกรหัสผ่านใหม่อย่างน้อย 6 หลัก',
            'password.confirmed' => 'กรุณากรอกรหัสผ่านใหม่ให้ตรงกัน',
        ]);

        $user = User::findOrFail(Auth::id());
        $hashedPassword = $user->password;

        if (Hash::check($request->oldPassword, $hashedPassword)) {
            //Change the password
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            $request->session()->flash('success', 'เปลี่ยนแปลงรหัสผ่านสำเร็จ');
            return back();
        }

        $request->session()->flash('failure', 'เปลี่ยนแปลงรหัสผ่านไม่สำเร็จ');

        return back();
    }

    public function listUserSetting() {
        $users = User::orderBy('type', 'ASC')
                     ->get();

        return view('admin.user-setting')->with('users', $users);
    }

    public function updateUserSetting (Request $request) {
        $userId = $request->get('user_id');
        $userType = $request->get('type');
        $user = User::where('id', $userId)->first();
        $user->type =  $userType;
        $user->update();
        return back();
    }

    public function orderList () {
        $paymentDetails = DB::table('order_details')->join('payments', 'payments.order_id', '=', 'order_details.order_id')
                                                    ->join('products', 'products.product_id', '=', 'order_details.product_id')
                                                    ->where('payments.payment_status', Payment::PAYMENT_PAID)
                                                    ->get();

        return view('admin.orders')->with('paymentDetails', $paymentDetails);
    }
}