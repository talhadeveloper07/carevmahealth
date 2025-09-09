@extends('admin.layouts.app')
@section('admin_content')
<div class="container">
    <h2>Reporting Managers</h2>
    <a href="{{ route('reporting-managers.create') }}" class="btn btn-primary mb-3">+ Add Reporting Manager</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($managers as $reportingManager)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $reportingManager->name }}</td>
                <td>
                    <a href="{{ route('reporting-managers.show',$reportingManager->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('reporting-managers.edit',$reportingManager->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('reporting-managers.destroy',$reportingManager->id) }}" method="POST" class="d-inline">
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
