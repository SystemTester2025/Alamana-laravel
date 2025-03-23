<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     * Checks if the site is in maintenance mode and redirects accordingly.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip middleware for these paths - always allow access
        $allowedPaths = [
            'maintenance',
            'maintenance/*',
            'admin',
            'admin/*',
            'login',
            'logout',
            'css/dynamic-styles.css',
            'images/*',
        ];

        // Check if current path is in the allowed paths
        foreach ($allowedPaths as $path) {
            if ($request->is($path)) {
                return $next($request);
            }
        }
        
        // Check if site is in maintenance mode (with 5-minute cache to improve performance)
        $maintenanceMode = Cache::remember('maintenance_mode_status', 300, function () {
            $settings = Setting::first();
            return $settings ? $settings->maintenance_mode : false;
        });
        
        // If in maintenance mode, redirect to maintenance page
        if ($maintenanceMode) {
            return redirect()->route('maintenance');
        }
        
        // If not in maintenance mode and URL is specifically '/maintenance', redirect to home
        if ($request->is('/maintenance')) {
            return redirect('/');
        }
        
        return $next($request);
    }
} 