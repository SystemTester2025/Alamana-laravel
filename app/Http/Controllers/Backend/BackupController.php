<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackupController extends Controller
{
    /**
     * Display a listing of the seeders and tables
     */
    public function index()
    {
        // Get all available seeders
        $seeders = [
            'images' => [
                'class' => 'ImageSeeder',
                'table' => 'images',
                'description' => 'إعادة تعيين جميع بيانات الصور'
            ],
            'sections' => [
                'class' => 'SectionSeeder',
                'table' => 'sections',
                'description' => 'إعادة تعيين جميع بيانات الأقسام'
            ],
            'section_parts' => [
                'class' => 'SectionPartSeeder',
                'table' => 'section_parts',
                'description' => 'إعادة تعيين جميع بيانات أجزاء الأقسام'
            ],
            'products' => [
                'class' => 'ProductSeeder',
                'table' => 'products',
                'description' => 'إعادة تعيين جميع بيانات المنتجات'
            ],
            'settings' => [
                'class' => 'SettingSeeder',
                'table' => 'settings',
                'description' => 'إعادة تعيين جميع بيانات الإعدادات'
            ]
        ];
        
        return view('backend.backup.index', compact('seeders'));
    }
    
    /**
     * Reset a specific seeder
     */
    public function resetSeeder(Request $request)
    {
        $seederClass = $request->input('seeder');
        $table = $request->input('table');
        
        if (!$seederClass || !$table) {
            return redirect()->route('backup.index')->with('error', 'يرجى تحديد المحتوى المراد إعادة تعيينه');
        }
        
        try {
            if ($table === 'all') {
                // Handle resetting all tables
                Artisan::call('migrate:fresh', [
                    '--seed' => true
                ]);
                
                return redirect()->route('backup.index')->with('success', "تم إعادة تعيين جميع البيانات بنجاح");
            } else {
                // Truncate the table first
                Schema::disableForeignKeyConstraints();
                DB::table($table)->truncate();
                Schema::enableForeignKeyConstraints();
                
                // Run the seeder
                Artisan::call('db:seed', [
                    '--class' => "Database\\Seeders\\{$seederClass}"
                ]);
                
                return redirect()->route('backup.index')->with('success', "تم إعادة تعيين {$table} بنجاح");
            }
        } catch (\Exception $e) {
            return redirect()->route('backup.index')->with('error', 'حدث خطأ أثناء إعادة التعيين: ' . $e->getMessage());
        }
    }
} 