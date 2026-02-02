<?php
include 'auth.php';
include '../config/db_connection.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: users.php");
    exit;
}
$id = (int) $_GET['id'];

// UPDATE USER(POST REQUEST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $status = (int) $_POST['status'];

    if ($name === '' || !in_array($status, [0, 1])) {
        die("Invalid input");
    }

    $updateSql = "UPDATE users SET name = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $updateSql);
    mysqli_stmt_bind_param($stmt, "sii", $name, $status, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: users.php");
    exit;
}

// FETCH USER (GET REQUEST)
$sql = "SELECT name, email, status FROM users WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found");
}
mysqli_stmt_close($stmt);
?>

<?php include "./base/header.php"; ?>
<div class="content-page">
    <div class="content">
        <div class="container mt-4">
            <h4>Edit User</h4>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email (readonly)</label>
                    <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="0" <?= $user['status'] == 0 ? 'selected' : ''; ?>>
                            Active
                        </option>
                        <option value="1" <?= $user['status'] == 1 ? 'selected' : ''; ?>>
                            Banned
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    Update User
                </button>
                <a href="users.php" class="btn btn-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>

<?php include "./base/footer.php"; ?>