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
<div class="flex flex-wrap mt-4 justify-center align-center gap-4">
    @foreach($products as $product)
        <div class="border border-blue-300 shadow-lg p-4 rounded-lg flex-wrap flex-shrink-0">
            <!-- Image Display -->
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-full h-32 object-cover mb-2">
            @else
                <div class="w-full h-32 bg-gray-200 mb-2 flex items-center justify-center text-gray-500">
                    No Image
                </div>
            @endif

            <h2 class="text-xl font-bold mb-2">{{ $product->product_name }}</h2>
            <p class="mb-1">Category: <strong>{{ $product->category }}</strong></p>
            <p class="mb-1">Price: <strong>${{ $product->price }}</strong></p>
            <p class="mb-1">Location: <strong>{{ $product->location }}</strong></p>

            <!-- Edit and Delete Buttons -->
            <div class="flex justify-between mt-2">
                <a href="/products/{{ $product->product_id }}/edit" class="text-blue-500">Edit</a>
                <form action="/products/{{ $product->product_id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
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
