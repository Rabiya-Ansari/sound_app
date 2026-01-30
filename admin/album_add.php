<?php
include "base/auth_check.php";
?>

<?php
include '../config/db_connection.php';

$artists = mysqli_query($con, "SELECT * FROM artists");
$genres  = mysqli_query($con, "SELECT * FROM genres");
$langs   = mysqli_query($con, "SELECT * FROM languages");

if (isset($_POST['add'])) {
    mysqli_query(
        $con,
        "INSERT INTO albums
        (album_name, artist_id, genre_id, language_id, release_year)
        VALUES (
            '{$_POST['name']}',
            '{$_POST['artist']}',
            '{$_POST['genre']}',
            '{$_POST['language']}',
            '{$_POST['year']}'
        )"
    );

    header("Location: album_sall.php");
    exit;
}
?>

<?php include './base/header.php'; ?>

<div class="main-content" style="margin-left: 250px; padding: 20px;">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">🎵 Add New Album</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label">Album Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter album name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Artist</label>
                        <select name="artist" class="form-select" required>
                            <option value="">Select Artist</option>
                            <?php while ($a = mysqli_fetch_assoc($artists)) { ?>
                                <option value="<?= $a['id'] ?>"><?= $a['artist_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <select name="genre" class="form-select" required>
                            <option value="">Select Genre</option>
                            <?php while ($g = mysqli_fetch_assoc($genres)) { ?>
                                <option value="<?= $g['id'] ?>"><?= $g['genre_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Language</label>
                        <select name="language" class="form-select" required>
                            <option value="">Select Language</option>
                            <?php while ($l = mysqli_fetch_assoc($langs)) { ?>
                                <option value="<?= $l['id'] ?>"><?= $l['language_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Release Year</label>
                        <input type="number" name="year" class="form-control" placeholder="e.g., 2026" required>
                    </div>

                    <button type="submit" name="add" class="btn bg-primary text-white">
                        <i class="ri-add-line"></i> Add Album
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include './base/footer.php'; ?>
