<?php
include '../config/db_connection.php';

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $password_hashed = sha1($password);

        $check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already exists";
        } else {
            $query = "INSERT INTO users (name,email,password,role)
                      VALUES ('$name','$email','$password_hashed','user')";

            if (mysqli_query($con, $query)) {
                header("Location: /sound/login.php");
                exit;
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" crossorigin="anonymous"/>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .register-header {
            background: #185a9d;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .form-control:focus { box-shadow: none; border-color: #185a9d; }
        .btn-primary { background: #185a9d; border: none; }
        .btn-primary:hover { background: #134e87; }
        .login-link a { color: #185a9d; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card register-card">
                <div class="register-header">
                    <h4>Create Account</h4>
                    <small>Join us and explore</small>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Create password" required>
                                <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                                    <i class="ri-eye-off-line" id="eyeIcon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Re-type password" required>
                                <span class="input-group-text" onclick="toggleConfirmPassword()" style="cursor:pointer">
                                    <i class="ri-eye-off-line" id="eyeIconConfirm"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" name="register" class="btn btn-primary w-100 py-2">Register</button>
                    </form>

                    <div class="text-center mt-3 login-link">
                        Already have an account? <a href="/sound/login.php">Login</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const pass = document.getElementById("password");
        const icon = document.getElementById("eyeIcon");
        if (pass.type === "password") {
            pass.type = "text";
            icon.classList.replace("ri-eye-off-line","ri-eye-line");
        } else {
            pass.type = "password";
            icon.classList.replace("ri-eye-line","ri-eye-off-line");
        }
    }

    function toggleConfirmPassword() {
        const pass = document.getElementById("confirm_password");
        const icon = document.getElementById("eyeIconConfirm");
        if (pass.type === "password") {
            pass.type = "text";
            icon.classList.replace("ri-eye-off-line","ri-eye-line");
        } else {
            pass.type = "password";
            icon.classList.replace("ri-eye-line","ri-eye-off-line");
        }
    }
</script>
</body>
</html>
