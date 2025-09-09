@extends('admin.layouts.app')
@section('admin_content')
<div class="container">
    <h2>Employee Statuses</h2>
    <a href="{{ route('employee-statuses.create') }}" class="btn btn-primary mb-3">+ Add Employee Status</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($statuses as $employeeStatus)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employeeStatus->name }}</td>
                <td>
                    <a href="{{ route('employee-statuses.edit',$employeeStatus->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('employee-statuses.destroy',$employeeStatus->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
