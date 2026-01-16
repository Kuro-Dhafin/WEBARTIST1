@extends('layouts.app')
@section('title','My Services')
@section('content')

<h2>My Services</h2>
<a href="{{ route('artist.services.create') }}" class="btn btn-primary mb-3">Add New Service</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Thumbnail</th>
            <th>Title</th>
            <th>Status</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($services as $service)
        <tr>
            <td>
                @if($service->thumbnail)
                    <img src="{{ asset('storage/' . $service->thumbnail) }}" alt="Thumbnail" class="img-fluid" style="max-width: 100px;">
                @else
                    N/A
                @endif
            </td>
            <td>{{ $service->title }}</td>
            <td>{{ ucfirst($service->status) }}</td>
            <td>${{ $service->price }}</td>
            <td>
                <a href="{{ route('artist.services.edit', $service) }}" class="btn btn-sm btn-warning"
                   onclick="return confirm('⚠ Are you sure you want to edit this service?');">Edit</a>

                <form action="{{ route('artist.services.destroy', $service) }}" method="POST" style="display:inline-block;"
                      onsubmit="return confirm('⚠ Are you sure you want to delete this service? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">{{ $services->links() }}</div>

@endsection
