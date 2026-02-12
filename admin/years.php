<?php
include "./auth.php";
include "../config/db_connection.php";

// delete logics
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];


    $res = mysqli_query($con, "SELECT image FROM albums WHERE id=$delete_id");
    $row = mysqli_fetch_assoc($res);
    if ($row && $row['image'] && file_exists('../media/' . $row['image'])) {
        unlink('../media/' . $row['image']);
    }

mysqli_query($con, "DELETE FROM albums WHERE id=$delete_id");

    $_SESSION['message'] = "year deleted successfully!";
    $_SESSION['message_type'] = "success";

    header("Location: years.php");
    exit;
}

/* EDIT LOGIC */
$edit_id = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$year_to_edit = null;

if ($edit_id > 0) {
    $res = mysqli_query($con, "SELECT * FROM years WHERE id=$edit_id");
    $year_to_edit = mysqli_fetch_assoc($res);
}

/* ADD / UPDATE LOGIC */
if (isset($_POST['save_year'])) {
    $year = (int) $_POST['year'];

    if ($year_to_edit) {
        mysqli_query($con, "UPDATE years SET `release_year`=$year WHERE id=$edit_id");
    } else {
        mysqli_query($con, "INSERT INTO years (`release_year`) VALUES ($year)");
    }

    header("Location: years.php");
    exit;
}

/* FETCH ALL YEARS */
$years = mysqli_query($con, "SELECT * FROM years ORDER BY `release_year` DESC");
?>

<?php include "./base/header.php"; ?>

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

            <!-- ADD / EDIT YEAR FORM -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?= $year_to_edit ? '✏️ Edit Year' : '➕ Add New Year' ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Year</label>
                            <input type="number" name="year" class="form-control" placeholder="e.g. 2024"
                                value="<?= $year_to_edit ? htmlspecialchars($year_to_edit['release_year']) : '' ?>"
                                required>
                        </div>

                        <button type="submit" name="save_year" class="btn btn-primary">
                            <?= $year_to_edit ? 'Update Year' : 'Add Year' ?>
                        </button>

                        <?php if ($year_to_edit): ?>
                            <a href="years.php" class="btn btn-secondary ms-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- YEARS TABLE -->
            <div class="card">
                <div class="card-header">
                    <h4>📅 All Years</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover justify-content-center align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = mysqli_fetch_assoc($years)): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['release_year']) ?></td>
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
                    <?php if (mysqli_num_rows($years) == 0): ?>
                        <p class="text-center mt-3">No years found.</p>
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
                text: "This year will be deleted!",
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

<?php include "./base/footer.php"; ?>