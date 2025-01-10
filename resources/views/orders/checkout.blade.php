@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Order Summary -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
            @foreach($cartItems as $item)
                <div class="flex justify-between mb-2">
                    <span>{{ $item->product->product_name }} (x{{ $item->quantity }})</span>
                    <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                </div>
            @endforeach
            <div class="border-t pt-2 mt-4">
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
            
            <form action="{{ route('orders.place') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" 
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" 
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" name="phone" value="{{ auth()->user()->phone }}" 
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Shipping Address</label>
                    <textarea name="address" rows="3" class="w-full border rounded px-3 py-2" required>{{ auth()->user()->location }}</textarea>
                </div>

                <button type="submit" 
                        class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded">
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 