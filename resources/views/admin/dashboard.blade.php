@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="space-y-4">
                <a href="{{ route('admin.products.create') }}" class="block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Add New Product
                </a>
                <a href="{{ route('admin.orders.track') }}" class="block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Track Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 