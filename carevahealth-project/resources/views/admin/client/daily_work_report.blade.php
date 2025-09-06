@extends('admin.layouts.app')
@section('admin_content')

<div class="container-xxl flex-grow-1 container-p-y">
    @include('admin.client.profile_layouts.header')
    @include('admin.client.profile_layouts.nav')
    <div class="row">
        <div class="col-xl-12 col-lg-12 order-0 order-md-1">

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

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="attendanceTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                    <th>Total Hours</th>
                                    <th>Late Minutes</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                
        </div>
    </div>
</div>

<script>
$(function () {
    $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('daily.report', $client->id) }}',
        columns: [
            { data: 'employee_name', name: 'employee_name' },
            { data: 'date', name: 'date' },
            { data: 'clock_in', name: 'clock_in' },
            { data: 'clock_out', name: 'clock_out' },
            { data: 'total_minutes', name: 'total_minutes' },
            { data: 'late_minutes', name: 'late_minutes' },
        ]
    });
});
</script>
@endsection
