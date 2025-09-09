<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Expertise;
use Illuminate\Http\Request;

class ExpertiseController extends Controller
{
    public function index()
    {
        $expertises = Expertise::all();
        return view('admin.expertises.index', compact('expertises'));
    }

    public function create()
    {
        return view('admin.expertises.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:expertises']);
        Expertise::create($request->only('name'));

        return redirect()->route('expertises.index')->with('success', 'Expertise created successfully');
    }

    public function show(Expertise $expertise)
    {
        return view('admin.expertises.show', compact('expertise'));
    }

    public function edit(Expertise $expertise)
    {
        return view('admin.expertises.edit', compact('expertise'));
    }

    public function update(Request $request, Expertise $expertise)
    {
        $request->validate(['name' => 'required|unique:expertises,name,' . $expertise->id]);
        $expertise->update($request->only('name'));

        return redirect()->route('expertises.index')->with('success', 'Expertise updated successfully');
    }

    public function destroy(Expertise $expertise)
    {
        $expertise->delete();
        return redirect()->route('expertises.index')->with('success', 'Expertise deleted successfully');
    }
}
