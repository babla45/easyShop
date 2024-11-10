<!-- resources/views/products/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Edit Product</h2>

    <form action="/products/{{ $product->product_id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="product_name" class="block mb-2">Product Name</label>
            <input type="text" id="product_name" name="product_name" class="border p-2 w-full" value="{{ $product->product_name }}" required>
        </div>

        <div class="mb-4">
            <label for="category" class="block mb-2">Category</label>
            <input type="text" id="category" name="category" class="border p-2 w-full" value="{{ $product->category }}" required>
        </div>

        <div class="mb-4">
            <label for="price" class="block mb-2">Price</label>
            <input type="number" id="price" name="price" class="border p-2 w-full" value="{{ $product->price }}" step="0.01" required>
        </div>

        <div class="mb-4">
            <label for="location" class="block mb-2">Location</label>
            <input type="text" id="location" name="location" class="border p-2 w-full" value="{{ $product->location }}" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block mb-2">Product Image</label>
            <input type="file" id="image" name="image" class="border p-2 w-full">
        </div>

        @if ($product->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-32 h-32 object-cover">
                <p class="text-gray-500">Current Image</p>
            </div>
        @endif

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Update Product</button>
        <a href="/products" class="ml-4 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
