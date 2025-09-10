<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.invoice.index');
    }

    public function add_invoice(Request $request)
    {
        $clients = Client::all();
        $employees = Employee::all();
        return view('admin.invoice.add',compact(['clients','employees']));
    }

    public function storeInvoice(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employees' => 'required|array',
            'employees.*.employee_id' => 'required|exists:employees,id',
            'employees.*.total_hours' => 'required|numeric|min:0',
            'employees.*.salary_amount' => 'required|numeric|min:0',
            'employees.*.total_late' => 'nullable|numeric|min:0',
            'employees.*.total_overtime' => 'nullable|numeric|min:0',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
        ]);
    
        foreach ($request->employees as $empData) {
            EmployeeSalary::create([
                'client_id'      => $request->client_id,
                'employee_id'    => $empData['employee_id'],
                'total_hours'    => $empData['total_hours'],
                'salary_amount'  => $empData['salary_amount'],
                'total_late'     => $empData['total_late'] ?? 0,
                'total_overtime' => $empData['total_overtime'] ?? 0,
                'period_start'   => $request->period_start,
                'period_end'     => $request->period_end,
                'invoice_number' => 'INV-' . strtoupper(uniqid()), // unique invoice number
            ]);
        }
    
        return redirect()->route('admin.invoices')->with('success', 'Invoice(s) saved successfully!');
    }
    

}
