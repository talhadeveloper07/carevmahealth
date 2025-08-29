<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Client;
use App\Models\ContractType;
use Monarobase\CountryList\CountryList;
use Yajra\DataTables\Facades\DataTables;

class AdminClientController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $clients = Client::with(['contractType', 'service'])->select('clients.*');

            return DataTables::of($clients)
                ->addColumn('contract_type', function($row){
                    return $row->contractType->name ?? '-';
                })
                ->addColumn('service', function($row){
                    return $row->service->name ?? '-';
                })
                ->editColumn('per_hour_charges', function($row){
                    return '$' . number_format($row->per_hour_charges, 2);
                })
                ->addColumn('ring_center', function($row){
                    return $row->ring_center 
                        ? '<span class="badge bg-success">Enabled</span>' 
                        : '<span class="badge bg-danger">Disabled</span>';
                })
                ->addColumn('actions', function($row){
                    $editUrl = '';
                    $deleteUrl = '';
                    return '
                        <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline-block;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['ring_center','actions']) // ✅ so HTML works
                ->make(true);
        }
        return view('admin.client.index');
    }

    public function add_client(Request $request, CountryList $countryList)
    {
        $services = Service::all();
        $contractTypes = ContractType::all();
        $countries = $countryList->getList('en'); // works now
        return view('admin.client.add',compact(['services','contractTypes','countries']));
    }

    public function insert_client(Request $request)
    {

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:clients,email',
            'business_name'    => 'nullable|string|max:255',
            'country'          => 'required|string|max:2', // ISO country code
            'phone_number'     => 'required|string|max:20',
            'per_hour_charges' => 'required|numeric|min:0',
            'timezone'         => 'required|string',
            'contract_type_id' => 'required|integer|exists:contract_types,id',
            'service_id'       => 'required|integer|exists:services,id',
            'ring_center'      => 'nullable|boolean',
        ]);

        $client = new Client();
        $client->name             = $validated['name'];
        $client->email            = $validated['email'];
        $client->business_name    = $validated['business_name'] ?? null;
        $client->country          = $validated['country'];
        $client->phone_number     = $validated['phone_number'];
        $client->per_hour_charges = $validated['per_hour_charges'];
        $client->timezone         = $validated['timezone'];
        $client->contract_type_id = $validated['contract_type_id'];
        $client->service_id       = $validated['service_id'];
        $client->ring_center      = $request->has('ring_center') ? 1 : 0;
        $client->save();

        return redirect()->back()->with('success', 'Client has been added successfully!');
    }
}
