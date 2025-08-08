@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-6xl">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Top Section: Image and Product Details -->
        <div class="flex flex-col md:flex-row gap-8 p-6">
            <!-- Left Column: Product Image (50% width) -->
            <div class="w-full md:w-1/2 flex items-center justify-center">
                <div class="w-full max-w-md h-80 lg:h-96 bg-gray-50 flex items-center justify-center p-4 rounded-lg border">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->product_name }}"
                             class="w-full h-full object-contain" />
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-lg">
                            <span class="text-gray-500 text-lg">No Image Available</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Product Details (50% width) -->
            <div class="w-full md:w-1/2 space-y-6">
                <!-- Product Title -->
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-blue-600 leading-tight">
                        {{ $product->product_name }}
                    </h1>
                </div>

                <!-- Pricing and Availability -->
                <div class="space-y-4">
                    <div class="p-3 rounded-lg">
                        <span class="text-lg font-semibold text-gray-900">Price: {{ number_format($product->price, 2) }} <span class="text-2xl font-bold">৳</span></span>
                    </div>

                    <div class="p-3 rounded-lg">
                        <span class="text-gray-800">Status: <span class="text-green-600 font-medium">In Stock</span></span>
                    </div>

                    <div class="p-3 rounded-lg">
                        <span class="text-gray-800">Product Code: <span class="font-medium">{{ $product->id }}</span></span>
                    </div>

                    <div class="p-3 rounded-lg">
                        <span class="text-gray-800">Category: <span class="font-medium">{{ $product->category }}</span></span>
                    </div>

                    <div class="p-3 rounded-lg">
                        <span class="text-gray-800">Location: <span class="font-medium">{{ $product->location }}</span></span>
                    </div>
                </div>

                <!-- Payment Options -->
                <div class="border-t pt-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Payment Options</h3>
                    <div class="text-gray-700 space-y-1">
                        <div>• Cash on Delivery</div>
                        <div>• Credit Card</div>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                @auth
                    @if(!auth()->user()->isAdmin())
                        <div class="pt-4">
                            <button type="button"
                                    onclick="addToCart({{ $product->id }})"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                Add to Cart
                            </button>
                        </div>
                    @endif
                @endauth

            </div>
        </div>

        <!-- Bottom Section: Full Description (Full Width) -->
        <div class="border-t border-gray-200">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Description</h2>
                <div class="prose max-w-none">

                <!-- Pricing and Availability -->
                <div class="space-y-4">
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-gray-800">Product Code: <span class="font-medium">{{ $product->id }}</span></span>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-gray-800">Status: <span class="text-green-600 font-medium">In Stock</span></span>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-gray-800">Category: <span class="font-medium">{{ $product->category }}</span></span>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-gray-800">Location: <span class="font-medium">{{ $product->location }}</span></span>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <span class="text-lg font-semibold text-gray-900">Price: {{ number_format($product->price, 2) }} <span class="text-2xl font-bold">৳</span></span>

                    </div>
                </div>
                <br>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Product Features</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Premium quality materials</li>
                                <li>• Reliable performance</li>
                                <li>• User-friendly design</li>
                                <li>• Long-lasting durability</li>
                                <li>• Easy to use and maintain</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Care Instructions</h3>
                            <div class="text-gray-700 space-y-2">
                                <p>• Handle with care</p>
                                <p>• Keep in a dry place</p>
                                <p>• Avoid extreme temperatures</p>
                                <p>• Clean regularly as needed</p>
                                <p>• Follow manufacturer guidelines</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Additional Information</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Our products are designed with quality and functionality in mind. They offer excellent value for money and is built to meet your needs. Whether for personal use, business, or as a gift, this product delivers reliable performance and satisfaction. Each item is carefully inspected to ensure it meets our quality standards before reaching our customers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    // Show loading state
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Adding...';
    button.disabled = true;

    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(async (response) => {
        // Try to parse JSON; if not JSON, throw error
        const text = await response.text();
        try { return JSON.parse(text); } catch (_) { throw new Error(text); }
    })
    .then(data => {
        if (data.success) {
            // Show success message
            showMessage('Product added to cart!', 'success');

            // Update cart counter if it exists
            const cartCounter = document.querySelector('.cart-counter');
            if (cartCounter && data.cartCount > 0) {
                cartCounter.textContent = `(${data.cartCount > 99 ? '99+' : data.cartCount})`;
            } else if (data.cartCount > 0) {
                // Create cart counter if it doesn't exist
                const cartLink = document.querySelector('a[href*="cart"]');
                if (cartLink) {
                    const counter = document.createElement('span');
                    counter.className = 'cart-counter';
                    counter.textContent = `(${data.cartCount > 99 ? '99+' : data.cartCount})`;
                    cartLink.appendChild(counter);
                }
            }
        } else {
            showMessage(data.error || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Failed to add product to cart', 'error');
    })
    .finally(() => {
        // Restore button state
        button.textContent = originalText;
        button.disabled = false;
    });
}

function showMessage(message, type) {
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    messageDiv.textContent = message;

    // Add to page
    document.body.appendChild(messageDiv);

    // Remove after 3 seconds
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}
</script>
@endsection
