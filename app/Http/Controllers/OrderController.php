<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Service;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, Service $service)
    {
        $order = Order::create([
            'buyer_id' => $request->user()->id,
            'service_id' => $service->id,
            'status' => 'pending',
            'total_price' => $service->price,
        ]);

        OrderLog::create([
            'order_id' => $order->id,
            'message' => 'Order placed',
        ]);

        return response()->json($order, 201);
    }

    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        $order->update(['status' => 'cancelled']);

        OrderLog::create([
            'order_id' => $order->id,
            'message' => 'Order cancelled by buyer',
        ]);

        return response()->noContent();
    }
}


