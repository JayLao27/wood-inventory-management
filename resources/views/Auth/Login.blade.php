<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RM Woodworks - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #FFF1DA;
            display: flex;
            height: 100vh;
        }
        .left-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url("{{ asset('images/woodworks-bg.png') }}") no-repeat center;
            background-size: contain;
        }
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: #fff9f1;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-box img.logo {
            height: 60px;
            margin-bottom: 15px;
        }
        .login-box h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            color: #6B3D00;
        }
        .login-box p {
            font-size: 14px;
            margin-bottom: 20px;
            color: #A75F00;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #FFD28C;
            border-radius: 6px;
            font-size: 14px;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #E17100;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #c86000;
        }
        .demo-box {
            background: #FFF1DA;
            border: 1px solid #FFD28C;
            border-radius: 6px;
            padding: 12px;
            margin-top: 20px;
            font-size: 13px;
            text-align: left;
        }
        .demo-box strong {
            color: #E17100;
        }
    </style>
</head>
<body>
    <div class="left-panel">
        <!-- Changeable logo or image -->
        <img src="{{ asset('images/logo.png') }}" alt="RM Woodworks Logo" style="max-width: 300px;">
    </div>

    <div class="right-panel">
        <div class="login-box">
            <img src="{{ asset(path: 'images/logo.png') }}" alt="Small Logo" class="logo">
            <h2>RM Woodworks</h2>
            <p>Management System Login</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                <button type="submit" class="btn">Sign In</button>
            </form>

            <div class="demo-box">
                <p><strong>Demo accounts:</strong></p>
                <p>Admin: admin@rmwoodworks.com / admin123</p>
                <p>Manager: manager@rmwoodworks.com / manager123</p>
                <p>Worker: worker@rmwoodworks.com / worker123</p>
            </div>
        </div>
    </div>
</body>
</html>

            </div>
        </div>
    </div>
</body>
</html>
