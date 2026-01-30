<?php include 'auth.php'; ?>

<?php
include '../config/db_connection.php';

$result = $con->query("SELECT * FROM categories");

while ($row = $result->fetch_assoc()) {
    echo '<li><a href="' . $row['link'] . '" target="_blank">' . $row['name'] . '</a></li>';
}

include("./base/header.php");
// album logics

$albums = mysqli_query(
    $con,
    "SELECT albums.*, artists.artist_name 
     FROM albums
     LEFT JOIN artists ON albums.artist_id = artists.id
     ORDER BY albums.id DESC
     LIMIT 8"
);
?>


<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<!-- Trending Albums Section -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .album-card {
            background: #fff;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .album-img img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .album-info h5 {
            font-size: 16px;
            font-weight: 600;
        }

        .album-info p {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="content-page  mt-4">
        <div class="content">
            <div class="container-fluid">

                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="page-title">Trending Albums</h4>
                    </div>
                </div>

                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($albums)): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="album-card shadow-sm">
                                <div class="album-img">
                                    <?php if ($row['image'] && file_exists('../media/' . $row['image'])): ?>
                                        <img src="../media/<?= htmlspecialchars($row['image']) ?>" alt="Album Image">
                                    <?php else: ?>
                                        <img src="../assets/images/default-album.png" alt="Album Image">
                                    <?php endif; ?>
                                </div>

                                <div class="album-info text-center p-3">
                                    <h6 class="mb-1"><?= htmlspecialchars($row['album_name']) ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($row['artist_name']) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

            </div>
        </div>
    </div>

</body>

</html>

<?php
include("./base/footer.php");
?>