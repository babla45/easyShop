@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Success Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
        <p class="text-gray-600 text-lg">Thank you for your purchase. We're processing your order.</p>
    </div>

    <!-- Order Summary Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>
                <p class="text-gray-600">Order #{{ $order->id }}</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-600">{{ number_format($order->total_amount, 2) }} <span class="text-3xl">৳</span></p>
                <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($order->products as $product)
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center space-x-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->product_name }}"
                                 class="w-16 h-18 object-cover rounded-lg">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-500 text-xs">No Image</span>
                            </div>
                        @endif
                        <div class="flex-1 ml-4">
                            <h3 class="font-semibold text-gray-900">{{ $product->product_name }}</h3>
                            <p class="text-sm text-gray-600">Quantity: {{ $product->pivot->quantity }}</p>
                            <p class="text-sm font-medium text-gray-900">{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }} <span class="text-lg">৳</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Order Details -->
        <div class="border-t border-gray-200 pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Delivery Information</h3>
                    <p class="text-gray-600">{{ $order->delivery_location }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Payment Method</h3>
                    <p class="text-gray-600 capitalize">{{ $order->payment_method }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status and Next Steps -->
    <div class="bg-blue-50 rounded-lg p-6 mb-8">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">What's Next?</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Order confirmation email sent to your email</li>
                    <li>• We'll notify you when your order ships</li>
                    <li>• Estimated delivery: 3-5 business days</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 text-center">
            Continue Shopping
        </a>
        <a href="#"
           class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-8 py-3 rounded-lg font-semibold transition-colors duration-200 text-center">
            View Order History
        </a>
    </div>
</div>
@endsection
