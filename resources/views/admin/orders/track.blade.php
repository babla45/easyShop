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
                            <th>Payment</th>
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
                                <span class="badge equal-badge bg-{{ $order->status === 'pending' ? 'warning' :
                                    ($order->status === 'processing' ? 'info' :
                                    ($order->status === 'completed' ? 'success' : 'danger')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge equal-badge bg-{{ $order->payment_method === 'cod' ? 'secondary' : 'primary' }}">
                                    {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Card' }}
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

.equal-badge{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 90px; /* same width for status and payment */
    white-space: nowrap;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
    cursor: pointer;
}

/* Hide pagination arrows */
.pagination svg {
    display: none;
}

/* Style pagination numbers */
.pagination span {
    padding: 8px 12px;
    margin: 0 4px;
    border-radius: 4px;
}

.pagination .active {
    background-color: #007bff;
    color: white;
}
</style>
@endsection
