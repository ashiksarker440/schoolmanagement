<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentSessionController;
use App\Http\Controllers\AttendanceController;

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Class
    Route::resource('classes', ClassRoomController::class);

    // Students
    Route::resource('students', StudentController::class);

    // Teachers
    Route::resource('teachers', TeacherController::class);

    // Departments
    Route::resource('departments', DepartmentController::class);

    // Designations
    Route::resource('designations', DesignationController::class);

    // Shifts
    Route::resource('shifts', ShiftController::class);

    // Groups
    Route::resource('groups', GroupController::class);

    // Sections
    Route::resource('sections', SectionController::class);

    // Student Sessions
    Route::resource('sessions', StudentSessionController::class);


    // ==================================
    // Attendance AJAX Routes
    // ==================================

    // Get Sections by Class
    Route::get(
        '/attendances/get-sections/{classId}',
        [AttendanceController::class, 'getSections']
    )->name('attendances.getSections');

    // Get Students by Class and Section
    Route::get(
        '/attendances/get-students',
        [AttendanceController::class, 'getStudents']
    )->name('attendances.getStudents');


    // Attendance CRUD
    Route::resource('attendances', AttendanceController::class);

});

require __DIR__ . '/auth.php';
