<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function place(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required'
        ]);

        // Get cart items
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'delivery_location' => $request->address
        ]);

        // Attach products to order
        foreach ($cartItems as $item) {
            $order->products()->attach($item->product_id, [
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // Clear cart
        Cart::where('user_id', auth()->id())->delete();

        // Redirect to success page
        return redirect()->route('orders.success', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function success(Order $order)
    {
        return view('orders.success', compact('order'));
    }
}