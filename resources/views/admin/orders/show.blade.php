@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Order #{{ $order->id }} Details</h1>

    <div class="mb-3">
        <strong>Buyer:</strong> {{ $order->user->name }}<br>
        <strong>Service:</strong> {{ $order->service->title }}<br>
        <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
        <strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
    </div>

    <h4>Order Logs</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Changed By</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ ucfirst($log->status) }}</td>
                <td>{{ $log->user->name ?? 'System' }}</td>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection
