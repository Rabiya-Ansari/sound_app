<?php
include "./auth.php";
include "../config/db_connection.php";

$admin_id = (int) $_SESSION['user_id'];

// Fetch admin data
$stmt = mysqli_prepare(
    $con,
    "SELECT name, email, password FROM users WHERE id = ? AND role = 'admin'"
);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$admin = mysqli_fetch_assoc($result)) {
    die("Access denied");
}

$error = "";

// Handle profile & password update
if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $old_password = trim($_POST['old_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');

    // Update password only if fields are filled
    if (!empty($old_password) || !empty($new_password)) {
        if (sha1($old_password) !== $admin['password']) {
            $error = "Old password is incorrect";
        } elseif (empty($new_password)) {
            $error = "Please enter a new password";
        } else {
            $hashed_password = sha1($new_password);
            $stmt = mysqli_prepare(
                $con,
                "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ? AND role = 'admin'"
            );
            mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $hashed_password, $admin_id);
        }
    } else {
        // Update only name & email
        $stmt = mysqli_prepare(
            $con,
            "UPDATE users SET name = ?, email = ? WHERE id = ? AND role = 'admin'"
        );
        mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $admin_id);
    }

    if (!$error && mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Profile updated successfully";
        header("Location: index.php");
        exit;
    } elseif (!$error) {
        $error = "Update failed";
    }
}
?>

<?php include './base/header.php' ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-3"></div>

        <!-- Main Content -->
        <div class="col-lg-10 col-md-9 mt-4">

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Edit Profile & Change Password</h4>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?= htmlspecialchars($admin['name']) ?>" required>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?= htmlspecialchars($admin['email']) ?>" required>
                                </div>

                                <!-- Old Password -->
                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <input type="password" name="old_password" class="form-control" placeholder="Enter old password to change">
                                </div>

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                                </div>

                                <button type="submit" name="update_profile" class="btn btn-primary">
                                    Update Profile
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include './base/footer.php' ?>
