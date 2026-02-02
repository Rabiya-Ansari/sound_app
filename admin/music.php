<?php
include "./auth.php";
include "../config/db_connection.php";

/* =====================
   DELETE MUSIC
===================== */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $res = mysqli_query($con, "SELECT music_file FROM musics WHERE id=$id");
    $row = mysqli_fetch_assoc($res);

    if ($row && file_exists("../media/" . $row['music_file'])) {
        unlink("../media/" . $row['music_file']);
    }

    mysqli_query($con, "DELETE FROM musics WHERE id=$id");
    header("Location: music.php");
    exit;
}

/* =====================
   ADD MUSIC
===================== */
if (isset($_POST['add_music'])) {

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $artist = (int) $_POST['artist'];
    $album = (int) $_POST['album'];
    $year = (int) $_POST['year'];

    $file = $_FILES['music_file']['name'];
    $tmp = $_FILES['music_file']['tmp_name'];

    $folder = "../media/";
    if (!is_dir($folder))
        mkdir($folder, 0777, true);

    $new_name = time() . "_" . $file;

    if (move_uploaded_file($tmp, $folder . $new_name)) {
        mysqli_query($con, "
            INSERT INTO musics (title, artist_id, album_id, release_year, music_file)
            VALUES ('$title','$artist','$album','$year','$new_name')
        ");
        header("Location: music.php");
        exit;
    }
}

//fetch logics
$musics = mysqli_query($con, "
    SELECT musics.*, artists.artist_name, albums.album_name
    FROM musics
    LEFT JOIN artists ON artists.id = musics.artist_id
    LEFT JOIN albums ON albums.id = musics.album_id
    ORDER BY musics.id DESC
");

$years_res = mysqli_query($con, "SELECT * FROM years ORDER BY release_year DESC");
?>


<?php include "./base/header.php"; ?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-4">

            <div class="card mb-4">
                <div class="card-header">
                    <h4>➕ Add New Music</h4>
                </div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label>Music Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Artist</label>
                                <select name="artist" class="form-select" required>
                                    <option value="">Select Artist</option>
                                    <?php
                                    $a = mysqli_query($con, "SELECT * FROM artists");
                                    while ($r = mysqli_fetch_assoc($a)) {
                                        echo "<option value='{$r['id']}'>{$r['artist_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Album</label>
                                <select name="album" class="form-select">
                                    <option value="0">Select Album</option>
                                    <?php
                                    $al = mysqli_query($con, "SELECT * FROM albums");
                                    while ($r = mysqli_fetch_assoc($al)) {
                                        echo "<option value='{$r['id']}'>{$r['album_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Release Year</label>
                                <select name="year" class="form-select" required>
                                    <option value="">Select Year</option>
                                    <?php
                                    while ($y = mysqli_fetch_assoc($years_res)) {
                                        echo "<option value='{$y['release_year']}'>{$y['release_year']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Music File</label>
                                <input type="file" name="music_file" class="form-control" required>
                            </div>
                        </div>

                        <button name="add_music" class="btn btn-primary">
                            Add Music
                        </button>

                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>🎵 All Songs</h4>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Album</th>
                                <th>Year</th>
                                <th>Play</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = 1;
                            while ($m = mysqli_fetch_assoc($musics)) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($m['title']) ?></td>
                                    <td><?= $m['artist_name'] ?? '-' ?></td>
                                    <td><?= $m['album_name'] ?? '-' ?></td>
                                    <td><?= $m['release_year'] ?></td>
                                    <td>
                                        <audio controls style="width:180px">
                                            <source src="../media/<?= $m['music_file'] ?>">
                                        </audio>
                                    </td>
                                    <td>
                                        <a href="?delete=<?= $m['id'] ?>" onclick="return confirm('Delete this song?')"
                                            class="btn btn-sm btn-danger">
                                            🗑
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "./base/footer.php"; ?>