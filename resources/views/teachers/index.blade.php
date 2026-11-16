@extends('layouts.master')
@section('title', 'Teachers')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">All Teachers</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('teachers.create') }}" class="btn btn-outline-secondary btn-sm" type="button">
                    <i class="fas fa-plus"></i> Add Teacher</a>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="panel-header">
                <div class="d-flex flex-wrap gap-2">
                    <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                        <input class="form-control form-control-sm table-search" type="search" placeholder="Search teachers"
                            name="search" aria-label="Search teachers" value="{{ request('search') }}">
                        <select name="status" class="form-control w-auto">
                            <option value="">All Status</option>
                            <option value="active" @selected(request('status') == 'active')>Active</option>
                            <option value="inactive" @selected(request('status') == 'inactive')>Inactive</option>
                        </select>
                        <button class="btn btn-info"><i class="fas fa-search"></i> Filter</button>
                        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Reset</a>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="teachersTable" data-searchable-table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td>{{ $loop->iteration + ($teachers->currentPage() - 1) * $teachers->perPage() }}</td>
                                <td>
                                    @if($teacher->photo)
                                        <img src="{{ asset('storage/teachers/' . $teacher->photo) }}" alt="{{ $teacher->name }}"
                                            width="40" height="40" class="rounded-circle" style="object-fit: cover;">
                                    @else
                                        <span class="badge badge-light p-2">
                                            <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->phone ?? '-' }}</td>
                                <td>{{ $teacher->main_subject ?? '-' }}</td>
                                <td>{{ $teacher->salary ? '৳' . number_format($teacher->salary, 2) : '-' }}</td>
                                <td>
                                    @if($teacher->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this teacher and their login?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No teachers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
                {{ $teachers->links() }}
            </div>
        </section>
    </div>
@endsection