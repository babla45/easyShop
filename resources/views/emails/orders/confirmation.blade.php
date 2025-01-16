<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .order-details {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .product-table th,
        .product-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            padding: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Order Confirmation</h1>
        <p>Thank you for your order!</p>
    </div>

    <div class="order-details">
        <h2>Order #{{ $order->id }}</h2>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
        <p><strong>Delivery Location:</strong> {{ $order->delivery_location }}</p>

        <table class="product-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>${{ number_format($product->pivot->price, 2) }}</td>
                    <td>${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Total: ${{ number_format($order->total_amount, 2) }}
        </div>

        <p>
            Your order has been confirmed and will be shipped soon. 
            We'll send you another email with tracking information once your order is shipped.
        </p>

        <a href="{{ route('index') }}" class="button">Continue Shopping</a>
    </div>

    <div style="margin-top: 20px; text-align: center; color: #666;">
        <p>If you have any questions, please contact our support team.</p>
        <p>Thank you for shopping with us!</p>
    </div>
</body>
</html>