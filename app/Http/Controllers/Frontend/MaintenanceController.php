<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Show the maintenance page.
     */
    public function index()
    {
        $settings = Setting::first();
        return view('maintenance.index', compact('settings'));
    }

    /**
     * Preview the maintenance page (for admin use).
     */
    public function preview()
    {
        $settings = Setting::first();
        return view('maintenance.index', compact('settings'));
    }
} 