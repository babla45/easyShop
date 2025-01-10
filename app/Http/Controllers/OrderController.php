<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();
            
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function place(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required'
        ]);

        // Get cart items
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        // Create order items
        foreach($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // Send email
        Mail::to($request->email)->send(new OrderConfirmation($order));

        // Clear cart
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('orders.success', $order)
            ->with('success', 'Order placed successfully! Check your email for confirmation.');
    }

    public function success(Order $order)
    {
        return view('orders.success', compact('order'));
    }
}