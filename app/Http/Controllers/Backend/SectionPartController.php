<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionPart;
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
            $imagePath = $request->file('image')->store('section_parts', 'public');
            $data['image'] = $imagePath;
        }

        SectionPart::create($data);

        return redirect()->route('sections.show', $request->section_id)
            ->with('success', 'تم إضافة محتوى القسم بنجاح');
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
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($sectionPart->image && Storage::disk('public')->exists($sectionPart->image)) {
                Storage::disk('public')->delete($sectionPart->image);
            }
            
            $imagePath = $request->file('image')->store('section_parts', 'public');
            $data['image'] = $imagePath;
        }

        $sectionPart->update($data);

        return redirect()->route('sections.show', $request->section_id)
            ->with('success', 'تم تحديث محتوى القسم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sectionPart = SectionPart::findOrFail($id);
        $sectionId = $sectionPart->section_id;
        
        // Delete image if exists
        if ($sectionPart->image && Storage::disk('public')->exists($sectionPart->image)) {
            Storage::disk('public')->delete($sectionPart->image);
        }
        
        $sectionPart->delete();

        return redirect()->route('sections.show', $sectionId)
            ->with('success', 'تم حذف محتوى القسم بنجاح');
    }
}
