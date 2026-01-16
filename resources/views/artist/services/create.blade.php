@extends('layouts.app')
@section('title','Add Service')
@section('content')
<h2>Add New Service</h2>

<form action="{{ route('artist.services.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price ($)</label>
        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
    </div>

    <div class="mb-3">
        <label for="pricing_type" class="form-label">Pricing Type</label>
        <select name="pricing_type" id="pricing_type" class="form-select" required>
            <option value="per_panel" @selected(old('pricing_type')=='per_panel')>Per Panel</option>
            <option value="per_second" @selected(old('pricing_type')=='per_second')>Per Second</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail (optional)</label>
        <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-success">Save</button>
</form>
@endsection
