<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMANAGER - Sign Up</title>
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <div class="logo-icon">📝</div>
            <h1>Create Your Account</h1>
            <p class="subtitle">Join BMANAGER to manage your budget</p>
        </div>

        @if($errors->any())
            <div style="background-color:#fff0f0;border:1px solid #ffcccc;border-radius:8px;padding:12px 15px;margin-bottom:20px;color:#cc0000;font-size:14px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" id="fullName" placeholder="John Doe" value="{{ old('full_name') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="signupEmail" placeholder="your@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="signupPassword" placeholder="Create a password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Confirm your password" required>
            </div>

            <div class="checkbox-group" style="margin-bottom: 25px;">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="#" class="forgot-link">Terms & Conditions</a></label>
            </div>

            <button type="submit" class="btn-login">Sign Up</button>
        </form>

        <div class="signup-link">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</body>
</html>
