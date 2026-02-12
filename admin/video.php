<?php
include "./auth.php";
include '../config/db_connection.php';

$editData = null;

/* =====================
   DELETE
===================== */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $res = mysqli_query($con, "SELECT video_file FROM videos WHERE id=$id");
    $row = mysqli_fetch_assoc($res);

    if ($row && file_exists("../media/" . $row['video_file'])) {
        unlink("../media/" . $row['video_file']);
    }

    mysqli_query($con, "DELETE FROM videos WHERE id=$id");

    $_SESSION['message'] = "video deleted successfully!";
    $_SESSION['message_type'] = "success";

    header("Location: video.php");
    exit;
}

/* =====================
   FETCH EDIT DATA
===================== */
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    $res = mysqli_query($con, "SELECT * FROM videos WHERE id=$id");
    $editData = mysqli_fetch_assoc($res);
}

/* =====================
   ADD VIDEO
===================== */
if (isset($_POST['add_video'])) {

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $artist = (int) $_POST['artist'];
    $genre = (int) $_POST['genre'];
    $language = (int) $_POST['language'];
    $year = (int) $_POST['year'];

    $file = $_FILES['video_file']['name'];
    $tmp = $_FILES['video_file']['tmp_name'];

    $folder = "../media/";
    if (!is_dir($folder)) mkdir($folder, 0777, true);

    $new_name = time() . "_" . $file;

    if (move_uploaded_file($tmp, $folder . $new_name)) {

        mysqli_query($con, "
            INSERT INTO videos (title, artist_id, genre_id, language_id, release_year, video_file)
            VALUES ('$title','$artist','$genre','$language','$year','$new_name')
        ");

        $_SESSION['message'] = "New video added successfully!";
        $_SESSION['message_type'] = "success";

        header("Location: video.php");
        exit;
    }
}

/* =====================
   UPDATE VIDEO
===================== */
if (isset($_POST['update_video'])) {

    $id = (int) $_POST['id'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $artist = (int) $_POST['artist'];
    $genre = (int) $_POST['genre'];
    $language = (int) $_POST['language'];
    $year = (int) $_POST['year'];

    mysqli_query($con, "
        UPDATE videos SET
        title='$title',
        artist_id='$artist',
        genre_id='$genre',
        language_id='$language',
        release_year='$year'
        WHERE id=$id
    ");

    $_SESSION['message'] = "Video updated successfully!";
    $_SESSION['message_type'] = "success";

    header("Location: video.php");
    exit;
}
/* =====================
   FETCH SELECT DATA
===================== */
$artists = mysqli_query($con, "SELECT * FROM artists");
$genres = mysqli_query($con, "SELECT * FROM genres");
$languages = mysqli_query($con, "SELECT * FROM languages");
$years_res = mysqli_query($con, "SELECT * FROM years ORDER BY release_year DESC");


/* =====================
   FETCH VIDEOS
===================== */
$videos = mysqli_query($con, "
    SELECT videos.*, artists.artist_name, genres.genre_name, languages.language_name
    FROM videos
    LEFT JOIN artists ON artists.id = videos.artist_id
    LEFT JOIN genres ON genres.id = videos.genre_id
    LEFT JOIN languages ON languages.id = videos.language_id
    ORDER BY videos.id DESC
");
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
            <!-- ADD VIDEO FORM -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>➕ Add New Video</h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">

                        <?php if ($editData): ?>
                            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label>Video Title</label>
                            <input type="text" name="title" class="form-control"
                                value="<?= $editData['title'] ?? '' ?>" required>
                        </div>
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label>Artist</label>
                                <select name="artist" class="form-select" required>
                                    <option value="">Select Artist</option>
                                    <?php while ($a = mysqli_fetch_assoc($artists)) { ?>
                                        <option value="<?= $a['id'] ?>"
                                            <?= ($editData && $editData['artist_id'] == $a['id']) ? 'selected' : '' ?>>
                                            <?= $a['artist_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Genre</label>
                                <select name="genre" class="form-select" required>
                                    <option value="">Select Genre</option>
                                    <?php while ($g = mysqli_fetch_assoc($genres)) { ?>
                                        <option value="<?= $g['id'] ?>"
                                            <?= ($editData && $editData['genre_id'] == $g['id']) ? 'selected' : '' ?>>
                                            <?= $g['genre_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Language</label>
                                <select name="language" class="form-select" required>
                                    <option value="">Select Language</option>
                                    <?php while ($l = mysqli_fetch_assoc($languages)) { ?>
                                        <option value="<?= $l['id'] ?>"
                                            <?= ($editData && $editData['language_id'] == $l['id']) ? 'selected' : '' ?>>
                                            <?= $l['language_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Year</label>
                            <select name="year" class="form-select" required>
                                <option value="">Select Year</option>
                                <?php while ($y = mysqli_fetch_assoc($years_res)) { ?>
                                    <option value="<?= $y['release_year'] ?>"
                                        <?= ($editData && $editData['release_year'] == $y['release_year']) ? 'selected' : '' ?>>
                                        <?= $y['release_year'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <?php if (!$editData): ?>
                            <div class="mb-3">
                                <label>Video File</label>
                                <input type="file" name="video_file" class="form-control" required>
                            </div>
                        <?php endif; ?>

                        <button class="btn btn-primary"
                            name="<?= $editData ? 'update_video' : 'add_video' ?>">
                            <?= $editData ? 'Update Video' : 'Add Video' ?>
                        </button>

                    </form>

                </div>
            </div>

            <!-- LIST ALL VIDEOS -->
            <div class="card">
                <div class="card-header">
                    <h4>🎬 All Videos</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover justify-content-center align-middle text-center table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Video</th>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Genre</th>
                                <th>Language</th>
                                <th>Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($v = mysqli_fetch_assoc($videos)) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <?php $path = "../media/" . $v['video_file']; ?>
                                        <?php if (!empty($v['video_file']) && file_exists($path)): ?>
                                            <video width="150" style="cursor:pointer" onclick="openVideoModal('<?= $path ?>')" muted preload="metadata">
                                                <source src="<?= $path ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php else: ?>
                                            <span class="text-muted">No video</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($v['title']) ?></td>
                                    <td><?= $v['artist_name'] ?? '-' ?></td>
                                    <td><?= $v['genre_name'] ?? '-' ?></td>
                                    <td><?= $v['language_name'] ?? '-' ?></td>
                                    <td><?= $v['release_year'] ?></td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="video.php?edit=<?= $v['id'] ?>" class="btn btn-sm btn-dark">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            <a href="?delete=<?= $v['id'] ?>"
                                                class="btn btn-sm btn-danger delete-btn"
                                                data-id="<?= $v['id'] ?>"
                                                title="Delete"
                                                aria-label="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </div>
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

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🎬 Video Player</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <video id="modalVideo" width="100%" controls autoplay>
                    <source src="" type="video/mp4">
                </video>
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
                text: "This video will be deleted!",
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

    function openVideoModal(videoPath) {
        let video = document.getElementById('modalVideo');
        video.src = videoPath;
        video.load();

        let modal = new bootstrap.Modal(document.getElementById('videoModal'));
        modal.show();
    }
    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
        let video = document.getElementById('modalVideo');
        video.pause();
        video.currentTime = 0;
        video.src = "";
    });
</script>

<?php include './base/footer.php' ?>

