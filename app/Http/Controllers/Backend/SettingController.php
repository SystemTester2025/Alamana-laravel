<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display the settings page with settings data.
     */
    public function index()
    {
        $setting = Setting::first();
        
        // If no settings exist yet, create a default one
        if (!$setting) {
            $setting = Setting::create([
                'title' => 'الأمانة للاستيراد والتصدير',
                'description' => 'شركة متخصصة في استيراد وتصدير المنتجات الزراعية',
            ]);
        }
        
        return view('backend.settings.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for settings
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Not needed for settings
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not needed for settings
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = Setting::findOrFail($id);
        return view('backend.settings.index', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'facebook' => 'nullable|string|url',
            'twitter' => 'nullable|string|url',
            'instagram' => 'nullable|string|url',
            'linkedin' => 'nullable|string|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $setting = Setting::findOrFail($id);
        
        // Save old attributes for logging
        $oldAttributes = $setting->toArray();

        // Update basic fields
        $setting->title = $validated['title'];
        $setting->description = $validated['description'] ?? null;
        $setting->email = $validated['email'] ?? null;
        $setting->phone = $validated['phone'] ?? null;
        $setting->address = $validated['address'] ?? null;
        $setting->facebook = $validated['facebook'] ?? null;
        $setting->twitter = $validated['twitter'] ?? null;
        $setting->instagram = $validated['instagram'] ?? null;
        $setting->linkedin = $validated['linkedin'] ?? null;
        
        // Explicitly check for the checkbox values
        $setting->show_falling_leaves = $request->has('show_falling_leaves') ? true : false;
        
        // Update maintenance mode and clear cache
        $maintenance_mode_changed = $setting->maintenance_mode != ($request->has('maintenance_mode') ? true : false);
        $setting->maintenance_mode = $request->has('maintenance_mode') ? true : false;

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old logo if exists
            if ($setting->favicon && file_exists(public_path($setting->favicon))) {
                unlink(public_path($setting->favicon));
            }
            $imagePath = 'images/logo';
            $imageName = time() . '_' . rand(1000, 9999) . '_' . $request->file('favicon')->getClientOriginalName();
            $request->file('favicon')->move(public_path($imagePath), $imageName);
            $setting->favicon = $imagePath . '/' . $imageName;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($setting->logo && file_exists(public_path($setting->logo))) {
                unlink(public_path($setting->logo));
            }
            $imagePath = 'images/logo';
            $imageName = time() . '_' . rand(1000, 9999) . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path($imagePath), $imageName);
            $setting->logo = $imagePath . '/' . $imageName;
        }
        //Handle a footer icon upload
        if ($request->hasFile('footer_logo')) {
            // Delete old logo if exists
            if ($setting->footer_logo && file_exists(public_path($setting->footer_logo))) {
                unlink(public_path($setting->footer_logo));
            }
            $imagePath = 'images/logo';
            $imageName = time() . '_' . rand(1000, 9999) . '_' . $request->file('footer_logo')->getClientOriginalName();
            $request->file('footer_logo')->move(public_path($imagePath), $imageName);
            $setting->footer_logo = $imagePath . '/' . $imageName;
        }

        $setting->save();
        
        // Clear maintenance mode cache if it changed
        if ($maintenance_mode_changed) {
            Cache::forget('maintenance_mode_status');
        }
        
        // Log the settings update activity
        ActivityLogService::logUpdated($setting, $oldAttributes, "تم تحديث إعدادات الموقع");

        return redirect()->route('settings.index')->with('success', 'تم تحديث الإعدادات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Not needed for settings
    }
}
