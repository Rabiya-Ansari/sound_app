<?php
include 'auth.php';
include '../config/db_connection.php';

// FETCHING USERS IN ROLES
$sql = "SELECT id, name, email, role, status 
        FROM users 
        ORDER BY id ASC";

$users = mysqli_query($con, $sql);

if (!$users) {
    die(mysqli_error($con));
}
?>

<?php include "./base/header.php"; ?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                <h4 class="mb-0">Users List</h4>
                <a href="add_admin.php" class="btn btn-primary">Add Admin</a>
            </div>

            <!-- Responsive wrapper added -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle justify-content-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th class="text-nowrap">Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($users)): ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= htmlspecialchars($row['name']); ?></td>
                                        <td class="text-nowrap"><?= htmlspecialchars($row['email']); ?></td>

                                        <td>
                                            <?php
                                            $role = strtolower($row['role']);
                                            if ($role === 'admin') {
                                                echo '<span class="badge bg-primary">Admin</span>';
                                            } elseif ($role === 'editor') {
                                                echo '<span class="badge bg-warning text-dark">Editor</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary">User</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <span class="badge bg-danger">Banned</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- Buttons responsive + clean spacing -->
                                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                                <a href="edit_user.php?id=<?= $row['id']; ?>"
                                                    class="btn btn-success btn-sm w-100">
                                                    <i class="ri-pencil-line"></i> Edit
                                                </a>
                                                <a href="delete_user.php?id=<?= $row['id']; ?>"
                                                    class="btn btn-danger btn-sm w-100"
                                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "./base/footer.php"; ?>