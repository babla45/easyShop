<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MultiVendor E-Commerce Platform</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        nav {
            position: sticky;
            top: 0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow mb-4">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="/" class="text-xl font-bold">EasyShop</a>
                <div class="flex items-center gap-4">
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('cart.index') }}" class="text-blue-500">Cart</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-500">Login</a>
                        <a href="{{ route('register') }}" class="text-blue-500">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(auth()->check() && auth()->user()->isAdmin())
        <div class="bg-red-500 text-white p-4 text-center">
            Logged in as Admin
        </div>
    @endif

    <div class="container mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
