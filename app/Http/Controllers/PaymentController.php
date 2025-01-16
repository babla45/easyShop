<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $amount = $request->amount;
            $orderId = $request->order_id;

            // Create a PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100, // Amount in cents
                'currency' => 'usd',
                'metadata' => [
                    'order_id' => $orderId
                ]
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::find($orderId);
        
        if ($order) {
            $order->update(['status' => 'paid']);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'Order not found'], 404);
    }
} 