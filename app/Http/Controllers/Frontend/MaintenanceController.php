<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Show the maintenance page.
     * This page is directly accessed by the middleware when maintenance mode is on.
     */
    public function index()
    {
        $settings = Setting::first();
        return view('maintenance.index', compact('settings'));
    }

    /**
     * Preview the maintenance page (for admin use).
     * This allows admins to see the maintenance page without activating maintenance mode.
     */
    public function preview()
    {
        $settings = Setting::first();
        return view('maintenance.index', compact('settings'));
    }
} 