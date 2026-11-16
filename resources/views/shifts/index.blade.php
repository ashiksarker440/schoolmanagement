@extends('layouts.master')
@section('title', 'Shifts')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">All Shifts</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('shifts.create') }}" class="btn btn-outline-secondary btn-sm" type="button">
                    <i class="fas fa-plus"></i> Add Shift</a>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Shift Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shifts as $shift)
                            <tr>
                                <td>{{ $loop->iteration + ($shifts->currentPage() - 1) * $shifts->perPage() }}</td>
                                <td>{{ $shift->name }}</td>
                                <td>
                                    <a href="{{ route('shifts.show', $shift) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('shifts.edit', $shift) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('shifts.destroy', $shift) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this shift?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No shifts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $shifts->links() }}</div>
        </section>
    </div>
@endsection