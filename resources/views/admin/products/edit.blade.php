@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1>Edit Product</h1>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                   id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}">
            @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control @error('category') is-invalid @enderror" 
                   id="category" name="category" value="{{ old('category', $product->category) }}">
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                   id="price" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                   id="location" name="location" value="{{ old('location', $product->location) }}">
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if($product->image)
        <div class="mb-3">
            <label class="form-label">Current Image</label>
            <div>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" 
                     style="max-width: 200px; height: auto;">
            </div>
        </div>
        @endif

        <div class="mb-3">
            <label for="image" class="form-label">New Image (optional)</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                   id="image" name="image">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 