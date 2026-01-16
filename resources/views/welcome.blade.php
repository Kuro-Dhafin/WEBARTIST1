@extends('layouts.app')

@section('title', 'Explore Services')

@section('content')
<div class="container py-6">

    <h1 class="mb-4">Explore Services</h1>

    {{-- Search form --}}
    <form action="{{ route('home') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title or description...">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    {{-- Service cards --}}
    <div class="row">
        @forelse($services as $service)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($service->thumbnail && file_exists(public_path($service->thumbnail)))
                        <img src="{{ asset($service->thumbnail) }}" class="card-img-top" alt="{{ $service->title }}">
                    @else
                        <div class="bg-secondary text-white text-center py-5">No Image</div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $service->title }}</h5>
                        <p class="card-text text-truncate">{{ $service->description }}</p>
                        <p class="mt-auto"><strong>${{ $service->price }}</strong></p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p>No services found.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $services->withQueryString()->links() }}
    </div>
</div>
@endsection
