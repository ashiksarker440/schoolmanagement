
@extends('layouts.app')

@section('content')

<div class="container-fluid dashboard-container">

    <!-- Dashboard Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Dashboard</h2>
            <p class="text-muted">
                Welcome to School Management System
            </p>
        </div>

        <div>
            <span class="badge bg-primary p-2">
                Admin Panel
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">

        <!-- Students -->
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card student-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Total Students</p>
                            <h2>0</h2>
                            <span>Student Management</span>
                        </div>

                        <div class="dashboard-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                    </div>

                    <a href="#" class="dashboard-link">
                        Manage Students →
                    </a>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card teacher-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Total Teachers</p>
                            <h2>0</h2>
                            <span>Teacher Management</span>
                        </div>

                        <div class="dashboard-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>

                    <a href="#" class="dashboard-link">
                        Manage Teachers →
                    </a>
                </div>
            </div>
        </div>

        <!-- Classes -->
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card class-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Total Classes</p>
                            <h2>0</h2>
                            <span>Class Management</span>
                        </div>

                        <div class="dashboard-icon">
                            <i class="bi bi-book-fill"></i>
                        </div>
                    </div>

                    <a href="#" class="dashboard-link">
                        Manage Classes →
                    </a>
                </div>
            </div>
        </div>

        <!-- Attendance -->
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card attendance-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Attendance</p>
                            <h2>0</h2>
                            <span>Attendance Management</span>
                        </div>

                        <div class="dashboard-icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                    </div>

                    <a href="#" class="dashboard-link">
                        Manage Attendance →
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Quick Management</h5>
        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-3">
                    <a href="#" class="quick-action">
                        <i class="bi bi-person-plus-fill"></i>
                        <h6>Add Student</h6>
                        <p>Register a new student</p>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="#" class="quick-action">
                        <i class="bi bi-person-badge-fill"></i>
                        <h6>Add Teacher</h6>
                        <p>Register a new teacher</p>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="#" class="quick-action">
                        <i class="bi bi-journal-plus"></i>
                        <h6>Add Class</h6>
                        <p>Create a new class</p>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="#" class="quick-action">
                        <i class="bi bi-calendar-check"></i>
                        <h6>Take Attendance</h6>
                        <p>Manage daily attendance</p>
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
