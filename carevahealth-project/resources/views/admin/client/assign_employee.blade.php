@extends('admin.layouts.app')
@section('admin_content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="employeeScheduleForm">
                        @csrf

                        <div id="employeeSections">

                            <!-- Employee Schedule Template -->
                            <div class="employee-section border p-3 mb-3 rounded">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Employee Schedule</h6>
                                    <button type="button" class="btn btn-success btn-sm" id="addEmployeeBtn">+ Add Employee</button>
                                </div>

                                <div class="mb-3">
                                    <label>Client</label>
                                    <select name="client_id" class="select2 form-select client-select" required>
                                        <option value=""></option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="client-details mt-2 text-muted small"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Select Employee</label>
                                    <select name="employees[0][employee_id]" class="select2 form-select employee-select" required>
                                        <option></option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="employee-details mt-2 text-muted small"></div>
                                </div>


                                <label class="form-label fw-bold">Weekdays Schedule</label>
                                <table class="table table-bordered table-sm border rounded-3" style="border-collapse: separate; border-spacing: 0;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="rounded-top-start">Day</th>
                                            <th>Enable</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                            <tr>
                                                <td>{{ $day }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="employees[0][weekdays][{{ $day }}][enabled]" value="1">
                                                </td>
                                                <td>
                                                    <input type="time" class="form-control form-control-sm" name="employees[0][weekdays][{{ $day }}][start]">
                                                </td>
                                                <td>
                                                    <input type="time" class="form-control form-control-sm" name="employees[0][weekdays][{{ $day }}][end]">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Assign Employees</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#employeeFilter').select2({
            placeholder: "Select an Employee", // <-- Your placeholder text
            allowClear: true
        });
    });
</script>

<script>
let employeeIndex = 1;

document.getElementById('addEmployeeBtn').addEventListener('click', function() {
    const template = document.querySelector('.employee-section').cloneNode(true);

    // Update names of cloned inputs
    template.querySelectorAll('select, input').forEach(el => {
        if(el.name) {
            el.name = el.name.replace(/\d+/, employeeIndex);
            if(el.tagName === 'SELECT') el.value = ''; // Reset selection
            if(el.type === 'time') el.value = ''; // Reset time
            if(el.type === 'checkbox') el.checked = false; // Reset checkbox
        }
    });

    document.getElementById('employeeSections').appendChild(template);
    employeeIndex++;
});
</script>

<script>

$(document).ready(function() {
$(document).on('change', '.client-select', function() {
    let clientId = $(this).val();
    let detailsDiv = $(this).siblings('.client-details');

    if(clientId) {
        $.ajax({
            url: `/admin/assign-client/${clientId}/details`,
            type: 'GET',
            success: function(client) {
                $('.client-details').html(`
                    <strong>${client.name}</strong><br>
                    Email: ${client.email ?? '-'}<br>
                    Phone: ${client.phone_number ?? '-'}
                `);
            }
        });
    } else {
        detailsDiv.html('');
    }
});

$(document).on('change', '.employee-select', function() {
    let employeeId = $(this).val();
    let detailsDiv = $(this).siblings('.employee-details');

    if(employeeId) {
        $.ajax({
            url: `/admin/assign-employee/${employeeId}/details`,
            type: 'GET',
            success: function(employee) {
                $('.employee-details').html(`
                    <strong>${employee.first_name} ${employee.last_name}</strong><br>
                    Email: ${employee.email ?? '-'}<br>
                `);
            }
        });
    } else {
        detailsDiv.html('');
    }
});
});
</script>

@endsection