<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeStatus;
use Illuminate\Http\Request;

class EmployeeStatusController extends Controller
{
    public function index()
    {
        $statuses = EmployeeStatus::all();
        return view('admin.employee_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.employee_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:employee_statuses']);
        EmployeeStatus::create($request->only('name'));

        return redirect()->route('employee-statuses.index')->with('success', 'Employee Status created successfully');
    }

    public function show(EmployeeStatus $employeeStatus)
    {
        return view('admin.employee_statuses.show', compact('employeeStatus'));
    }

    public function edit(EmployeeStatus $employeeStatus)
    {
        return view('admin.employee_statuses.edit', compact('employeeStatus'));
    }

    public function update(Request $request, EmployeeStatus $employeeStatus)
    {
        $request->validate(['name' => 'required|unique:employee_statuses,name,' . $employeeStatus->id]);
        $employeeStatus->update($request->only('name'));

        return redirect()->route('employee-statuses.index')->with('success', 'Employee Status updated successfully');
    }

    public function destroy(EmployeeStatus $employeeStatus)
    {
        $employeeStatus->delete();
        return redirect()->route('employee-statuses.index')->with('success', 'Employee Status deleted successfully');
    }
}
