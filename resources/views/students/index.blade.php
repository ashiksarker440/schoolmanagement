@extends('layouts.master')
@section('title', 'Students')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-users" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">All Students</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('students.create') }}" class="btn btn-outline-secondary btn-sm" type="button">
                    <i class="fas fa-plus"></i> Add Student</a>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="panel-header">
                <div class="d-flex flex-wrap gap-2">
                    <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                        <input class="form-control form-control-sm table-search" type="search" name="search"
                            placeholder="Search students" data-table-search="studentsTable" aria-label="Search students"
                            value="{{ request('search') }}">
                        <select name="class_id" class="form-control w-auto">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>
                                    {{ $class->name }} {{ $class->section }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-info"><i class="fas fa-search"></i> Filter</button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Reset</a>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="studentsTable" data-searchable-table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Father</th>
                            <th>Mother</th>
                            <th>Guardian</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Shift</th>
                            <th>Group</th>
                            <th>Session</th>
                            <th>Roll</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->father_name ?: '-' }}<br><small>{{ $student->father_phone }}</small></td>
                                <td>{{ $student->mother_name ?: '-' }}<br><small>{{ $student->mother_phone }}</small></td>
                                <td>{{ $student->guardian_name ?: '-' }}<br><small>{{ $student->guardian_phone }}</small></td>
                                <td>{{ $student->enrollment?->classRoom?->name ?? '-' }}</td>
                                <td>{{ $student->enrollment?->section?->name ?? '-' }}</td>
                                <td>{{ $student->enrollment?->shift?->name ?? '-' }}</td>
                                <td>{{ $student->enrollment?->group?->name ?? '-' }}</td>
                                <td>{{ $student->enrollment?->studentSession?->name ?? '-' }}</td>
                                <td><span class="badge badge-secondary">{{ $student->enrollment?->roll_no ?? '-' }}</span></td>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this student and their login?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted py-4">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
                {{ $students->links() }}
            </div>
        </section>
    </div>

@endsection