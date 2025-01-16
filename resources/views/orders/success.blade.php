@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 max-w-lg">
    <!-- Success Message -->
    <div class="text-center mb-4">
        <h1 class="text-2xl font-semibold text-gray-800">Order Confirmed!</h1>
        <p class="text-gray-600 text-sm">Thank you for your purchase</p>
    </div>

    <!-- Basic Order Info -->
    <div class="text-sm mb-4 text-center">
        <span class="text-gray-600">Order #{{ $order->id }}</span>
        <span class="mx-2">•</span>
        <span class="text-gray-600">${{ number_format($order->total_amount, 2) }}</span>
    </div>

    <!-- Ordered Items -->
    <div class="grid grid-cols-2 gap-4 mb-4">
        @foreach($order->products as $product)
            <div class="text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->product_name }}" 
                         class="w-16 h-16 object-cover rounded mx-auto mb-2">
                @endif
                <h3 class="font-medium text-gray-800 text-sm">{{ $product->product_name }}</h3>
                <p class="text-gray-600 text-xs">Qty: {{ $product->pivot->quantity }}</p>
                <p class="text-gray-800 text-sm">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</p>
            </div>
        @endforeach
    </div>

    <!-- Delivery Info -->
    <div class="text-sm text-gray-600 mb-2">
        <p>Delivery to: {{ $order->delivery_location }}</p>
    </div>

    <!-- Email Info -->
    <div class="text-sm text-gray-600 mb-6">
        <p>Order confirmation sent to your email</p>
    </div>
</div>

<!-- Fixed Continue Shopping Button -->
<div class="fixed bottom-0 left-0 right-0 bg-blue-600 text-center py-3">
    <a href="{{ route('index') }}" 
       class="text-white text-sm font-medium">
        Continue Shopping
    </a>
</div>

<!-- Add padding to prevent content from being hidden behind fixed button -->
<div class="h-16"></div>
@endsection 