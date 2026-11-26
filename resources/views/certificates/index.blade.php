@extends('layouts.master')
@section('title', 'Certificates')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-file-earmark-text"></i></span>
            <div><h1 class="h3 mb-1">Certificates</h1></div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('certificates.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Issue Certificate
            </a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cert No</th>
                        <th>Student</th>
                        <th>Type</th>
                        <th>Issue Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $c)
                        <tr>
                            <td>{{ $loop->iteration + ($certificates->currentPage() - 1) * $certificates->perPage() }}</td>
                            <td><span class="badge bg-secondary">{{ $c->certificate_no }}</span></td>
                            <td>{{ $c->enrollment->student->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-{{ $c->type_badge }}">{{ \App\Models\Certificate::types()[$c->type] ?? $c->type }}</span></td>
                            <td>{{ $c->issue_date?->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('certificates.show', $c) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('certificates.edit', $c) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('certificates.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this certificate?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No certificates found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $certificates->links() }}</div>
    </section>
</div>
@endsection