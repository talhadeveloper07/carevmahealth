@extends('admin.layouts.app')
@section('admin_content')
<div class="container">
    <h2>Shift Types</h2>
    <a href="{{ route('shift-types.create') }}" class="btn btn-primary mb-3">+ Add Shift Type</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($shiftTypes as $shiftType)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $shiftType->name }}</td>
                <td>
                 
                    <a href="{{ route('shift-types.edit',$shiftType->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('shift-types.destroy',$shiftType->id) }}" method="POST" class="d-inline">
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
