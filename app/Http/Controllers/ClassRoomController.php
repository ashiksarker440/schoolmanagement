<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::with('teacher')->latest()->paginate(10);
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = User::role('teacher')->get();
        return view('classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'section' => 'nullable|string|max:10',
            'teacher_id' => 'nullable|exists:users,id',
        ]);
        ClassRoom::create($validated);
        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully!');
    }

    public function show(ClassRoom $class)
    {
        $class->load('teacher', 'students');
        return view('classes.show', compact('class'));
    }

    public function edit(ClassRoom $class)
    {
        $teachers = User::role('teacher')->get();
        return view('classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'section' => 'nullable|string|max:10',
            'teacher_id' => 'nullable|exists:users,id',
        ]);
        $class->update($validated);
        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully!');
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();
        return redirect()->route('classes.index')
            ->with('success', 'Class deleted!');
    }
}