@extends('layouts.master')
@section('title', 'Fee Categories')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-tags"></i></span>
            <div>
                <h1 class="h3 mb-1">Fee Categories</h1>
            </div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('fee-categories.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Add Category
            </a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Default Amount</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                            <td><strong>{{ $cat->name }}</strong></td>
                            <td>৳{{ number_format($cat->default_amount, 2) }}</td>
                            <td>{{ Str::limit($cat->description, 50) ?? '-' }}</td>
                            <td>
                                <a href="{{ route('fee-categories.show', $cat) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('fee-categories.edit', $cat) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('fee-categories.destroy', $cat) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No categories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $categories->links() }}</div>
    </section>
</div>
@endsection