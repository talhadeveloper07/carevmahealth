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

            <div class="row">
    @php
        // group schedules by employee
        $groupedSchedules = $client->employeeSchedules->groupBy('employee_id');
    @endphp

    @forelse($groupedSchedules as $employeeId => $schedules)
        @php
            $employee = $schedules->first()->employee;
        @endphp

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $employee->first_name }} {{ $employee->last_name }}</h5>
                    <p class="text-muted mb-2">{{ $employee->email }}</p>
                    <hr>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td class="fw-semibold">{{ ucfirst($schedule->weekday) }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                        -
                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                    </td>
                                    <td>
                                    {{ number_format($schedule->no_of_hours, 2) }} hrs
                                    </td>
                                    <td>
                                        @if(!$schedule->enabled)
                                            <span class="text-danger">Disabled</span>
                                        @else
                                            <span class="text-success">Enabled</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">No employees assigned to this client.</div>
        </div>
    @endforelse
</div>
    </div>
    </div>
</div>


@endsection
