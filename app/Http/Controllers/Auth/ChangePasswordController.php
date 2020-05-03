<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Order\OrderController;

class ChangePasswordController extends Controller {
    private $carts, $paymentPending;

    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {
        $this->middleware('auth');
        $this->carts = new CartController();
        $this->paymentPending = new OrderController();
    }

    public function index(Request $request) {
        if (Auth::id() !== null) {
            $this->paymentPending->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        if (auth()->user()->isAdmin()) {
            return view('admin.change-password');
        } else {
            return view('customer.change-password');
        }
    }

    public function changePassword(Request $request) {
        if (Auth::id() !== null) {
            $this->paymentPending->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

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
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            $request->session()->flash('success', 'เปลี่ยนแปลงรหัสผ่านสำเร็จ');
            return back();
        }

        $request->session()->flash('failure', 'เปลี่ยนแปลงรหัสผ่านไม่สำเร็จ');

        return back();
    }
}