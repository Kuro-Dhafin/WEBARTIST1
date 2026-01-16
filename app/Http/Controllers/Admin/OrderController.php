<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List all orders
    public function index()
    {
        return view('admin.orders.index', [
            'orders' => Order::with('buyer', 'service')->get(),
        ]);
    }

    public function logs(Order $order)
    {
        return $order->logs;
    }
}
