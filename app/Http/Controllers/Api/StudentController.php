<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller 
{
    public function index(Request $request)
    {
        $students = Student::with(['user', 'classRoom'])->get();
        return response()->json(['data' => $students]);
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

        $student = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
            ]);

            return Student::create([
                'user_id' => $user->id,
                'class_id' => $validated['class_id'],
                'roll_number' => $validated['roll_number'],
                'guardian_name' => $validated['guardian_name'],
                'guardian_phone' => $validated['guardian_phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'address' => $validated['address'] ?? null,
            ]);
        });

        return response()->json([
            'message' => 'Student created successfully',
            'data' => $student->load('user', 'classRoom'),
        ], 201);
    }

    public function show(Student $student)
    {
        $student->load(['user', 'classRoom']);
        return response()->json(['data' => $student]);
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

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student->fresh(['user', 'classRoom']),
        ]);
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->user->delete();
        });

        return response()->json(['message' => 'Student deleted successfully']);
    }
}