<?php
include "./config/db_connection.php";

$search = "";
$where = "";

/* SEARCH FILTER */
if (!empty($_GET['query'])) {

    $search = mysqli_real_escape_string($con, trim($_GET['query']));

    $where = " WHERE 
        videos.title LIKE '%$search%' OR
        artists.artist_name LIKE '%$search%' OR
        videos.release_year LIKE '%$search%' ";
}

/* FETCH VIDEOS */
$sql = "
    SELECT 
        videos.id,
        videos.title,
        videos.release_year,
        videos.video_file,
        IFNULL(artists.artist_name, 'Unknown Artist') AS artist_name
    FROM videos
    LEFT JOIN artists ON artists.id = videos.artist_id
    $where
    ORDER BY videos.id DESC
";

$videos = mysqli_query($con, $sql);

include 'base/header.php';
?>

<section class="videos spad">
    <div class="container">

        <!-- Title -->
        <div class="text-center mb-4">
            <h2 style="color:#6f42c1;">Video Collection</h2>
            <h1>All Videos</h1>
        </div>
        <div class="row mb-5">
            <div class="col-lg-6 mx-auto">
                <form id="searchForm" method="GET" action="videos.php">
                    <div style="display:flex; border:2px solid #6f42c1;">
                        <input type="text" name="query" placeholder="Search Video, Artist, Year..."
                            style="flex:1; padding:10px; border:none; outline:none;"
                            value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
                        <button type="submit" style="background:#6f42c1; color:white; border:none; padding:10px 20px;">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Video Cards -->
        <div class="row">
            <?php if (mysqli_num_rows($videos) > 0): ?>
                <?php while ($video = mysqli_fetch_assoc($videos)): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card " style="border:1px solid #6f42c1; box-shadow: 0 5px 15px #6f42c1; cursor:pointer;"
                            onclick="openVideo('<?= htmlspecialchars($video['video_file']) ?>')" data-toggle="modal"
                            data-target="#videoModal">
                            <div
                                style="height:220px; overflow:hidden; background:#f8f9fa; display:flex; align-items:center; justify-content:center;">
                                <?php if (file_exists("media/" . $video['video_file'])): ?>
                                    <video width="100%" height="220" muted playsinline style="object-fit:cover;">
                                        <source src="media/<?= htmlspecialchars($video['video_file']) ?>" type="video/mp4">
                                    </video>
                                <?php else: ?>
                                    <span style="font-size:40px; color:#6f42c1;">
                                        <i class="fa fa-play-circle"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body text-center">

                                <h5><?= htmlspecialchars($video['title']) ?></h5>

                                <p><strong>Artist:</strong>
                                    <?= htmlspecialchars($video['artist_name']) ?>
                                </p>

                                <p><strong>Year:</strong>
                                    <?= htmlspecialchars($video['release_year']) ?>
                                </p>

                                <a href="give-review.php?type=video&id=<?= $video['id'] ?>" class="btn btn-sm mt-2 hover-purple"
                                    style="font-weight:bold;">
                                    Give Review
                                </a>

                            </div>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <h4>No Videos Found</h4>
                </div>
            <?php endif; ?>
        </div>


    </div>
</section>

<!-- VIDEO MODAL -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:#6f42c1; color:white;">
                <h5 class="modal-title">Video Player</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center" id="videoContainer"></div>
        </div>
    </div>
</div>

<script>
    function openVideo(filename) {

        var container = document.getElementById("videoContainer");

        if (filename && filename.endsWith(".mp4")) {

            container.innerHTML =
                '<video width="100%" height="400" controls autoplay>' +
                '<source src="media/' + filename + '" type="video/mp4">' +
                'Your browser does not support the video tag.' +
                '</video>';

        } else {

            container.innerHTML =
                '<p style="color:red;">Video file not found.</p>';
        }
    }

    $('#videoModal').on('hidden.bs.modal', function () {
        $('#videoContainer').html('');
    });
</script>
<script>
    if (window.location.search.length > 0) {

        if (!window.location.hash.includes("searched")) {
            window.history.replaceState({}, document.title, "videos.php");
        }
    }
    document.getElementById("searchForm").addEventListener("submit", function () {
        window.location.hash = "searched";
    });
</script>

<?php include 'base/footer.php'; ?>