@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            <div class="space-y-4">
                @foreach($cartItems as $item)
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-medium">{{ $item->product->product_name }}</h3>
                            <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <p class="font-medium">${{ number_format($item->quantity * $item->product->price, 2) }}</p>
                    </div>
                @endforeach
                <div class="border-t pt-4">
                    <div class="flex justify-between items-center font-bold">
                        <p>Total:</p>
                        <p>${{ number_format($total, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
            
            <form id="payment-form" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label for="delivery_location" class="block text-sm font-medium text-gray-700">
                        Delivery Address
                    </label>
                    <textarea 
                        id="delivery_location" 
                        name="delivery_location" 
                        rows="3" 
                        class="w-full border rounded-md p-2"
                        required
                    ></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Select Payment Method</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="card" class="mr-2">
                            <span>Credit/Debit Card</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="cod" class="mr-2">
                            <span>Cash on Delivery</span>
                        </label>
                    </div>
                </div>

                <div id="card-payment-section" class="hidden space-y-2">
                    <label for="card-element" class="block text-sm font-medium text-gray-700">
                        Credit or debit card
                    </label>
                    <div id="card-element" class="p-3 border rounded-md">
                        <!-- Stripe Card Element will be inserted here -->
                    </div>
                    <div id="card-errors" class="text-red-600 text-sm" role="alert"></div>
                </div>

                <button type="submit" 
                        id="submit-button"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    
    const paymentForm = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const cardPaymentSection = document.getElementById('card-payment-section');
    
    // Mount card element but keep it hidden initially
    card.mount('#card-element');

    // Handle payment method selection
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', (e) => {
            if (e.target.value === 'card') {
                cardPaymentSection.classList.remove('hidden');
                submitButton.textContent = 'Pay ${{ number_format($total, 2) }}';
            } else {
                cardPaymentSection.classList.add('hidden');
                submitButton.textContent = 'Place Order';
            }
        });
    });

    paymentForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        submitButton.disabled = true;
        
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const deliveryLocation = document.getElementById('delivery_location').value;

        try {
            // Create order
            const orderResponse = await fetch('/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    delivery_location: deliveryLocation,
                    payment_method: paymentMethod
                })
            });

            const orderData = await orderResponse.json();

            if (!orderResponse.ok) {
                throw new Error(orderData.error || 'Failed to create order');
            }

            if (paymentMethod === 'card') {
                // Handle card payment
                submitButton.textContent = 'Processing payment...';
                
                const paymentResponse = await fetch('/payment/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: {{ $total }},
                        order_id: orderData.order_id
                    })
                });

                const paymentData = await paymentResponse.json();

                if (paymentData.error) {
                    throw new Error(paymentData.error);
                }

                const result = await stripe.confirmCardPayment(paymentData.clientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: '{{ auth()->user()->name }}'
                        }
                    }
                });

                if (result.error) {
                    throw new Error(result.error.message);
                }

                await fetch('/payment/confirm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: orderData.order_id
                    })
                });
            }

            // Redirect to success page
            window.location.href = orderData.redirect_url;

        } catch (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            submitButton.disabled = false;
            submitButton.textContent = paymentMethod === 'card' ? 
                'Pay ${{ number_format($total, 2) }}' : 'Place Order';
        }
    });
</script>
@endpush
@endsection 