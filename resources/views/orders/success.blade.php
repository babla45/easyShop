@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800">Order Placed Successfully!</h1>
            <p class="text-gray-600">Thank you for your order. Your order details are below.</p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Order Details</h2>
            <div class="bg-gray-50 rounded p-4">
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Status:</strong> 
                    <span class="px-2 py-1 rounded text-sm text-white bg-{{ $order->status_color }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><strong>Delivery Location:</strong> {{ $order->delivery_location }}</p>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Items Ordered</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Product</th>
                            <th class="px-4 py-2 text-left">Quantity</th>
                            <th class="px-4 py-2 text-left">Price</th>
                            <th class="px-4 py-2 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $product)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $product->product_name }}</td>
                            <td class="px-4 py-2">{{ $product->pivot->quantity }}</td>
                            <td class="px-4 py-2">${{ number_format($product->pivot->price, 2) }}</td>
                            <td class="px-4 py-2">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr class="border-t">
                            <td colspan="3" class="px-4 py-2 font-semibold text-right">Total:</td>
                            <td class="px-4 py-2 font-semibold">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('index') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<style>
.bg-warning { background-color: #f1c40f; }
.bg-info { background-color: #3498db; }
.bg-success { background-color: #2ecc71; }
.bg-danger { background-color: #e74c3c; }
.bg-secondary { background-color: #95a5a6; }
</style>
@endsection 