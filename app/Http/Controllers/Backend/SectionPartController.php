<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionPart;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionPartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sectionParts = SectionPart::with('section')->orderBy('section_id')->orderBy('sort_order')->get();
        return view('backend.section-parts.index', compact('sectionParts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        $selectedSectionId = request('section_id');
        return view('backend.section-parts.create', compact('sections', 'selectedSectionId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'key' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('section-parts', 'public');
        }
        
        $sectionPart = SectionPart::create($data);
        
        // Log the section part creation activity
        $section = Section::find($request->section_id);
        $sectionName = $section ? $section->name : 'غير معروف';
        ActivityLogService::logCreated($sectionPart, "تم إنشاء عنصر جديد في قسم {$sectionName}: {$sectionPart->title}");

        return redirect()->route('section-parts.index')->with('success', 'تم إنشاء عنصر القسم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sectionPart = SectionPart::with('section')->findOrFail($id);
        return view('backend.section-parts.show', compact('sectionPart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sectionPart = SectionPart::findOrFail($id);
        $sections = Section::all();
        return view('backend.section-parts.edit', compact('sectionPart', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sectionPart = SectionPart::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'sub' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'key' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->except('image');
        
        // Save old attributes for logging
        $oldAttributes = $sectionPart->toArray();
        $oldSectionId = $sectionPart->section_id;
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($sectionPart->image && Storage::disk('public')->exists($sectionPart->image)) {
                Storage::disk('public')->delete($sectionPart->image);
            }
            
            $data['image'] = $request->file('image')->store('section-parts', 'public');
        }
        
        $sectionPart->update($data);
        
        // Log the section part update activity
        $section = Section::find($request->section_id);
        $sectionName = $section ? $section->name : 'غير معروف';
        
        // Check if section changed
        $sectionChanged = $oldSectionId != $request->section_id;
        if ($sectionChanged) {
            $oldSection = Section::find($oldSectionId);
            $oldSectionName = $oldSection ? $oldSection->name : 'غير معروف';
            $message = "تم نقل عنصر \"{$sectionPart->title}\" من قسم {$oldSectionName} إلى قسم {$sectionName}";
        } else {
            $message = "تم تحديث عنصر في قسم {$sectionName}: {$sectionPart->title}";
        }
        
        ActivityLogService::logUpdated($sectionPart, $oldAttributes, $message);

        return redirect()->route('section-parts.index')->with('success', 'تم تحديث عنصر القسم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sectionPart = SectionPart::findOrFail($id);
        
        // Store data for logging before deletion
        $sectionPartData = $sectionPart->toArray();
        $sectionPartTitle = $sectionPart->title;
        $section = Section::find($sectionPart->section_id);
        $sectionName = $section ? $section->name : 'غير معروف';
        
        // Delete image if exists
        if ($sectionPart->image && Storage::disk('public')->exists($sectionPart->image)) {
            Storage::disk('public')->delete($sectionPart->image);
        }
        
        $sectionPart->delete();
        
        // Log the section part deletion activity
        ActivityLogService::logDeleted(new SectionPart($sectionPartData), "تم حذف عنصر \"{$sectionPartTitle}\" من قسم {$sectionName}");

        return redirect()->route('section-parts.index')->with('success', 'تم حذف عنصر القسم بنجاح');
    }
}
