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
use App\Http\Controllers\Frontend\MaintenanceController;
use App\Http\Middleware\CheckMaintenanceMode;

// Routes that bypass maintenance mode check
Route::get('/css/dynamic-styles.css', [DynamicStylesController::class, 'css'])->name('dynamic.css');
Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance');
Route::get('/maintenance/preview', [MaintenanceController::class, 'preview'])->name('maintenance.preview');

// All frontend routes that should be affected by maintenance mode
Route::middleware([CheckMaintenanceMode::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Add all other frontend routes that should be affected by maintenance mode here
});

// Admin Dashboard Routes (always accessible)
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
    
    // Contact and Email Management
    Route::resource('contacts', ContactController::class);
    Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::post('contacts/{contact}/toggle-read', [ContactController::class, 'toggleRead'])->name('contacts.toggle-read');
    Route::post('contacts/{contact}/trash', [ContactController::class, 'trash'])->name('contacts.trash');
    Route::post('contacts/{contact}/restore', [ContactController::class, 'restore'])->name('contacts.restore');
    Route::post('contacts/empty-trash', [ContactController::class, 'emptyTrash'])->name('contacts.empty-trash');
    
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
