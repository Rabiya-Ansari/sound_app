<?php
include '../config/db_connection.php';

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = sha1($_POST['password']);


    $check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo " Email already exists";
    } else {
        $query = "INSERT INTO users (name,email,password,role)
                  VALUES ('$name','$email','$password','user')";

        if (mysqli_query($con, $query)) {
            header("Location: /sound/login.php");
            exit;
        } else {
            echo " Registration failed. Try again.";
        }
    }
}

?>

<h2>Register</h2>

<?php if (isset($error))
    echo "<p style='color:red'>$error</p>"; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="text-center mb-4">Create Account</h4>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" required>
                                <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                                    👁️
                                </span>
                            </div>
                        </div>

                        <button type="submit" name="register" class="btn btn-primary w-100">
                            Register
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="/sound/login.php">I already have an account</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>



<script>
    function togglePassword() {
        var pass = document.getElementById("password");
        pass.type = (pass.type === "password") ? "text" : "password";
    }
</script>