<!-- resources/views/products/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <form action="/products" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="product_name" placeholder="Product Name" class="border p-2 rounded mb-2">
        <input type="text" name="category" placeholder="Category" class="border p-2 rounded mb-2">
        <input type="text" name="location" placeholder="Location" class="border p-2 rounded mb-2">
        <input type="number" name="price" placeholder="Price" class="border p-2 rounded mb-2">
        <input type="file" name="image" class="mb-2">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Product</button>
    </form>
</div>
@endsection
