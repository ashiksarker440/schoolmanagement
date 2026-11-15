<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'classRoom']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('roll_number', 'like', "%{$search}%")
                    ->orWhereHas(
                        'user',
                        fn($u) =>
                            $u->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                    );
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        $classes = ClassRoom::all();

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = ClassRoom::all();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'class_id' => 'required|exists:classes,id',
            'roll_number' => 'required|string|unique:students,roll_number',
            'guardian_name' => 'required|string|max:100',
            'guardian_phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'class_id' => $validated['class_id'],
                'roll_number' => $validated['roll_number'],
                'guardian_name' => $validated['guardian_name'],
                'guardian_phone' => $validated['guardian_phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'address' => $validated['address'] ?? null,
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully!');
    }

    public function show(Student $student)
    {
        $student->load(['user', 'classRoom']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::all();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'class_id' => 'required|exists:classes,id',
            'roll_number' => 'required|string|unique:students,roll_number,' . $student->id,
            'guardian_name' => 'required|string|max:100',
            'guardian_phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $student->update([
                'class_id' => $validated['class_id'],
                'roll_number' => $validated['roll_number'],
                'guardian_name' => $validated['guardian_name'],
                'guardian_phone' => $validated['guardian_phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'address' => $validated['address'] ?? null,
            ]);
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