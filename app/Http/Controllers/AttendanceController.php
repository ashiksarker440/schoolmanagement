<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Get all enrollments (used by Edit page)
    private function getEnrollments()
    {
        return StudentEnrollment::with([
            'student',
            'classRoom',
            'section'
        ])->get();
    }

    // CREATE
    public function create()
    {
        // Get available classes from student enrollments
        $classes = StudentEnrollment::with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->filter()
            ->unique('id')
            ->values();

        return view('attendances.create', compact('classes'));
    }

    // Get sections according to selected class
    public function getSections($classId)
    {
        $sections = StudentEnrollment::with('section')
            ->where('class_id', $classId)
            ->get()
            ->pluck('section')
            ->filter()
            ->unique('id')
            ->values()
            ->map(function ($section) {
                return [
                    'id' => $section->id,
                    'name' => $section->name,
                ];
            });

        return response()->json($sections);
    }

    // Get students according to selected class and section
    public function getStudents(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
        ]);

        $students = StudentEnrollment::with('student')
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->get()
            ->map(function ($enrollment) {
                return [
                    'enrollment_id' => $enrollment->id,
                    'name' => $enrollment->student->name ?? 'Unknown',
                    'roll_no' => $enrollment->roll_no,
                ];
            });

        return response()->json($students);
    }

    // INDEX
    public function index(Request $request)
    {
        $query = Attendance::with([
            'enrollment.student',
            'enrollment.classRoom',
            'enrollment.section',
            'markedBy',
            'updatedBy'
        ]);

        if ($request->filled('attendance_date')) {
            $query->whereDate(
                'attendance_date',
                $request->attendance_date
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query
            ->latest('attendance_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('attendances.index', compact('attendances'));
    }

    // STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => [
                'required',
                'exists:student_enrollments,id'
            ],
            'attendance_date' => 'required|date',
            'status' => 'required|in:0,1,2',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $exists = Attendance::where(
            'enrollment_id',
            $validated['enrollment_id']
        )->whereDate(
                'attendance_date',
                $validated['attendance_date']
            )->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'enrollment_id' =>
                        'Attendance already exists for this student on this date.'
                ]);
        }

        $validated['marked_by'] = auth()->id();

        Attendance::create($validated);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Attendance created successfully.');
    }

    // SHOW
    public function show(Attendance $attendance)
    {
        $attendance->load([
            'enrollment.student',
            'enrollment.classRoom',
            'enrollment.section',
            'markedBy',
            'updatedBy'
        ]);

        return view('attendances.show', compact('attendance'));
    }

    // EDIT
    public function edit(Attendance $attendance)
    {
        $attendance->load('enrollment');

        $classes = StudentEnrollment::with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->filter()
            ->unique('id')
            ->values();

        return view('attendances.edit', compact(
            'attendance',
            'classes'
        ));
    }

    // UPDATE
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'enrollment_id' => [
                'required',
                'exists:student_enrollments,id'
            ],
            'attendance_date' => 'required|date',
            'status' => 'required|in:0,1,2',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $exists = Attendance::where(
            'enrollment_id',
            $validated['enrollment_id']
        )->whereDate(
                'attendance_date',
                $validated['attendance_date']
            )->where('id', '!=', $attendance->id)->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'enrollment_id' =>
                        'Attendance already exists for this student on this date.'
                ]);
        }

        $validated['updated_by'] = auth()->id();

        $attendance->update($validated);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Attendance updated successfully.');
    }

    // DELETE
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Attendance deleted successfully.');
    }
}
