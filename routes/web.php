<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SectionController;
use App\Http\Controllers\Backend\SectionPartController;
use App\Http\Controllers\Backend\ImageController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Frontend\HomeController;

Route::get('/', [HomeController::class, 'index']);

// Admin Dashboard Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Sections Management
    Route::resource('sections', SectionController::class);
    Route::resource('section-parts', SectionPartController::class);
    
    // Products Management
    Route::resource('products', ProductController::class);
    
    // Media Management
    Route::resource('images', ImageController::class);
    
    // Settings Management
    Route::resource('settings', SettingController::class);
    
    // Contact Management
    Route::resource('contacts', ContactController::class);
});

// Auth Routes
require __DIR__.'/auth.php';
