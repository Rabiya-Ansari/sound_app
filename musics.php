<?php
include "./config/db_connection.php";

$search = "";
$where = "";

// Handle search query
if (isset($_GET['query']) && trim($_GET['query']) != "") {
    $search = mysqli_real_escape_string($con, $_GET['query']);

    $where = "WHERE 
        musics.title LIKE '%$search%' OR
        artists.artist_name LIKE '%$search%' OR
        albums.album_name LIKE '%$search%' OR
        musics.release_year LIKE '%$search%'";
}

// Fetch tracks with artist, image, album, and search applied
$tracks = mysqli_query($con, "
    SELECT 
        musics.*, 
        artists.artist_name,
        artists.artist_image,
        albums.album_name
    FROM musics
    LEFT JOIN artists ON artists.id = musics.artist_id
    LEFT JOIN albums ON albums.id = musics.album_id
    $where
    ORDER BY musics.id DESC
");

include './base/header.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="container mt-5 mb-5">
    <div class="text-center mb-4">
        <h2 style="color:#6f42c1;">Musics Collection</h2>
        <h1>All Musics</h1>
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <div class="row mb-5">
            <div class="col-lg-6 mx-auto">
                <form id="searchForm" method="GET" action="musics.php">
                    <div style="display:flex; border:2px solid #6f42c1;">
                        <input type="text" name="query" value="<?= htmlspecialchars($search) ?>"
                            placeholder="Search Music, Artist, Year..."
                            style="flex:1; padding:10px; border:none; outline:none;">
                        <button type="submit" style="background:#6f42c1; color:white; border:none; padding:10px 20px;">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Music Cards -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (mysqli_num_rows($tracks) > 0): ?>
            <?php while ($m = mysqli_fetch_assoc($tracks)): ?>
                <div class="col d-flex">
                    <div class="card flex-fill p-3" style="border: 1px solid lightslategray; box-shadow: 0 5px 15px #6f42c1;">

                        <div class="d-flex align-items-center mb-2">
                            <?php if (!empty($m['artist_image']) && file_exists("media/" . $m['artist_image'])): ?>
                                <img src="media/<?= htmlspecialchars($m['artist_image']) ?>" width="40" height="40"
                                    class="rounded-circle me-2">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/40x40" width="40" height="40" class="rounded-circle me-2">
                            <?php endif; ?>

                            <strong><?= htmlspecialchars($m['artist_name'] ?? 'Unknown Artist') ?></strong>
                        </div>

                        <h6 class="card-title"><?= htmlspecialchars($m['title']) ?></h6>

                        <small class="text-muted">
                            <?= htmlspecialchars($m['album_name'] ?? '') ?>
                            <?php if (!empty($m['release_year'])): ?>
                                Year| <?= htmlspecialchars($m['release_year']) ?>
                            <?php endif; ?>
                        </small>

                        <div class="mini-progress mt-3" data-id="<?= $m['id'] ?>">
                            <div class="mini-bar"></div>
                        </div>

                        <button class="select-track btn btn-sm mt-3 text-white" style="background:#6f42c1;"
                            data-id="<?= $m['id'] ?>" data-url="media/<?= htmlspecialchars($m['music_file']) ?>"
                            data-title="<?= htmlspecialchars($m['title']) ?>"
                            data-artist="<?= htmlspecialchars($m['artist_name'] ?? 'Unknown Artist') ?>">
                            <i class="fa-solid fa-play"></i> Play
                        </button>

                        <a href="give-review.php?type=music&id=<?= $m['id'] ?>" class="btn btn-sm mt-2 hover-purple"
                            style="font:bold;">
                            Give Review
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h4 style="color:#6f42c1;">No Musics Found</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- GLOBAL PLAYER -->
<div class="fixed-bottom glass-player text-white p-3 d-flex align-items-center justify-content-between border-top border-purple-light"
    style="background: rgba(106, 13, 173, 0.55); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
     border-top: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 -5px 25px rgba(0,0,0,0.2);">

    <div class="player-info">
        <strong id="player-title" class="text-purple-accent">Select a track</strong><br>
        <small id="player-artist" class="opacity-75"></small>
    </div>

    <div class="d-flex align-items-center gap-3 flex-fill mx-4">
        <button id="play-pause" class="btn btn-purple-glow rounded-circle shadow-sm">
            <i class="fa-solid fa-play"></i>
        </button>

        <span id="current-time" class="small fw-bold">0:00</span>

        <div class="flex-fill">
            <div class="jp-seek-bar custom-slider" id="main-seek">
                <div class="jp-play-bar" id="main-bar"></div>
            </div>
        </div>

        <span id="duration" class="small fw-bold">0:00</span>
    </div>

    <div style="width:150px;" class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-volume-high text-purple-accent"></i>
        <div class="jp-seek-bar custom-slider" id="volume-bar">
            <div class="jp-play-bar" id="volume-fill" style="width:100%"></div>
        </div>
    </div>
</div>

<script>

    if (window.location.search.length > 0) {
        if (!window.location.hash.includes("searched")) {
            window.history.replaceState({}, document.title, "musics.php");
        }
    }

    document.getElementById("searchForm").addEventListener("submit", function () {
        window.location.hash = "searched";
    });

    // ======= AUDIO PLAYER LOGIC =======
    let audio = new Audio();
    audio.volume = 1;
    let currentCardID = null;
    let isDragging = false;

    const playPauseBtn = document.getElementById('play-pause');
    const playIcon = playPauseBtn.querySelector('i');
    const mainBar = document.getElementById('main-bar');
    const mainSeek = document.getElementById('main-seek');
    const volumeBar = document.getElementById('volume-bar');
    const volumeFill = document.getElementById('volume-fill');
    const volumeIcon = document.querySelector('.fa-volume-high');

    document.querySelectorAll('.select-track').forEach(btn => {
        btn.addEventListener('click', () => {
            audio.src = btn.dataset.url;
            audio.play();

            document.getElementById('player-title').textContent = btn.dataset.title;
            document.getElementById('player-artist').textContent = btn.dataset.artist;

            currentCardID = btn.dataset.id;
        });
    });

    playPauseBtn.onclick = () => {
        if (!audio.src) return;
        audio.paused ? audio.play() : audio.pause();
    };

    audio.addEventListener('play', () => playIcon.classList.replace('fa-play', 'fa-pause'));
    audio.addEventListener('pause', () => playIcon.classList.replace('fa-pause', 'fa-play'));

    audio.addEventListener('timeupdate', () => {
        if (isDragging) return;
        let current = audio.currentTime;
        let duration = audio.duration || 0;

        document.getElementById('current-time').textContent = format(current);
        document.getElementById('duration').textContent = format(duration);

        let percent = duration ? (current / duration) * 100 : 0;
        mainBar.style.width = percent + '%';

        if (currentCardID) {
            let cardBar = document.querySelector(`.mini-progress[data-id="${currentCardID}"] .mini-bar`);
            if (cardBar) cardBar.style.width = percent + '%';
        }
    });

    mainSeek.addEventListener('mousedown', () => isDragging = true);
    document.addEventListener('mouseup', () => isDragging = false);

    mainSeek.addEventListener('mousemove', e => {
        if (!isDragging || !audio.duration) return;
        let rect = mainSeek.getBoundingClientRect();
        let percent = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
        mainBar.style.width = (percent * 100) + '%';
        audio.currentTime = percent * audio.duration;
    });

    volumeBar.addEventListener('click', e => {
        let rect = volumeBar.getBoundingClientRect();
        let percent = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
        audio.volume = percent;
        volumeFill.style.width = (percent * 100) + '%';
    });

    volumeIcon.addEventListener('click', () => {
        audio.muted = !audio.muted;
        if (audio.muted) {
            volumeIcon.classList.replace('fa-volume-high', 'fa-volume-xmark');
        } else {
            volumeIcon.classList.replace('fa-volume-xmark', 'fa-volume-high');
        }
    });

    function format(sec) {
        let m = Math.floor(sec / 60) || 0;
        let s = Math.floor(sec % 60) || 0;
        return m + ":" + (s < 10 ? '0' : '') + s;
    }
</script>

<?php include './base/footer.php'; ?>