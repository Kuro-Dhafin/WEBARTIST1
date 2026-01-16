<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;

class OrderController extends Controller
{
    public function store(Service $service)
{
    $this->authorize('create', Order::class);

    if ($service->status !== 'approved') {
        abort(403);
    }

    return Order::create([
        'buyer_id' => auth()->id(),
        'service_id' => $service->id,
        'status' => 'pending',
    ]);
}


    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        $order->update(['status' => 'cancelled']);

        return response()->noContent();
    }
}

