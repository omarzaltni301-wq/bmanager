<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMANAGER - Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <div class="logo-icon">👛</div>
            <h1 id="loginTitle">Welcome Back to BMANAGER</h1>
            <p class="subtitle" id="loginSubtitle">Sign in to manage your finances</p>
        </div>

        @if($errors->any())
            <div style="background-color:#fff0f0;border:1px solid #ffcccc;border-radius:8px;padding:12px 15px;margin-bottom:20px;color:#cc0000;font-size:14px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="tab-container">
            <button type="button" class="tab active" onclick="switchTab('user')">User Login</button>
            <button type="button" class="tab" onclick="switchTab('admin')">Admin Login</button>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="login_type" id="loginType" value="user">
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="userEmail" placeholder="your@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="userPassword" placeholder="••••••••" required>
            </div>

            <div class="remember-forgot">
                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-login" id="loginBtn">Login as User</button>
        </form>

        <div class="signup-link" id="signupLinkContainer">
            Don't have an account? <a href="{{ route('register') }}">Sign up</a>
        </div>
    </div>

    <script>
        function switchTab(type) {
            document.getElementById('loginType').value = type;
            var tabs = document.querySelectorAll('.tab');
            tabs[0].classList.remove('active');
            tabs[1].classList.remove('active');
            
            if (type === 'admin') {
                tabs[1].classList.add('active');
                document.getElementById('loginTitle').innerText = 'Admin Portal Access';
                document.getElementById('loginSubtitle').innerText = 'Sign in to manage BMANAGER';
                document.getElementById('loginBtn').innerText = 'Login as Admin';
                document.getElementById('signupLinkContainer').style.display = 'none';
            } else {
                tabs[0].classList.add('active');
                document.getElementById('loginTitle').innerText = 'Welcome Back to BMANAGER';
                document.getElementById('loginSubtitle').innerText = 'Sign in to manage your finances';
                document.getElementById('loginBtn').innerText = 'Login as User';
                document.getElementById('signupLinkContainer').style.display = 'block';
            }
        }
    </script>
</body>
</html>
