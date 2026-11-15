@extends('layouts.master')
@Section('title', 'sections')

@Section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-users" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">All Sections</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('Sectionses.create') }}" class="btn btn-outline-secondary btn-sm" type="button">
                    <i class="fas fa-plus"></i> Add Section</a>
            </div>
        </div>

        <Section class="panel mt-3">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Sections as $Section)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $Section->name }}</td>
                                <td>
                                    <a href="{{ route('Sectionses.edit', $Section) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('Sectionses.destroy', $Section) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this Section?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No Sections found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $Sections->links() }}</div>
        </Section>
    </div>
@endSection