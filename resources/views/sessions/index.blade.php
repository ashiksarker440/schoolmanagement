@extends('layouts.master')
@section('title', 'Sessions')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-calendar3"></i></span>
                <div>
                    <h1 class="h3 mb-1">All Sessions</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('sessions.create') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-plus"></i> Add Session
                </a>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Session Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $session)
                            <tr>
                                <td>{{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}</td>
                                <td><strong>{{ $session->name }}</strong></td>
                                <td>{{ $session->created_at?->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('sessions.show', $session) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('sessions.edit', $session) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('sessions.destroy', $session) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this session?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No sessions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $sessions->links() }}</div>
        </section>
    </div>
@endsection