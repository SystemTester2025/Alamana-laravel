<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SectionController;
use App\Http\Controllers\Backend\SectionPartController;
use App\Http\Controllers\Backend\ImageController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\ActivityLogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\DynamicStylesController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/css/dynamic-styles.css', [DynamicStylesController::class, 'css'])->name('dynamic.css');

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
    
    // Backup and Restore
    Route::get('backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('backup/reset', [BackupController::class, 'resetSeeder'])->name('backup.reset');
    
    // Activity Logs
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::delete('activity-logs', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');
});

// Auth Routes
require __DIR__.'/auth.php';
