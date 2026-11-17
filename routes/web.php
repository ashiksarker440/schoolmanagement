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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('classes', ClassRoomController::class);
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);

    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('shifts', ShiftController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('sessions', StudentSessionController::class);

});

require __DIR__ . '/auth.php';