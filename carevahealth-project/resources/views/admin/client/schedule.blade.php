@extends('admin.layouts.app')
@section('admin_content')

<div class="container-xxl flex-grow-1 container-p-y">
    @include('admin.client.profile_layouts.header')
    @include('admin.client.profile_layouts.nav')
    <div class="row">
    <div class="col-xl-12 col-lg-12 order-0 order-md-1">
        <!-- Employee Schedule -->
        <div class="card mb-4">
            <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                   
                        @foreach ($errors->all() as $error)
                            <p class='p-0 mb-1'>{{ $error }}</p>
                        @endforeach
                   
                </div>
            @endif
            <form method="POST" id="employeeScheduleForm" action='{{ route("employee.schedules.store") }}'>
                @csrf
                <input type="hidden" name='client_id' value='{{ $client->id }}'>

                <div id="employeeSections">
                    <!-- Employee Schedule Template -->
                    <div class="employee-section mb-3 rounded border p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Employee Schedule</h6>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Employee</label>
                            <select name="employees[0][employee_id]" class="select2 form-select employee-select" required>
                                <option></option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                @endforeach
                            </select>
                            <div class="employee-details mt-2 text-dark small alert alert-dark" style='display:none;'></div>
                        </div>

                        <label class="form-label fw-bold">Weekdays Schedule</label>
                        <table class="table table-bordered table-sm border rounded-3" style="border-collapse: separate; border-spacing: 0;">
                            <thead class="table-light">
                                <tr>
                                    <th class="rounded-top-start">
                                        <div class="d-flex gap-2">
                                            <input type="checkbox" class="form-check-input select-all-days ms-2">
                                            <span>Day</span>
                                        </div>
                                    </th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Total Hours</th>
                                    <th class="text-center rounded-top-end">
                                        <input type="checkbox" class="form-check-input select-all-repeat">
                                        Repeat
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input enable-day me-2" 
                                                    name="employees[0][weekdays][{{ $day }}][enabled]" value="1" id='input-{{ $day }}'>
                                                <label for='input-{{ $day }}' class="form-check-label">{{ $day }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" class="form-control form-control-sm start-time"
                                                name="employees[0][weekdays][{{ $day }}][start]">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control form-control-sm end-time"
                                                name="employees[0][weekdays][{{ $day }}][end]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm total-hours"
                                                name="employees[0][weekdays][{{ $day }}][total_hours]" readonly>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input repeat-day"
                                                name="employees[0][weekdays][{{ $day }}][repeat]" value="1">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-3 text-end">
                    <button type="button" class="btn btn-success" id="addEmployeeBtn">+ Add Employee</button>
                    <button type="submit" class="btn btn-primary">Assign Employees</button>
                </div>
            </form>

            </div>
        </div>
    </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let employeeIndex = 1;

    // Function to initialize Select2 + bind AJAX
    function initEmployeeSelect(section) {
        let $select = section.find('.employee-select');
        $select.select2({
            placeholder: "Select an Employee",
            allowClear: true,
            width: '100%'
        });

        $select.off('change').on('change', function() {
            let employeeId = $(this).val();
            let detailsDiv = $(this).siblings('.employee-details');

            if(employeeId) {
                $.ajax({
                    url: `/admin/assign-employee/${employeeId}/details`,
                    type: 'GET',
                    success: function(employee) {
                        $('.employee-details').show().html(`
                            <strong>${employee.first_name} ${employee.last_name}</strong><br>
                            Email: ${employee.email ?? '-'}<br>
                        `);
                    }
                });
            } else {
                detailsDiv.hide().html('');
            }
        });
    }

    // Init first select
    initEmployeeSelect($('.employee-section'));

    // Add employee section
    $('#addEmployeeBtn').on('click', function() {
        const template = $('.employee-section').first().clone();

        // Update names & reset fields
        template.find('select, input').each(function() {
            if(this.name) {
                this.name = this.name.replace(/\d+/, employeeIndex);
                if(this.tagName === 'SELECT') this.value = '';
                if(this.type === 'time' || this.type === 'text') this.value = '';
                if(this.type === 'checkbox') this.checked = false;
            }
        });

        template.find('.employee-details').hide().html('');
        $('#employeeSections').append(template);
        initEmployeeSelect(template); // re-init select2 + ajax
        employeeIndex++;
    });

    // Checkbox: select all days
    $(document).on('change', '.select-all-days', function () {
        $(this).closest('table').find('.enable-day').prop('checked', $(this).is(':checked'));
    });

    // Checkbox: select all repeat
    $(document).on('change', '.select-all-repeat', function () {
        $(this).closest('table').find('.repeat-day').prop('checked', $(this).is(':checked'));
    });

    // Auto calc total hours
    $(document).on('change', '.start-time, .end-time', function () {
        let row = $(this).closest('tr');
        let start = row.find('.start-time').val();
        let end = row.find('.end-time').val();

        if (start && end) {
            let startTime = new Date(`1970-01-01T${start}:00`);
            let endTime = new Date(`1970-01-01T${end}:00`);
            let diff = (endTime - startTime) / (1000 * 60 * 60);
            if (diff < 0) diff += 24;
            row.find('.total-hours').val(diff.toFixed(2));
        } else {
            row.find('.total-hours').val('');
        }
    });
});
</script>
@endsection
