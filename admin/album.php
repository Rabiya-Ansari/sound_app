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


    echo "<script>window.location.href='album.php';</script>";
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

// Fetch artists, genres, languages, years for forms
$artists = mysqli_query($con, "SELECT * FROM artists ORDER BY artist_name ASC");
$genres = mysqli_query($con, "SELECT * FROM genres ORDER BY genre_name ASC");
$languages = mysqli_query($con, "SELECT * FROM languages ORDER BY language_name ASC");
$years_res = mysqli_query($con, "SELECT * FROM years ORDER BY release_year DESC");

?>


<?php include './base/header.php'; ?>

<div class="card shadow-sm">
    <div class="card-body">

        <!-- Responsive wrapper -->
        <div class="table-responsive-lg">
            <table class="table table-hover align-middle text-nowrap">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Album Name</th>
                        <th>Artist</th>
                        <th class="d-none d-md-table-cell">Genre</th>
                        <th class="d-none d-md-table-cell">Language</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; while ($r = mysqli_fetch_assoc($albums)): ?>
                        <tr>
                            <td><?= $i++ ?></td>

                            <td>
                                <?php if ($r['image'] && file_exists('../media/' . $r['image'])): ?>
                                    <img src="../media/<?= htmlspecialchars($r['image']) ?>"
                                         class="img-fluid rounded"
                                         style="max-height:50px; width:auto;">
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($r['album_name']) ?></td>
                            <td><?= htmlspecialchars($r['artist_name']) ?></td>

                            <td class="d-none d-md-table-cell">
                                <?= htmlspecialchars($r['genre_name']) ?>
                            </td>

                            <td class="d-none d-md-table-cell">
                                <?= htmlspecialchars($r['language_name']) ?>
                            </td>

                            <td><?= htmlspecialchars($r['release_year']) ?></td>

                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <a href="?edit=<?= $r['id'] ?>"
                                       class="btn btn-sm btn-warning">
                                        <i class="ri-edit-line"></i>
                                    </a>

                                    <a href="?delete=<?= $r['id'] ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this album?');">
                                        <i class="ri-delete-bin-line"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if (mysqli_num_rows($albums) == 0): ?>
                <p class="text-center text-muted mt-3">No albums found.</p>
            <?php endif; ?>
        </div>

    </div>
</div>


<?php include './base/footer.php'; ?>