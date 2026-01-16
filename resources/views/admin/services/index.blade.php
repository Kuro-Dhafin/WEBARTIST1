@extends('layouts.app')
@section('title','Moderate Services')
@section('content')
<h2>Service Moderation</h2>
<table class="table table-bordered">
<thead><tr><th>Title</th><th>Artist</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>
@foreach($services as $service)
<tr>
    <td>{{ $service->title }}</td>
    <td>{{ $service->artist?->name ?? 'N/A' }}</td>
    <td>{{ ucfirst($service->status) }}</td>
    <td>
        @if($service->status=='pending')
            <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="d-inline">@csrf<button class="btn btn-success btn-sm">Approve</button></form>
            <form action="{{ route('admin.services.reject', $service) }}" method="POST" class="d-inline">@csrf<button class="btn btn-danger btn-sm">Reject</button></form>
        @else
            <span class="text-muted">No actions</span>
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>
<div class="mt-4">{{ $services->links() }}</div>
@endsection
