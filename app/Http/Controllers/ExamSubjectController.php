<?php

namespace App\Http\Controllers;

use App\Models\ExamSubject;
use App\Models\Exam;
use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamSubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = ExamSubject::with(['exam', 'classRoom', 'subject']);

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $examSubjects = $query->latest()->paginate(15)->withQueryString();
        $exams        = Exam::orderBy('name')->get();
        $classes      = ClassRoom::orderBy('name')->get();

        return view('exam_subjects.index', compact('examSubjects', 'exams', 'classes'));
    }

    public function create()
    {
        $exams    = Exam::orderBy('name')->get();
        $classes  = ClassRoom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('exam_subjects.create', compact('exams', 'classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id'           => 'required|exists:exams,id',
            'class_id'          => 'required|exists:classes,id',
            'selected_subjects' => 'required|array|min:1',
        ]);

        $examId     = $validated['exam_id'];
        $classId    = $validated['class_id'];
        $subjectIds = $validated['selected_subjects'];

        $createdCount = 0;

        foreach ($subjectIds as $subjectId) {
            // ডুপ্লিকেট চেক
            $exists = ExamSubject::where('exam_id', $examId)
                ->where('class_id', $classId)
                ->where('subject_id', $subjectId)
                ->exists();

            if (!$exists) {
                ExamSubject::create([
                    'exam_id'    => $examId,
                    'class_id'   => $classId,
                    'subject_id' => $subjectId,
                    'full_marks' => $request->input("full_marks.$subjectId", 100),
                    'pass_marks' => $request->input("pass_marks.$subjectId", 33),
                    'exam_date'  => $request->input("exam_date.$subjectId"),
                ]);
                $createdCount++;
            }
        }

        return redirect()->route('exam-subjects.index')
            ->with('success', $createdCount . ' exam subject(s) created successfully!');
    }

    public function show(ExamSubject $examSubject)
    {
        $examSubject->load('exam', 'classRoom', 'subject');
        return view('exam_subjects.show', compact('examSubject'));
    }

    public function edit(ExamSubject $examSubject)
    {
        $exams    = Exam::orderBy('name')->get();
        $classes  = ClassRoom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('exam_subjects.edit', compact('examSubject', 'exams', 'classes', 'subjects'));
    }

    public function update(Request $request, ExamSubject $examSubject)
    {
        $validated = $request->validate([
            'exam_id'    => 'required|exists:exams,id',
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'full_marks' => 'required|numeric|min:1',
            'pass_marks' => 'required|numeric|min:0|lt:full_marks',
            'exam_date'  => 'nullable|date',
        ]);
        $examSubject->update($validated);
        return redirect()->route('exam-subjects.index')->with('success', 'Exam subject updated!');
    }

    public function destroy(ExamSubject $examSubject)
    {
        $examSubject->delete();
        return redirect()->route('exam-subjects.index')->with('success', 'Exam subject deleted!');
    }
}