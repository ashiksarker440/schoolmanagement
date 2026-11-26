@extends('layouts.master')
@section('title', 'Exams')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-journal-bookmark"></i></span>
            <div>
                <h1 class="h3 mb-1">Exams</h1>
                <p class="text-muted mb-0">Manage all exams</p>
            </div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('exams.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Add Exam
            </a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exam Name</th>
                        <th>Session</th>
                        <th>Dates</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                        <tr>
                            <td>{{ $loop->iteration + ($exams->currentPage() - 1) * $exams->perPage() }}</td>
                            <td><strong>{{ $exam->name }}</strong></td>
                            <td>{{ $exam->session->name ?? '-' }}</td>
                            <td>
                                {{ $exam->start_date?->format('d M Y') ?? '-' }}
                                @if($exam->end_date)
                                    - {{ $exam->end_date->format('d M Y') }}
                                @endif
                            </td>
                            <td>
                                @if($exam->status == 'upcoming')
                                    <span class="badge bg-info">Upcoming</span>
                                @elseif($exam->status == 'ongoing')
                                    <span class="badge bg-warning">Ongoing</span>
                                @else
                                    <span class="badge bg-success">Completed</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('exams.show', $exam) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('exams.edit', $exam) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this exam?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No exams found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $exams->links() }}</div>
    </section>
</div>
@endsection