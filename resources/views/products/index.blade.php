<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form with Dropdown -->
    <form action="{{ route('search') }}" method="GET" class="mb-4 flex items-center gap-2">
        <select name="search_by" class="border p-2 rounded">
            <option value="name">Search by Name</option>
            <option value="category">Search by Category</option>
            <option value="location">Search by Location</option>
        </select>
        <input type="text" name="query" placeholder="Enter search term" class="border p-2 rounded w-1/2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
    </form>

    <!-- Products Display -->
    <div class="products-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden product-card">
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center p-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->product_name }}"
                             class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $product->product_name }}</h3>
                    <div class="text-sm text-gray-600 mb-1">Category: {{ $product->category }}</div>
                    <div class="text-sm text-gray-600 mb-1">Location: {{ $product->location }}</div>
                    <div class="text-lg font-bold text-blue-600 mb-3">${{ number_format($product->price, 2) }}</div>

                    <div class="flex gap-2">
                        @auth
                            @if(!auth()->user()->isAdmin())
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif
                        @else
                            {{-- <a href="{{ route('login') }}" class="w-full bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded text-center transition duration-200">
                                Login to Buy
                            </a> --}}
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>

<style>
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .admin-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 71, 87, 0.2);
        color: white;
    }


</style>
@endsection
