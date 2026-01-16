<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
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

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->authorize('update', $service);
        $data = $request->validated();

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

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        if ($service->thumbnail) {
            Storage::disk('public')->delete($service->thumbnail);
        }

        $service->delete();

        return response()->noContent();
    }
    public function index()
{
    $services = Service::where('status', 'approved')->paginate(10);
    return view('buyer.services.index', compact('services'));
}

}

