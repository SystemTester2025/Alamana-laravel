<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DynamicStylesController extends Controller
{
    /**
     * Generate a dynamic CSS file with settings-based styles
     * 
     * @return \Illuminate\Http\Response
     */
    public function css()
    {
        try {
            // Clear any cached settings first
            Cache::forget('site_settings');
            
            // Get settings directly from database
            $settings = Setting::first();
            
            // Get the logo path from settings
            $logoPath = 'images/logo/logo.svg'; // Default fallback path
            
            if ($settings && $settings->logo) {
                // Force refresh by creating a new reference to the logo path
                $logoPath = $settings->logo . '?' . time();
                
                // Check if the file exists
                if (!file_exists(public_path($settings->logo))) {
                    // Log the issue but continue with default
                    Log::warning("Logo file not found: {$settings->logo}, using default");
                    $logoPath = 'images/logo/logo.svg';
                }
            }
            
            // Create CSS content
            $css = view('frontend.css.dynamic', compact('settings', 'logoPath'))->render();
            
            // Return as CSS content type with no-cache headers
            return response($css)
                ->header('Content-Type', 'text/css')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error generating dynamic CSS: " . $e->getMessage());
            
            // Return a minimal CSS that won't break the site
            $fallbackCss = "/* Fallback CSS due to error */\n";
            $fallbackCss .= ".navbar.fixed-navbar::before { display: none; }\n";
            
            return response($fallbackCss)
                ->header('Content-Type', 'text/css')
                ->header('Cache-Control', 'no-cache');
        }
    }
} 