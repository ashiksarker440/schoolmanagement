<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalStudents' => Student::count(),
            'totalTeachers' => '0',//User::where('role', 'teacher')->count(),
            'totalClasses' => ClassRoom::count(),
            'pendingFees' => 0,
        ];
        return view('dashboard', $data);
    }
}