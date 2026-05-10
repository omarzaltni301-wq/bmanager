@extends('admin.layout')

@section('title', 'Registered Users')

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $u->user_id }}</td>
                <td style="font-weight: 500;">{{ $u->full_name }}</td>
                <td>{{ $u->email }}</td>
                <td>
                    @if($u->is_admin)
                        <span class="badge badge-admin">Admin</span>
                    @else
                        <span class="badge badge-user">User</span>
                    @endif
                </td>
                <td>{{ $u->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
            @if($users->count() == 0)
            <tr>
                <td colspan="5" class="no-data">No users found.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
