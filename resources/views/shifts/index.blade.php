@extends('layouts.master')
@Section('title', 'shifts')

@Section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-users" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">All Shifts</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('shifts.create') }}" class="btn btn-outline-secondary btn-sm" type="button">
                    <i class="fas fa-plus"></i> Add Shift</a>
            </div>
        </div>

        <Section class="panel mt-3">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>shifts</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Shifts as $Shift)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $Shift->name }}</td>
                                <td>
                                    <a href="{{ route('shifts.edit', $Shift) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('shifts.destroy', $Shift) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this Shift?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No Shifts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $Shifts->links() }}</div>
        </Section>
    </div>
@endSection