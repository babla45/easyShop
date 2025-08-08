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

    {{-- Custom pagination with proper positioning --}}
    @if($products->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            {{-- Previous button on left --}}
            <div>
                @if($products->onFirstPage())
                    <span class="btn btn-outline-secondary disabled">Previous</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="btn btn-outline-primary">Previous</a>
                @endif
            </div>

            {{-- Page numbers in center --}}
            <div class="d-flex align-items-center">
                <span class="text-muted me-3">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>
                <ul class="pagination mb-0">
                    @for($page = 1; $page <= $products->lastPage(); $page++)
                        @if($page == $products->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->url($page) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endfor
                </ul>
            </div>

            {{-- Next button on right --}}
            <div>
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="btn btn-outline-primary">Next</a>
                @else
                    <span class="btn btn-outline-secondary disabled">Next</span>
                @endif
            </div>
        </div>
    @endif
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

  /* Pagination styling and positioning */
  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-top: 2rem;
    margin-bottom: 2rem;
  }

  /* Style page links and numbers */
  .pagination .page-link,
  .pagination span:not(.sr-only) {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background-color: white;
    color: #374151;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
  }

  .pagination .page-link:hover,
  .pagination span:not(.sr-only):hover {
    background-color: #f3f4f6;
    border-color: #9ca3af;
    color: #111827;
  }

  .pagination .page-item.active .page-link,
  .pagination span:not(.sr-only).bg-blue-600 {
    background-color: #2563eb;
    border-color: #2563eb;
    color: white;
  }

  .pagination .page-item.disabled .page-link,
  .pagination span:not(.sr-only).bg-gray-100 {
    background-color: #f3f4f6;
    border-color: #d1d5db;
    color: #9ca3af;
    cursor: not-allowed;
  }

  /* Hide navigation arrows - more comprehensive approach */
  .pagination .page-item:first-child,
  .pagination .page-item:last-child,
  .pagination a[rel="prev"],
  .pagination a[rel="next"],
  .pagination li:first-child,
  .pagination li:last-child {
    display: none !important;
  }

  /* Hide navigation arrows using more specific selectors */
  .pagination .page-item:first-child,
  .pagination .page-item:last-child,
  .pagination a[rel="prev"],
  .pagination a[rel="next"],
  .pagination li:first-child,
  .pagination li:last-child,
  .pagination a[aria-label*="previous"],
  .pagination a[aria-label*="Previous"],
  .pagination span[aria-label*="previous"],
  .pagination span[aria-label*="Previous"],
  .pagination a[aria-label*="next"],
  .pagination a[aria-label*="Next"],
  .pagination span[aria-label*="next"],
  .pagination span[aria-label*="Next"] {
    display: none !important;
  }

  /* Hide specific text content by targeting elements with specific text */
  .pagination a:not([href*="page="]),
  .pagination span:not([class*="page-link"]) {
    display: none !important;
  }

  /* Ensure pagination layout is proper */
  .pagination {
    justify-content: center !important;
    flex-wrap: wrap;
  }

  .pagination .page-item {
    margin: 0 2px;
  }
</style>
@endpush
@endsection
