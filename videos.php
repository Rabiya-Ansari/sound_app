<?php
include "./config/db_connection.php";

$search = "";
$where = "";

if (isset($_GET['query']) && trim($_GET['query']) != "") {
    $search = mysqli_real_escape_string($con, $_GET['query']);
    $where = "WHERE 
        videos.title LIKE '%$search%' OR
        artists.artist_name LIKE '%$search%' OR
        videos.release_year LIKE '%$search%'";
}

// Check if query exists in GET
if (isset($_GET['query']) && trim($_GET['query']) != "") {
    $search = mysqli_real_escape_string($con, $_GET['query']);
    $where = "WHERE 
        videos.title LIKE '%$search%' OR
        artists.artist_name LIKE '%$search%' OR
        videos.release_year LIKE '%$search%'";
}

// Fetch videos
$videos = mysqli_query($con, "
    SELECT 
        videos.*, 
        artists.artist_name
    FROM videos
    LEFT JOIN artists ON artists.id = videos.artist_id
    $where
    ORDER BY videos.id DESC
");

include 'base/header.php';
?>


<section class="videos spad">
    <div class="container">

        <!-- Title -->
        <div class="text-center mb-4">
            <h2 style="color:#6f42c1;">Video Collection</h2>
            <h1>All Videos</h1>
        </div>

        <!-- Search Box -->
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
                        <div class="card shadow-sm" style="border:1px solid #6f42c1; cursor:pointer;"
                            onclick="openVideo('<?= $video['video_file'] ?>')" data-toggle="modal" data-target="#videoModal">

                            <div
                                style="height:220px; display:flex; align-items:center; justify-content:center; background:#f8f9fa;">
                                <span style="font-size:40px; color:#6f42c1;">
                                    <i class="fa fa-play-circle"></i>
                                </span>
                            </div>

                            <div class="card-body text-center">
                                <h5><?= htmlspecialchars($video['title']) ?></h5>
                                <p><strong>Artist:</strong> <?= htmlspecialchars($video['artist_name']) ?></p>
                                <p><strong>Year:</strong> <?= $video['release_year'] ?></p>
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

<!-- MODAL -->
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
    function openVideo(url) {
        var container = document.getElementById("videoContainer");

        // Only play MP4 videos
        if (url.endsWith(".mp4")) {
            container.innerHTML =
                '<video width="100%" height="400" controls autoplay>' +
                '<source src="' + url + '" type="video/mp4">' +
                '</video>';
        } else {
            container.innerHTML =
                '<p style="color:red;">This video format is not supported.</p>';
        }
    }

    // Stop video when modal closes
    $('#videoModal').on('hidden.bs.modal', function () {
        $('#videoContainer').html('');
    });
</script>
<script>
    // Automatically remove query params on page refresh
    if (window.location.search.length > 0) {
        // Only remove if page is loaded without submitting form
        if (!window.location.hash.includes("searched")) {
            window.history.replaceState({}, document.title, "videos.php");
        }
    }

    // Optional: mark URL when search is performed
    document.getElementById("searchForm").addEventListener("submit", function () {
        window.location.hash = "searched";
    });
</script>

<?php include 'base/footer.php'; ?>