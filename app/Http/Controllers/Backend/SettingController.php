<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // Not needed for settings
    }

    /**
     * Update the settings in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg|max:1024',
        ]);
        
        $setting = Setting::findOrFail($id);
        
        // Handle file uploads
        $data = $request->except(['logo', 'footer_logo', 'favicon']);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            
            $logoPath = $request->file('logo')->store('settings', 'public');
            $data['logo'] = $logoPath;
        }
        
        // Handle footer logo upload
        if ($request->hasFile('footer_logo')) {
            // Delete old footer logo if exists
            if ($setting->footer_logo && Storage::disk('public')->exists($setting->footer_logo)) {
                Storage::disk('public')->delete($setting->footer_logo);
            }
            
            $footerLogoPath = $request->file('footer_logo')->store('settings', 'public');
            $data['footer_logo'] = $footerLogoPath;
        }
        
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            $data['favicon'] = $faviconPath;
        }
        
        $setting->update($data);
        
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
