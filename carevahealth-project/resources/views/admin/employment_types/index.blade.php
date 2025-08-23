@extends('admin.layouts.app')
@section('admin_content')
<div class="container">
    <h2>Employment Types</h2>
    <a href="{{ route('employment-types.create') }}" class="btn btn-primary mb-3">+ Add Employment Type</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($employmentTypes as $employmentType)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employmentType->name }}</td>
                <td>
                    <a href="{{ route('employment-types.edit',$employmentType->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('employment-types.destroy',$employmentType->id) }}" method="POST" class="d-inline">
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
