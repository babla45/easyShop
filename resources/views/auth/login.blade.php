<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-96">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Login to your account</h2>
    @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Add this alert for admins -->
    <div class="admin-alert">
        <i class="fas fa-info-circle"></i>
        This is the user login form. If you're an admin, please use the 
        <a href="{{ route('admin.loginForm') }}" class="admin-link">Admin Login</a> instead.
    </div>

    <form action="{{ route('login.submit') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="emailInput" class="block text-gray-600 mb-2">Email</label>
        <input type="email" id="emailInput" name="email" placeholder="Enter your email" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-6">
        <label for="passwordInput" class="block text-gray-600 mb-2">Password</label>
        <input type="password" id="passwordInput" name="password" placeholder="Enter your password" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-6">
        <input type="checkbox" name="remember" id="remember" class="mr-2">
        <label for="remember" class="text-gray-600">Remember Me</label>
      </div>
      <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600">Login</button>
    </form>

    <div class="admin-login-link">
        <a href="{{ route('admin.loginForm') }}" class="admin-button">
            <i class="fas fa-user-shield"></i>
            Admin Login
        </a>
    </div>
  </div>

  <p>Don't have an account? <a href="register">Create Account</a></p>

  <style>
    .admin-login-link {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .admin-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .admin-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    }

    .admin-button i {
        font-size: 1.1rem;
    }

    .admin-alert {
        background: linear-gradient(45deg, #f1c40f20, #f39c1220);
        border: 1px solid #f1c40f;
        border-radius: 6px;
        padding: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #7f6000;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-alert i {
        font-size: 16px;
        color: #f1c40f;
    }

    .admin-link {
        color: #e74c3c;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .admin-link:hover {
        color: #c0392b;
        text-decoration: underline;
    }
  </style>
</body>
</html>
