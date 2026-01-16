@extends('layouts.app')
@section('title','Edit Service')
@section('content')

<h2>Edit Service</h2>

<form action="{{ route('artist.services.update', $service) }}" method="POST" enctype="multipart/form-data"
      onsubmit="return confirm('⚠ Are you sure you want to save changes to this service?');">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" 
               value="{{ old('title', $service->title) }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" required>{{ old('description', $service->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price ($)</label>
        <input type="number" name="price" id="price" class="form-control" 
               value="{{ old('price', $service->price) }}" required>
    </div>

    <div class="mb-3">
        <label for="pricing_type" class="form-label">Pricing Type</label>
        <select name="pricing_type" id="pricing_type" class="form-select" required>
            <option value="per_panel" @selected($service->pricing_type=='per_panel')>Per Panel</option>
            <option value="per_second" @selected($service->pricing_type=='per_second')>Per Second</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail</label>
        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
        @if($service->thumbnail)
            <img src="{{ asset('storage/' . $service->thumbnail) }}" alt="Thumbnail" class="img-fluid mt-2" width="150">
        @endif
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>

@endsection
