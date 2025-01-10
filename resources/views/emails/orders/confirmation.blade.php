@component('mail::message')
# Order Confirmation

Thank you for your order!

**Order #{{ $order->id }}**

## Order Details:
@foreach($order->items as $item)
- {{ $item->product->product_name }} (x{{ $item->quantity }}) - ${{ number_format($item->price * $item->quantity, 2) }}
@endforeach

**Total: ${{ number_format($order->total_amount, 2) }}**

Shipping Address:
{{ $order->shipping_address }}

We'll notify you when your order ships.

Thanks,<br>
{{ config('app.name') }}
@endcomponent