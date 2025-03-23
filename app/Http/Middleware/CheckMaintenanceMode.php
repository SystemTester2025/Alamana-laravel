<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip middleware if already on maintenance page or admin routes
        if ($request->is('maintenance') || $request->is('maintenance/*') || $request->is('admin') || $request->is('admin/*') || $request->is('login')) {
            return $next($request);
        }
        
        // Check if site is in maintenance mode
        $settings = Setting::first();
        
        if ($settings && $settings->maintenance_mode) {
            return redirect()->route('maintenance');
        }
        
        return $next($request);
    }
} 