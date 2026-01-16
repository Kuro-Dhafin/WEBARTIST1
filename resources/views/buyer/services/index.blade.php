@extends('layouts.app')
@section('title','Browse Services')
@section('content')
<h2>Available Services</h2>
<div class="row">
@foreach($services as $service)
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $service->title }}</h5>
                <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                <p class="text-muted">By: {{ $service->user->name }}</p>
                <p class="fw-bold">${{ $service->price }}</p>
                <a href="{{ route('orders.create', $service) }}" class="btn btn-primary">Order</a>
            </div>
        </div>
    </div>
@endforeach
</div>
<div class="mt-4">{{ $services->links() }}</div>
@endsection
