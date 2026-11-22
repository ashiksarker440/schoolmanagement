<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('main_subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $teachers = $query->latest()->paginate(10)->withQueryString();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string|max:100',
            'main_subject' => 'nullable|string|max:100',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($validated, $request) {
            
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'teacher',
            ]);

            // 2. Photo upload
            $photoName = null;
            if ($request->hasFile('photo')) {
                $photoName = time() . '_' . $request->photo->getClientOriginalName();
                $request->photo->storeAs('teachers', $photoName, 'public');
            }

            // 3. Teacher 
            Teacher::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'gender' => $validated['gender'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'],
                'address' => $validated['address'] ?? null,
                'qualification' => $validated['qualification'] ?? null,
                'main_subject' => $validated['main_subject'] ?? null,
                'salary' => $validated['salary'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
                'photo' => $photoName,
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully!');
    }

    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string|max:100',
            'main_subject' => 'nullable|string|max:100',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($validated, $request, $teacher) {
            // User update
            $teacher->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Photo update
            $photoName = $teacher->photo;
            if ($request->hasFile('photo')) {
                if ($teacher->photo) {
                    Storage::disk('public')->delete('teachers/' . $teacher->photo);
                }
                $photoName = time() . '_' . $request->photo->getClientOriginalName();
                $request->photo->storeAs('teachers', $photoName, 'public');
            }

            // Teacher update
            $teacher->update([
                'name' => $validated['name'],
                'gender' => $validated['gender'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'],
                'address' => $validated['address'] ?? null,
                'qualification' => $validated['qualification'] ?? null,
                'main_subject' => $validated['main_subject'] ?? null,
                'salary' => $validated['salary'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
                'photo' => $photoName,
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully!');
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
            if ($teacher->photo) {
                Storage::disk('public')->delete('teachers/' . $teacher->photo);
            }
            $teacher->user->delete(); // cascade deletes teacher
        });

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully!');
    }
}