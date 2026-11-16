@extends('layouts.master')
@section('title', 'groups')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-users" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">All Groups</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('groups.create') }}" class="btn btn-outline-secondary btn-sm" type="button">
                    <i class="fas fa-plus"></i> Add Groups</a>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>groups</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groups as $groups)
                            <tr>
                                <td>{{ $groups->id }}</td>
                                <td>{{ $groups->name }}</td>

                                <td>
                                    <a href="{{ route('groups.edit', $groups) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('groups.destroy', $groups) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this groups?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No groups found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $groups->links() }}</div>
        </section>
    </div>
@endsection