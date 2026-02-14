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

    $_SESSION['message'] = "album deleted successfully!";
    $_SESSION['message_type'] = "success";

    header("Location: album.php");
    exit;
}

// add logics
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $artist = (int) $_POST['artist'];
    $genre = (int) $_POST['genre'];
    $language = (int) $_POST['language'];
    $year = (int) $_POST['year'];


    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('album_') . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../media/' . $image_name);
    }

    mysqli_query(
        $con,
        "INSERT INTO albums (album_name, artist_id, genre_id, language_id, release_year, image)
         VALUES ('$name', $artist, $genre, $language, $year, '" . ($image_name ? $image_name : '') . "')"
    );


    echo "<script>window.location.href='album.php';</script>";
    exit;
}

// update logics
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $artist = (int) $_POST['artist'];
    $genre = (int) $_POST['genre'];
    $language = (int) $_POST['language'];
    $year = (int) $_POST['year'];


    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {

        $res = mysqli_query($con, "SELECT image FROM albums WHERE id=$id");
        $row = mysqli_fetch_assoc($res);
        if ($row && $row['image'] && file_exists('../media/' . $row['image'])) {
            unlink('../media/' . $row['image']);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('album_') . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../media/' . $image_name);
        $img_sql = ", image='$image_name'";
    } else {
        $img_sql = "";
    }

    mysqli_query(
        $con,
        "UPDATE albums SET
            album_name='$name',
            artist_id=$artist,
            genre_id=$genre,
            language_id=$language,
            release_year=$year
            $img_sql
         WHERE id=$id"
    );
    echo "<script>window.location.href='album.php';</script>";
    exit;
}


$edit_album = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $res = mysqli_query($con, "SELECT * FROM albums WHERE id=$id");
    $edit_album = mysqli_fetch_assoc($res);
}


$albums = mysqli_query(
    $con,
    "SELECT albums.*, artists.artist_name, genres.genre_name, languages.language_name
     FROM albums
     LEFT JOIN artists ON albums.artist_id=artists.id
     LEFT JOIN genres  ON albums.genre_id=genres.id
     LEFT JOIN languages ON albums.language_id=languages.id
     ORDER BY albums.id DESC"
);

// Fetch artists, genres, languages for forms
$artists = mysqli_query($con, "SELECT * FROM artists ORDER BY artist_name ASC");
$genres = mysqli_query($con, "SELECT * FROM genres ORDER BY genre_name ASC");
$languages = mysqli_query($con, "SELECT * FROM languages ORDER BY language_name ASC");

?>


<?php include './base/header.php'; ?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-4">
            <h2>🎵 Albums</h2>

            <!-- Add/Edit Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><?= $edit_album ? 'Edit Album' : 'Add New Album' ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <?php if ($edit_album): ?>
                            <input type="hidden" name="id" value="<?= $edit_album['id'] ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Album Name</label>
                            <input type="text" name="name" class="form-control" required
                                value="<?= $edit_album ? htmlspecialchars($edit_album['album_name']) : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Artist</label>
                            <select name="artist" class="form-select" required>
                                <option value="">Select Artist</option>
                                <?php mysqli_data_seek($artists, 0);
                                while ($a = mysqli_fetch_assoc($artists)): ?>
                                    <option value="<?= $a['id'] ?>" <?= $edit_album && $edit_album['artist_id'] == $a['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($a['artist_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Genre</label>
                            <select name="genre" class="form-select" required>
                                <option value="">Select Genre</option>
                                <?php mysqli_data_seek($genres, 0);
                                while ($g = mysqli_fetch_assoc($genres)): ?>
                                    <option value="<?= $g['id'] ?>" <?= $edit_album && $edit_album['genre_id'] == $g['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($g['genre_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Language</label>
                            <select name="language" class="form-select" required>
                                <option value="">Select Language</option>
                                <?php mysqli_data_seek($languages, 0);
                                while ($l = mysqli_fetch_assoc($languages)): ?>
                                    <option value="<?= $l['id'] ?>" <?= $edit_album && $edit_album['language_id'] == $l['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($l['language_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Release Year</label>
                            <select name="year" class="form-select" required>
                                <option value="">Select Year</option>
                                <?php
                                $currentYear = date('Y');
                                for ($y = $currentYear; $y >= 1950; $y--) {
                                    $selected = ($edit_album && $edit_album['release_year'] == $y) ? 'selected' : '';
                                    echo "<option value='$y' $selected>$y</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Album Image</label>
                            <input type="file" name="image" class="form-control" required>
                            <?php if ($edit_album && $edit_album['image']): ?>
                                <img src="../media/<?= htmlspecialchars($edit_album['image']) ?>" alt="Album Image"
                                    style="height:100px;margin-top:10px;">
                            <?php endif; ?>
                        </div>

                        <button type="submit" name="<?= $edit_album ? 'update' : 'add' ?>" class="btn btn-primary">
                            <?= $edit_album ? 'Update Album' : 'Add Album' ?>
                        </button>
                        <?php if ($edit_album): ?>
                            <a href="album.php" class="btn btn-secondary ms-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Albums Table -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover justify-content-center align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Album Name</th>
                                <th>Artist</th>
                                <th>Genre</th>
                                <th>Language</th>
                                <th>Release Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($r = mysqli_fetch_assoc($albums)): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <?php if ($r['image'] && file_exists('../media/' . $r['image'])): ?>
                                            <img src="../media/<?= htmlspecialchars($r['image']) ?>" alt="Album Image" style="height:50px;">
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($r['album_name']) ?></td>
                                    <td><?= htmlspecialchars($r['artist_name']) ?></td>
                                    <td><?= htmlspecialchars($r['genre_name']) ?></td>
                                    <td><?= htmlspecialchars($r['language_name']) ?></td>
                                    <td><?= htmlspecialchars($r['release_year']) ?></td>
                                    <td>
                                        <a href="?edit=<?= $r['id'] ?>" class="btn btn-sm btn-dark">
                                            <i class="ri-pencil-line"></i> Edit
                                        </a>

                                        <a href="?delete=<?= $r['id'] ?>"
                                            class="btn btn-sm btn-danger delete-btn"
                                            onclick="return confirm('Are you sure you want to delete this album.');">
                                            <i class="ri-delete-bin-line"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php if (mysqli_num_rows($albums) == 0): ?>
                        <p class="text-center mt-3">No albums found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './base/footer.php'; ?>