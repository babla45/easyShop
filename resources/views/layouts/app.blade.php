<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MultiVendor E-Commerce Platform</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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

    <style>
    .admin-controls {
        position: fixed;
        top: 80px;
        right: 20px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .admin-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .admin-badge {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.2);
        display: flex;
        align-items: center;
        gap: 8px;
        animation: slideIn 0.5s ease-out;
    }

    .order-track-btn {
        background: linear-gradient(45deg, #2ecc71, #27ae60);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
    }

    .order-track-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46, 204, 113, 0.3);
        color: white;
    }

    .logout-btn {
        background: linear-gradient(45deg, #95a5a6, #7f8c8d);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        border: none;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(127, 140, 141, 0.2);
    }

    .logout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(127, 140, 141, 0.3);
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .admin-controls {
            top: 20px;
            right: 10px;
        }

        .admin-actions {
            flex-direction: column;
        }
    }
    </style>

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
