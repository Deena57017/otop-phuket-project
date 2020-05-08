<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Model\Payment;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Order\OrderController;

class PaypalController extends Controller {
    private $emailReceiver, $nameReceiver, $emailSender, $nameSender, $orderId;
    // Generate Base64(clientId:secretKey)
    const AUTHENTICATION_TOKEN = 'Authorization: Basic QVlLUHBRR0JoSVR6VUw3cHVrMl9oNDVjNTV6UWJqT0NQSExFTF9uc1NGR0tQUlJkVWpfMUFmTDFXVG1ka253S2NHTnFiSjBDeTJrYzRVSkU6RUtMdGhCdU1uNmFZeXFVNVF1MjJyQ3MwZU0zS3ZQWnJGV25vclNwbFI5REx0M080dHRGUTZlXzNKaEo2R0xmNklLOU5oZkY5b2pJRzc4LU4=';
    const CONTENT_TYPE_URLENCODED = 'Content-Type: application/x-www-form-urlencoded';
    const CONTENT_TYPE_JSON = 'Content-Type: application/json';
    const AUTH_API_ENDPOINT_SANDBOX = 'https://api.sandbox.paypal.com/v1/oauth2/token';
    const PAYMENT_API_ENDPOINT_SANDBOX = 'https://api.sandbox.paypal.com/v1/payments/payment';
    const PAYMENT_STATUS = 'approved';
    // const BASE_URL = 'http://c21cab7b.ngrok.io/';
    const BASE_URL = 'http://127.0.0.1:8000/';
    private $carts, $paymentPending;

    public function __construct() {
        $this->emailSender = 'Otop5717@gmail.com';
        $this->nameSender = 'OTOP PHUKET';
        $this->middleware('auth');
        $this->carts = new CartController();
        $this->paymentPending = new OrderController();
    }

    // STEP 1: การ Authentication
    private function authentication () {
        $curlHttp = curl_init();
        // ใช้ CURL PHP
        curl_setopt_array($curlHttp, array(
            CURLOPT_URL => self::AUTH_API_ENDPOINT_SANDBOX,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                self::AUTHENTICATION_TOKEN,
                self::CONTENT_TYPE_URLENCODED,
            ),
        ));

        $curlHttpResponse = curl_exec($curlHttp);
        $response = json_decode($curlHttpResponse);
        curl_close($curlHttp);

        return $response;
    }

    // STEP 2: การ สร้าง
    public function payment (Request $request) {
        $responseAuth = $this->authentication();
        $paymentId = $request->get('payment_id');
        $payment = Payment::findOrFail($paymentId);

        if ($payment->payment_status == Payment::PAYMENT_PENDING) {
            $products = DB::table('order_details')->join('products', 'order_details.product_id', '=', 'products.product_id')
                ->where('order_details.order_id', $payment->order_id)
                ->orderBy('order_details.order_detail_quantity', 'asc')
                ->get();


            $prepareData = $this->preparePaypalPaymentData($paymentId, $products);

            $curlHttp = curl_init();
            curl_setopt_array($curlHttp, array(
                CURLOPT_URL => self::PAYMENT_API_ENDPOINT_SANDBOX,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $prepareData,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '. $responseAuth->access_token,
                    self::CONTENT_TYPE_JSON,
                ),
            ));

            $curlHttpResponse = curl_exec($curlHttp);
            $response = json_decode($curlHttpResponse);
            curl_close($curlHttp);

            $redirectURL = $response->links[1]->href;

            return redirect($redirectURL); // ไปที่ URL นี้
        } else {
            abort(503, 'Payment status is paid');
        }
    }

    public function successPaypalCallback(Request $request, $payId) {
        $responseAuth = $this->authentication();
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');
        $urlExecute = self::PAYMENT_API_ENDPOINT_SANDBOX. '/' . $paymentId . '/execute';
        $body['payer_id'] = $payerId;
        $prepareData = json_encode($body);

        $curlHttp = curl_init();
        curl_setopt_array($curlHttp, array(
            CURLOPT_URL => $urlExecute,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $prepareData,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $responseAuth->access_token,
                self::CONTENT_TYPE_JSON,
            ),
        ));

        $curlHttpResponse = curl_exec($curlHttp);
        $response = json_decode($curlHttpResponse);
        curl_close($curlHttp);

        $payment = Payment::findOrFail($payId);
        if (isset($response->state) && $response->state === self::PAYMENT_STATUS) {
            $currentTime = Carbon::now();
            $isSendMail = true;

            if ($payment->payment_status === Payment::PAYMENT_PENDING) {
                $isSendMail = $this->sendMail($payment);

                $payment->update([
                    'payment_status' => Payment::PAYMENT_PAID,
                    'reference_id' => $response->id,
                    'payment_date' => $currentTime
                ]);
            }

            if ($isSendMail) {
                return view('customer.success')->with('payment', $payment);
            }
        } else if ($payment->payment_status === Payment::PAYMENT_PAID) {
            return view('customer.success')->with('payment', $payment);
        } else {
            return view('customer.success');
        }
    }

    private function preparePaypalPaymentData($paymentId, $products) {
        $prepareData['intent'] = 'sale';
        $prepareData['redirect_urls']['return_url'] = self::BASE_URL . 'payment/status/' . $paymentId;
        $prepareData['redirect_urls']['cancel_url'] = self::BASE_URL . 'payment/status/' . $paymentId;
        $prepareData['payer']['payment_method'] = 'paypal';
        $prepareData['transactions'][0]['amount'] = [];
        $prepareData['transactions'][0]['item_list']['items'] = [];

        $totalPrice = 0;
        $itemProducts = [];

        foreach ($products as $index => $product) {
            $totalPrice += $product->order_detail_total;
            $itemProducts[$index] = [
                'name' =>  $product->product_name,
                'description' => $product->product_name,
                'quantity' => $product->order_detail_quantity,
                'price' => $product->product_price,
                'tax' => '0.00',
                'sku' => '#OTOP-' . $product->product_name,
                'currency' => 'THB'
            ];
        }

        $prepareData['transactions'][0]['item_list']['items'] = $itemProducts;

        if ($totalPrice > 0) {
            $prepareData['transactions'][0]['amount'] = [
                'total' => $totalPrice,
                'currency' => 'THB',
                'details' => [
                    'subtotal' => $totalPrice,
                    'tax' => "0.00",
                    'shipping' => "0.00",
                    'handling_fee' => "0.00",
                    'shipping_discount' => '0.00',
                    'insurance' => '0.00'
                ]
            ];
        }


        return json_encode($prepareData);
    }

    public function sendMail ($payment) {
        $orderId = $payment->order_id;
        $userId = $payment->user_id;

        $orderData = DB::table('order_details')->join('orders', 'orders.order_id', '=', 'order_details.order_id')
                                               ->join('products', 'products.product_id', '=', 'order_details.product_id')
                                               ->where('order_details.order_id', $orderId)
                                               ->get();

        $userData = DB::table('user_details')->join('users', 'users.id', '=', 'user_details.user_id')
                                             ->where('user_id', $userId)
                                             ->first();
        $this->emailReceiver = $userData->email;
        $this->nameReceiver = $userData->name;
        $this->orderId = $orderId;

        $prepareData['orders'] = $orderData;
        $prepareData['user'] = $userData;
        $prepareData['order_id'] = '#OTOP-' . $this->orderId;
        $prepareData['order_date'] = $payment->payment_date;
        $prepareData['order_total'] = $payment->payment_total;

        try {
            Mail::send('customer.mail', $prepareData, function($message) {
                $message->to($this->emailReceiver, $this->nameReceiver)
                        ->from($this->emailSender, $this->nameSender)
                        ->subject('#OTOP-' . $this->orderId);
            });

            return true;
        } catch (Exception $exception) {
            dump("We've got errors!");
            dump($exception->getMessage());

            return false;
        }
    }

    public function paymentDetail ($paymentId) {
        if (Auth::id() !== null) {
            $this->paymentPending->getPaymentPending(Auth::id());
            $this->carts->getCart(Auth::id());
        }

        $payment = Payment::findOrFail($paymentId);
        $orderId = $payment->order_id;
        $userId = $payment->user_id;

        $orderData = DB::table('order_details')->join('orders', 'orders.order_id', '=', 'order_details.order_id')
                                               ->join('products', 'products.product_id', '=', 'order_details.product_id')
                                               ->where('order_details.order_id', $orderId)
                                               ->get();

        $userData = DB::table('user_details')->join('users', 'users.id', '=', 'user_details.user_id')
                                             ->where('user_id', $userId)
                                             ->first();


        return view('customer.payment-detail')->with('payment', $payment)
                                                   ->with('userData', $userData)
                                                   ->with('orderData', $orderData);
    }
}