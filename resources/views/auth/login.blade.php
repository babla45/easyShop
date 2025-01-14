<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-blue-100 via-purple-50 to-pink-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-xl">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Sign in to continue</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
            <p class="text-sm text-blue-700 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                For admin access, use <a href="{{ route('admin.loginForm') }}" class="font-medium text-blue-600 hover:text-blue-500 underline ml-1">Admin Login</a>
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="emailInput" class="text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="emailInput" name="email" required
                           class="appearance-none relative block w-full px-4 py-3 mt-1 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="passwordInput" class="text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="passwordInput" name="password" required
                           class="appearance-none relative block w-full px-4 py-3 mt-1 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Forgot password?</a>
            </div>

            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-xl text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 font-medium">
                Sign in
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="register" class="font-medium text-blue-600 hover:text-blue-500">Create Account</a>
            </p>
        </div>
    </div>
</body>
</html>
