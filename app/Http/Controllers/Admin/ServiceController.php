<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // List all services
    // AdminServiceController.php

public function index()
{
    // Previously: $services = Service::all();
    $services = Service::paginate(10); // 10 per page
    return view('admin.services.index', compact('services'));
}


    // Approve or deactivate service
    public function update(Request $request, Service $service)
    {
        $service->update($request->only('status'));

        return redirect()
            ->route('admin.services.index');
    }
    public function approve(Service $service)
{
    $service->update(['status' => 'approved']);
    return redirect()->back()->with('success', 'Service approved.');
}

public function reject(Service $service)
{
    $service->update(['status' => 'rejected']);
    return redirect()->back()->with('success', 'Service rejected.');
}

}
