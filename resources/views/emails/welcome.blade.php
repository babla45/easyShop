<!DOCTYPE html>
<html>
<head>
    <title>Welcome to EasyShop</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333; text-align: center;">Welcome to EasyShop!</h2>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Thank you for registering with EasyShop. We're excited to have you as a member of our community!</p>
        
        <p>Your account details:</p>
        <ul>
            <li>Name: {{ $user->name }}</li>
            <li>Email: {{ $user->email }}</li>
            <li>Location: {{ $user->location }}</li>
        </ul>
        
        <p>You can now:</p>
        <ul>
            <li>Browse our wide range of products</li>
            <li>Add items to your cart</li>
            <li>Place orders</li>
            <li>Track your deliveries</li>
        </ul>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('index') }}" 
               style="background: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Start Shopping
            </a>
        </div>
        
        <p style="margin-top: 30px;">If you have any questions, feel free to contact our support team.</p>
        
        <p>Best regards,<br>The EasyShop Team</p>
    </div>
</body>
</html> 