<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Invoice;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::with('client');

            return DataTables::of($invoices)
                ->addColumn('client', function ($row) {
                    return $row->client ? $row->client->name : '-';
                })
                ->addColumn('period', function ($row) {
                    return Carbon::parse($row->period_start)->format('d-M-Y') 
     . ' to ' . Carbon::parse($row->period_end)->format('d-M-Y');

                })
                ->addColumn('action', function ($row) {
                    $url = route('invoices.pdf', $row->id);
                    return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-primary">View PDF</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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

    // Generate one invoice number for all employees
    $invoiceNumber = 'INV-' . strtoupper(uniqid());

    // Calculate totals
    $totalHours = 0;
    $totalAmount = 0;
    foreach ($request->employees as $emp) {
        $totalHours += $emp['total_hours'];
        $totalAmount += $emp['salary_amount'];
    }

    // Create invoice in invoices table
    $invoice = Invoice::create([
        'client_id'     => $request->client_id,
        'invoice_number'=> $invoiceNumber,
        'period_start'  => $request->period_start,
        'period_end'    => $request->period_end,
        'total_hours'   => $totalHours,
        'total_amount'  => $totalAmount,
    ]);

    // Store each employee salary linked to invoice
    foreach ($request->employees as $empData) {
        EmployeeSalary::create([
            'invoice_id'     => $invoice->id,   // link salaries to invoice
            'client_id'      => $request->client_id,
            'employee_id'    => $empData['employee_id'],
            'total_hours'    => $empData['total_hours'],
            'salary_amount'  => $empData['salary_amount'],
            'total_late'     => $empData['total_late'] ?? 0,
            'total_overtime' => $empData['total_overtime'] ?? 0,
            'period_start'   => $request->period_start,
            'period_end'     => $request->period_end,
        ]);
    }

    return redirect()->route('admin.invoices')->with('success', 'Invoice created successfully!');
}


public function generateInvoicePdf($id)
{
    $invoice = Invoice::with(['client', 'salaries.employee'])->findOrFail($id);

    $pdf = PDF::loadView('invoices.invoice', [
        'invoice'  => $invoice,
        'client'   => $invoice->client,
        'salaries' => $invoice->salaries,
    ]);

    return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
}
    
    


}
