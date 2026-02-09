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

    // ✅ Set flash message
    $_SESSION['message'] = "Music deleted successfully!";
    $_SESSION['message_type'] = "success";

    header("Location: music.php");
    exit;
}

/* =====================
   FETCH MUSIC FOR EDIT
===================== */
$edit_music = null;
if (isset($_GET['edit'])) {
    $edit_id = (int) $_GET['edit'];
    $res = mysqli_query($con, "SELECT * FROM musics WHERE id=$edit_id LIMIT 1");
    $edit_music = mysqli_fetch_assoc($res);
}

/* =====================
   ADD / UPDATE MUSIC
===================== */
if (isset($_POST['save_music'])) {

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $artist = (int) $_POST['artist'];
    $year = (int) $_POST['year'];
    $language = (int) $_POST['language'];
    $genre = (int) $_POST['genre'];

    $folder = "../media/";

    // check if editing
    if (!empty($_POST['id'])) {
        $id = (int) $_POST['id'];

        if (!empty($_FILES['music_file']['name'])) {
            $file = $_FILES['music_file']['name'];
            $tmp = $_FILES['music_file']['tmp_name'];
            $new_name = time() . "_" . $file;
            if (!is_dir($folder)) mkdir($folder, 0777, true);

            // delete old file
            $old_res = mysqli_query($con, "SELECT music_file FROM musics WHERE id=$id");
            $old_row = mysqli_fetch_assoc($old_res);
            if ($old_row && file_exists($folder . $old_row['music_file'])) {
                unlink($folder . $old_row['music_file']);
            }

            move_uploaded_file($tmp, $folder . $new_name);
        } else {
            $new_name = $edit_music['music_file'];
        }

        mysqli_query($con, "
            UPDATE musics SET
                title='$title',
                artist_id=$artist,
                release_year=$year,
                language_id=$language,
                genre_id=$genre,
                music_file='$new_name'
            WHERE id=$id
        ");

       
        $_SESSION['message'] = "Music updated successfully!";
        $_SESSION['message_type'] = "success";

        header("Location: music.php");
        exit;

    } else {
        // add new music
        $file = $_FILES['music_file']['name'];
        $tmp = $_FILES['music_file']['tmp_name'];
        $new_name = time() . "_" . $file;
        if (!is_dir($folder)) mkdir($folder, 0777, true);
        move_uploaded_file($tmp, $folder . $new_name);

        mysqli_query($con, "
            INSERT INTO musics (title, artist_id, release_year, language_id, genre_id, music_file)
            VALUES ('$title', $artist, $year, $language, $genre, '$new_name')
        ");

       
        $_SESSION['message'] = "New music added successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: music.php");
        exit;
    }
}

/* =====================
   FETCH DATA
===================== */
$musics = mysqli_query($con, "
    SELECT musics.*, 
           artists.artist_name, 
           languages.language_name, 
           genres.genre_name
    FROM musics
    LEFT JOIN artists   ON artists.id = musics.artist_id
    LEFT JOIN languages ON languages.id = musics.language_id
    LEFT JOIN genres    ON genres.id = musics.genre_id
    ORDER BY musics.id DESC
");

$years_res = mysqli_query($con, "SELECT * FROM years ORDER BY release_year DESC");
$artists_res = mysqli_query($con, "SELECT * FROM artists ORDER BY artist_name ASC");
$languages_res = mysqli_query($con, "SELECT * FROM languages ORDER BY language_name ASC");
$genres_res = mysqli_query($con, "SELECT * FROM genres ORDER BY genre_name ASC");
?>

<?php include "./base/header.php"; ?>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<?php if(isset($_SESSION['message'])): ?>
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

            <!-- ADD / EDIT MUSIC FORM -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><?= $edit_music ? "✏️ Edit Music" : "➕ Add New Music" ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="id" value="<?= $edit_music['id'] ?? '' ?>">

                        <div class="mb-3">
                            <label>Music Title</label>
                            <input type="text" name="title" class="form-control" 
                                value="<?= htmlspecialchars($edit_music['title'] ?? '') ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>Artist</label>
                                <select name="artist" class="form-select" required>
                                    <option value="">Select Artist</option>
                                    <?php mysqli_data_seek($artists_res, 0); ?>
                                    <?php while ($a = mysqli_fetch_assoc($artists_res)) : ?>
                                        <option value="<?= $a['id'] ?>" 
                                            <?= isset($edit_music['artist_id']) && $edit_music['artist_id']==$a['id'] ? 'selected':'' ?>>
                                            <?= htmlspecialchars($a['artist_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Year</label>
                                <select name="year" class="form-select" required>
                                    <option value="">Select Year</option>
                                    <?php mysqli_data_seek($years_res, 0); ?>
                                    <?php while ($y = mysqli_fetch_assoc($years_res)) : ?>
                                        <option value="<?= $y['release_year'] ?>" 
                                            <?= isset($edit_music['release_year']) && $edit_music['release_year']==$y['release_year'] ? 'selected':'' ?>>
                                            <?= $y['release_year'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Language</label>
                                <select name="language" class="form-select" required>
                                    <option value="">Select Language</option>
                                    <?php mysqli_data_seek($languages_res, 0); ?>
                                    <?php while ($l = mysqli_fetch_assoc($languages_res)) : ?>
                                        <option value="<?= $l['id'] ?>" 
                                            <?= isset($edit_music['language_id']) && $edit_music['language_id']==$l['id'] ? 'selected':'' ?>>
                                            <?= htmlspecialchars($l['language_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Genre</label>
                                <select name="genre" class="form-select" required>
                                    <option value="">Select Genre</option>
                                    <?php mysqli_data_seek($genres_res, 0); ?>
                                    <?php while ($g = mysqli_fetch_assoc($genres_res)) : ?>
                                        <option value="<?= $g['id'] ?>" 
                                            <?= isset($edit_music['genre_id']) && $edit_music['genre_id']==$g['id'] ? 'selected':'' ?>>
                                            <?= htmlspecialchars($g['genre_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Music File <?= $edit_music ? "(Leave empty to keep current)" : "" ?></label>
                            <input type="file" name="music_file" class="form-control" <?= $edit_music ? '' : 'required' ?>>
                        </div>

                        <button name="save_music" class="btn btn-primary">
                            <?= $edit_music ? "Update Music" : "Add Music" ?>
                        </button>
                    </form>
                </div>
            </div>

            <!-- MUSIC LIST TABLE -->
            <div class="card">
                <div class="card-header">
                    <h4>🎵 All Songs</h4>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Year</th>
                                <th>Language</th>
                                <th>Genre</th>
                                <th>Play</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($m = mysqli_fetch_assoc($musics)) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($m['title']) ?></td>
                                    <td><?= htmlspecialchars($m['artist_name'] ?? '-') ?></td>
                                    <td><?= $m['release_year'] ?></td>
                                    <td><?= htmlspecialchars($m['language_name'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($m['genre_name'] ?? '-') ?></td>
                                    <td>
                                        <audio controls style="width:180px">
                                            <source src="../media/<?= $m['music_file'] ?>">
                                        </audio>
                                    </td>
                                    <td>
                                        <a href="?edit=<?= $m['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                                        <a href="?delete=<?= $m['id'] ?>" class="btn btn-sm btn-danger delete-btn" data-id="<?= $m['id'] ?>">🗑</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// SweetAlert delete confirmation
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        let id = this.dataset.id;
        Swal.fire({
            title: 'Are you sure?',
            text: "This song will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                window.location.href = '?delete=' + id;
            }
        });
    });
});
</script>

<?php include "./base/footer.php"; ?>
