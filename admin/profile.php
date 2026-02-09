<?php
include "./auth.php";
include "../config/db_connection.php";

$admin_id = (int) $_SESSION['user_id'];
$error = "";

// fetch admin
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

if (isset($_POST['update_profile'])) {

    $name = trim($_POST['name']);
    $old_password = trim($_POST['old_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');

    if (!empty($old_password) || !empty($new_password)) {

        if (sha1($old_password) !== $admin['password']) {
            $error = "Old password is incorrect";

        } elseif (empty($new_password)) {
            $error = "Please enter a new password";

        } else {
            $hashed_password = sha1($new_password);

            $stmt = mysqli_prepare(
                $con,
                "UPDATE users SET name = ?, password = ? WHERE id = ? AND role = 'admin'"
            );
            mysqli_stmt_bind_param($stmt, "ssi", $name, $hashed_password, $admin_id);
        }

    } else {
        $stmt = mysqli_prepare(
            $con,
            "UPDATE users SET name = ? WHERE id = ? AND role = 'admin'"
        );
        mysqli_stmt_bind_param($stmt, "si", $name, $admin_id);
    }

    if (!$error && isset($stmt) && mysqli_stmt_execute($stmt)) {
        $_SESSION['swal'] = [
            'icon' => 'success',
            'title' => 'Profile Updated!',
            'text' => 'Your profile has been updated successfully.'
        ];
        header("Location: profile.php");
        exit;
    } elseif (!$error) {
        $error = "Update failed";
    }
}
?>


<?php include './base/header.php' ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION['swal'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['swal']['icon'] ?>',
                title: '<?= $_SESSION['swal']['title'] ?>',
                text: '<?= $_SESSION['swal']['text'] ?>',
                confirmButtonColor: '#3085d6'
            });
        </script>
        <?php
        unset($_SESSION['swal']);
endif;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-3"></div>

        <!-- Main Content -->
        <div class="col-lg-10 col-md-9 mt-4">

            <?php if (!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'];
                        unset($_SESSION['success']); ?>
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
                                    <input type="email" class="form-control"
                                        value="<?= htmlspecialchars($admin['email']) ?>" readonly>
                                </div>

                                <!-- Old Password -->
                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <input type="password" name="old_password" class="form-control"
                                        placeholder="Enter old password to change" required>
                                </div>

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control"
                                        placeholder="Enter new password" required>
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