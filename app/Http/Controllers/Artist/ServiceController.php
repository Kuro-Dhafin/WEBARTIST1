<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
    // Display all services for the logged-in artist
    public function artistIndex()
    {
        $services = auth()->user()->services()->paginate(10);
        return view('artist.services.index', compact('services'));
    }

    // Show form to create new service
    public function create()
    {
        return view('artist.services.create');
    }

    // Store new service
    public function store(StoreServiceRequest $request)
    {
        $this->authorize('create', Service::class);

        $data = $request->validated();
        $data['artist_id'] = $request->user()->id;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('services', 'public');
        }

        $service = Service::create($data);

        return response()->json($service, 201);
    }

    // Show edit form
    public function edit(Service $service)
    {
        $this->authorize('update', $service);
        return view('artist.services.edit', compact('service'));
    }

    // Update service with warning
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->authorize('update', $service);

        $data = $request->validated();

        // Handle new thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($service->thumbnail) {
                Storage::disk('public')->delete($service->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('services', 'public');
        }

        $service->update($data);

        return response()->json($service);
    }

    // Delete service with warning
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        if ($service->thumbnail && File::exists(public_path( $service->thumbnail))) {
            File::delete(public_path($service->thumbnail));
        }

        $service->delete();

        return response()->noContent();
    }
}
