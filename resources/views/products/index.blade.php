<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')
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
                    </a>
                @endauth
            </div>
        </div>
    @endforeach
</div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
