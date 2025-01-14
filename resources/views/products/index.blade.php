<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')
<<<<<<< HEAD
<div class="container">
    @if(session('error'))
        <div class="access-denied-alert">
            <i class="fas fa-lock"></i>
            <div class="alert-content">
                <h4>Access Restricted</h4>
                <p>{{ session('error') }}</p>
                <div class="alert-actions">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout Current User
                        </button>
                    </form>
                    <a href="{{ route('admin.loginForm') }}" class="admin-redirect-btn">
                        <i class="fas fa-user-shield"></i>
                        Login as Admin
=======
<div class="container mx-auto p-4">

    <!-- Add Product Button -->
    <div class="mb-5">
        <a href="/" class="bg-green-500 text-white px-4 py-2 rounded">Home Page</a>
        <a href="/products/create" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
            Add Product
        </a>
    </div>


    {{-- -------------- --}}
    <!-- Search Form with Dropdown -->
    <form action="/search" method="GET" class="mb-4 flex items-center gap-2">
        <select name="search_by" class="border p-2 rounded">
            <option value="name">Search by Name</option>
            <option value="category">Search by Category</option>
            <option value="location">Search by Location</option>
        </select>
        <input type="text" name="query" placeholder="Enter search term" class="border p-2 rounded w-1/2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
    </form>

    {{-- --------------------- --}}

<!-- Products Display with Flex Wrap Enabled -->
<div class="flex flex-wrap mt-4 justify-left align-center gap-4">
    @foreach($products as $product)
        <div class="border border-blue-300 shadow-lg p-4 rounded-lg w-72">
            <!-- Image Display -->
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->product_name }}"
                     class="w-full h-48 object-cover mb-4 rounded">
            @else
                <div class="w-full h-48 bg-gray-200 mb-4 flex items-center justify-center text-gray-500 rounded">
                    No Image
                </div>
            @endif

            <!-- Product Info -->
            <div class="mb-4">
                <h2 class="text-xl font-bold mb-2">{{ $product->product_name }}</h2>
                <p class="mb-2">Category: <span class="font-semibold">{{ $product->category }}</span></p>
                <p class="mb-2">Price: <span class="font-semibold text-green-600">${{ number_format($product->price, 2) }}</span></p>
                <p class="mb-2">Location: <span class="font-semibold">{{ $product->location }}</span></p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-2 mt-auto">
                @auth
                    <div class="flex gap-2">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="flex-1 bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                Remove
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="w-full bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded text-center">
                        Login to Buy
>>>>>>> 3a17cbb106bf060e85dc82b047fb35459081a18d
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if(auth()->check() && auth()->user()->isAdmin())
        <div class="mb-4 d-flex justify-content-end">
            <a href="{{ route('products.create') }}" class="btn btn-success btn-add-top">
                <i class="fas fa-plus-circle me-2"></i>Add New Product
            </a>
        </div>
    @endif

    <div class="row">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @foreach($products as $product)
            <div class="col-lg-6 mb-4">
                <div class="card product-card">
                    <div class="row g-0">
                        <div class="col-5">
                            <div class="image-container">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="product-image" 
                                         alt="{{ $product->product_name }}">
                                @endif
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <div class="admin-buttons-overlay">
                                            <a href="{{ route('products.edit', $product->id) }}" 
                                               class="btn btn-warning btn-sm btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm btn-action" 
                                                        onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <div class="product-details">
                                    <div class="product-detail">
                                        <i class="fas fa-tag text-primary"></i>
                                        <span>{{ $product->category }}</span>
                                    </div>
                                    <div class="product-detail">
                                        <i class="fas fa-dollar-sign text-success"></i>
                                        <span>${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <div class="product-detail">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                        <span>{{ $product->location }}</span>
                                    </div>
                                </div>

                                @if(!auth()->check() || !auth()->user()->isAdmin())
                                    <div class="mt-3">
                                        @if(auth()->check())
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm w-100 add-to-cart-btn">
                                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-gradient btn-sm w-100 login-purchase-btn">
                                                <i class="fas fa-sign-in-alt me-2"></i>Login to Purchase
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .product-card {
        border: none;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
        border-radius: 8px;
        height: 100%;
        max-width: 350px;
        margin: 0 auto;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.15);
    }

    .image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
        aspect-ratio: 1/1;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .admin-buttons-overlay {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .admin-buttons-overlay {
        opacity: 1;
    }

    .btn-add-top {
        padding: 10px 20px;
        font-weight: 500;
        border-radius: 8px;
        background-color: #2ecc71;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-add-top:hover {
        background-color: #27ae60;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 204, 113, 0.2);
    }

    .card-body {
        padding: 1.25rem;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .product-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .product-detail {
        display: flex;
        align-items: center;
        font-size: 0.95rem;
        color: #555;
    }

    .product-detail i {
        width: 24px;
        margin-right: 8px;
        font-size: 1rem;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
    }

    .btn-warning {
        background-color: #f39c12;
        border: none;
        color: white;
    }

    .btn-warning:hover {
        background-color: #e67e22;
        color: white;
    }

    .btn-danger {
        background-color: #e74c3c;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c0392b;
    }

    @media (max-width: 768px) {
        .image-container {
            height: 180px;
        }
        
        .product-image {
            border-radius: 12px 12px 0 0;
        }
        
        .admin-buttons-overlay {
            opacity: 1;
        }
        
        .product-image {
            height: 280px;
        }
        
        .product-card {
            max-width: 300px;
        }
    }

    .add-to-cart-btn {
        background: linear-gradient(45deg, #2ecc71, #27ae60);
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
    }

    .add-to-cart-btn:hover {
        background: linear-gradient(45deg, #27ae60, #2ecc71);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46, 204, 113, 0.3);
    }

    .login-purchase-btn {
        background: linear-gradient(45deg, #3498db, #2980b9);
        border: none;
        color: white !important;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.2);
    }

    .login-purchase-btn:hover {
        background: linear-gradient(45deg, #2980b9, #3498db);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3);
    }

    .btn i {
        transition: transform 0.3s ease;
    }

    .btn:hover i {
        transform: scale(1.2);
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }

    .add-to-cart-btn:hover,
    .login-purchase-btn:hover {
        animation: pulse 1s infinite;
    }

    .access-denied-alert {
        background: #fff5f5;
        border: 1px solid #ff4757;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        box-shadow: 0 2px 10px rgba(255, 71, 87, 0.1);
    }

    .alert-actions {
        display: flex;
        gap: 12px;
        margin-top: 15px;
    }

    .logout-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #f1f2f6;
        color: #2d3436;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: #e4e5e7;
        transform: translateY(-2px);
    }

    .admin-redirect-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: linear-gradient(45deg, #ff4757, #ff6b6b);
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .admin-redirect-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 71, 87, 0.2);
        color: white;
    }
</style>
@endsection
