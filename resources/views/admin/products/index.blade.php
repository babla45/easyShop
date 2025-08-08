@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New Product</a>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success mb-4">
            {{ session()->pull('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-products">
            <colgroup>
                <col class="col-id">
                <col class="col-image">
                <col class="col-name">
                <col class="col-category">
                <col class="col-price">
                <col class="col-location">
                <col class="col-actions">
            </colgroup>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->location }}</td>
                                        <td class="text-nowrap">
                        <div class="d-inline-flex align-items-center gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning" style="width: 60px;">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="width: 60px;" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $products->links() }}
</div>
@push('styles')
<style>
  /* Make table use available width smartly without horizontal scroll */
  .table-products { table-layout: auto; width: 100%; }
  .table-products .col-id { width: 5%; }
  .table-products .col-image { width: 8%; }
  .table-products .col-category { width: 12%; }
  .table-products .col-price { width: 12%; }
  .table-products .col-location { width: 13%; }
  .table-products .col-actions { width: 12%; }
  .table-products .col-name { width: auto; }

  /* Truncate long text in name column while letting it flex */
  .table-products td:nth-child(3) { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  /* Keep numbers and action buttons on one line */
  .table-products td:nth-child(5),
  .table-products td:nth-child(7) { white-space: nowrap; }
</style>
@endpush
@endsection
