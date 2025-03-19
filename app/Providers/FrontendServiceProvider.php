<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
     */
    public function boot()
    {
        // Share common data with all frontend views
        View::composer('frontend.*', function ($view) {
            // Can share data that should be available in all frontend views
            $view->with('appName', 'الأمانة للاستيراد والتصدير');
        });
    }
} 