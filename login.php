<?php
session_start();
include 'config/db_connection.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $res = mysqli_query(
        $con,
        "SELECT * FROM users 
         WHERE email='$email' AND password='$password'"
    );

    if (mysqli_num_rows($res) == 1) {
        $user = mysqli_fetch_assoc($res);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: /sound/admin/index.php");
        } else {
            header("Location: /sound/user/dashboard.php");
        }
        exit;
    } else {
        echo " Invalid Email or Password";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Remix icon link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 360px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .login-header {
            background: #185a9d;
            color: #fff;
            padding: 22px;
            text-align: center;
        }

        .login-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .login-header small {
            opacity: 0.9;
        }

        .login-body {
            padding: 28px;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #185a9d;
        }

        .btn-login {
            background: #185a9d;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-login:hover {
            background: #134e87;
        }

        .login-footer {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }

        .login-footer a {
            color: #185a9d;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="login-header">
            <h3>Welcome Back</h3>
            <small>Please login to continue</small>
        </div>

        <div class="login-body">
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                <button type="submit" name="login" class="btn btn-login w-100">
                    Login
                </button>
            </form>

            <div class="login-footer">
                Don’t have an account?
                <a href="/sound/admin/registration.php">Register</a>
            </div>
        </div>

    </div>

</body>

</html>