<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeePaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = FeePayment::with([
            'fee.enrollment.student',
            'fee.details.category',
            'receiver',
        ]);

        if ($request->filled('fee_id')) {
            $query->where('fee_id', $request->fee_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('receipt_no', 'like', "%{$search}%");
        }

        $payments = $query->latest()->paginate(20)->withQueryString();
        $fees = Fee::with('enrollment.student')->get();

        return view('fee_payments.index', compact('payments', 'fees'));
    }

    public function create(Request $request)
    {
        $fees = Fee::with(['enrollment.student', 'details.category'])
            ->whereIn('status', ['unpaid', 'partial'])
            ->get();

        $selectedFeeId = $request->fee_id;

        return view('fee_payments.create', compact('fees', 'selectedFeeId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fee_id'                => 'required|exists:fees,id',
            'payment_amount'        => 'required|numeric|min:0.01',
            'payment_date'          => 'required|date',
            'payment_method'        => 'nullable|string|max:50',
            'transaction_reference' => 'nullable|string|max:100',
        ]);

        $fee = Fee::findOrFail($validated['fee_id']);

        // Cannot pay more than due
        if ($validated['payment_amount'] > $fee->due_total) {
            return back()
                ->withErrors(['payment_amount' => 'Payment amount cannot exceed due amount (৳' . number_format($fee->due_total, 2) . ')'])
                ->withInput();
        }

        $validated['receipt_no']  = FeePayment::generateReceiptNo();
        $validated['received_by'] = Auth::id();

        FeePayment::create($validated);

        // Update fee status
        $fee->refresh();
        $fee->refreshStatus();

        return redirect()->route('fees.show', $fee)
            ->with('success', 'Payment recorded! Receipt: ' . $validated['receipt_no']);
    }

    public function show(FeePayment $payment)
    {
        $payment->load([
            'fee.enrollment.student',
            'fee.enrollment.studentSession',
            'fee.enrollment.classRoom',
            'fee.enrollment.section',
            'fee.details.category',
            'fee.payments',
            'receiver',
        ]);
        return view('fee_payments.show', compact('payment'));
    }

    public function edit(FeePayment $payment)
    {
        $fees = Fee::with(['enrollment.student'])->get();
        return view('fee_payments.edit', compact('payment', 'fees'));
    }

    public function update(Request $request, FeePayment $payment)
    {
        $validated = $request->validate([
            'fee_id'                => 'required|exists:fees,id',
            'payment_amount'        => 'required|numeric|min:0.01',
            'payment_date'          => 'required|date',
            'payment_method'        => 'nullable|string|max:50',
            'transaction_reference' => 'nullable|string|max:100',
        ]);

        $payment->update($validated);

        // Refresh fee status
        $payment->fee->refresh();
        $payment->fee->refreshStatus();

        return redirect()->route('fee-payments.index')
            ->with('success', 'Payment updated!');
    }

    public function destroy(FeePayment $payment)
    {
        $fee = $payment->fee;
        $payment->delete();

        // Refresh fee status
        $fee->refresh();
        $fee->refreshStatus();

        return redirect()->route('fee-payments.index')
            ->with('success', 'Payment deleted!');
    }
}