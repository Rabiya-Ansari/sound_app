<?php
include "./config/db_connection.php";

$search = "";

// Search filter
if (isset($_GET['query']) && trim($_GET['query']) != "") {
    $search = mysqli_real_escape_string($con, $_GET['query']);

    $where = "WHERE 
        videos.title LIKE '%$search%' OR
        artists.artist_name LIKE '%$search%' OR
        videos.release_year LIKE '%$search%'";
} else {
    $where = "";
}

// Fetch videos with artist info
$videos = mysqli_query($con, "
    SELECT 
        videos.*, 
        artists.artist_name,
        artists.artist_image
    FROM videos
    LEFT JOIN artists ON artists.id = videos.artist_id
    $where
    ORDER BY videos.id DESC
");

include 'base/header.php';
?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="#"><i class="fa fa-home"></i> Home</a>
                    <span>Videos</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Video Section Begin -->
<section class="videos spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title center-title">
                    <h2>YouTube feed</h2>
                    <h1>Latest videos</h1>
                </div>

                <!-- Featured Video: Latest Video -->
                <?php if($row = mysqli_fetch_assoc($videos)) : ?>
                <div class="videos__large__item set-bg" data-setbg="https://img.youtube.com/vi/<?php echo getYouTubeID($row['video_file']); ?>/hqdefault.jpg">
                    <a href="<?php echo $row['video_file']; ?>" class="play-btn video-popup">
                        <i class="fa fa-play"></i>
                    </a>
                    <div class="videos__large__item__text">
                        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                        <ul>
                            <li><?php echo $row['release_year']; ?></li>
                        </ul>
                        <p>By <?php echo htmlspecialchars($row['artist_name']); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Slider Videos -->
                <div class="row">
                    <div class="videos__slider owl-carousel">
                        <?php
                        // Reset pointer if featured video was used
                        if($row) mysqli_data_seek($videos, 0);

                        while($video = mysqli_fetch_assoc($videos)) :
                        ?>
                        <div class="col-lg-3">
                            <div class="videos__item">
                                <div class="videos__item__pic set-bg" data-setbg="https://img.youtube.com/vi/<?php echo getYouTubeID($video['video_file']); ?>/mqdefault.jpg">
                                    <a href="<?php echo $video['video_file']; ?>" class="play-btn video-popup">
                                        <i class="fa fa-play"></i>
                                    </a>
                                </div>
                                <div class="videos__item__text">
                                    <h5><?php echo htmlspecialchars($video['title']); ?></h5>
                                    <ul>
                                        <li><?php echo $video['release_year']; ?></li>
                                        <li>By <?php echo htmlspecialchars($video['artist_name']); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Video Section End -->

<!-- Magnific Popup Initialization -->
<script>
$(document).ready(function () {
    $('.video-popup').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
});
</script>

<?php include 'base/footer.php'; ?>

<?php
// Helper function to extract YouTube ID from URL
function getYouTubeID($url) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
    return $matches[1] ?? '';
}
?>
