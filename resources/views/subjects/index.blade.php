@extends('layouts.master')
@section('title', 'Subjects')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-book"></i></span>
            <div><h1 class="h3 mb-1">Subjects</h1></div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Add Subject</a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Mark Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $s)
                    <tr>
                        <td>{{ $loop->iteration + ($subjects->currentPage() - 1) * $subjects->perPage() }}</td>
                        <td>{{ $s->subject_id ?? '-' }}</td>
                        <td><strong>{{ $s->name }}</strong></td>
                        <td>{{ $s->code ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ \App\Models\Subject::markTypes()[$s->mark_type] ?? $s->mark_type }}
                            </span>
                        </td>
                        <td>
                            @if($s->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('subjects.show', $s) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('subjects.edit', $s) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('subjects.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No subjects found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $subjects->links() }}</div>
    </section>
</div>
@endsection