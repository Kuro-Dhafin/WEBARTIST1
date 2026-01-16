<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderLog;

class OrderStatusController extends Controller
{
    public function accept(Order $order)
    {
        $this->authorize('accept', $order);

        $order->update(['status' => 'accepted']);

        OrderLog::create([
            'order_id' => $order->id,
            'message' => 'Order accepted by artist',
        ]);

        return response()->noContent();
    }

    public function reject(Order $order)
    {
        $this->authorize('reject', $order);

        $order->update(['status' => 'rejected']);

        OrderLog::create([
            'order_id' => $order->id,
            'message' => 'Order rejected by artist',
        ]);

        return response()->noContent();
    }

    public function complete(Order $order)
    {
        $this->authorize('complete', $order);

        $order->update(['status' => 'completed']);

        OrderLog::create([
            'order_id' => $order->id,
            'message' => 'Order marked completed',
        ]);

        return response()->noContent();
    }
}

