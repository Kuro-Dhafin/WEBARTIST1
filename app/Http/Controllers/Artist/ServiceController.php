<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'pricing_type' => 'required|string|in:per_panel,per_second',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/services'), $filename);
            $thumbnailPath = 'uploads/services/' . $filename;
        }

        Service::create([
            'artist_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'pricing_type' => $request->pricing_type,
            'thumbnail' => $thumbnailPath,
            'status' => 'pending',
        ]);

        return redirect()->route('artist.services.index')
                         ->with('success', 'Service created successfully.');
    }

    // Show edit form
    public function edit(Service $service)
    {
        $this->authorize('update', $service);
        return view('artist.services.edit', compact('service'));
    }

    // Update service with warning
    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'pricing_type' => 'required|string|in:per_panel,per_second',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        // Handle new thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($service->thumbnail && File::exists(public_path($service->thumbnail))) {
                File::delete(public_path($service->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/services'), $filename);
            $service->thumbnail = 'uploads/services/' . $filename;
        }

        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'pricing_type' => $request->pricing_type,
            'thumbnail' => $service->thumbnail,
        ]);

        return redirect()->route('artist.services.index')
                         ->with('success', '⚠ Service updated successfully. Check changes carefully.');
    }

    // Delete service with warning
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        if ($service->thumbnail && File::exists(public_path($service->thumbnail))) {
            File::delete(public_path($service->thumbnail));
        }

        $service->delete();

        return redirect()->route('artist.services.index')
                         ->with('success', '⚠ Service deleted successfully. This action cannot be undone.');
    }
}
