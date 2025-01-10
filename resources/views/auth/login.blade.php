<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
    <p class="mt-4 text-gray-600">Don't have an account? <a href="register" class="text-blue-500 hover:underline">Create Account</a></p>
  </div>
</body>
</html>
