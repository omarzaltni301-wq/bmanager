@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="font-size: 3rem; color: #3b82f6;">👥</div>
        <div>
            <div style="color: #64748b; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Total Users</div>
            <div style="font-size: 2rem; font-weight: 700; color: #1e293b;">{{ $usersCount }}</div>
        </div>
    </div>
    
    <div class="card" style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="font-size: 3rem; color: #f59e0b;">💬</div>
        <div>
            <div style="color: #64748b; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Total Feedbacks</div>
            <div style="font-size: 2rem; font-weight: 700; color: #1e293b;">{{ $feedbacksCount }}</div>
        </div>
    </div>

    <div class="card" style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="font-size: 3rem; color: #10b981;">🏷️</div>
        <div>
            <div style="color: #64748b; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Tracked Prices</div>
            <div style="font-size: 2rem; font-weight: 700; color: #1e293b;">{{ $pricesCount }}</div>
        </div>
    </div>
</div>

<div class="card">
    <h2 style="margin-top: 0;">Welcome to the Admin Panel</h2>
    <p style="color: #475569; line-height: 1.6;">
        From here, you have full control over BMANAGER. You can manage the tracked prices that appear on the public pages, review user feedback, and monitor user registrations.
    </p>
    <br>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.prices') }}" class="btn-primary" style="text-decoration: none;">Update Prices</a>
        <a href="{{ route('dashboard') }}" class="btn-primary" style="background: #64748b; text-decoration: none;">View User Site</a>
    </div>
</div>
@endsection
