<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

/**
 * Service provider responsible for managing frontend components and views
 */
class FrontendServiceProvider extends ServiceProvider
{
    /**
     * Register any application services related to the frontend
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services related to the frontend
     * Share settings with all frontend views
     */
    public function boot()
    {
        // Share settings with all frontend views
        View::composer('frontend.*', function ($view) {
            // Cache settings to avoid database query on every request
            $settings = Cache::remember('site_settings', 60 * 24, function () {
                return Setting::first();
            });
            
            $view->with([
                'settings' => $settings,
                'appName' => $settings ? $settings->title : 'الأمانة للاستيراد والتصدير'
            ]);
        });
    }
} 