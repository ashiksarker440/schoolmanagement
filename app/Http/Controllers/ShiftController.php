<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::latest()->paginate(10);
        return view('shifts.index', compact('shifts'));
    }

    public function create()
    {
        return view('shifts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:50|unique:shifts,name',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'is_active'  => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        Shift::create($validated);
        return redirect()->route('shifts.index')->with('success', 'Shift created!');
    }

    public function show(Shift $shift)
    {
        return view('shifts.show', compact('shift'));
    }

    public function edit(Shift $shift)
    {
        return view('shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:50|unique:shifts,name,' . $shift->id,
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'is_active'  => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $shift->update($validated);
        return redirect()->route('shifts.index')->with('success', 'Shift updated!');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('shifts.index')->with('success', 'Shift deleted!');
    }
}