<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $markTypes = Subject::markTypes();
        return view('subjects.create', compact('markTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'nullable|string|max:20|unique:subjects,subject_id',
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:subjects,code',
            'mark_type' => 'required',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Subject::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject created!');
    }

    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $markTypes = Subject::markTypes();
        return view('subjects.edit', compact('subject', 'markTypes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_id' => 'nullable|string|max:20|unique:subjects,subject_id,' . $subject->id,
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:subjects,code,' . $subject->id,
            'mark_type' => 'required',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject updated!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted!');
    }
}