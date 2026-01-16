@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin: All Orders</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Buyer</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->buyer->name }}</td>
                        <td>{{ $order->service->title }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->total_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection