<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Education ERP System - Login</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            border-radius: 30px;
        }

        .btn-custom {
            background-color: #667eea;
            color: white;
            border-radius: 30px;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #5a67d8;
        }

        .forgot-password {
            font-size: 14px;
            text-decoration: none;
            color: #667eea;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="text-center mb-4">
            <img src="{{ asset('backend/images/logo-dark.png') }}" alt="Logo" width="50">
            <h3 class="mt-2"><b>Education ERP</b></h3>
        </div>

        <h4 class="text-center mb-3">Welcome Back</h4>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter password">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-custom w-100">Login</button>

            <p class="text-center mt-3">Don't have an account? <a href="{{ route('register') }}"
                    class="forgot-password">Sign Up</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>