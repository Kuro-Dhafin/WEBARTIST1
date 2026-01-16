@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row g-4">

        <!-- Users Metrics -->
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Users</h5>
                <p>{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Artists</h5>
                <p>{{ $totalArtists }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Buyers</h5>
                <p>{{ $totalBuyers }}</p>
            </div>
        </div>

        <!-- Services Metrics -->
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Services</h5>
                <p>{{ $totalServices }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Active Services</h5>
                <p>{{ $activeServices }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Inactive Services</h5>
                <p>{{ $inactiveServices }}</p>
            </div>
        </div>

        <!-- Orders Metrics -->
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Total Orders</h5>
                <p>{{ $totalOrders }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Pending Orders</h5>
                <p>{{ $pendingOrders }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5>In Progress Orders</h5>
                <p>{{ $inProgressOrders }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Completed Orders</h5>
                <p>{{ $completedOrders }}</p>
            </div>
        </div>

    </div>
</div>
@endsection
