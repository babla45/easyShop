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
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function place(Request $request)
    {
        try {
            $validated = $request->validate([
                'delivery_location' => 'required|string',
                'payment_method' => 'required|in:card,cod'
            ]);

            $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
            
            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Your cart is empty'], 400);
            }

            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'delivery_location' => $validated['delivery_location'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'processing'
            ]);

            session(['order_id' => $order->id]);

            foreach ($cartItems as $item) {
                $order->products()->attach($item->product_id, [
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            // Send order confirmation email
            try {
                Mail::to(auth()->user()->email)->send(new OrderConfirmation($order));
                \Log::info('Order confirmation email sent to: ' . auth()->user()->email);
            } catch (\Exception $e) {
                \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'redirect_url' => route('orders.success', $order->id)
            ]);

        } catch (\Exception $e) {
            \Log::error('Order placement error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while placing your order.'], 500);
        }
    }

    public function success(Order $order)
    {
        // Verify the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }
}