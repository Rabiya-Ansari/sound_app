<?php
include "./auth.php";
include '../config/db_connection.php';

//delete logics
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    mysqli_query($con, "DELETE FROM artists WHERE id=$delete_id");
    header("Location: artist.php");
    exit;
}


$edit_id = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$artist_to_edit = null;
if ($edit_id > 0) {
    $res = mysqli_query($con, "SELECT * FROM artists WHERE id=$edit_id");
    $artist_to_edit = mysqli_fetch_assoc($res);
}

//add logics
if (isset($_POST['save_artist'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);

    if ($artist_to_edit) {
        
        mysqli_query($con, "UPDATE artists SET artist_name='$name' WHERE id=$edit_id");
    } else {
        
        mysqli_query($con, "INSERT INTO artists (artist_name) VALUES ('$name')");
    }

    header("Location: artist.php");
    exit;
}


$artists = mysqli_query($con, "SELECT * FROM artists ORDER BY artist_name ASC");
?>

<?php include './base/header.php'; ?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-4">

            <!-- ADD / EDIT ARTIST FORM -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?= $artist_to_edit ? '✏️ Edit Artist' : '➕ Add New Artist' ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Artist Name</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= $artist_to_edit ? htmlspecialchars($artist_to_edit['artist_name']) : '' ?>" 
                                   placeholder="Enter artist name" required>
                        </div>
                        <button type="submit" name="save_artist" class="btn btn-primary">
                            <?= $artist_to_edit ? 'Update Artist' : 'Add Artist' ?>
                        </button>
                        <?php if($artist_to_edit): ?>
                            <a href="artists.php" class="btn btn-secondary ms-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- ALL ARTISTS TABLE -->
            <div class="card">
                <div class="card-header">
                    <h4>🎤 All Artists</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Artist Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while($row = mysqli_fetch_assoc($artists)): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['artist_name']) ?></td>
                                    <td>
                                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="ri-edit-line"></i> Edit
                                        </a>
                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this artist?');">
                                            <i class="ri-delete-bin-line"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <?php if(mysqli_num_rows($artists) == 0): ?>
                        <p class="text-center mt-3">No artists found.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include './base/footer.php'; ?>
