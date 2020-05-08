<?php

namespace App\Http\Controllers\Order;

use App\Model\Cart;
use App\Model\OrderDetail;
use App\Http\Controllers\Controller;
use App\Model\Payment;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use View;
use DB;
use Carbon\Carbon;
use App\Model\Order;
use App\Http\Controllers\Cart\CartController;

class OrderController extends Controller {
    const LIMIT_OUT_OF_STOCK = 5;
    const LINE_API = 'https://notify-api.line.me/api/notify';
    const LINE_ACCESS_TOKEN = 'ol3uZkhmmuyBgB6Fz58thOc9t5m0OwDqeO23VoMZbDO';
    // const BASE_URL = 'http://c21cab7b.ngrok.io/';
    const BASE_URL = 'http://127.0.0.1:8000/';
    const TIME_END = '+2 minute';

    private $carts;

    public function getPaymentPending ($user_id) {
        $payments = Payment::where('user_id', $user_id)->get();
        $paymentPending = 0;

        foreach ($payments as $payment) {
            if ($payment->payment_status === Payment::PAYMENT_PENDING) {
                $paymentPending++;
            }
        }

        View::share('paymentPending', $paymentPending);
    }

    public function __construct($className = 'OtherController') {
        if ($className == 'OtherController') {
            $this->carts = new CartController();
        }
    }

    public function index(Request $request) {
        if (Auth::id() !== null) {
            $this->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        $NUM_PAGE = 6;
        $page = $request->input('page');
        $page = ($page != null) ? $page : 1;

        $paymentDetails = DB::table('order_details')->join('payments', 'payments.order_id', '=', 'order_details.order_id')
                                                    ->join('products', 'products.product_id', '=', 'order_details.product_id')
                                                    ->where('payments.user_id', Auth::id())
                                                    ->get();

        $paymentPendingTime = [];

        foreach ($paymentDetails as $paymentDetail) {
            if ($paymentDetail->payment_status === Payment::PAYMENT_PENDING) {
                $timeAddHour = date('Y-m-d H:i:s', strtotime(self::TIME_END, strtotime($paymentDetail->payment_date)));
                $paymentPendingTime[$paymentDetail->payment_id] = [
                    'payment_id' => $paymentDetail->payment_id,
                    'date' => $timeAddHour
                ];
            } else {
                $paymentPendingTime[$paymentDetail->payment_id] = null;
            }
        }

        $currentTime = Carbon::now();
        $paymentIds = [];
        foreach ($paymentPendingTime as $pendingTime) {
            if ($pendingTime['date'] !== null) {
                if (strtotime($currentTime) >= strtotime($pendingTime['date'])) {
                    $paymentIds[] = $pendingTime['payment_id'];
                }
            }
        }

        foreach ($paymentIds as $payId) {
            $paymentData = Payment::findOrFail($payId);
            $orderDetails = OrderDetail::where('order_id', $paymentData->order_id)
                                       ->get();

            foreach ($orderDetails as $orderDetail) {
                $product = Product::findOrFail($orderDetail->product_id);

                $product->update([
                    'product_quantity' => $product->product_quantity + $orderDetail->order_detail_quantity,
                ]);
            }
            Payment::destroy($payId);
        }

        $payments = Payment::where('user_id', Auth::id())
                           ->orderBy('payments.payment_id', 'desc')
                           ->paginate($NUM_PAGE);

        return view('customer.order')->with('payments', $payments)
                                          ->with('paymentDetails', $paymentDetails)
                                          ->with('page', $page)
                                          ->with('paymentPendingTime', $paymentPendingTime)
                                          ->with('NUM_PAGE' ,$NUM_PAGE);
    }

    public function checkout() {
        $currentTime = Carbon::now();
        if (Auth::id() !== null) {
            $this->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        $totalPrice = 0;
        $products = DB::table('carts')->join('products', 'carts.product_id', '=', 'products.product_id')
                                      ->where('carts.user_id', Auth::id())
                                      ->orderBy('carts.quantity', 'asc')
                                      ->get();

        $outOfStockList = [];

        foreach ($products as $product) {
            $totalPrice += $product->total;

            if ($product->product_quantity <= self::LIMIT_OUT_OF_STOCK) {
                array_push($outOfStockList, $product);
            }
        }

        if (sizeof($outOfStockList) > 0) {
            $this->alertMessageOutOfStock($outOfStockList);
        }

        $userDetail = DB::table('user_details')->join('users', 'users.id', '=', 'user_details.user_id')
                                               ->where('user_id', Auth::id())
                                               ->first();

        if ($totalPrice > 0) {
            $order = Order::create([
                'order_date' => $currentTime,
                'order_total' => $totalPrice,
                'user_id' => Auth::id()
            ]);

            foreach ($products as $product) {
                OrderDetail::create([
                    'order_id' => $order['order_id'],
                    'product_id' => $product->product_id,
                    'order_detail_quantity' => $product->quantity,
                    'order_detail_total' => $product->total
                ]);

                Cart::destroy($product->cart_id);
            }

            $hasAddress = $this->validateAddress($userDetail);

            $payment = Payment::create([
                'payment_date' => $currentTime,
                'user_id' => Auth::id(),
                'order_id' => $order['order_id'],
                'payment_total' => $order['order_total'],
                'payment_status' => Payment::PAYMENT_PENDING
            ]);

            return view('customer.checkout')->with('products', $products)
                                                 ->with('userDetail', $userDetail)
                                                 ->with('totalPrice', $totalPrice)
                                                 ->with('hasAddress', $hasAddress)
                                                 ->with('paymentId', $payment->payment_id);
        } else {
            return redirect('order');
        }
    }

    public function checkoutByPaymentId($paymentId) {
        if (Auth::id() !== null) {
            $this->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        $payment = Payment::findOrFail($paymentId);
        if ($payment->payment_status == Payment::PAYMENT_PENDING) {
            $totalPrice = 0;
            $products = DB::table('order_details')->join('products', 'order_details.product_id', '=', 'products.product_id')
                                                  ->where('order_details.order_id', $payment->order_id)
                                                  ->orderBy('order_details.order_detail_quantity', 'asc')
                                                  ->get();

            $userDetail = DB::table('user_details')->join('users', 'users.id', '=', 'user_details.user_id')
                                                   ->where('user_id', Auth::id())
                                                   ->first();

            $outOfStockList = [];

            foreach ($products as $product) {
                $totalPrice += $product->order_detail_total;

                if ($product->product_quantity <= self::LIMIT_OUT_OF_STOCK) {
                    array_push($outOfStockList, $product);
                }
            }

            if (sizeof($outOfStockList) > 0) {
                $this->alertMessageOutOfStock($outOfStockList);
            }

            $hasAddress = $this->validateAddress($userDetail);

            return view('customer.checkout')->with('products', $products)
                                                 ->with('userDetail', $userDetail)
                                                 ->with('totalPrice', $totalPrice)
                                                 ->with('hasAddress', $hasAddress)
                                                 ->with('paymentId', $paymentId);
        } else {
            abort(503, 'Payment status is paid');
        }
    }

    private function validateAddress($user) {
        $hasAddress = true;

        if (empty($user->user_address)) {
            $hasAddress = false;
        }

        if (empty($user->user_district)) {
            $hasAddress = false;
        }

        if (empty($user->user_province)) {
            $hasAddress = false;
        }

        if (empty($user->user_country)) {
            $hasAddress = false;
        }

        if (empty($user->user_postcode)) {
            $hasAddress = false;
        }

        return $hasAddress;
    }

    private function alertMessageOutOfStock ($outOfStockList) {
        $messageNotification = 'สินค้าในคลังใกล้หมดมีดังนี้: ';
        $products = [];
        foreach ($outOfStockList as $item) {
            $products[] = $item->product_name;
        }

        $messageNotification .= implode(', ', $products);
        $messageNotification .= ' คลิกลิ้งนี้เพื่ออัพเดทคลังสินค้า ' . self::BASE_URL . 'product' ;
        $messageNotification = nl2br($messageNotification);

        $message = array(
            'message' => $messageNotification,
            'imageThumbnail' => '',
            'imageFullsize' => ''
        );

        $this->sendNotificationMessage($message);
    }

    private function sendNotificationMessage ($message) {
        $headers = [
            'Method: POST',
            'Content-type: multipart/form-data',
            'Authorization: Bearer ' . self::LINE_ACCESS_TOKEN
        ];

        $curlHttp = curl_init();
        // ใช้ CURL PHP
        curl_setopt_array($curlHttp, array(
            CURLOPT_URL => self::LINE_API,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => $message,
            CURLOPT_RETURNTRANSFER => 1
        ));

        curl_exec($curlHttp);
        curl_close($curlHttp);
    }
}
