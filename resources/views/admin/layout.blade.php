<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BMANAGER Admin - @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            color: #1e293b;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e293b, #0f172a);
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.25rem;
            font-weight: 800;
            color: #60a5fa;
            letter-spacing: -0.02em;
        }

        .sidebar-header .icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 0.25rem 0.6rem;
            border-radius: 8px;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }

        .sidebar-nav {
            padding: 1.5rem 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-nav a:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar-nav a.active {
            background: #3b82f6;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .logout-btn {
            width: 100%;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }

        .logout-btn:hover {
            background: #ef4444;
            color: #fff;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-width: 0; /* Prevents overflow */
        }

        .admin-header {
            background: #fff;
            padding: 1.25rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .admin-header h1 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            color: #475569;
        }

        .admin-content {
            padding: 2rem;
            flex: 1;
        }

        /* Reusable UI Components */
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            font-size: 14px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(59, 130, 246, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            font-size: 14px;
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        .btn-danger:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
            font-size: 14px;
        }
        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
        }
        .btn-secondary:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(107, 114, 128, 0.3);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-admin {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-user {
            background: #f1f5f9;
            color: #475569;
        }

        .badge.green {
            background: #d1fae5;
            color: #065f46;
        }

        .badge.orange {
            background: #fed7aa;
            color: #ea580c;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }

        .actions-cell {
            display: flex;
            gap: 0.5rem;
        }

        .category-name {
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            text-align: left;
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            color: #334155;
            font-size: 0.95rem;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #64748b;
            font-style: italic;
        }

        /* Admin Form Styles */
        .admin-form-container {
            display: flex;
            gap: 2rem;
        }

        .admin-form-card {
            width: 350px;
            flex-shrink: 0;
            align-self: flex-start;
        }

        .admin-list-card {
            flex: 1;
        }

        .admin-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #475569;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge.green { background: #dcfce7; color: #166534; }
        .badge.orange { background: #ffedd5; color: #9a3412; }
        
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: 1px solid #bbf7d0;
        }

        @yield('styles')
    </style>
</head>
<body>

<aside class="admin-sidebar">
    <div class="sidebar-header">
        <span class="icon">BM</span>
        BMANAGER
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">👥 Registered Users</a>
        <a href="{{ route('admin.prices') }}" class="{{ request()->routeIs('admin.prices') ? 'active' : '' }}">🏷️ Manage Prices</a>
        <a href="{{ route('admin.feedbacks') }}" class="{{ request()->routeIs('admin.feedbacks') ? 'active' : '' }}">💬 User Feedbacks</a>
    </nav>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>
</aside>

<main class="admin-main">
    <header class="admin-header">
        <h1>@yield('title')</h1>
        <div class="admin-user">
            👤 {{ Auth::user()->full_name ?? 'Admin' }}
        </div>
    </header>

    <div class="admin-content">
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</main>

@yield('scripts')
</body>
</html>
