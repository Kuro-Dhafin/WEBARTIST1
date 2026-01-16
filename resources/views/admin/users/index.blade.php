@extends('layouts.app')
@section('title','Manage Users')
@section('content')
<h2>User Management</h2>
<table class="table table-striped">
<thead>
<tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr>
</thead>
<tbody>
@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ ucfirst($user->role) }}</td>
    <td>{{ ucfirst($user->status) }}</td>
    <td>
        <form action="{{ route('admin.users.status', $user) }}" method="POST" class="d-inline">
            @csrf @method('PATCH')
            <select name="status" class="form-select form-select-sm d-inline w-auto">
                <option value="pending" @selected($user->status=='pending')>Pending</option>
                <option value="active" @selected($user->status=='active')>Active</option>
                <option value="banned" @selected($user->status=='banned')>Banned</option>
            </select>
            <button class="btn btn-sm btn-primary">Update</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
