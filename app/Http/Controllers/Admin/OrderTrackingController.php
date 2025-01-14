<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'products'])
                      ->latest()
                      ->paginate(10);
                      
        return view('admin.orders.track', compact('orders'));
    }
}