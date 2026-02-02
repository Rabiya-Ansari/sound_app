<?php
include 'auth.php';
include '../config/db_connection.php';

// ADMIN ACCESS CONTROL
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: login.php");
    exit;
}
$error = "";

// HANDLE FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $status = (int) $_POST['status'];

    // Validation
    if ($name === '' || $email === '' || $password === '') {
        $error = "All fields are required.";
    } 
    else {
        // CHECK DUPLICATE EMAIL
        $checkSql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($con, $checkSql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Admin with this email already exists.";
            mysqli_stmt_close($stmt);
        } 
        else {
            mysqli_stmt_close($stmt);
            // CREATE ADMIN
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $role = 'admin';
            $insertSql = "
                INSERT INTO users (name, email, password, status, role)
                VALUES (?, ?, ?, ?, ?)
            ";
            $stmt = mysqli_prepare($con, $insertSql);
            mysqli_stmt_bind_param(
                $stmt,
                "sssis",
                $name,
                $email,
                $hashedPassword,
                $status,
                $role
            );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: users.php");
            exit;
        }
    }
}
?>
<?php include "./base/header.php"; ?>

<div class="content-page">
    <div class="content">
        <div class="container mt-4">
            <h4>Add New Admin</h4>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Admin Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Admin Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Temporary Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="0">Active</option>
                        <option value="1">Banned</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    Create Admin
                </button>

                <a href="users.php" class="btn btn-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>

<?php include "./base/footer.php"; ?>