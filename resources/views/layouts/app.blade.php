<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MultiVendor E-Commerce Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        nav {
            position: sticky;
            top: 0;
            background: linear-gradient(to right, #6098db, #58d9e2) !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }
        .brand-gradient {
            background: linear-gradient(90deg, #f59e0b, #ec4899, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .cart-counter {
            color: #dc2626 !important;
            font-weight: bold;
            font-size: 0.75rem;
        }
        .nav-button {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="shadow-lg">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-extrabold text-white transition duration-200">
                    EasyShop
                </a>
                <div class="flex items-center gap-6">
                    @auth
                        <div class="flex items-center gap-4">
                            <div class="text-white">
                                {{-- <span class="text-sm text-blue-100">Welcome back,</span> --}}
                                <div class="font-semibold">Welcome back, {{ auth()->user()->name }}</div>
                            </div>
                            @if(!auth()->user()->isAdmin())
                                <a href="{{ route('cart.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-1 rounded-lg transition duration-200 flex items-center gap-2 relative nav-button">
                                    🛒 Cart
                                    @php
                                        $cartCount = auth()->user()->getCartCount();
                                    @endphp
                                    @if($cartCount > 0)
                                        <span class="cart-counter">
                                            ({{ $cartCount > 99 ? '99+' : $cartCount }})
                                        </span>
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('admin.products.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-1 rounded-lg transition duration-200 flex items-center gap-2 nav-button">
                                    ⬅️ Back to Admin
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-lg transition duration-200 nav-button">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-white hover:text-blue-100 transition duration-200 font-medium">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-4 py-1 rounded-lg transition duration-200 font-medium nav-button">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(auth()->check() && auth()->user()->isAdmin())
        <div class="bg-gray-500 p-4 text-center">
            Logged in as Admin
        </div>
    @endif

    <div class="container mx-auto p-4 max-w-screen-xl">
        <div id="flash-container" class="space-y-3">
            @foreach (['success' => 'bg-green-50 border-green-300 text-green-800', 'error' => 'bg-red-50 border-red-300 text-red-800', 'warning' => 'bg-yellow-50 border-yellow-300 text-yellow-800', 'info' => 'bg-blue-50 border-blue-300 text-blue-800'] as $type => $classes)
                @if(session($type))
                    <div class="flash {{ $type }} border {{ $classes }} rounded-md px-4 py-3 flex items-start justify-between shadow-sm" role="alert">
                        <div class="flex items-center gap-2">
                            @if($type === 'success')
                                <span>✅</span>
                            @elseif($type === 'error')
                                <span>⛔</span>
                            @elseif($type === 'warning')
                                <span>⚠️</span>
                            @else
                                <span>ℹ️</span>
                            @endif
                            <span>{{ session($type) }}</span>
                        </div>
                        <button type="button" class="flash-close text-gray-500 hover:text-gray-700 ml-4">✖</button>
                    </div>
                @endif
            @endforeach
        </div>

        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const flashes = document.querySelectorAll('.flash');
            flashes.forEach(flash => {
                const closeBtn = flash.querySelector('.flash-close');
                const remove = () => {
                    flash.style.transition = 'opacity 300ms ease, transform 300ms ease';
                    flash.style.opacity = '0';
                    flash.style.transform = 'translateY(-4px)';
                    setTimeout(() => flash.remove(), 300);
                };
                if (closeBtn) closeBtn.addEventListener('click', remove);
                setTimeout(remove, 4000); // auto hide after 4s
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
