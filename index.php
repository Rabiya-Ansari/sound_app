<?php
session_start();
include 'config/db_connection.php';
$reviews = mysqli_query($con, "
    SELECT 
        reviews.review,
        reviews.rating,
        users.name
    FROM reviews
    JOIN users ON reviews.user_id = users.id
    WHERE reviews.rating > 0
    ORDER BY reviews.id DESC
    LIMIT 6
");



/* passed events auto update */
mysqli_query($con, "
    UPDATE events 
    SET status='passed' 
    WHERE event_date < NOW()
");

/* fetch events */
$events = mysqli_query($con, "
    SELECT * FROM events 
    ORDER BY event_date ASC
");


$tracks = mysqli_query($con, "
    SELECT musics.*, artists.artist_name
    FROM musics
    LEFT JOIN artists ON artists.id = musics.artist_id
    ORDER BY musics.id DESC
    LIMIT 6
");
// search logics
$search = "";

if (isset($_GET['query']) && trim($_GET['query']) != "") {
    $search = mysqli_real_escape_string($con, $_GET['query']);

    $where = "WHERE 
        musics.title LIKE '%$search%' OR
        artists.artist_name LIKE '%$search%' OR
        albums.album_name LIKE '%$search%' OR
        musics.release_year LIKE '%$search%'";
} else {
    $where = "";
}

// Fetch tracks with artist, image, album, and search applied
$tracks = mysqli_query($con, "
    SELECT 
        musics.*, 
        artists.artist_name,
        albums.album_name
    FROM musics
    LEFT JOIN artists ON artists.id = musics.artist_id
    LEFT JOIN albums ON albums.id = musics.album_id
    $where
    ORDER BY musics.id DESC
");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="DJoz Template">
    <meta name="keywords" content="DJoz, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DJoz | Template</title>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Css Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/sound/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/sound/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/sound/css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="/sound/css/nowfont.css" type="text/css">
    <link rel="stylesheet" href="/sound/css/rockville.css" type="text/css">
    <link rel="stylesheet" href="/sound/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/sound/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/sound/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/sound/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="header__logo">
                        <a href="./index.php"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="./index.php">Home</a></li>
                                <li><a href="./about.php">About</a></li>
                                <li><a href="./musics.php">Musics</a></li>
                                <li><a href="./videos.php">Videos</a></li>
                                <li><a href="./contact.php">Contact</a></li>

                                <!-- Search Icon -->
                                <li class="search-box" style="background:transparent; list-style:none;">

                                    <style>
                                        .search-box {
                                            display: flex;
                                            align-items: center;
                                        }

                                        .search-form form {
                                            display: flex;
                                            align-items: center;
                                            background: rgba(255, 255, 255, 0.1);
                                            backdrop-filter: blur(8px);
                                            border-radius: 50px;
                                            padding: 5px 10px;
                                            border: 1px solid rgba(255, 255, 255, 0.3);
                                        }

                                        .search-form input {
                                            border: none;
                                            outline: none;
                                            background: transparent;
                                            color: #fff;
                                            padding: 8px 12px;
                                            width: 180px;
                                            font-size: 14px;
                                        }

                                        .search-form input::placeholder {
                                            color: rgba(255, 255, 255, 0.7);
                                        }

                                        .search-form button {
                                            background: transparent;
                                            border: none;
                                            color: #fff;
                                            cursor: pointer;
                                            font-size: 16px;
                                            padding: 5px 10px;
                                            border-radius: 50%;
                                            transition: 0.3s ease;
                                        }

                                        .search-form button:hover {
                                            background: rgba(255, 255, 255, 0.2);
                                        }
                                    </style>

                                    <!-- Search Form -->
                                    <div id="searchForm" class="search-form">
                                        <form action="" method="GET">
                                            <input type="text" name="query" placeholder="Search here..." required>
                                            <button type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </form>
                                    </div>

                                </li>

                            </ul>
                        </nav>
                        <div class="header__right__social">

                            <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['name'])): ?>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle text-white" data-bs-toggle="dropdown">
                                        <i class="fa fa-user"></i>
                                        <?= htmlspecialchars($_SESSION['name']) ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a style="color:black; font-size: 18px; font-weight:bold;"
                                                onmouseover="this.style.color='#5c00ff'"
                                                onmouseout="this.style.color='black'" class="dropdown-item"
                                                href="/sound/user/logout.php">
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <a href="/sound/login.php">Login</a>
                                <a href="/sound/admin/registration.php">SignUp</a>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header Section End -->


    <!-- Hero Section Begin -->
    <section class="hero spad set-bg" data-setbg="img/hero-bg.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero__text">
                        <span>New single</span>
                        <h1>Feel the heart beats</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <br />tempor
                            incididunt ut labore et dolore magna aliqua.</p>
                        <a href="https://www.youtube.com/watch?v=K4DyBUG242c" class="play-btn video-popup"><i
                                class="fa fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="linear__icon">
            <i class="fa fa-angle-double-down"></i>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Event Section Begin -->
    <section class="event spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Upcoming Events</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="event__slider owl-carousel">

                    <?php while ($row = mysqli_fetch_assoc($events)) { ?>

                        <div class="col-lg-4">
                            <div class="event__item">

                                <div class="event__item__pic"
                                    style="background-image:url('media/<?php echo $row['image']; ?>')">

                                    <div class="tag-date">
                                        <?php if ($row['status'] == 'upcoming') { ?>
                                            <span class="countdown" data-date="<?php echo $row['event_date']; ?>">
                                                Loading...
                                            </span>
                                        <?php } else { ?>
                                            <span class="passed">Passed</span>
                                        <?php } ?>
                                    </div>

                                </div>

                                <div class="event__item__text">
                                    <h4>
                                        <?php echo $row['title']; ?>
                                    </h4>
                                    <p>
                                        <i class="fa fa-map-marker"></i>
                                        <?php echo $row['location']; ?>
                                    </p>
                                </div>

                            </div>
                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>
    </section>
    <!-- Event Section End -->


    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__pic">
                        <img src="img/about/about.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__text">
                        <div class="section-title">
                            <h2>DJ Alexandra Rud</h2>
                            <h1>About me</h1>
                        </div>
                        <p>DJ Rainflow knows how to move your mind, body and soul by delivering tracks that stand out
                            from the norm. As if this impressive succession of high impact, floor-filling bombs wasn’t
                            enough to sustain.</p>
                        <a href="#" class="primary-btn">CONTACT ME</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Services Section Begin -->
    <section class="services">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="services__left set-bg" data-setbg="img/services/service-left.jpg">
                        <a href="https://www.youtube.com/watch?v=JGwWNGJdvx8" class="play-btn video-popup"><i
                                class="fa fa-play"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="row services__list">
                        <div class="col-lg-6 p-0 order-lg-1 col-md-6 order-md-1">
                            <div class="service__item deep-bg">
                                <img src="img/services/service-1.png" alt="">
                                <h4>Wedding</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 p-0 order-lg-2 col-md-6 order-md-2">
                            <div class="service__item">
                                <img src="img/services/service-2.png" alt="">
                                <h4>Clubs and bar</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 p-0 order-lg-4 col-md-6 order-md-4">
                            <div class="service__item deep-bg">
                                <img src="img/services/service-4.png" alt="">
                                <h4>DJ lessons</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 p-0 order-lg-3 col-md-6 order-md-3">
                            <div class="service__item">
                                <img src="img/services/service-3.png" alt="">
                                <h4>Corporate events</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Track Section Begin -->
    <section class="track spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section-title">
                        <h2>Latest tracks</h2>
                        <h1>Music podcast</h1>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="track__all">
                        <a href="./musics.php" class="primary-btn border-btn">View all tracks</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 p-0">
                    <div class="track__content nice-scroll">

                        <?php
                        $i = 1;
                        while ($m = mysqli_fetch_assoc($tracks)):
                            ?>
                            <div class="single_player_container">
                                <h4>
                                    <?= htmlspecialchars($m['title']) ?>
                                    <small style="font-size:12px;color:#aaa;">
                                        - <?= htmlspecialchars($m['artist_name'] ?? '') ?>
                                        <?php if (!empty($m['release_year'])): ?>
                                            (<?= $m['release_year'] ?>)
                                        <?php endif; ?>
                                    </small>
                                </h4>

                                <?php if (!empty($m['artist_image'])): ?>
                                    <div class="track_artist_image mb-2">
                                        <img src="media/<?= $m['artist_image'] ?>"
                                            alt="<?= htmlspecialchars($m['artist_name']) ?>"
                                            style="width:50px; height:50px; border-radius:50%;">
                                    </div>
                                <?php endif; ?>

                                <div class="jp-jplayer jplayer" data-ancestor=".jp_container_<?= $i ?>"
                                    data-url="media/<?= $m['music_file'] ?>">
                                </div>

                                <div class="jp-audio jp_container_<?= $i ?>" role="application" aria-label="media player">
                                    <div class="jp-gui jp-interface">

                                        <!-- Play Button -->
                                        <div class="player_controls_box">
                                            <button class="jp-play player_button" tabindex="0"></button>
                                        </div>

                                        <!-- Progress -->
                                        <div class="player_bars">
                                            <div class="jp-progress">
                                                <div class="jp-seek-bar">
                                                    <div class="jp-play-bar">
                                                        <div class="jp-current-time">0:00</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Volume -->
                                        <div class="jp-volume-controls">
                                            <button class="jp-mute"><i class="fa fa-volume-down"></i></button>
                                            <div class="jp-volume-bar">
                                                <div class="jp-volume-bar-value"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                            $i++;
                        endwhile;
                        ?>

                    </div>
                </div>
                <div class="col-lg-5 p-0">
                    <div class="track__pic">
                        <img src="img/track-right.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Track Section End -->
    <!-- Youtube Section Begin -->
    <section class="youtube spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Youtube feed</h2>
                        <h1>Latest videos</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="youtube__item">
                        <div class="youtube__item__pic set-bg" data-setbg="img/youtube/youtube-1.jpg"> <a
                                href="https://www.youtube.com/watch?v=yJg-Y5byMMw?autoplay=1"
                                class="play-btn video-popup"><i class="fa fa-play"></i></a> </div>
                        <div class="youtube__item__text">
                            <h4>David Guetta Miami Ultra Music Festival 2019</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="youtube__item">
                        <div class="youtube__item__pic set-bg" data-setbg="img/youtube/youtube-2.jpg"> <a
                                href="https://www.youtube.com/watch?v=K4DyBUG242c?autoplay=1"
                                class="play-btn video-popup"><i class="fa fa-play"></i></a> </div>
                        <div class="youtube__item__text">
                            <h4>Martin Garrix (Full live-set) | SLAM!Koningsdag</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="youtube__item">
                        <div class="youtube__item__pic set-bg" data-setbg="img/youtube/youtube-3.jpg"> <a
                                href="https://www.youtube.com/watch?v=S19UcWdOA-I?autoplay=1"
                                class="play-btn video-popup"><i class="fa fa-play"></i></a> </div>
                        <div class="youtube__item__text">
                            <h4>Dimitri Vegas, Steve Aoki & Like Mike’s “3 Are Legend”</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- Youtube Section End -->

    <!-- Albums Section Begin -->
    <style>
        /* Section spacing */
        .albums {
            padding: 80px 0;
            background: #f8f9fa;
        }

        /* Album card */
        .album__item {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        /* Hover effect */
        .album__item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        /* Image */
        .album__item__pic img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        /* Text area */
        .album__item__text {
            padding: 20px;
            text-align: center;
        }

        /* Album title */
        .album__item__text h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #111;
        }

        /* Artist + year */
        .album__item__text p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }
    </style>

    <section class="albums spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Albums</h2>
                        <h1>Latest Albums</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                // Include database connection
                include "./config/db_connection.php";

                // Fetch albums with artist name and release year
                $albums_query = "
                SELECT albums.*, artists.artist_name
                FROM albums
                LEFT JOIN artists ON artists.id = albums.artist_id
                ORDER BY albums.id DESC
            ";
                $albums = mysqli_query($con, $albums_query);

                if (mysqli_num_rows($albums) > 0) {
                    while ($album = mysqli_fetch_assoc($albums)) {
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="album__item">
                                <div class="album__item__pic">
                                    <img src="media/<?php echo $album['image']; ?>" alt="" class="img-fluid">
                                </div>
                                <div class="album__item__text">
                                    <h4><?php echo $album['album_name']; ?></h4>
                                    <p><?php echo $album['artist_name']; ?> | <?php echo $album['release_year']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No albums found.</p>";
                }
                ?>
            </div>
        </div>
    </section>
    <!-- Albums Section End -->

    <script>
        // jQuery to set background images dynamically
        $(document).ready(function () {
            $(".set-bg").each(function () {
                var bg = $(this).data("setbg");
                $(this).css("background-image", "url(" + bg + ")");
            });
        });
    </script>


    <script>
        // jQuery to set background images dynamically
        $(document).ready(function () {
            $(".set-bg").each(function () {
                var bg = $(this).data("setbg");
                $(this).css("background-image", "url(" + bg + ")");
            });
        });
    </script>


    <!-- Testimonial Section Begin -->
    <section class="testimonial spad">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <h2>Testimonials</h2>
                        <h1>What our users say</h1>
                    </div>
                </div>
            </div>

            <?php if (mysqli_num_rows($reviews) > 0): ?>
                <!-- Swiper Slider -->
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php while ($row = mysqli_fetch_assoc($reviews)): ?>
                            <div class="swiper-slide">
                                <div class="testimonial__item p-4"
                                    style="background: linear-gradient(to bottom, #5c00ff, #1a0000); color: #fff; border-radius: 10px;">
                                    <h4 style="color:white; font-weight: bold;"><?= htmlspecialchars($row['name']) ?></h4>
                                    <div class="rating mb-2" style="color:yellow;">
                                        <?php
                                        $rating = (int) $row['rating'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $rating
                                                ? '<i class="fa fa-star"></i>'
                                                : '<i class="fa fa-star-o"></i>';
                                        }
                                        ?>
                                    </div>
                                    <p style="color:white;"><?= nl2br(htmlspecialchars($row['review'])) ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Slider navigation -->
                    <div style="color:black;" class="swiper-button-next"></div>
                    <div style="color:black;" class="swiper-button-prev"></div>
                    <div style="color:white;" class="swiper-pagination"></div>
                </div>
            <?php else: ?>
                <p class="text-center">No reviews yet.</p>
            <?php endif; ?>

            <!-- Review Form (kept intact for logged-in users) -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <h3>Leave a Review</h3>
                        <form method="POST" action="submit_review.php">
                            <div class="mb-3">
                                <label>Rating</label>
                                <select name="rating" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="5">★★★★★</option>
                                    <option value="4">★★★★</option>
                                    <option value="3">★★★</option>
                                    <option value="2">★★</option>
                                    <option value="1">★</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Review</label>
                                <textarea name="review" class="form-control" required style="resize:none;"></textarea>
                            </div>

                            <button style="background-color: white; border:2px solid #5c00ff; padding:8px;">SUBMIT
                                REVIEW</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-12 text-center mt-4">
                    <a href="/sound/login.php" style="color:black; font-weight: bold;  ">Login to leave a review</a>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- Countdown Section Begin -->
    <section class="countdown spad set-bg" data-setbg="img/countdown-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="countdown__text">
                        <h1>Tomorrowland 2020</h1>
                        <h4>Music festival start in</h4>
                    </div>
                    <div class="countdown__timer" id="countdown-time">
                        <div class="countdown__item">
                            <span>20</span>
                            <p>days</p>
                        </div>
                        <div class="countdown__item">
                            <span>45</span>
                            <p>hours</p>
                        </div>
                        <div class="countdown__item">
                            <span>18</span>
                            <p>minutes</p>
                        </div>
                        <div class="countdown__item">
                            <span>09</span>
                            <p>seconds</p>
                        </div>
                    </div>
                    <div class="buy__tickets">
                        <a href="#" class="primary-btn">Buy tickets</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Countdown Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer spad set-bg" data-setbg="img/footer-bg.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer__address">
                        <ul>
                            <li>
                                <i class="fa fa-phone"></i>
                                <p>Phone</p>
                                <h6>1-677-124-44227</h6>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <p>Email</p>
                                <h6>DJ.Music@gmail.com</h6>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1 col-md-6">
                    <div class="footer__social">
                        <h2>DJoz</h2>
                        <div class="footer__social__links">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6">
                    <div class="footer__newslatter">
                        <h4>Stay With me</h4>
                        <form action="#">
                            <input type="text" placeholder="Email">
                            <button type="submit"><i class="fa fa-send-o"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <div class="footer__copyright__text">
                <p>Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | This template is made with <i class="fa fa-heart"
                        aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                </p>
            </div>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="/sound/js/jquery-3.3.1.min.js"></script>
    <script src="/sound/js/bootstrap.min.js"></script>
    <script src="/sound/js/jquery.magnific-popup.min.js"></script>
    <script src="/sound/js/jquery.nicescroll.min.js"></script>
    <script src="/sound/js/jquery.barfiller.js"></script>
    <script src="/sound/js/jquery.countdown.min.js"></script>
    <script src="/sound/js/jquery.slicknav.js"></script>
    <script src="/sound/js/owl.carousel.min.js"></script>
    <script src="/sound/js/main.js"></script>

    <!-- swiper links -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- Bootstarp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!-- Music Plugin -->
    <script src="/sound/js/jquery.jplayer.min.js"></script>
    <script src="/sound/js/jplayerInit.js"></script>


    <script>
        // swiper logics 
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                },
            },
        });
    </script>

    < <!-- js search -->
        <script>
            function toggleSearch() {
                var form = document.getElementById("searchForm");
                if (form.style.display === "block") {
                    form.style.display = "none";
                } else {
                    form.style.display = "block";
                }
            }
        </script>

</body>

</html>