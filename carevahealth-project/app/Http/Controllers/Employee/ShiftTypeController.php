<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ShiftType;
use Illuminate\Http\Request;

class ShiftTypeController extends Controller
{
    public function index()
    {
        $shiftTypes = ShiftType::all();
        return view('admin.shift_types.index', compact('shiftTypes'));
    }

    public function create()
    {
        return view('admin.shift_types.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:shift_types']);
        ShiftType::create($request->only('name'));

        return redirect()->route('shift-types.index')->with('success', 'Shift Type created successfully');
    }

    public function show(ShiftType $shiftType)
    {
        return view('admin.shift_types.show', compact('shiftType'));
    }

    public function edit(ShiftType $shiftType)
    {
        return view('admin.shift_types.edit', compact('shiftType'));
    }

    public function update(Request $request, ShiftType $shiftType)
    {
        $request->validate(['name' => 'required|unique:shift_types,name,' . $shiftType->id]);
        $shiftType->update($request->only('name'));

        return redirect()->route('shift-types.index')->with('success', 'Shift Type updated successfully');
    }

    public function destroy(ShiftType $shiftType)
    {
        $shiftType->delete();
        return redirect()->route('shift-types.index')->with('success', 'Shift Type deleted successfully');
    }
}
