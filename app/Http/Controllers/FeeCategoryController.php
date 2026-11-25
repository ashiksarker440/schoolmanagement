<?php

namespace App\Http\Controllers;

use App\Models\FeeCategory;
use Illuminate\Http\Request;

class FeeCategoryController extends Controller
{
    public function index()
    {
        $categories = FeeCategory::latest()->paginate(10);
        return view('fee_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('fee_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100|unique:fee_categories,name',
            'description'    => 'nullable|string',
            'default_amount' => 'nullable|numeric|min:0',
        ]);

        FeeCategory::create($validated);

        return redirect()->route('fee-categories.index')
            ->with('success', 'Fee category created!');
    }

    public function show(FeeCategory $feeCategory)
    {
        return view('fee_categories.show', compact('feeCategory'));
    }

    public function edit(FeeCategory $feeCategory)
    {
        return view('fee_categories.edit', compact('feeCategory'));
    }

    public function update(Request $request, FeeCategory $feeCategory)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100|unique:fee_categories,name,' . $feeCategory->id,
            'description'    => 'nullable|string',
            'default_amount' => 'nullable|numeric|min:0',
        ]);

        $feeCategory->update($validated);

        return redirect()->route('fee-categories.index')
            ->with('success', 'Fee category updated!');
    }

    public function destroy(FeeCategory $feeCategory)
    {
        $feeCategory->delete();

        return redirect()->route('fee-categories.index')
            ->with('success', 'Fee category deleted!');
    }
}