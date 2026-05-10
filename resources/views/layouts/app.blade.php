<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BMANAGER - @yield('title', 'Dashboard')</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Global & Reset for Header/Footer */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            color: #1e293b;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Glassmorphism Header */
        header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
            transition: all 0.3s ease;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }

        #logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e40af;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.2s ease;
            letter-spacing: -0.02em;
        }

        #logo:hover {
            transform: scale(1.02);
        }

        .logo-icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 0.25rem 0.6rem;
            border-radius: 8px;
            font-size: 1.25rem;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
            font-weight: 800;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            gap: 1rem;
        }

        nav ul li a {
            text-decoration: none;
            color: #475569;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            position: relative;
        }

        nav ul li a:hover {
            color: #2563eb;
            background-color: #eff6ff;
        }

        nav ul li a.active {
            color: #2563eb;
            background-color: #eff6ff;
            font-weight: 600;
            box-shadow: inset 0 0 0 1px #bfdbfe;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .logout-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(239, 68, 68, 0.4);
        }

        .user-avatar {
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.2s ease;
            background: #e2e8f0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
            background: #cbd5e1;
        }

        /* Content Area */
        main.content-wrapper {
            flex: 1;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
            background: transparent;
        }

        /* Sleek Modern Footer */
        footer {
            background: linear-gradient(180deg, #1e293b, #0f172a);
            color: #f1f5f9;
            padding: 4rem 2rem 2rem;
            margin-top: auto;
            border-top: 4px solid #3b82f6;
            font-family: 'Inter', sans-serif;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 3rem;
        }

        .footer-col h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #60a5fa;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .footer-col p {
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.7;
            margin: 0 0 1rem 0;
        }

        .footer-link-group {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .footer-link-group a, .footer-link-group button {
            color: #94a3b8;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s ease;
            background: none;
            border: none;
            padding: 0;
            text-align: left;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        .footer-link-group a:hover, .footer-link-group button:hover {
            color: #bfdbfe;
            transform: translateX(4px);
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 3rem auto 0;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.05);
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
        }
    </style>
    @yield('styles')
</head>
<body>

<header>
    <div class="header-left">
        <div id="logo" onclick="window.location.href='{{ route('dashboard') }}'">
            <span class="logo-icon">BM</span> BMANAGER
        </div>
        <nav>
            <ul>
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('dashboard') }}#prices">Price Awareness</a></li>
                <li><a href="{{ route('budget-tips') }}" class="{{ request()->routeIs('budget-tips') ? 'active' : '' }}">Budget Tips</a></li>
                <li><a href="{{ route('calculator') }}" class="{{ request()->routeIs('calculator') ? 'active' : '' }}">Calculator</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Feedback</a></li>
            </ul>
        </nav>
    </div>
    <div class="header-right">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
        <div class="user-avatar">👤</div>
    </div>
</header>

<main class="content-wrapper">
    @yield('content')
</main>

<footer>
    <div class="footer-container">
        <div class="footer-col">
            <h4>BMANAGER</h4>
            <p>Your trusted source for price information and budget management in Tunisia. Take control of your finances today.</p>
        </div>
        <div class="footer-col">
            <h4>For Users</h4>
            <div class="footer-link-group">
                <a href="{{ route('calculator') }}">Budget Calculator</a>
                <a href="{{ route('budget-tips') }}">Budget Tips</a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Tools</h4>
            <div class="footer-link-group">
                <a href="{{ route('dashboard') }}#prices">Price Awareness</a>
                <a href="{{ route('contact') }}">Send Feedback</a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Account</h4>
            <div class="footer-link-group">
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} BMANAGER. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
