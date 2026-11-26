<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Result::with(['enrollment.student', 'examSubject.exam', 'examSubject.subject']);

        if ($request->filled('exam_id')) {
            $query->whereHas('examSubject', fn($q) => $q->where('exam_id', $request->exam_id));
        }

        $results = $query->latest()->paginate(20)->withQueryString();
        $exams   = Exam::orderBy('name')->get();

        return view('results.index', compact('results', 'exams'));
    }

    public function create()
    {
        $enrollments  = StudentEnrollment::with('student')->get();
        $examSubjects = ExamSubject::with(['exam', 'subject', 'classRoom'])->get();
        return view('results.create', compact('enrollments', 'examSubjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id'   => 'required|exists:student_enrollments,id',
            'exam_subject_id' => 'required|exists:exam_subjects,id',
            'obtained_marks'  => 'required|numeric|min:0',
            'status'          => 'required|in:pass,fail,absent',
        ]);

        $exists = Result::where('enrollment_id', $validated['enrollment_id'])
            ->where('exam_subject_id', $validated['exam_subject_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['enrollment_id' => 'এই student-এর এই subject-এ result আগেই আছে।'])->withInput();
        }

        Result::create($validated);
        return redirect()->route('results.index')->with('success', 'Result created!');
    }

    public function show(Result $result)
    {
        $result->load([
            'enrollment.student',
            'enrollment.classRoom',
            'enrollment.section',
            'enrollment.studentSession',
            'examSubject.exam.session',
            'examSubject.subject',
        ]);

        $examId = $result->examSubject->exam_id;
        $examResults = Result::with(['examSubject.subject'])
            ->where('enrollment_id', $result->enrollment_id)
            ->whereHas('examSubject', fn ($query) => $query->where('exam_id', $examId))
            ->get();

        return view('results.show', compact('result', 'examResults'));
    }

    public function edit(Result $result)
    {
        $enrollments  = StudentEnrollment::with('student')->get();
        $examSubjects = ExamSubject::with(['exam', 'subject', 'classRoom'])->get();
        return view('results.edit', compact('result', 'enrollments', 'examSubjects'));
    }

    public function update(Request $request, Result $result)
    {
        $validated = $request->validate([
            'enrollment_id'   => 'required|exists:student_enrollments,id',
            'exam_subject_id' => 'required|exists:exam_subjects,id',
            'obtained_marks'  => 'required|numeric|min:0',
            'status'          => 'required|in:pass,fail,absent',
        ]);

        $result->update($validated);
        return redirect()->route('results.index')->with('success', 'Result updated!');
    }

    public function destroy(Result $result)
    {
        $result->delete();
        return redirect()->route('results.index')->with('success', 'Result deleted!');
    }
}