<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeeCategory;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    // Show Create Fee Form
    public function create()
    {
        $enrollments = StudentEnrollment::with([
            'student',
            'classRoom',
            'section',
        ])->get();

        $categories = FeeCategory::orderBy('id')->get();

        return view('fees.create', compact(
            'enrollments',
            'categories'
        ));
    }

    public function categoryAmount(FeeCategory $category)
    {
        return response()->json([
            'amount' => $category->default_amount,
        ]);
    }

    // Show All Fees
    public function index()
    {
        $fees = Fee::with([
            'enrollment.student',
            'enrollment.classRoom',
            'enrollment.section',
            'details.category',
            'payments',
        ])->latest()->paginate(15);

        return view('fees.index', compact('fees'));
    }

    public function show(Fee $fee)
    {
        $fee->load([
            'enrollment.student',
            'enrollment.studentSession',
            'enrollment.classRoom',
            'enrollment.section',
            'details.category',
            'payments.receiver',
        ]);

        return view('fees.show', compact('fee'));
    }

    public function edit(Fee $fee)
    {
        $fee->load('details.category');
        $enrollments = StudentEnrollment::with(['student', 'classRoom', 'section'])->get();
        $categories = FeeCategory::orderBy('id')->get();

        return view('fees.edit', compact('fee', 'enrollments', 'categories'));
    }

    // Store one fee with multiple category details
    public function store(Request $request)
    {
        $validated = $this->validateNewFee($request);

        $fee = DB::transaction(function () use ($validated) {
            $categories = FeeCategory::whereIn('id', $validated['selected_categories'])
                ->get()
                ->keyBy('id');
            $total = collect($validated['selected_categories'])
                ->sum(fn ($categoryId) => $validated['amounts'][$categoryId]);
            $total = round($total, 2);

            $fee = Fee::create([
                'enrollment_id' => $validated['enrollment_id'],
                'total_amount' => $total,
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
            ]);

            foreach ($validated['selected_categories'] as $categoryId) {
                $category = $categories->get($categoryId);
                $fee->details()->create([
                    'enrollment_id' => $validated['enrollment_id'],
                    'fee_category_id' => $category->id,
                    'amount' => $validated['amounts'][$categoryId],
                ]);
            }

            return $fee;
        });

        return redirect()
            ->route('fees.show', $fee)
            ->with('success', 'Fee created successfully!');
    }

    public function update(Request $request, Fee $fee)
    {
        $validated = $this->validateFee($request, $fee);

        DB::transaction(function () use ($fee, $validated) {
            $this->saveFeeDetails($fee, $validated);
        });

        return redirect()
            ->route('fees.show', $fee)
            ->with('success', 'Fee updated successfully!');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();

        return redirect()
            ->route('fees.index')
            ->with('success', 'Fee deleted successfully.');
    }

    private function validateNewFee(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'enrollment_id' => 'required|exists:student_enrollments,id',
            'selected_categories' => 'required|array|min:1',
            'selected_categories.*' => 'required|integer|distinct|exists:fee_categories,id',
            'amounts' => 'required|array',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,partial,paid',
        ]);

        $validator->after(function ($validator) use ($request) {
            $selectedCategories = $request->input('selected_categories', []);
            $amounts = $request->input('amounts', []);
            if (
                ! is_array($selectedCategories)
                || ! is_array($amounts)
                || $validator->errors()->count() > 0
            ) {
                return;
            }

            $categories = FeeCategory::whereIn('id', $selectedCategories)->get();
            if ($categories->contains(fn (FeeCategory $category) => $category->default_amount <= 0)) {
                $validator->errors()->add(
                    'selected_categories',
                    'Selected fee categories must have a saved amount greater than zero.'
                );
            }

            $total = 0;
            foreach ($selectedCategories as $categoryId) {
                $amount = $amounts[$categoryId] ?? null;
                if (! is_numeric($amount) || $amount < 0.01 || $amount > 99999999.99) {
                    $validator->errors()->add(
                        'amounts.'.$categoryId,
                        'Enter an amount between 0.01 and 99999999.99 for each selected category.'
                    );

                    continue;
                }

                $total += (float) $amount;
            }

            if ($total > 99999999.99) {
                $validator->errors()->add('amounts', 'The total fee amount is too large.');
            }
        });

        return $validator->validate();
    }

    private function validateFee(Request $request, ?Fee $fee = null): array
    {
        $validator = Validator::make($request->all(), [
            'enrollment_id' => 'required|exists:student_enrollments,id',
            'amounts' => 'required|array',
            'amounts.*' => 'nullable|numeric|min:0.01|max:99999999.99',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,partial,paid',
        ]);

        $validator->after(function ($validator) use ($request, $fee) {
            $amounts = $request->input('amounts', []);
            if (! is_array($amounts)) {
                return;
            }

            $hasAmount = collect($amounts)->contains(function ($amount) {
                return $amount !== null && $amount !== '';
            });

            if (! $hasAmount) {
                $validator->errors()->add('amounts', 'Please enter at least one fee amount.');
            }

            $categoryIds = array_keys($amounts);
            if (FeeCategory::whereIn('id', $categoryIds)->count() !== count($categoryIds)) {
                $validator->errors()->add('amounts', 'One or more selected fee categories are invalid.');
            }

            $total = collect($amounts)
                ->filter(function ($amount) {
                    return $amount !== null && $amount !== '' && is_numeric($amount);
                })
                ->sum();

            if ($total > 99999999.99) {
                $validator->errors()->add('amounts', 'The total fee amount is too large.');
            }

            if ($fee && $total < $fee->payments()->sum('payment_amount')) {
                $validator->errors()->add(
                    'amounts',
                    'The total fee amount cannot be less than the amount already paid.'
                );
            }
        });

        return $validator->validate();
    }

    private function saveFeeDetails(Fee $fee, array $validated): Fee
    {
        $amounts = collect($validated['amounts'])
            ->filter(function ($amount) {
                return $amount !== null && $amount !== '';
            });

        $fee->fill([
            'enrollment_id' => $validated['enrollment_id'],
            'total_amount' => round($amounts->sum(), 2),
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
        ])->save();

        $fee->details()->delete();

        foreach ($amounts as $categoryId => $amount) {
            $fee->details()->create([
                'enrollment_id' => $validated['enrollment_id'],
                'fee_category_id' => $categoryId,
                'amount' => $amount,
            ]);
        }

        return $fee;
    }
}
