<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::latest()->paginate(10);
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:groups,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        Group::create($validated);
        return redirect()->route('groups.index')->with('success', 'Group created!');
    }

    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:groups,name,' . $group->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $group->update($validated);
        return redirect()->route('groups.index')->with('success', 'Group updated!');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Group deleted!');
    }
}