@extends('layouts.app')
@section('title','Place Order')
@section('content')
<h2>Place Order for: {{ $service->title }}</h2>
<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <input type="hidden" name="service_id" value="{{ $service->id }}">
    <div class="mb-3">
        <label for="notes" class="form-label">Additional Notes</label>
        <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit Order</button>
</form>
@endsection
