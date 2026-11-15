<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::latest()->paginate(10);
        return view('designations.index', compact('designations'));
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:designations,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        Designation::create($validated);
        return redirect()->route('designations.index')->with('success', 'Designation created!');
    }

    public function show(Designation $designation)
    {
        return view('designations.show', compact('designation'));
    }

    public function edit(Designation $designation)
    {
        return view('designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:designations,name,' . $designation->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $designation->update($validated);
        return redirect()->route('designations.index')->with('success', 'Designation updated!');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Designation deleted!');
    }
}