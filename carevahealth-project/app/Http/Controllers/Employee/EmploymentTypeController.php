<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmploymentType;
use Illuminate\Http\Request;

class EmploymentTypeController extends Controller
{
    public function index()
    {
        $employmentTypes = EmploymentType::all();
        return view('admin.employment_types.index', compact('employmentTypes'));
    }

    public function create()
    {
        return view('admin.employment_types.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:employment_types']);
        EmploymentType::create($request->only('name'));

        return redirect()->route('employment-types.index')->with('success', 'Employment Type created successfully');
    }

    public function show(EmploymentType $employmentType)
    {
        return view('admin.employment_types.show', compact('employmentType'));
    }

    public function edit(EmploymentType $employmentType)
    {
        return view('admin.employment_types.edit', compact('employmentType'));
    }

    public function update(Request $request, EmploymentType $employmentType)
    {
        $request->validate(['name' => 'required|unique:employment_types,name,' . $employmentType->id]);
        $employmentType->update($request->only('name'));

        return redirect()->route('employment-types.index')->with('success', 'Employment Type updated successfully');
    }

    public function destroy(EmploymentType $employmentType)
    {
        $employmentType->delete();
        return redirect()->route('employment-types.index')->with('success', 'Employment Type deleted successfully');
    }
}
