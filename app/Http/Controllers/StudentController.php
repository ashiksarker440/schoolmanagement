<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentEnrollment;
use App\Models\ClassRoom;
use App\Models\Group;
use App\Models\Section;
use App\Models\StudentSession;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with([
            'enrollment.classRoom',
            'enrollment.section',
            'enrollment.shift',
            'enrollment.group',
            'enrollment.studentSession',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('mother_name', 'like', "%{$search}%")
                    ->orWhere('guardian_name', 'like', "%{$search}%")
                    ->orWhereHas('enrollment', fn($enrollment) => $enrollment
                        ->where('roll_no', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('class_id')) {
            $query->whereHas('enrollment', fn($enrollment) => $enrollment
                ->where('class_id', $request->class_id));
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        $classes = ClassRoom::all();

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = ClassRoom::all();
        $sections = Section::all();
        $studentSessions = StudentSession::all();
        $groups = Group::all();
        $shifts = Shift::all();
        return view('students.create', compact('classes', 'sections', 'studentSessions', 'groups', 'shifts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'class_id' => 'required|exists:classes,id',
            'guardian_name' => 'required|string|max:100',
            'guardian_phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            $student = Student::create($request->all());
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
                $student->update(['photo' => $photoPath]);
            }
            // save student enrollment
            $request['student_id'] = $student->id;
            StudentEnrollment::create($request->all());
        });

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully!');
    }

    public function show(Student $student)
    {
        $student->load([
            'enrollment.classRoom',
            'enrollment.section',
            'enrollment.shift',
            'enrollment.group',
            'enrollment.studentSession',
        ]);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::all();
        $sections = Section::all();
        $studentSessions = StudentSession::all();
        $groups = Group::all();
        $shifts = Shift::all();
        $student->load('enrollment');

        return view('students.edit', compact('student', 'classes', 'sections', 'studentSessions', 'groups', 'shifts'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:1,2,3',
            'religion' => 'required|in:1,2,3,4,5',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'birth_certificate' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'mother_phone' => 'required|string|max:20',
            'father_profession' => 'required|string|max:255',
            'mother_profession' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'student_session_id' => 'required|exists:student_sessions,id',
            'group_id' => 'required|exists:groups,id',
            'shift_id' => 'required|exists:shifts,id',
            'roll_no' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:100',
            'guardian_phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $student) {
            /* upload if photo is present */
            if (request()->hasFile('photo')) {
                $photoPath = request()->file('photo')->store('photos', 'public');
                $student->update(['photo' => $photoPath]);
            }

            $student->update([
                'name' => $validated['name'],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'religion' => $validated['religion'],
                'blood_group' => $validated['blood_group'],
                'birth_certificate' => $validated['birth_certificate'],
                'father_name' => $validated['father_name'],
                'mother_name' => $validated['mother_name'],
                'father_phone' => $validated['father_phone'],
                'mother_phone' => $validated['mother_phone'],
                'father_profession' => $validated['father_profession'],
                'mother_profession' => $validated['mother_profession'],
                'guardian_name' => $validated['guardian_name'],
                'guardian_phone' => $validated['guardian_phone'],
                'address' => $validated['address'] ?? null,
            ]);

            $enrollmentData = [
                'class_id' => $validated['class_id'],
                'section_id' => $validated['section_id'],
                'student_session_id' => $validated['student_session_id'],
                'group_id' => $validated['group_id'],
                'shift_id' => $validated['shift_id'],
                'roll_no' => $validated['roll_no'],
            ];

            $enrollment = $student->enrollment;
            if ($enrollment) {
                $enrollment->update($enrollmentData);
            } else {
                $student->enrollment()->create($enrollmentData);
            }
        });

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->user->delete();
        });

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }
}