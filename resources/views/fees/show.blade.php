@extends('layouts.master')
@section('title', 'Fee Details')

@section('content')
    <style>
        .fee-print-slip {
            display: none;
        }

        @media print {
            @page {
                size: A5 portrait;
                margin: 10mm;
            }

            body * {
                visibility: hidden !important;
            }

            #fee-print-slip,
            #fee-print-slip * {
                visibility: visible !important;
            }

            #fee-print-slip {
                display: block !important;
                position: absolute;
                inset: 0;
                width: 100%;
                color: #111;
                background: #fff;
                font: 12px Arial, sans-serif;
            }

            #fee-print-slip h1,
            #fee-print-slip h2,
            #fee-print-slip p {
                margin: 0;
            }

            .fee-slip-header {
                text-align: center;
                border-bottom: 2px solid #111;
                padding-bottom: 10px;
                margin-bottom: 12px;
            }

            .fee-slip-header h1 {
                font-size: 20px;
                font-weight: 700;
                text-transform: uppercase;
            }

            .fee-slip-header p {
                margin-top: 4px !important;
                font-size: 14px;
                font-weight: 700;
                letter-spacing: 1px;
            }

            .fee-slip-meta,
            .fee-slip-student {
                display: flex;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 10px;
            }

            .fee-slip-student {
                flex-wrap: wrap;
                border: 1px solid #555;
                padding: 8px;
            }

            .fee-slip-student div {
                width: 48%;
                padding: 2px 0;
            }

            .fee-slip-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 8px;
            }

            .fee-slip-table th,
            .fee-slip-table td {
                border: 1px solid #555;
                padding: 6px;
            }

            .fee-slip-table th {
                text-align: left;
                background: #eee !important;
                print-color-adjust: exact;
            }

            .fee-slip-table .amount {
                text-align: right;
                white-space: nowrap;
            }

            .fee-slip-total td {
                font-weight: 700;
            }

            .fee-slip-balance td {
                font-weight: 700;
                font-size: 14px;
                border-top: 2px solid #111;
            }

            .fee-slip-note {
                margin-top: 12px !important;
                text-align: center;
            }

            .fee-slip-signatures {
                display: flex;
                justify-content: space-between;
                margin-top: 45px;
            }

            .fee-slip-signatures div {
                width: 40%;
                border-top: 1px solid #111;
                text-align: center;
                padding-top: 5px;
            }
        }
    </style>

    <div class="container-fluid px-3 px-lg-4 py-4">
        <article id="fee-print-slip" class="fee-print-slip">
            <header class="fee-slip-header">
                <h1>{{ config('app.name') === 'Laravel' ? 'School Management System' : config('app.name') }}</h1>
                <p>Student Fee Slip</p>
            </header>

            <div class="fee-slip-meta">
                <span><strong>Slip No:</strong> FEE-{{ str_pad($fee->id, 6, '0', STR_PAD_LEFT) }}</span>
                <span><strong>Date:</strong> {{ $fee->created_at?->format('d/m/Y') ?? now()->format('d/m/Y') }}</span>
            </div>

            <section class="fee-slip-student">
                <div><strong>Student:</strong> {{ $fee->enrollment->student->name ?? 'N/A' }}</div>
                <div><strong>Roll:</strong> {{ $fee->enrollment->roll_no ?? '-' }}</div>
                <div><strong>Class:</strong> {{ $fee->enrollment->classRoom->name ?? '-' }}</div>
                <div><strong>Section:</strong> {{ $fee->enrollment->section->name ?? '-' }}</div>
                <div><strong>Academic Session:</strong> {{ $fee->enrollment->studentSession->name ?? '-' }}</div>
                <div><strong>Due Date:</strong> {{ $fee->due_date?->format('d/m/Y') ?? '-' }}</div>
            </section>

            <table class="fee-slip-table">
                <thead>
                    <tr>
                        <th style="width: 10%">SL</th>
                        <th>Fee Particulars</th>
                        <th class="amount">Amount (৳)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fee->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->category->name ?? 'Fee category' }}</td>
                            <td class="amount">{{ number_format($detail->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fee-slip-total">
                        <td colspan="2">Total Fee</td>
                        <td class="amount">৳{{ number_format($fee->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Paid</td>
                        <td class="amount">৳{{ number_format($fee->paid_total, 2) }}</td>
                    </tr>
                    <tr class="fee-slip-balance">
                        <td colspan="2">Balance Due</td>
                        <td class="amount">৳{{ number_format($fee->due_total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <p class="fee-slip-note">
                <strong>Status:</strong> {{ ucfirst($fee->status) }}
                @if($fee->due_total > 0)
                    &nbsp; Please pay the balance by the due date.
                @else
                    &nbsp; Fee paid in full.
                @endif
            </p>

            <div class="fee-slip-signatures">
                <div>Student / Guardian</div>
                <div>Authorized Signature</div>
            </div>
        </article>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-heading">

            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-receipt"></i></span>
                <div>
                    <h1 class="h3 mb-1">Fee Details</h1>
                </div>
            </div>

            <div class="heading-actions">
                <button onclick="window.print()" class="btn btn-success btn-sm">
                    <i class="bi bi-printer"></i> Print Fee Slip
                </button>
                @if($fee->due_total > 0)
                    <a href="{{ route('fee-payments.create', ['fee_id' => $fee->id]) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-cash"></i> Record Payment
                    </a>
                @endif
                <a href="{{ route('fees.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row mt-3 g-3">
            <div class="col-md-6">
                <div class="panel h-100">
                    <div class="panel-header">
                        <h2 class="h5 mb-0">Fee Info</h2>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Student</dt>
                            <dd class="col-sm-8">{{ $fee->enrollment->student->name ?? 'N/A' }}</dd>
                            <dt class="col-sm-4">Roll</dt>
                            <dd class="col-sm-8">{{ $fee->enrollment->roll_no ?? '-' }}</dd>
                            <dt class="col-sm-4">Class</dt>
                            <dd class="col-sm-8">{{ $fee->enrollment->classRoom->name ?? '-' }}</dd>
                            <dt class="col-sm-4">Section</dt>
                            <dd class="col-sm-8">{{ $fee->enrollment->section->name ?? '-' }}</dd>
                            <dt class="col-sm-4">Categories</dt>
                            <dd class="col-sm-8">
                                @forelse($fee->details as $detail)
                                    <div>{{ $detail->category->name ?? '-' }}: ৳{{ number_format($detail->amount, 2) }}</div>
                                @empty
                                    -
                                @endforelse
                            </dd>
                            <dt class="col-sm-4">Total Amount</dt>
                            <dd class="col-sm-8">৳{{ number_format($fee->total_amount, 2) }}</dd>
                            <dt class="col-sm-4">Paid</dt>
                            <dd class="col-sm-8 text-success">৳{{ number_format($fee->paid_total, 2) }}</dd>
                            <dt class="col-sm-4">Due</dt>
                            <dd class="col-sm-8 text-danger">৳{{ number_format($fee->due_total, 2) }}</dd>
                            <dt class="col-sm-4">Due Date</dt>
                            <dd class="col-sm-8">{{ $fee->due_date?->format('d M Y') }}</dd>
                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $fee->status_badge }}">{{ ucfirst($fee->status) }}</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel h-100">
                    <div class="panel-header">
                        <h2 class="h5 mb-0">Actions</h2>
                    </div>
                    <div class="card-body">
                        @if($fee->payments->count() <= 0)
                            <form action="{{ route('fees.destroy', $fee) }}" method="POST"
                                onsubmit="return confirm('Delete this fee and all payments?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger w-100">
                                    <i class="fas fa-trash"></i> Delete Fee
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('fees.edit', $fee) }}" class="btn btn-warning w-100 mb-2">
                            <i class="fas fa-edit"></i> Edit Fee
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="panel-header">
                <h2 class="h5 mb-0">Payment History ({{ $fee->payments->count() }})</h2>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Receipt No</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Reference</th>
                            <th>Received By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fee->payments as $payment)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $payment->receipt_no }}</span></td>
                                <td>৳{{ number_format($payment->payment_amount, 2) }}</td>
                                <td>{{ $payment->payment_date?->format('d M Y') }}</td>
                                <td>{{ $payment->payment_method ?? '-' }}</td>
                                <td>{{ $payment->transaction_reference ?? '-' }}</td>
                                <td>{{ $payment->receiver->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('fee-payments.show', $payment) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">No payments yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection