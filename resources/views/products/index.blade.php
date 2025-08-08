<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">


    <!-- Search Form with Dropdown -->
    <form action="{{ route('search') }}" method="GET" class="mb-4 flex items-center justify-center gap-2 w-full">
        <select name="search_by" class="border p-2 rounded">
            <option value="name">Search by Name</option>
            <option value="category">Search by Category</option>
            <option value="location">Search by Location</option>
        </select>
        <input type="text" name="query" placeholder="Enter search term" class="border p-2 rounded flex-1 max-w-2xl">
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
                    <h3 class="text-lg font-semibold mb-2 text-center">{{ $product->product_name }}</h3>
                    <div class="text-sm text-gray-600 mb-1 text-center">Category: {{ $product->category }}</div>
                    <div class="text-sm text-gray-600 mb-1 text-center">Location: {{ $product->location }}</div>
                    <div class="text-lg font-bold text-blue-600 mb-3 text-center">
                        {{ number_format($product->price, 2) }}
                        <span class="text-2xl align-middle">৳</span>
                      </div>


                    <div class="mt-2 text-center">
                        <a href="{{ route('products.show', $product->id) }}" class="inline-block text-blue-600 hover:text-blue-800 font-medium">
                            View details
                        </a>
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
        transition: box-shadow 0.3s ease;
    }

    .product-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .admin-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 71, 87, 0.2);
        color: white;
    }
</style>
@endsection
