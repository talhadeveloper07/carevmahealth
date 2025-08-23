<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function add_employee(Request $request)
    {
        return view('admin.employee.add');
    }
}
