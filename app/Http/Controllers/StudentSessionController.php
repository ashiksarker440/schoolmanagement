<?php

namespace App\Http\Controllers;

use App\Models\StudentSession;
use Illuminate\Http\Request;

class StudentSessionController extends Controller
{
    public function index()
    {
        $sessions = StudentSession::latest()->paginate(10);
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:student_sessions,name',
        ]);

        StudentSession::create($validated);

        return redirect()->route('sessions.index')
            ->with('success', 'Session created successfully!');
    }

    public function show(StudentSession $session)
    {
        return view('sessions.show', compact('session'));
    }

    public function edit(StudentSession $session)
    {
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, StudentSession $session)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:student_sessions,name,' . $session->id,
        ]);

        $session->update($validated);

        return redirect()->route('sessions.index')
            ->with('success', 'Session updated successfully!');
    }

    public function destroy(StudentSession $session)
    {
        $session->delete();
        return redirect()->route('sessions.index')
            ->with('success', 'Session deleted successfully!');
    }
}