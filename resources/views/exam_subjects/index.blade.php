@extends('layouts.master')
@section('title', 'Exam Subjects')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-journals"></i></span>
            <div><h1 class="h3 mb-1">Exam Subjects</h1></div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('exam-subjects.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Add Subject</a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="panel-header">
            <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                <select name="exam_id" class="form-control w-auto">
                    <option value="">All Exams</option>
                    @foreach($exams as $e)
                        <option value="{{ $e->id }}" @selected(request('exam_id') == $e->id)>{{ $e->name }}</option>
                    @endforeach
                </select>
                <select name="class_id" class="form-control w-auto">
                    <option value="">All Classes</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" @selected(request('class_id') == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-info"><i class="bi bi-search"></i> Filter</button>
                <a href="{{ route('exam-subjects.index') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr><th>#</th><th>Exam</th><th>Class</th><th>Subject</th><th>Full Marks</th><th>Pass Marks</th><th>Date</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($examSubjects as $es)
                        <tr>
                            <td>{{ $loop->iteration + ($examSubjects->currentPage() - 1) * $examSubjects->perPage() }}</td>
                            <td>{{ $es->exam->name ?? '-' }}</td>
                            <td>{{ $es->classRoom->name ?? '-' }}</td>
                            <td>{{ $es->subject->name ?? '-' }}</td>
                            <td>{{ $es->full_marks }}</td>
                            <td>{{ $es->pass_marks }}</td>
                            <td>{{ $es->exam_date?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <a href="{{ route('exam-subjects.show', $es) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('exam-subjects.edit', $es) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('exam-subjects.destroy', $es) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No exam subjects found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $examSubjects->links() }}</div>
    </section>
</div>
@endsection