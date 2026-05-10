@extends('admin.layout')

@section('title', 'User Feedbacks')

@section('content')
<div class="card">
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Subject</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $fb)
            <tr>
                <td style="white-space: nowrap;">{{ $fb->submitted_at->format('Y-m-d') }}</td>
                <td style="font-weight: 500; white-space: nowrap;">{{ $fb->first_name }} {{ $fb->last_name }}</td>
                <td style="font-weight: 600;">{{ $fb->category }}</td>
                <td style="color: #475569;">{{ $fb->message }}</td>
            </tr>
            @endforeach
            @if($feedbacks->count() == 0)
            <tr>
                <td colspan="4" style="text-align: center; padding: 2rem;">No feedbacks received yet.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
