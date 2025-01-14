@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Order Tracking</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                {{ $order->user->name }}<br>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>
                            <td>
                                @foreach($order->products as $product)
                                    <div class="mb-1">
                                        {{ $product->product_name }}
                                        <span class="text-muted">(x{{ $product->pivot->quantity }})</span>
                                    </div>
                                @endforeach
                            </td>
                            <td>{{ $order->delivery_location }}</td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_color }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>

<style>
.table {
    font-size: 0.95rem;
}

.badge {
    padding: 8px 12px;
    font-weight: 500;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
    cursor: pointer;
}
</style>
@endsection 