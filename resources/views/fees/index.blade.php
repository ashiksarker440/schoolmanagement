@extends('layouts.master')
@section('title', 'Fee List')

@section('content')

    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3>Fee Management</h3>
                <p class="text-muted">Manage Student Fees</p>
            </div>

            <a href="{{ route('fees.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Fee
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Student Name</th>
                            <th>Roll</th>
                            <th>Class</th>
                            <th>Fee Category</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($fees as $key => $fee)

                            <tr>
                                <td>{{ $fees->firstItem() + $key }}</td>

                                <td>
                                    {{ $fee->enrollment->student->name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $fee->enrollment->roll_no ?? '-' }}
                                </td>

                                <td>
                                    {{ $fee->enrollment->classRoom->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $fee->details->pluck('category.name')->filter()->join(', ') ?: 'N/A' }}
                                </td>

                                <td>
                                    ৳{{ number_format($fee->total_amount, 2) }}
                                </td>

                                <td>
                                    {{ $fee->due_date }}
                                </td>

                                <td>
                                    @if($fee->status == 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($fee->status == 'partial')
                                        <span class="badge bg-warning text-dark">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>

                                <td class="text-nowrap">
                                    <a href="{{ route('fees.show', $fee) }}" class="btn btn-sm btn-info" title="View fee details">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('fees.edit', $fee) }}" class="btn btn-sm btn-warning" title="Edit fee">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="text-center">
                                    No Fees Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                {{ $fees->links() }}

            </div>
        </div>

    </div>

@endsection