<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::orderBy('id', 'desc')->get();
        return view('backend.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sections,slug',
            'title' => 'required|string|max:255',
            'sub' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
            'key' => 'required|string|max:255|unique:sections',
        ]);

        $data = $request->all();
        
        // Generate slug from name if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $section = Section::create($data);
        
        // Log the section creation activity
        ActivityLogService::logCreated($section, "تم إنشاء قسم جديد: {$section->name}");

        return redirect()->route('sections.index')->with('success', 'تم إنشاء القسم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $section = Section::with('sectionParts')->findOrFail($id);
        return view('backend.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $section = Section::findOrFail($id);
        return view('backend.sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $section = Section::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sections,slug,' . $id,
            'title' => 'required|string|max:255',
            'sub' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
            'key' => 'required|string|max:255|unique:sections,key,' . $id,
        ]);

        $data = $request->all();
        
        // Generate slug from name if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        // Save old attributes for logging
        $oldAttributes = $section->toArray();
        
        $section->update($data);
        
        // Log the section update activity
        ActivityLogService::logUpdated($section, $oldAttributes, "تم تحديث قسم: {$section->name}");

        return redirect()->route('sections.index')->with('success', 'تم تحديث القسم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = Section::findOrFail($id);
        
        // Store section data for logging before deletion
        $sectionData = $section->toArray();
        $sectionName = $section->name;
        
        $section->delete();
        
        // Log the section deletion activity
        ActivityLogService::logDeleted(new Section($sectionData), "تم حذف قسم: {$sectionName}");

        return redirect()->route('sections.index')->with('success', 'تم حذف القسم بنجاح');
    }
}
