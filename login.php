<?php
session_start();
include 'config/db_connection.php';

// LOGIN HANDLER
if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = sha1($_POST['password']);

    $res = mysqli_query(
        $con,
        "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1"
    );

    if (mysqli_num_rows($res) == 1) {

        $user = mysqli_fetch_assoc($res);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['name']    = $user['name'];   

        if ($user['role'] === 'admin') {
            header("Location: /sound/admin/index.php");
        } else {
            
            header("Location: /sound/index.php");
        }
        exit;

    } else {
        $error = "Invalid Email or Password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>

    <div class="container-fluid login-wrapper">
        <div class="row h-100">
            <!-- LEFT VISUAL -->
            <div class="col-md-7 d-none d-md-flex align-items-center login-visual">
                <div class="triangle-rain"></div>
                <div class="visual-content d-flex align-items-center gap-5">
                    <img src="./img/login.png" alt="" class="img-fluid" style="max-width:400px;">
                    <div>
                        <h1 class="mb-1 fw-bold">Feel The Beats</h1>
                        <p class="mb-0 medium opacity-75">
                            Log in and immerse yourself in a world of sound.
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT FORM -->
            <div class="col-12 col-md-5 login-form-area">
                <div class="login-card">

                    <div class="text-center mb-4">
                        <h3>Welcome Back</h3>
                        <small class="text-light opacity-75">Pick up where you left off</small>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center py-2">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label small">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <span class="input-group-text" onclick="togglePassword()">
                                    <i class="ri-eye-off-line" id="eyeIcon"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" name="login" class="btn btn-login w-100">
                            Login
                        </button>

                    </form>

                    <div class="login-links text-center mt-3">
                        <a href="#">Forgot password?</a>
                        <br>
                        <span class="text-light">No account?</span>
                        <a href="/sound/admin/registration.php">Register</a>
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
    </script>
</body>

</html>