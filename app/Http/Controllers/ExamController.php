<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('session')->latest()->paginate(10);
        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        $sessions = StudentSession::orderBy('name')->get();
        return view('exams.create', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'session_id' => 'nullable|exists:student_sessions,id',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'status'     => 'required|in:upcoming,ongoing,completed',
        ]);
        Exam::create($validated);
        return redirect()->route('exams.index')->with('success', 'Exam created!');
    }

    public function show(Exam $exam)
    {
        $exam->load('session', 'examSubjects.subject', 'examSubjects.classRoom');
        return view('exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $sessions = StudentSession::orderBy('name')->get();
        return view('exams.edit', compact('exam', 'sessions'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'session_id' => 'nullable|exists:student_sessions,id',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'status'     => 'required|in:upcoming,ongoing,completed',
        ]);
        $exam->update($validated);
        return redirect()->route('exams.index')->with('success', 'Exam updated!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted!');
    }
}