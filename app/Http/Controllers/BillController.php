<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Bill;
use App\Models\ProductSize;

/**
 *
 */
class BillController extends Controller
{
    public function showBill()
    {

        $cart = Cart::with('cartProducts.productSize')->where('user_id', auth()->user()->id)->first();
        $cartItems = $cart->cartProducts;
        $totalPrice = $cartItems->sum('total_price');

        $product_size = ProductSize::all();
        $category = Category::all();
        return view('bill', compact('cartItems', 'totalPrice', 'category', 'product_size'));
    }
    public function applyCoupon(Request $request)
    {
        $cp = Coupon::where('content', $request->get('content'))->where('status', 'new')->where('count', '>', 0)->first();
        if ($request->get('content') && !$cp) {
            return response()->json([
                'status' => 500,
                'message' => "Coupon ko đúng hoặc đã hết hạn"
            ]);
        }
        return response()->json([
            'status' => 200,
            'data' => $cp->value,
            'message' => "Áp dụng thành công"
        ]);
    }
    public function checkout(Request $request)
    {
        $cp = Coupon::where('content', $request->get('coupon'))->where('status', 'new')->where('count', '>', 0)->first();

        if ($request->coupon && !$cp) {
            return redirect()->back()->with('error', 'Không có coupon.');
        }

        $customerName = $request->input('customer_name');
        $customerEmail = $request->input('customer_email');
        $customerAddress = $request->input('customer_address');
        $customerPhone = $request->input('customer_phone');
        $paymentMethod = $request->input('payment_method');

       
        $cart = Cart::with(['cartProducts.productSize', 'cartProducts.product'])->where('user_id', auth()->user()->id)->first();
        $cartItems = $cart->cartProducts;

        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->total_price;
        }
        if ($cp) {
            $totalPrice -= $totalPrice * $cp->value;
            $cp->count -= 1;
            $cp->save();
        }
        $products = [];
        foreach ($cartItems as $cartItem) {
            $products[] = $cartItem->toArray();
        }
        $bill = new Bill([
            'user_id' => auth()->user()->id,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_address' => $customerAddress,
            'total_price' => $totalPrice,
            'status' => 'Xác Nhận', 
            'customer_phone' => $customerPhone,
            'payment_method' => $paymentMethod,
            'date' => now(),
            'product' => json_encode($products),
            'discount' => $cp ? $totalPrice * $cp->value : 0,
        ]);
        $bill->save();
        $this->clearCart();

        return redirect('/')->with('success', 'Đặt hàng thành công. Cảm ơn bạn!');
    }

   
    private function clearCart()
    {
     
        CartProduct::with('cart')->whereHas('cart', function ($q) {
            return $q->where('user_id', auth()->user()->id);
        })->delete();
    }
    public function show($id)
    {
        $orders = Bill::findOrFail($id);

        return view('admin.billdetail', compact('orders'));
    }
    public function index()
    {
        $orders = Bill::all();

        return view('admin.bill', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Bill::findOrFail($id);

        $newStatus = $request->input('status');

        if (!in_array($newStatus, ['Xác nhận', 'Đang vận chuyển', 'Đã thanh toán', 'Hủy'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
    public function showInvoice()
    {
        $userId = auth()->id();
        $bills = Bill::where('user_id', $userId)->get()->toArray();
        $category = Category::all();

        return view('authBill', ['bills' => $bills,  'category' => $category]);
    }
}
