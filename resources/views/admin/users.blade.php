@extends('admin.layout')

@section('title', 'Registered Users')

@section('content')
<div class="card">
    <table style="width: 100%;">
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
                        <span class="badge" style="background:#dbeafe; color:#1e40af;">Admin</span>
                    @else
                        <span class="badge" style="background:#f1f5f9; color:#475569;">User</span>
                    @endif
                </td>
                <td>{{ $u->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
            @if($users->count() == 0)
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem;">No users found.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
