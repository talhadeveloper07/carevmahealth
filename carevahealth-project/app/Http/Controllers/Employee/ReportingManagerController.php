<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ReportingManager;
use Illuminate\Http\Request;

class ReportingManagerController extends Controller
{
    public function index()
    {
        $managers = ReportingManager::all();
        return view('admin.reporting_managers.index', compact('managers'));
    }

    public function create()
    {
        return view('admin.reporting_managers.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:reporting_managers']);
        ReportingManager::create($request->only('name'));

        return redirect()->route('reporting-managers.index')->with('success', 'Reporting Manager created successfully');
    }

    public function show(ReportingManager $reportingManager)
    {
        return view('admin.reporting_managers.show', compact('reportingManager'));
    }

    public function edit(ReportingManager $reportingManager)
    {
        return view('admin.reporting_managers.edit', compact('reportingManager'));
    }

    public function update(Request $request, ReportingManager $reportingManager)
    {
        $request->validate(['name' => 'required|unique:reporting_managers,name,' . $reportingManager->id]);
        $reportingManager->update($request->only('name'));

        return redirect()->route('reporting-managers.index')->with('success', 'Reporting Manager updated successfully');
    }

    public function destroy(ReportingManager $reportingManager)
    {
        $reportingManager->delete();
        return redirect()->route('reporting-managers.index')->with('success', 'Reporting Manager deleted successfully');
    }
}
