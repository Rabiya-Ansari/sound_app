<?php
include "./auth.php";
include '../config/db_connection.php';

// DELETE LOGIC
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    $query = "DELETE FROM genres WHERE id = $delete_id";

    if (mysqli_query($con, $query)) {
        $_SESSION['message'] = "Genre deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting genre: " . mysqli_error($con);
        $_SESSION['message_type'] = "error";
    }

    header("Location: genre.php");
    exit;
}

// EDIT LOGIC
$edit_id = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$genre_to_edit = null;
if ($edit_id > 0) {
    $res = mysqli_query($con, "SELECT * FROM genres WHERE id=$edit_id");
    $genre_to_edit = mysqli_fetch_assoc($res);
}

// ADD / UPDATE LOGIC
if (isset($_POST['save_genre'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);

    if ($genre_to_edit) {
        mysqli_query($con, "UPDATE genres SET genre_name='$name' WHERE id=$edit_id");
        $_SESSION['message'] = "Genre updated successfully!";
    } else {
        mysqli_query($con, "INSERT INTO genres (genre_name) VALUES ('$name')");
        $_SESSION['message'] = "Genre added successfully!";
    }
    $_SESSION['message_type'] = "success";

    header("Location: genre.php");
    exit;
}

// FETCH ALL GENRES
$genres = mysqli_query($con, "SELECT * FROM genres ORDER BY genre_name ASC");
?>

<?php include './base/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-4">

            <!-- ADD / EDIT  FORM -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?= $genre_to_edit ? '✏️ Edit Genre' : '➕ Add New Genre' ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Genre Name</label>
                            <input type="text" name="name" class="form-control"
                                value="<?= $genre_to_edit ? htmlspecialchars($genre_to_edit['genre_name']) : '' ?>"
                                placeholder="Enter genre name" required>
                        </div>
                        <button type="submit" name="save_genre" class="btn btn-primary">
                            <?= $genre_to_edit ? 'Update Genre' : 'Add Genre' ?>
                        </button>
                        <?php if ($genre_to_edit): ?>
                            <a href="genre.php" class="btn btn-secondary ms-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- ALL GENRES TABLE -->
            <div class="card">
                <div class="card-header">
                    <h4>🎵 All Genres</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover justify-content-center align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Genre Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = mysqli_fetch_assoc($genres)): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['genre_name']) ?></td>
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
                        </tbody>
                    </table>

                    <?php if (mysqli_num_rows($genres) == 0): ?>
                        <p class="text-center mt-3">No genres found.</p>
                    <?php endif; ?>
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
                text: "This genre will be permanently deleted!",
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

    // SweetAlert2 session messages
    <?php if (isset($_SESSION['message'])): ?>
        Swal.fire({
            icon: '<?= $_SESSION['message_type'] ?>',
            title: '<?= $_SESSION['message'] ?>',
            timer: 2000,
            showConfirmButton: false
        });
        <?php unset($_SESSION['message'], $_SESSION['message_type']); endif; ?>
</script>

<?php include './base/footer.php'; ?>