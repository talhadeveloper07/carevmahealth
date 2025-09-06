@extends('admin.layouts.app')

@section('admin_content')

<div class="container-xxl flex-grow-1 container-p-y py-5">
        <div class='row d-flex justify-content-center mt-5 align-items-center'>

            <div class="col-md-5 custom-title-col">
                <h4 class='mb-0 custom-page-title'>Attendance</h4>
                <p>View, add, edit and delete all attendance details.</p>
            </div>
            <div class="col-md-5 text-end">
                <a href="{{ route('admin.attendance.requests') }}" class='btn cstm-btn-link text-white'>Change Requests</a>
            </div>
        </div>
        <div class='row d-flex justify-content-center mt-5 align-items-center'>
           
            <div class='col-md-10'>
                <div class="custom-card-body">
                    <table id="attendanceTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <!-- <th>Breaks</th> -->
                                <th>Breaks Time</th>
                                <th>Worked Hours</th>
                                <th>Over Time</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
</div>


<script>
$(function () {
    $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.attendance') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'date', name: 'date' },
            { data: 'clock_in', name: 'clock_in' },
            { data: 'clock_out', name: 'clock_out' },
            { data: 'breaks', name: 'breaks', orderable: false, searchable: false },
            // { data: 'break_taken', name: 'break_taken', orderable: false, searchable: false },
            { data: 'worked_hours', name: 'worked_hours', orderable: false, searchable: false },
            { data: 'overtime', name: 'overtime', orderable: false, searchable: false },
        ],
        order: [[2, 'desc']]
    });
});
</script>

@endsection