@extends('admin.layouts.app')
@section('admin_content')
<div class="container">
    <h2>Designations</h2>
    <a href="{{ route('designations.create') }}" class="btn btn-primary mb-3">+ Add Designation</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($designations as $designation)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $designation->name }}</td>
                <td>
                    <a href="{{ route('designations.edit',$designation->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('designations.destroy',$designation->id) }}" method="POST" class="d-inline">
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
