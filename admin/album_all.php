<?php
include "base/auth_check.php";
?>


<?php 
include '../config/db_connection.php';


if(isset($_GET['delete'])){
    $delete_id = (int) $_GET['delete'];
    mysqli_query($con, "DELETE FROM albums WHERE id=$delete_id");
    header("Location: album_all.php");
    exit;
}


$data = mysqli_query($con,
"SELECT albums.*, artists.artist_name
 FROM albums
 JOIN artists ON albums.artist_id=artists.id
 ORDER BY albums.id DESC");
?>

<?php include './base/header.php'; ?>

<div class="main-content" style="margin-left: 250px; padding: 20px;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">🎵 All Albums</h4>
            <a href="album_add.php" class="btn btn-primary">
                <i class="ri-add-line"></i> Add Album
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Album Name</th>
                            <th>Artist</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while($r = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($r['album_name']) ?></td>
                            <td><?= htmlspecialchars($r['artist_name']) ?></td>
                            <td>
                               
                                <a href="./album_edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <a href="?delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this album?');">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <?php if(mysqli_num_rows($data) == 0): ?>
                    <p class="text-center mt-3">No albums found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include './base/footer.php'; ?>
