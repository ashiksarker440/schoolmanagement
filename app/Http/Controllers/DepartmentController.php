<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:departments,name',
            'code' => 'nullable|string|max:20|unique:departments,code',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        Department::create($validated);
        return redirect()->route('departments.index')->with('success', 'Department created!');
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:departments,name,' . $department->id,
            'code' => 'nullable|string|max:20|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $department->update($validated);
        return redirect()->route('departments.index')->with('success', 'Department updated!');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted!');
    }
}