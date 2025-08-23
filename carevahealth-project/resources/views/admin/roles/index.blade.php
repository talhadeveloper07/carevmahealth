@extends('admin.layouts.app')
@section('admin_content')
<div class="container">
    <h2>Roles</h2>
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">+ Add Role</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $role->name }}</td>
                <td>
              
                    <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('roles.destroy',$role->id) }}" method="POST" class="d-inline">
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
