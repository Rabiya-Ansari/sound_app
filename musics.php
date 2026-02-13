<?php
include "./config/db_connection.php";

// Fetch music tracks with artist & album
$tracks = mysqli_query($con, "
    SELECT 
        musics.*, 
        artists.artist_name,
        artists.artist_image,
        albums.album_name
    FROM musics
    LEFT JOIN artists ON artists.id = musics.artist_id
    LEFT JOIN albums ON albums.id = musics.album_id
    ORDER BY musics.id DESC
");

include './base/header.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="container mt-5 mb-5">
<div class="row row-cols-1 row-cols-md-3 g-4">

<?php while ($m = mysqli_fetch_assoc($tracks)): ?>
<div class="col d-flex">
<div class="card flex-fill shadow-sm p-3">

    <!-- Artist -->
    <div class="d-flex align-items-center mb-2">
        <?php if (!empty($m['artist_image']) && file_exists("media/".$m['artist_image'])): ?>
            <img src="media/<?= htmlspecialchars($m['artist_image']) ?>" 
                 width="40" height="40" class="rounded-circle me-2">
        <?php else: ?>
            <img src="https://via.placeholder.com/40x40" 
                 width="40" height="40" class="rounded-circle me-2">
        <?php endif; ?>

        <strong><?= htmlspecialchars($m['artist_name'] ?? 'Unknown Artist') ?></strong>
    </div>

    <!-- Title -->
    <h6 class="card-title"><?= htmlspecialchars($m['title']) ?></h6>

    <!-- Album + Year -->
    <small class="text-muted">
        <?= htmlspecialchars($m['album_name'] ?? '') ?>
        <?php if(!empty($m['release_year'])): ?>
           Year| <?= htmlspecialchars($m['release_year']) ?>
        <?php endif; ?>
    </small>

    <!-- Mini Progress -->
    <div class="mini-progress mt-3" data-id="<?= $m['id'] ?>">
        <div class="mini-bar"></div>
    </div>

    <!-- Play Button -->
    <button class="select-track btn btn-sm mt-3 text-white"
        style="background:#6f42c1;"
        data-id="<?= $m['id'] ?>"
        data-url="media/<?= htmlspecialchars($m['music_file']) ?>"
        data-title="<?= htmlspecialchars($m['title']) ?>"
        data-artist="<?= htmlspecialchars($m['artist_name'] ?? 'Unknown Artist') ?>">
        <i class="fa-solid fa-play"></i> Play
    </button>

</div>
</div>
<?php endwhile; ?>

</div>
</div>


<!-- GLOBAL PLAYER -->

<div class="fixed-bottom bg-dark text-white p-3 d-flex align-items-center justify-content-between">

<div>
<strong id="player-title">Select a track</strong><br>
<small id="player-artist"></small>
</div>

<div class="d-flex align-items-center gap-3 flex-fill mx-4">

<button id="play-pause" class="btn btn-purple text-white">
<i class="fa-solid fa-play"></i>
</button>

<span id="current-time">0:00</span>

<div class="flex-fill">
<div class="jp-seek-bar" id="main-seek">
<div class="jp-play-bar" id="main-bar"></div>
</div>
</div>

<span id="duration">0:00</span>

</div>

<div style="width:150px;" class="d-flex align-items-center gap-2">
<i class="fa-solid fa-volume-high"></i>
<div class="jp-seek-bar" id="volume-bar">
<div class="jp-play-bar" id="volume-fill" style="width:100%"></div>
</div>
</div>

</div>


<script>
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


// SELECT TRACK
document.querySelectorAll('.select-track').forEach(btn => {
btn.addEventListener('click', () => {

audio.src = btn.dataset.url;
audio.play();

document.getElementById('player-title').textContent = btn.dataset.title;
document.getElementById('player-artist').textContent = btn.dataset.artist;

currentCardID = btn.dataset.id;

});
});


// PLAY / PAUSE
playPauseBtn.onclick = () => {
if (!audio.src) return;
audio.paused ? audio.play() : audio.pause();
};

audio.addEventListener('play', () => {
playIcon.classList.replace('fa-play','fa-pause');
});

audio.addEventListener('pause', () => {
playIcon.classList.replace('fa-pause','fa-play');
});


// UPDATE PROGRESS
audio.addEventListener('timeupdate', () => {

if(isDragging) return;

let current = audio.currentTime;
let duration = audio.duration || 0;

document.getElementById('current-time').textContent = format(current);
document.getElementById('duration').textContent = format(duration);

let percent = duration ? (current/duration)*100 : 0;
mainBar.style.width = percent + '%';

if(currentCardID){
let cardBar = document.querySelector(`.mini-progress[data-id="${currentCardID}"] .mini-bar`);
if(cardBar){
cardBar.style.width = percent + '%';
}
}

});


// DRAG SEEK GLOBAL
mainSeek.addEventListener('mousedown', () => isDragging = true);
document.addEventListener('mouseup', () => isDragging = false);

mainSeek.addEventListener('mousemove', e => {
if(!isDragging || !audio.duration) return;

let rect = mainSeek.getBoundingClientRect();
let percent = (e.clientX - rect.left) / rect.width;
percent = Math.max(0, Math.min(1, percent));

mainBar.style.width = (percent*100)+'%';
audio.currentTime = percent * audio.duration;
});


// CARD SEEK DRAG
document.querySelectorAll('.mini-progress').forEach(bar => {

let dragging = false;

bar.addEventListener('mousedown', () => dragging = true);
document.addEventListener('mouseup', () => dragging = false);

bar.addEventListener('mousemove', e => {
if(!dragging || !audio.duration) return;

let rect = bar.getBoundingClientRect();
let percent = (e.clientX - rect.left) / rect.width;
percent = Math.max(0, Math.min(1, percent));

audio.currentTime = percent * audio.duration;
});

});


// GLOBAL VOLUME BAR
volumeBar.addEventListener('click', e => {
let rect = volumeBar.getBoundingClientRect();
let percent = (e.clientX - rect.left) / rect.width;
percent = Math.max(0, Math.min(1, percent));

audio.volume = percent;
volumeFill.style.width = (percent*100)+'%';
});


// MUTE ON ICON CLICK
volumeIcon.addEventListener('click', () => {

audio.muted = !audio.muted;

if(audio.muted){
volumeIcon.classList.replace('fa-volume-high','fa-volume-xmark');
} else {
volumeIcon.classList.replace('fa-volume-xmark','fa-volume-high');
}

});


// CARD VOLUME CONTROL
document.querySelectorAll('.card-volume-bar').forEach(bar => {

bar.addEventListener('click', e => {

let rect = bar.getBoundingClientRect();
let percent = (e.clientX - rect.left) / rect.width;
percent = Math.max(0, Math.min(1, percent));

audio.volume = percent;

let fill = bar.querySelector('.card-volume-fill');
fill.style.width = (percent*100)+'%';

volumeFill.style.width = (percent*100)+'%';
});

});


// FORMAT TIME
function format(sec){
let m = Math.floor(sec/60)||0;
let s = Math.floor(sec%60)||0;
return m+":"+(s<10?'0':'')+s;
}
</script>


<?php include './base/footer.php'; ?>
