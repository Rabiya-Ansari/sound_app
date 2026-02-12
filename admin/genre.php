<?php
include "./auth.php";
include '../config/db_connection.php';

// delete logics
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];


    $res = mysqli_query($con, "SELECT image FROM albums WHERE id=$delete_id");
    $row = mysqli_fetch_assoc($res);
    if ($row && $row['image'] && file_exists('../media/' . $row['image'])) {
        unlink('../media/' . $row['image']);
    }

mysqli_query($con, "DELETE FROM albums WHERE id=$delete_id");

    $_SESSION['message'] = "genre deleted successfully!";
    $_SESSION['message_type'] = "success";

    header("Location: genre.php");
    exit;
}

//edit logics
$edit_id = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$genre_to_edit = null;
if ($edit_id > 0) {
    $res = mysqli_query($con, "SELECT * FROM genres WHERE id=$edit_id");
    $genre_to_edit = mysqli_fetch_assoc($res);
}


if (isset($_POST['save_genre'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);

    if ($genre_to_edit) {
       
        mysqli_query($con, "UPDATE genres SET genre_name='$name' WHERE id=$edit_id");
    } else {
        
        mysqli_query($con, "INSERT INTO genres (genre_name) VALUES ('$name')");
    }

    header("Location: genre.php");
    exit;
}


$genres = mysqli_query($con, "SELECT * FROM genres ORDER BY genre_name ASC");
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

            <!-- ADD / EDIT GENRE FORM -->
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
                        <?php if($genre_to_edit): ?>
                            <a href="genres.php" class="btn btn-secondary ms-2">Cancel</a>
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
                            <?php $i = 1; while($row = mysqli_fetch_assoc($genres)): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['genre_name']) ?></td>
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

                    <?php if(mysqli_num_rows($genres) == 0): ?>
                        <p class="text-center mt-3">No genres found.</p>
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
            let id = this.dataset.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "This genre will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?delete=' + id;
                }
            });
        });
    });
</script>

<?php include './base/footer.php'; ?>
