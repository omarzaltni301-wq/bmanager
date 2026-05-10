@extends('layouts.guest')

@section('title', 'Contact & Feedback')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
    <section class="page-header">
        <div class="header-icon">💬</div>
        <h1>Contact & Feedback</h1>
        <p>Help us improve BMANAGER. Send suggestions, report price corrections, or ask questions.</p>
    </section>

    <div class="form-container">
        <div class="form-card">
            @if(session('success'))
                <div style="background-color:#e8f5e9;border:1px solid #a5d6a7;border-radius:8px;padding:12px 15px;margin-bottom:20px;color:#2e7d32;font-size:14px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color:#fff0f0;border:1px solid #ffcccc;border-radius:8px;padding:12px 15px;margin-bottom:20px;color:#cc0000;font-size:14px;">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @auth
                <form method="POST" action="{{ route('feedback.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" id="userName" placeholder="Enter your name" value="{{ old('name', Auth::user()->full_name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" id="userEmail" placeholder="your@email.com" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Feedback Type</label>
                        <select name="category" id="feedbackType">
                            <option value="Suggestion">Suggestion</option>
                            <option value="Price Correction">Price Correction</option>
                            <option value="Question">Question</option>
                            <option value="Bug Report">Bug Report</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Your Message</label>
                        <textarea name="message" id="userMessage" placeholder="Share your thoughts, suggestions, or corrections..." required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-submit">📨 Send Feedback</button>
                </form>
            @else
                <div class="login-required">
                    <div class="lock-icon">🔒</div>
                    <h2>Login Required</h2>
                    <p>You need to be logged in to submit feedback.<br>Please sign in or create an account to continue.</p>
                    <a href="{{ route('login') }}" class="btn-login-required">Login</a>
                    <a href="{{ route('register') }}" class="btn-signup-required">Sign Up</a>
                </div>
            @endauth
        </div>
    </div>

    <div class="info-cards">
        <div class="info-card">
            <h4>⚠️ Price Corrections</h4>
            <p>If you notice incorrect pricing and the current price does not match, submit corrections to ensure data accuracy for all users.</p>
        </div>
        <div class="info-card">
            <h4>🔒 Your Privacy</h4>
            <p>We only use your contact information to respond to your feedback. Your data is stored securely and never shared.</p>
        </div>
    </div>

    <div class="help-section">
        <h3>How Your Feedback Helps</h3>
        <ul>
            <li>Suggestions help us improve features and user experience</li>
            <li>Price corrections ensure data accuracy for all users</li>
            <li>Questions help us understand what information you need</li>
            <li>Admin team reviews all feedback within 48 hours</li>
        </ul>
    </div>
@endsection
