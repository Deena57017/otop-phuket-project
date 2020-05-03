<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Product;
use Illuminate\Support\Facades\Auth;
use View;
use DB;
use App\Http\Controllers\Order\OrderController;

class CartController extends Controller {
    private $paymentPending;

    public function getCart ($user_id) {
        $carts = Cart::where('user_id', $user_id)->get();
        $cartItem = 0;

        foreach ($carts as $cart) {
            $cartItem = $cartItem + $cart->quantity;
        }

        View::share('cartItem', $cartItem);
    }

    public function __construct() {
        $this->paymentPending = new OrderController('CartController');
    }

    public function index () {
        $totalCart = 0;
        $this->getCart(Auth::id());
        $this->paymentPending->getPaymentPending(Auth::id());
        $products = Product::all();
//        $carts = Cart::where('user_id', Auth::id())->get();

        $carts = DB::table('carts')->join('products', 'carts.product_id', '=', 'products.product_id')
                                   ->where('carts.user_id', Auth::id())
                                   ->orderBy('carts.quantity', 'asc')
                                   ->get();

        foreach($carts as $cart) {
            $totalCart = $totalCart + $cart->total;
        }

        return view('customer.cart')->with('products',$products)
                                         ->with('carts', $carts)
                                         ->with('totalCart',$totalCart);
    }

    public function addToCart (Request $request) {
        $product = Product::findOrFail($request->get('product_id'));
        $quantity = $request->get('quantity');
        $carts = Cart::all();

        foreach ($carts as $cart) {
            if ($cart->product_id === $product->product_id && $cart->user_id === Auth::id()) {
                $this->_updateCartItem($cart->cart_id, $product, $quantity, Auth::id());
                return redirect('cart');
            }
        }

        $cart = array(
            'product_id' => $product->product_id,
            'quantity' => $quantity,
            'total' => $product->product_price * $quantity,
            'user_id' => Auth::id()
        );
        Cart::create($cart);
        $this->_deleteQuantityOfProduct($product->product_id, $quantity);

        return redirect('cart');
    }

    public function manageCartOptionByAction(Request $request) {
        switch ($request->input('action')) {
            case 'update':
                $this->updateToCart($request);
                break;
            case 'delete':
                $cart_id = $request->get('cart_id');
                $this->deleteCartById($request, $cart_id);
                break;
        }

        return redirect('cart');
    }

    private function updateToCart(Request $request) {
        $quantityUpdate = $request->get('quantity');
        $cartId = $request->get('cart_id');
        $productId = $request->get('product_id');

        $cart = Cart::findOrFail($cartId);
        $product = Product::findOrFail($productId);

        if ($quantityUpdate < $cart->quantity) {
            $diffQuantity = $cart->quantity - $quantityUpdate;
            $totalPrice = $cart->total - ($product->product_price * $diffQuantity);

            $cart->update([
                'total' => $totalPrice,
                'quantity' => $quantityUpdate,
            ]);

            $product->update([
                'product_quantity' => $product->product_quantity + $diffQuantity,
            ]);
        } else {
            $diffQuantity = $quantityUpdate - $cart->quantity;
            $totalPrice = ($product->product_price * $diffQuantity) + $cart->total;

            $cart->update([
                'total' => $totalPrice,
                'quantity' => $quantityUpdate
            ]);

            $product->update([
                'product_quantity' => $product->product_quantity - $diffQuantity,
            ]);
        }
    }

    private function deleteCartById(Request $request, $cart_id) {
        $quantity = $request->get('quantity');
        $productId = $request->get('product_id');
        Cart::destroy($cart_id);
        $product = Product::findOrFail($productId);

        $product->update([
            'product_quantity' => $product->product_quantity + $quantity,
        ]);
    }

    private function _updateCartItem ($cart_id, $product, $quantity, $user_id) {
        $cart = Cart::findOrFail($cart_id);
        $cart->user_id = $user_id;
        $cart->quantity = $cart->quantity + $quantity;
        $cart->total = $cart->total + ($product->product_price * $quantity);
        $this->_deleteQuantityOfProduct($product->product_id, $quantity);
        $cart->update();
    }

    private function _deleteQuantityOfProduct ($product_id, $quantity) {
        $product = Product::findOrFail($product_id);
        $product->product_quantity = $product->product_quantity - $quantity;
        $product->update();
    }
}
