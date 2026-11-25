@extends('layouts.master')
@section('title', 'Payment Receipt')

@section('content')
    <style>
        .money-receipt {
            max-width: 760px;
            margin: 0 auto;
            border: 1px solid #6c757d;
            background: #fff;
            color: #17212b;
        }

        .money-receipt-header {
            padding: 20px 24px 14px;
            border-bottom: 2px solid #17212b;
            text-align: center;
        }

        .money-receipt-header h1 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .money-receipt-header p {
            margin: 6px 0 0;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .money-receipt-body {
            padding: 20px 24px;
        }

        .receipt-meta,
        .receipt-student,
        .receipt-signatures {
            display: flex;
            justify-content: space-between;
            gap: 16px;
        }

        .receipt-meta {
            margin-bottom: 16px;
        }

        .receipt-student {
            flex-wrap: wrap;
            margin-bottom: 16px;
            padding: 10px 12px;
            border: 1px solid #6c757d;
        }

        .receipt-student div {
            width: 48%;
            padding: 3px 0;
        }

        .receipt-amount {
            margin: 16px 0;
            padding: 12px;
            border: 2px solid #17212b;
            text-align: center;
        }

        .receipt-amount strong {
            display: block;
            margin-top: 4px;
            font-size: 1.6rem;
        }

        .receipt-table {
            width: 100%;
            margin: 12px 0 18px;
            border-collapse: collapse;
        }

        .receipt-table th,
        .receipt-table td {
            padding: 8px;
            border: 1px solid #6c757d;
        }

        .receipt-table th {
            background: #f0f2f4;
            text-align: left;
        }

        .receipt-table .money {
            text-align: right;
            white-space: nowrap;
        }

        .receipt-summary {
            width: 100%;
            max-width: 390px;
            margin-left: auto;
        }

        .receipt-summary td {
            padding: 5px 0 5px 10px;
        }

        .receipt-summary .money {
            text-align: right;
            white-space: nowrap;
        }

        .receipt-summary .balance-row {
            border-top: 2px solid #17212b;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .receipt-signatures {
            margin-top: 58px;
        }

        .receipt-signatures div {
            width: 42%;
            padding-top: 7px;
            border-top: 1px solid #17212b;
            text-align: center;
        }

        .receipt-footer {
            padding: 10px 24px;
            border-top: 1px dashed #6c757d;
            text-align: center;
            font-size: .85rem;
        }

        @media print {
            @page {
                size: A5 portrait;
                margin: 9mm;
            }

            body * {
                visibility: hidden !important;
            }

            #money-receipt,
            #money-receipt * {
                visibility: visible !important;
            }

            #money-receipt {
                position: absolute;
                inset: 0;
                width: 100%;
                max-width: none;
                margin: 0;
                border: 1px solid #333;
                box-shadow: none !important;
                color: #000;
                font: 11px Arial, sans-serif;
            }

            #money-receipt .money-receipt-header {
                padding: 12px 14px 10px;
            }

            #money-receipt .money-receipt-header h1 {
                font-size: 17px;
            }

            #money-receipt .money-receipt-header p {
                font-size: 12px;
            }

            #money-receipt .money-receipt-body {
                padding: 12px 14px;
            }

            #money-receipt .receipt-amount {
                margin: 10px 0;
                padding: 8px;
            }

            #money-receipt .receipt-amount strong {
                font-size: 20px;
            }

            #money-receipt .receipt-signatures {
                margin-top: 42px;
            }

            #money-receipt .receipt-footer {
                padding: 7px 14px;
            }
        }
    </style>

    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading no-print">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-receipt"></i></span>
                <div>
                    <h1 class="h3 mb-1">Payment Receipt</h1>
                </div>
            </div>
            <div class="heading-actions">
                <button type="button" onclick="window.print()" class="btn btn-success btn-sm">
                    <i class="bi bi-printer"></i> Print Money Receipt
                </button>
                <a href="{{ route('fee-payments.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <article id="money-receipt" class="money-receipt panel mt-3">
            <header class="money-receipt-header">
                <h1>{{ config('app.name') === 'Laravel' ? 'School Management System' : config('app.name') }}</h1>
                <p>Official Money Receipt</p>
            </header>

            <div class="money-receipt-body">
                <div class="receipt-meta">
                    <span><strong>Receipt No:</strong> {{ $payment->receipt_no }}</span>
                    <span><strong>Date:</strong> {{ $payment->payment_date?->format('d/m/Y') ?? '-' }}</span>
                </div>

                <section class="receipt-student">
                    <div><strong>Received from:</strong> {{ $payment->fee->enrollment->student->name ?? 'N/A' }}</div>
                    <div><strong>Student ID:</strong> {{ $payment->fee->enrollment->student_id ?? '-' }}</div>
                    <div><strong>Class:</strong> {{ $payment->fee->enrollment->classRoom->name ?? '-' }}</div>
                    <div><strong>Roll:</strong> {{ $payment->fee->enrollment->roll_no ?? '-' }}</div>
                    <div><strong>Section:</strong> {{ $payment->fee->enrollment->section->name ?? '-' }}</div>
                    <div><strong>Academic Session:</strong> {{ $payment->fee->enrollment->studentSession->name ?? '-' }}
                    </div>
                </section>

                <div class="receipt-amount">
                    Amount Received
                    <strong>৳{{ number_format($payment->payment_amount, 2) }}</strong>
                </div>

                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th style="width: 10%">SL</th>
                            <th>Fee Particulars</th>
                            <th class="money">Fee Amount (৳)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payment->fee->details as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->category->name ?? 'Fee category' }}</td>
                                <td class="money">{{ number_format($detail->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Fee details unavailable</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <table class="receipt-summary">
                    <tbody>
                        <tr>
                            <td>Total Fee</td>
                            <td class="money">৳{{ number_format($payment->fee->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td>This Payment</td>
                            <td class="money">৳{{ number_format($payment->payment_amount, 2) }}</td>
                        </tr>
                        <tr class="balance-row">
                            <td>Current Balance Due</td>
                            <td class="money">৳{{ number_format($payment->fee->due_total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="mt-3 mb-1"><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method ?? 'Cash') }}</p>
                @if($payment->transaction_reference)
                    <p class="mb-1"><strong>Transaction Reference:</strong> {{ $payment->transaction_reference }}</p>
                @endif
                <p class="mb-0"><strong>Received By:</strong> {{ $payment->receiver->name ?? '-' }}</p>

                <div class="receipt-signatures">
                    <div>Student / Guardian Signature</div>
                    <div>Cashier / Authorized Signature</div>
                </div>
            </div>

            <footer class="receipt-footer">
                Thank you. Please keep this receipt for your records.
            </footer>
        </article>

        <div class="card-footer no-print mt-3">
            <a href="{{ route('fee-payments.edit', $payment) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('fee-payments.destroy', $payment) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Delete this payment?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>
@endsection