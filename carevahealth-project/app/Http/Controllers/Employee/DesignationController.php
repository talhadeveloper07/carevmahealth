<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::all();
        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        return view('admin.designations.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:designations']);
        Designation::create($request->only('name'));

        return redirect()->route('designations.index')->with('success', 'Designation created successfully');
    }

    public function show(Designation $designation)
    {
        return view('admin.designations.show', compact('designation'));
    }

    public function edit(Designation $designation)
    {
        return view('admin.designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate(['name' => 'required|unique:designations,name,' . $designation->id]);
        $designation->update($request->only('name'));

        return redirect()->route('designations.index')->with('success', 'Designation updated successfully');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully');
    }
}
