<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalArtists = User::where('role', 'artist')->count();
        $totalBuyers = User::where('role', 'buyer')->count();

        $totalServices = Service::count();
        $activeServices = Service::where('status', 'active')->count();
        $inactiveServices = Service::where('status', 'inactive')->count();

        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $inProgressOrders = Order::where('status', 'in_progress')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalArtists',
            'totalBuyers',
            'totalServices',
            'activeServices',
            'inactiveServices',
            'totalOrders',
            'pendingOrders',
            'inProgressOrders',
            'completedOrders'
        ));
    }
    public function __construct()
    {
        $this->middleware('role:admin');
    }
}
