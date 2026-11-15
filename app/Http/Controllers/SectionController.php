<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Section::with('classRoom');

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $sections = $query->latest()->paginate(10)->withQueryString();
        $classes  = ClassRoom::all();
        return view('sections.index', compact('sections', 'classes'));
    }

    public function create()
    {
        $classes = ClassRoom::all();
        return view('sections.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:10',
            'class_id'  => 'required|exists:classes,id',
            'capacity'  => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // same class + name already exists check
        $exists = Section::where('class_id', $validated['class_id'])
                         ->where('name', $validated['name'])
                         ->exists();
        if ($exists) {
            return back()->withErrors(['name' => 'This section already exists in this class.'])
                         ->withInput();
        }

        Section::create($validated);
        return redirect()->route('sections.index')->with('success', 'Section created!');
    }

    public function show(Section $section)
    {
        $section->load('classRoom', 'students');
        return view('sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        $classes = ClassRoom::all();
        return view('sections.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:10',
            'class_id'  => 'required|exists:classes,id',
            'capacity'  => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $section->update($validated);
        return redirect()->route('sections.index')->with('success', 'Section updated!');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section deleted!');
    }
}