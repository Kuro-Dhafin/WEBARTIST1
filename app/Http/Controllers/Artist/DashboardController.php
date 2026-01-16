<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Example: you can pass stats or services later
        return view('artist.dashboard');
    }
}
