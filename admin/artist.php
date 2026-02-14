<?php
include "./auth.php";
include '../config/db_connection.php';

// =====================
// DELETE LOGIC
// =====================
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];

    // get artist image
    $res = mysqli_query($con, "SELECT artist_image FROM artists WHERE id=$delete_id");
    $row = mysqli_fetch_assoc($res);
    if ($row && $row['artist_image'] && file_exists('../media/' . $row['artist_image'])) {
        unlink('../media/' . $row['artist_image']);
    }

    mysqli_query($con, "DELETE FROM artists WHERE id=$delete_id");

    $_SESSION['message'] = "Artist deleted successfully!";
    $_SESSION['message_type'] = "success";

    header("Location: artist.php");
    exit;
}

// =====================
// EDIT LOGIC
// =====================
$edit_id = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$artist_to_edit = null;
if ($edit_id > 0) {
    $res = mysqli_query($con, "SELECT * FROM artists WHERE id=$edit_id");
    $artist_to_edit = mysqli_fetch_assoc($res);
}

// =====================
// ADD / UPDATE LOGIC
// =====================
if (isset($_POST['save_artist'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    
    $image_name = null;

    // handle file upload
    if (isset($_FILES['artist_image']) && $_FILES['artist_image']['error'] == 0) {
        $ext = pathinfo($_FILES['artist_image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '_' . rand(1000,9999) . '.' . $ext;
        move_uploaded_file($_FILES['artist_image']['tmp_name'], '../media/' . $image_name);
    }

    if ($artist_to_edit) {
        // update existing artist
        if ($image_name) {
            // delete old image
            if ($artist_to_edit['artist_image'] && file_exists('../media/' . $artist_to_edit['artist_image'])) {
                unlink('../media/' . $artist_to_edit['artist_image']);
            }
            mysqli_query($con, "UPDATE artists SET artist_name='$name', artist_image='$image_name' WHERE id=$edit_id");
        } else {
            mysqli_query($con, "UPDATE artists SET artist_name='$name' WHERE id=$edit_id");
        }
        $_SESSION['message'] = "Artist updated successfully!";
    } else {
        // add new artist
        mysqli_query($con, "INSERT INTO artists (artist_name, artist_image) VALUES ('$name', '$image_name')");
        $_SESSION['message'] = "Artist added successfully!";
    }

    $_SESSION['message_type'] = "success";
    header("Location: artist.php");
    exit;
}

// =====================
// FETCH ALL ARTISTS
// =====================
$artists = mysqli_query($con, "SELECT * FROM artists ORDER BY artist_name ASC");
?>

<?php include './base/header.php'; ?>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<?php if (isset($_SESSION['message'])): ?>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION['message_type'] ?>',
            title: '<?= $_SESSION['message'] ?>',
            showConfirmButton: true,
            timer: 2000
        });
    </script>
<?php
    unset($_SESSION['message'], $_SESSION['message_type']);
endif; ?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-4">

            <!-- ADD / EDIT ARTIST FORM -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?= $artist_to_edit ? '✏️ Edit Artist' : '➕ Add New Artist' ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Artist Name</label>
                            <input type="text" name="name" class="form-control"
                                value="<?= $artist_to_edit ? htmlspecialchars($artist_to_edit['artist_name']) : '' ?>"
                                placeholder="Enter artist name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Artist Image</label>
                            <input type="file" name="artist_image" class="form-control" <?= $artist_to_edit ? '' : 'required' ?> required>
                            <?php if ($artist_to_edit && $artist_to_edit['artist_image']): ?>
                                <img src="../media/<?= htmlspecialchars($artist_to_edit['artist_image']) ?>" alt="Artist Image" style="width: 100px; margin-top: 10px;">
                            <?php endif; ?>
                        </div>

                        <button type="submit" name="save_artist" class="btn btn-primary">
                            <?= $artist_to_edit ? 'Update Artist' : 'Add Artist' ?>
                        </button>
                        <?php if ($artist_to_edit): ?>
                            <a href="artist.php" class="btn btn-secondary ms-2">Cancel</a>
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
                    <table class="table table-hover justify-content-center align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Artist Name</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($row = mysqli_fetch_assoc($artists)): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['artist_name']) ?></td>
                                    <td>
                                        <?php if ($row['artist_image']): ?>
                                            <img src="../media/<?= htmlspecialchars($row['artist_image']) ?>" style="width: 80px; height: auto;">
                                        <?php else: ?>
                                            <span>No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-dark">
                                            <i class="ri-pencil-line"></i> Edit
                                        </a>
                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger delete-btn">
                                            <i class="ri-delete-bin-line"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <?php if (mysqli_num_rows($artists) == 0): ?>
                        <p class="text-center mt-3">No artists found.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // SweetAlert delete confirmation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let href = this.getAttribute('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "This artist will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });
</script>

<?php include './base/footer.php'; ?>
