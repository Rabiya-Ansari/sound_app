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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/registration.css">
</head>

<body>
    <div class="container-fluid login-wrapper">
        <div class="row h-100">
            <!-- LEFT VISUAL -->
            <div class="col-md-7 d-none d-md-flex align-items-center login-visual">
                <div class="triangle-rain"></div>
                <div class="visual-content d-flex align-items-center gap-5">
                    <img src="./images/login.png" alt="" class="img-fluid" style="max-width:400px;">
                    <div>
                        <h1 class="mb-1 fw-bold">Step Into the Music</h1>
                        <p class="mb-0 medium opacity-75">
                            Join the ultimate audio experience and curate your personal vibe.
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT FORM -->
            <div class="col-12 col-md-5 login-form-area">

                <div class="login-card">

                    <div class="text-center mb-4">
                        <h3>Create Account</h3>
                        <small class="opacity-75">Enter your details to create an account</small>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                        </div>

                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="mb-3 input-group">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Password" required>
                            <span class="input-group-text" onclick="togglePassword()">
                                <i class="ri-eye-off-line" id="eyeIcon"></i>
                            </span>
                        </div>

                        <div class="mb-3 input-group">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                                placeholder="Confirm Password" required>
                            <span class="input-group-text" onclick="toggleConfirmPassword()">
                                <i class="ri-eye-off-line" id="eyeIconConfirm"></i>
                            </span>
                        </div>

                        <button type="submit" name="register" class="btn btn-login w-100">Register</button>

                    </form>
                    <div class="login-links text-center mt-3">
                        Already have an account? <a href="/sound/login.php">Login</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const container = document.querySelector('.triangle-rain');
        const MAX_ON_SCREEN = 90;
        const SPAWN_RATE = 120;

        function createTriangle() {
            const t = document.createElement('div');
            t.className = 'triangle';

            const size = Math.random() * 18 + 8;
            const left = Math.random() * 100;
            const duration = Math.random() * 5 + 8;
            const opacity = Math.random() * 0.6 + 0.3;

            t.style.width = size + 'px';
            t.style.height = size + 'px';
            t.style.left = left + '%';
            t.style.opacity = opacity;
            t.style.animationDuration = duration + 's';
            container.appendChild(t);

            setTimeout(() => {
                t.remove();
            }, duration * 1500);
        }
        /* ===== Infinite loop ===== */
        setInterval(() => {
            if (container.childElementCount < MAX_ON_SCREEN) {
                createTriangle();
            }
        }, SPAWN_RATE);

        function togglePassword() {
            const pass = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");
            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.replace("ri-eye-off-line", "ri-eye-line");
            } else {
                pass.type = "password";
                icon.classList.replace("ri-eye-line", "ri-eye-off-line");
            }
        }

        function toggleConfirmPassword() {
            const pass = document.getElementById("confirm_password");
            const icon = document.getElementById("eyeIconConfirm");
            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.replace("ri-eye-off-line", "ri-eye-line");
            } else {
                pass.type = "password";
                icon.classList.replace("ri-eye-line", "ri-eye-off-line");
            }
        }
    </script>

</body>

</html>