@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <p class="text-gray-600">Your cart is empty.</p>
    @else
        <div class="space-y-6">
            @foreach($cartItems as $item)
                <div class="border border-gray-200 rounded-lg shadow-sm p-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Product Image -->
                        <div class="w-full md:w-1/4">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                     alt="{{ $item->product->product_name }}"
                                     class="w-full h-48 object-cover rounded">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif

                            <!-- Quantity Controls and Remove Button -->
                            <div class="flex justify-between items-center mt-4">
                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                            onclick="updateQuantity({{ $item->id }}, 'decrement')"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2 rounded">
                                        -
                                    </button>
                                    <span id="quantity-{{ $item->id }}" class="text-xl font-semibold px-4">
                                        {{ $item->quantity }}
                                    </span>
                                    <button type="button"
                                            onclick="updateQuantity({{ $item->id }}, 'increment')"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2 rounded">
                                        +
                                    </button>
                                </div>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1">
                            <h2 class="text-xl font-bold mb-2">{{ $item->product->product_name }}</h2>
                            <p class="text-gray-600 mb-2">Category: {{ $item->product->category }}</p>
                            <p class="text-gray-600 mb-2">Location: {{ $item->product->location }}</p>
                            <p class="text-lg font-semibold text-green-600" id="price-{{ $item->id }}">
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Cart Total and Checkout Button -->
            <div class="mt-6 bg-white p-4 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-bold">Total:</span>
                    <span id="cart-total" class="text-2xl font-bold text-green-600">
                        ${{ number_format($total, 2) }}
                    </span>
                </div>
                <a href="{{ route('orders.checkout') }}" 
                   class="block w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-center">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Previous HTML remains the same until the script section -->

@push('scripts')
<script>
function updateQuantity(cartItemId, action) {
    fetch(`/cart/${cartItemId}/update-quantity`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ action: action })
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            // Redirect to home page if quantity was 1 and decreased
            window.location.href = data.redirect;
            return;
        }
        
        // Update quantity display
        document.querySelector(`#quantity-${cartItemId}`).textContent = data.quantity;
        
        // Update item total price
        document.querySelector(`#price-${cartItemId}`).textContent = 
            '$' + parseFloat(data.total).toLocaleString('en-US', { minimumFractionDigits: 2 });
        
        // Update cart total
        updateCartTotal();
    })
    .catch(error => console.error('Error:', error));
}

function updateCartTotal() {
    const prices = document.querySelectorAll('[id^="price-"]');
    const total = Array.from(prices).reduce((sum, price) => {
        return sum + parseFloat(price.textContent.replace('$', '').replace(',', ''));
    }, 0);
    
    document.querySelector('#cart-total').textContent = 
        '$' + total.toLocaleString('en-US', { minimumFractionDigits: 2 });
}
</script>
@endpush
@endsection 