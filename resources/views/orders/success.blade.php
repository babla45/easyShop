@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Order Confirmation</h1>
        
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Order #{{ $order->id }}</h2>
            <p class="text-gray-600">Status: {{ ucfirst($order->status) }}</p>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-2">Order Items:</h3>
            <div class="border rounded-lg overflow-hidden">
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
                        @foreach($order->items as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item->product->product_name }}</td>
                            <td class="px-4 py-2">{{ $item->quantity }}</td>
                            <td class="px-4 py-2">${{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-2">${{ number_format($item->price * $item->quantity, 2) }}</td>
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

        <div class="flex justify-between items-center">
            <a href="{{ route('index') }}" class="text-blue-500 hover:text-blue-700">
                ← Back to Shopping
            </a>
        </div>
    </div>
</div>
@endsection 