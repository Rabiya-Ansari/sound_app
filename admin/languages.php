<?php
include "./auth.php";
include '../config/db_connection.php';

/* =====================
   DELETE LANGUAGE
===================== */
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    mysqli_query($con, "DELETE FROM languages WHERE id=$delete_id");
    header("Location: languages.php");
    exit;
}

/* =====================
   FETCH LANGUAGE IF EDITING
===================== */
$edit_id = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$language_to_edit = null;
if ($edit_id > 0) {
    $res = mysqli_query($con, "SELECT * FROM languages WHERE id=$edit_id");
    $language_to_edit = mysqli_fetch_assoc($res);
}

//add logics
if (isset($_POST['save_language'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);

    if ($language_to_edit) {

        mysqli_query($con, "UPDATE languages SET language_name='$name' WHERE id=$edit_id");
    } else {
    
        mysqli_query($con, "INSERT INTO languages (language_name) VALUES ('$name')");
    }

    header("Location: languages.php");
    exit;
}

//edit logics
$languages = mysqli_query($con, "SELECT * FROM languages ORDER BY language_name ASC");
?>

<?php include './base/header.php'; ?>

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
                        <?php if($language_to_edit): ?>
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
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Language Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while($row = mysqli_fetch_assoc($languages)): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['language_name']) ?></td>
                                    <td>
                                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="ri-edit-line"></i> Edit
                                        </a>
                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this language?');">
                                            <i class="ri-delete-bin-line"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if(mysqli_num_rows($languages) == 0): ?>
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

<?php include './base/footer.php'; ?>
