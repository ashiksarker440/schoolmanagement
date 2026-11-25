@extends('layouts.master')
@section('title', 'Fee Payments')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-cash-stack"></i></span>
            <div><h1 class="h3 mb-1">All Payments</h1></div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('fee-payments.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Add Payment
            </a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Receipt No</th>
                        <th>Student</th>
                        <th>Fee Category</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Received By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $p->receipt_no }}</span></td>
                            <td>{{ $p->fee->enrollment->student->name ?? 'N/A' }}</td>
                            <td>{{ $p->fee->details->pluck('category.name')->filter()->join(', ') ?: '-' }}</td>
                            <td>৳{{ number_format($p->payment_amount, 2) }}</td>
                            <td>{{ $p->payment_date?->format('d M Y') }}</td>
                            <td>{{ $p->payment_method ?? '-' }}</td>
                            <td>{{ $p->receiver->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('fee-payments.show', $p) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('fee-payments.edit', $p) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('fee-payments.destroy', $p) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this payment?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $payments->links() }}</div>
    </section>
</div>
@endsection