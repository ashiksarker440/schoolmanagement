@extends('layouts.master')
@section('title', 'Exam Details')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-journal-text"></i></span>
            <div><h1 class="h3 mb-1">{{ $exam->name }}</h1></div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <div class="row mt-3 g-3">
        <div class="col-md-6">
            <div class="panel h-100">
                <div class="panel-header"><h2 class="h5 mb-0">Exam Info</h2></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Name</dt><dd class="col-sm-8"><strong>{{ $exam->name }}</strong></dd>
                        <dt class="col-sm-4">Session</dt><dd class="col-sm-8">{{ $exam->session->name ?? '-' }}</dd>
                        <dt class="col-sm-4">Start</dt><dd class="col-sm-8">{{ $exam->start_date?->format('d M Y') ?? '-' }}</dd>
                        <dt class="col-sm-4">End</dt><dd class="col-sm-8">{{ $exam->end_date?->format('d M Y') ?? '-' }}</dd>
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8"><span class="badge bg-{{ $exam->status_badge }}">{{ ucfirst($exam->status) }}</span></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel h-100">
                <div class="panel-header"><h2 class="h5 mb-0">Actions</h2></div>
                <div class="card-body">
                    <a href="{{ route('exams.edit', $exam) }}" class="btn btn-warning w-100 mb-2"><i class="fas fa-edit"></i> Edit</a>
                    <a href="{{ route('exam-subjects.create') }}?exam_id={{ $exam->id }}" class="btn btn-primary w-100 mb-2"><i class="bi bi-plus"></i> Add Subject</a>
                    <form action="{{ route('exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('Delete this exam?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger w-100"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="panel-header"><h2 class="h5 mb-0">Exam Subjects ({{ $exam->subjects->count() }})</h2></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr><th>Class</th><th>Subject</th><th>Full Marks</th><th>Pass Marks</th><th>Date</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($exam->subjects as $sub)
                        <tr>
                            <td>{{ $sub->classRoom->name ?? '-' }}</td>
                            <td>{{ $sub->subject->name ?? '-' }}</td>
                            <td>{{ $sub->full_marks }}</td>
                            <td>{{ $sub->pass_marks }}</td>
                            <td>{{ $sub->exam_date?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <a href="{{ route('exam-subjects.show', $sub) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No subjects added.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection