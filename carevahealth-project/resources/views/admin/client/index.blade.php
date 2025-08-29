
@extends('admin.layouts.app')
@section('admin_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class='m-0'>Clients</h4>
        <a href="{{ route('add.client') }}" class='btn btn-primary'>Add New Client</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="overflow-x:auto;">
                    <table id="clients-table" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Business Name</th>
                                <th>Country</th>
                                <th>Phone</th>
                                <th>Charges (per hr)</th>
                                <th>Timezone</th>
                                <th>Contract Type</th>
                                <th>Service</th>
                                <th>Ring Center</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('#clients-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('all.clients') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'business_name', name: 'business_name' },
            { data: 'country', name: 'country' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'per_hour_charges', name: 'per_hour_charges' },
            { data: 'timezone', name: 'timezone' },
            { data: 'contract_type', name: 'contractType.name', orderable: false, searchable: false },
            { data: 'service', name: 'service.name', orderable: false, searchable: false },
            { data: 'ring_center', name: 'ring_center', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>

@endsection