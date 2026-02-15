<?php
include "./auth.php";
include '../config/db_connection.php';

// DELETE LOGIC
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];

    $query = "DELETE FROM languages WHERE id = $delete_id";

    if (mysqli_query($con, $query)) {
        $_SESSION['message'] = "Language deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: Could not delete language. It might be linked to an existing album.";
        $_SESSION['message_type'] = "error";
    }

    header("Location: languages.php");
    exit;
}

/* FETCH LANGUAGE IF EDITING */
$edit_id = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$language_to_edit = null;
if ($edit_id > 0) {
    $res = mysqli_query($con, "SELECT * FROM languages WHERE id=$edit_id");
    $language_to_edit = mysqli_fetch_assoc($res);
}

// ADD / UPDATE LOGIC
if (isset($_POST['save_language'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);

    if ($language_to_edit) {
        mysqli_query($con, "UPDATE languages SET language_name='$name' WHERE id=$edit_id");
        $_SESSION['message'] = "Language updated successfully!";
    } else {
        mysqli_query($con, "INSERT INTO languages (language_name) VALUES ('$name')");
        $_SESSION['message'] = "Language added successfully!";
    }
    $_SESSION['message_type'] = "success";

    header("Location: languages.php");
    exit;
}

// FETCH ALL LANGUAGES
$languages = mysqli_query($con, "SELECT * FROM languages ORDER BY language_name ASC");
?>

<?php include './base/header.php'; ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-4">

            <!-- ADD / EDIT LANGUAGE FORM -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?= $language_to_edit ? '✏️ Edit Language' : '➕ Add New Language' ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Language Name</label>
                            <input type="text" name="name" class="form-control"
                                value="<?= $language_to_edit ? htmlspecialchars($language_to_edit['language_name']) : '' ?>"
                                placeholder="Enter language name" required>
                        </div>
                        <button type="submit" name="save_language" class="btn btn-primary">
                            <?= $language_to_edit ? 'Update Language' : 'Add Language' ?>
                        </button>
                        <?php if ($language_to_edit): ?>
                            <a href="languages.php" class="btn btn-secondary ms-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- ALL LANGUAGES TABLE -->
            <div class="card">
                <div class="card-header">
                    <h4>🗂️ All Languages</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover justify-content-center align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Language Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = mysqli_fetch_assoc($languages)): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['language_name']) ?></td>
                                    <td>
                                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-dark">
                                            <i class="ri-pencil-line"></i> Edit
                                        </a>
                                        <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $row['id'] ?>">
                                            <i class="ri-delete-bin-line"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if (mysqli_num_rows($languages) == 0): ?>
                                <tr>
                                    <td colspan="3" class="text-center">No languages found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // SweetAlert2 delete confirmation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "This language will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?delete=' + id;
                }
            });
        });
    });

<?php if (isset($_SESSION['message'])): ?>
    Swal    .fire({
            icon: '<?= $_SESSION['message_type'] ?>',
            title: '<?= $_SESSION['message'] ?>',
            timer: 2000,
            showConfirmButton: false
        });
    <?php unset($_SESSION['message'], $_SESSION['message_type']); endif; ?>
</script>

<?php include './base/footer.php'; ?>
