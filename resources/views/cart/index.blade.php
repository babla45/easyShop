@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <p class="text-gray-600">Your cart is empty.</p>
    @else
        <div class="space-y-6">
            @foreach($cartItems as $item)
                <div class="border border-gray-200 rounded-lg shadow-sm p-4" id="cart-item-{{ $item->id }}">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Product Image -->
                        <div class="w-full md:w-1/4">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                     alt="{{ $item->product->product_name }}"
                                     class="w-full h-42 object-cover rounded">
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
                                <button type="button"
                                        onclick="removeFromCart({{ $item->id }})"
                                        class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
                                    Remove
                                </button>
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
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ action: action })
    })
    .then(async (response) => {
        const text = await response.text();
        try { return JSON.parse(text); } catch (_) { throw new Error(text); }
    })
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

        // Update cart counter in navigation
        updateCartCounter(data.cartCount);
    })
    .catch(error => console.error('Error:', error));
}

function updateCartTotal() {
    const prices = document.querySelectorAll('[id^="price-"]');
    const total = Array.from(prices).reduce((sum, price) => {
        return sum + parseFloat(price.textContent.replace('$', '').replace(/,/g, ''));
    }, 0);

    document.querySelector('#cart-total').textContent =
        '$' + total.toLocaleString('en-US', { minimumFractionDigits: 2 });
}

function updateCartCounter(cartCount) {
    const cartCounter = document.querySelector('.cart-counter');
    if (cartCounter && cartCount > 0) {
        cartCounter.textContent = `(${cartCount > 99 ? '99+' : cartCount})`;
    } else if (cartCount > 0) {
        // Create cart counter if it doesn't exist
        const cartLink = document.querySelector('a[href*="cart"]');
        if (cartLink) {
            const counter = document.createElement('span');
            counter.className = 'cart-counter';
            counter.textContent = `(${cartCount > 99 ? '99+' : cartCount})`;
            cartLink.appendChild(counter);
        }
    } else if (cartCount === 0) {
        // Remove cart counter if cart is empty
        const existing = document.querySelector('.cart-counter');
        if (existing) existing.remove();
    }
}

function removeFromCart(cartItemId) {
    fetch(`/cart/${cartItemId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async (response) => {
        const text = await response.text();
        try { return JSON.parse(text); } catch (_) { throw new Error(text); }
    })
    .then(data => {
        if (data.success) {
            // Remove the item from the DOM
            const itemElement = document.querySelector(`#cart-item-${cartItemId}`);
            if (itemElement) itemElement.remove();

            // Update totals and counter
            updateCartTotal();
            updateCartCounter(data.cartCount);
            // Intentionally no flash message on success
        } else {
            // Suppress flash message; still log for debugging
            console.error('Failed to remove item:', data.error);
        }
    })
    .catch(error => {
        // Suppress flash message; still log for debugging
        console.error('Error removing item from cart:', error);
    });
}

function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `fixed top-4 left-1/2 transform -translate-x-1/2 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    messageDiv.textContent = message;
    document.body.appendChild(messageDiv);
    setTimeout(() => messageDiv.remove(), 3000);
}
</script>
@endpush
@endsection
