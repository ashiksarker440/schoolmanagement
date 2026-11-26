@extends('layouts.master')
@section('title', 'Results')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-award"></i></span>
            <div>
                <h1 class="h3 mb-1">Results</h1>
                <p class="text-muted mb-0">All student results</p>
            </div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('results.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Add Result
            </a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="panel-header">
            <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                <select name="exam_id" class="form-control w-auto">
                    <option value="">All Exams</option>
                    @foreach($exams as $e)
                        <option value="{{ $e->id }}" @selected(request('exam_id') == $e->id)>
                            {{ $e->name }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-info"><i class="bi bi-search"></i> Filter</button>
                <a href="{{ route('results.index') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Exam</th>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $r)
                        <tr>
                            <td>{{ $loop->iteration + ($results->currentPage() - 1) * $results->perPage() }}</td>
                            <td>
                                <strong>{{ $r->enrollment->student->name ?? 'N/A' }}</strong>
                                <br>
                                <small class="text-muted">Roll: {{ $r->enrollment->roll_no ?? '-' }}</small>
                            </td>
                            <td>{{ $r->examSubject->exam->name ?? '-' }}</td>
                            <td>{{ $r->examSubject->subject->name ?? '-' }}</td>
                            <td>
                                {{ $r->obtained_marks }} / {{ $r->examSubject->full_marks }}
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $r->grade }}</span>
                                <small class="text-muted">({{ number_format($r->grade_point, 2) }})</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $r->status_badge }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('results.show', $r) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('results.edit', $r) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('results.destroy', $r) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this result?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No results found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $results->links() }}</div>
    </section>
</div>
@endsection