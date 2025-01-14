<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - EasyShop</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-box">
            <div class="admin-login-header">
                <i class="fas fa-user-shield"></i>
                <h1>Admin Login</h1>
            </div>

            <form method="POST" action="{{ route('admin.login') }}" class="admin-login-form">
                @csrf
                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Admin Email" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                </div>

                <button type="submit">Login as Admin</button>
            </form>

            <a href="{{ route('login') }}" class="back-to-main">
                <i class="fas fa-arrow-left"></i> Back to Main Login
            </a>
        </div>
    </div>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
        }

        .admin-login-container {
            width: 100%;
            max-width: 320px;
            padding: 20px;
        }

        .admin-login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .admin-login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .admin-login-header i {
            font-size: 40px;
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .admin-login-header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin: 0;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .input-with-icon {
            position: relative;
            margin-bottom: 5px;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
            font-size: 16px;
        }

        .input-with-icon input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-with-icon input:focus {
            border-color: #e74c3c;
            outline: none;
            box-shadow: 0 0 10px rgba(231, 76, 60, 0.1);
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .back-to-main {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .back-to-main:hover {
            color: #e74c3c;
        }

        @media (max-width: 480px) {
            .admin-login-container {
                padding: 15px;
            }
            
            .admin-login-box {
                padding: 20px;
            }
        }
    </style>
</body>
</html> 