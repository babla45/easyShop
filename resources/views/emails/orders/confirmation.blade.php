<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333; text-align: center;">Order Confirmation</h2>
        
        <p>Hello {{ $order->user->name }},</p>
        
        <p>Thank you for your order! Here are your order details:</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0;">
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
            <p><strong>Delivery Location:</strong> {{ $order->delivery_location }}</p>
        </div>

        <h3>Order Items:</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 10px; text-align: left;">Product</th>
                    <th style="padding: 10px; text-align: right;">Quantity</th>
                    <th style="padding: 10px; text-align: right;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td style="padding: 10px; border-top: 1px solid #dee2e6;">
                        {{ $product->product_name }}
                    </td>
                    <td style="padding: 10px; border-top: 1px solid #dee2e6; text-align: right;">
                        {{ $product->pivot->quantity }}
                    </td>
                    <td style="padding: 10px; border-top: 1px solid #dee2e6; text-align: right;">
                        ${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="padding: 10px; text-align: right; font-weight: bold;">Total:</td>
                    <td style="padding: 10px; text-align: right; font-weight: bold;">
                        ${{ number_format($order->total_amount, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 30px;">
            <p>Your order will be processed and shipped soon. We'll send you another email with tracking information once your order is shipped.</p>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('index') }}" 
               style="background: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Continue Shopping
            </a>
        </div>
        
        <p style="margin-top: 30px;">If you have any questions about your order, please don't hesitate to contact us.</p>
        
        <p>Thank you for shopping with us!</p>
        
        <p>Best regards,<br>The EasyShop Team</p>
    </div>
</body>
</html>