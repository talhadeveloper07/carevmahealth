@extends('admin.layouts.app')
@section('admin_content')


<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-md-12">
            <h4>Employees</h4>
            <div class="card">
                <div class="card-body" style="overflow-x:auto;">
                <div class="mb-3">
                    <label for="status-filter">Employee Status</label>
                    <select id="status-filter" class="form-control" style="width: 200px;">
                        <option value="">Select Status</option>    
                        <option value="">All</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table table-bordered" id="employees-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Emp Code</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Expertise</th>
                            <th>Reporting Manager</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Shift Type</th>
                            <th>Timezone</th>
                            <th>Salary(PKR)</th>
                            <th>Salary(USD)</th>
                            <th>Date of Joining</th>
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
    var table = $('#employees-table').DataTable({
    processing: true,
    serverSide: true,
    dom: 'Bfrtip', // add buttons container
        buttons: [
            'csv',        // CSV export
            'excel',      // Excel expor
            'print'       // Print view
        ],
    ajax: {
        url: '{{ route("all.employees") }}',
        data: function(d) {
            d.status = $('#status-filter').val();
        }
    },
    columns: [
        { data: 'id', name: 'id' },
        { data: 'employee_code', name: 'employee_code' },
        { data: 'full_name', name: 'full_name' },
        { data: 'email', name: 'email' },
        { data: 'designation', name: 'designation' },
        { data: 'department', name: 'department' },
        { data: 'role', name: 'role' },
        { data: 'expertise', name: 'expertise' },
        { data: 'reporting_manager', name: 'reporting_manager' },
        { data: 'status', name: 'status' },
        { data: 'location', name: 'location' },
        { data: 'shift_type', name: 'shift_type' },
        { data: 'timezone', name: 'timezone' },
        { data: 'salary_pkr', name: 'salary_pkr' },
        { data: 'salary_usd', name: 'salary_usd' },
        { data: 'date_of_joining', name: 'date_of_joining' },
        { data: 'actions', name: 'actions', orderable: false, searchable: false },
    ]
    });

    // Redraw on filter change
    $('#status-filter').change(function() {
        table.draw();
    });

});
</script>

@endsection