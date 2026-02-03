<?php
include 'config/db_connection.php';
include("./base/header.php");
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
?>
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
                                style="background-image:url('../media/<?php echo $row['image']; ?>')">

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
                    <a href="#" class="primary-btn border-btn">View all tracks</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 p-0">
                <div class="track__content nice-scroll">
                    <div class="single_player_container">
                        <h4>David Guetta Miami Ultra</h4>
                        <div class="jp-jplayer jplayer" data-ancestor=".jp_container_1" data-url="music-files/1.mp3">
                        </div>
                        <div class="jp-audio jp_container_1" role="application" aria-label="media player">
                            <div class="jp-gui jp-interface">
                                <!-- Player Controls -->
                                <div class="player_controls_box">
                                    <button class="jp-play player_button" tabindex="0"></button>
                                </div>
                                <!-- Progress Bar -->
                                <div class="player_bars">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div>
                                                <div class="jp-play-bar">
                                                    <div class="jp-current-time" role="timer" aria-label="time">0:00
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jp-duration ml-auto" role="timer" aria-label="duration">00:00</div>
                                </div>
                                <!-- Volume Controls -->
                                <div class="jp-volume-controls">
                                    <button class="jp-mute" tabindex="0"><i class="fa fa-volume-down"></i></button>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single_player_container">
                        <h4>David Guetta Miami Ultra</h4>
                        <div class="jp-jplayer jplayer" data-ancestor=".jp_container_2" data-url="music-files/2.mp3">
                        </div>
                        <div class="jp-audio jp_container_2" role="application" aria-label="media player">
                            <div class="jp-gui jp-interface">
                                <!-- Player Controls -->
                                <div class="player_controls_box">
                                    <button class="jp-play player_button" tabindex="0"></button>
                                </div>
                                <!-- Progress Bar -->
                                <div class="player_bars">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div>
                                                <div class="jp-play-bar">
                                                    <div class="jp-current-time" role="timer" aria-label="time">0:00
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jp-duration ml-auto" role="timer" aria-label="duration">00:00</div>
                                </div>
                                <!-- Volume Controls -->
                                <div class="jp-volume-controls">
                                    <button class="jp-mute" tabindex="0"><i class="fa fa-volume-down"></i></button>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single_player_container">
                        <h4>David Guetta Miami Ultra</h4>
                        <div class="jp-jplayer jplayer" data-ancestor=".jp_container_3" data-url="music-files/3.mp3">
                        </div>
                        <div class="jp-audio jp_container_3" role="application" aria-label="media player">
                            <div class="jp-gui jp-interface">
                                <!-- Player Controls -->
                                <div class="player_controls_box">
                                    <button class="jp-play player_button" tabindex="0"></button>
                                </div>
                                <!-- Progress Bar -->
                                <div class="player_bars">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div>
                                                <div class="jp-play-bar">
                                                    <div class="jp-current-time" role="timer" aria-label="time">0:00
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jp-duration ml-auto" role="timer" aria-label="duration">00:00</div>
                                </div>
                                <!-- Volume Controls -->
                                <div class="jp-volume-controls">
                                    <button class="jp-mute" tabindex="0"><i class="fa fa-volume-down"></i></button>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single_player_container">
                        <h4>David Guetta Miami Ultra</h4>
                        <div class="jp-jplayer jplayer" data-ancestor=".jp_container_4" data-url="music-files/4.mp3">
                        </div>
                        <div class="jp-audio jp_container_4" role="application" aria-label="media player">
                            <div class="jp-gui jp-interface">
                                <!-- Player Controls -->
                                <div class="player_controls_box">
                                    <button class="jp-play player_button" tabindex="0"></button>
                                </div>
                                <!-- Progress Bar -->
                                <div class="player_bars">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div>
                                                <div class="jp-play-bar">
                                                    <div class="jp-current-time" role="timer" aria-label="time">0:00
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jp-duration ml-auto" role="timer" aria-label="duration">00:00</div>
                                </div>
                                <!-- Volume Controls -->
                                <div class="jp-volume-controls">
                                    <button class="jp-mute" tabindex="0"><i class="fa fa-volume-down"></i></button>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single_player_container">
                        <h4>David Guetta Miami Ultra</h4>
                        <div class="jp-jplayer jplayer" data-ancestor=".jp_container_5" data-url="music-files/5.mp3">
                        </div>
                        <div class="jp-audio jp_container_5" role="application" aria-label="media player">
                            <div class="jp-gui jp-interface">
                                <!-- Player Controls -->
                                <div class="player_controls_box">
                                    <button class="jp-play player_button" tabindex="0"></button>
                                </div>
                                <!-- Progress Bar -->
                                <div class="player_bars">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div>
                                                <div class="jp-play-bar">
                                                    <div class="jp-current-time" role="timer" aria-label="time">0:00
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jp-duration ml-auto" role="timer" aria-label="duration">00:00</div>
                                </div>
                                <!-- Volume Controls -->
                                <div class="jp-volume-controls">
                                    <button class="jp-mute" tabindex="0"><i class="fa fa-volume-down"></i></button>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single_player_container">
                        <h4>David Guetta Miami Ultra</h4>
                        <div class="jp-jplayer jplayer" data-ancestor=".jp_container_6" data-url="music-files/6.mp3">
                        </div>
                        <div class="jp-audio jp_container_6" role="application" aria-label="media player">
                            <div class="jp-gui jp-interface">
                                <!-- Player Controls -->
                                <div class="player_controls_box">
                                    <button class="jp-play player_button" tabindex="0"></button>
                                </div>
                                <!-- Progress Bar -->
                                <div class="player_bars">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div>
                                                <div class="jp-play-bar">
                                                    <div class="jp-current-time" role="timer" aria-label="time">0:00
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jp-duration ml-auto" role="timer" aria-label="duration">00:00</div>
                                </div>
                                <!-- Volume Controls -->
                                <div class="jp-volume-controls">
                                    <button class="jp-mute" tabindex="0"><i class="fa fa-volume-down"></i></button>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="youtube__item__pic set-bg" data-setbg="img/youtube/youtube-1.jpg">
                        <a href="https://www.youtube.com/watch?v=yJg-Y5byMMw?autoplay=1" class="play-btn video-popup"><i
                                class="fa fa-play"></i></a>
                    </div>
                    <div class="youtube__item__text">
                        <h4>David Guetta Miami Ultra Music Festival 2019</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="youtube__item">
                    <div class="youtube__item__pic set-bg" data-setbg="img/youtube/youtube-2.jpg">
                        <a href="https://www.youtube.com/watch?v=K4DyBUG242c?autoplay=1" class="play-btn video-popup"><i
                                class="fa fa-play"></i></a>
                    </div>
                    <div class="youtube__item__text">
                        <h4>Martin Garrix (Full live-set) | SLAM!Koningsdag</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="youtube__item">
                    <div class="youtube__item__pic set-bg" data-setbg="img/youtube/youtube-3.jpg">
                        <a href="https://www.youtube.com/watch?v=S19UcWdOA-I?autoplay=1" class="play-btn video-popup"><i
                                class="fa fa-play"></i></a>
                    </div>
                    <div class="youtube__item__text">
                        <h4>Dimitri Vegas, Steve Aoki & Like Mike’s “3 Are Legend”</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Youtube Section End -->

<!-- Testimonial Section Begin -->
<section class="testimonial spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Testimonials</h2>
                    <h1>What our users say</h1>
                </div>
            </div>
        </div>

        <div class="row">

            <?php if (mysqli_num_rows($reviews) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($reviews)): ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="testimonial__item">
                            <div class="testimonial__item__text">

                                <h4>
                                    <?= htmlspecialchars($row['name']) ?>
                                </h4>

                                <!-- Rating -->
                                <div class="rating">
                                    <?php
                                    $rating = (int) $row['rating'];

                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fa fa-star"></i>';
                                        } else {
                                            echo '<i class="fa fa-star-o"></i>';
                                        }
                                    }
                                    ?>
                                </div>

                                <p>
                                    <?= htmlspecialchars($row['review']) ?>
                                </p>

                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No reviews yet.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
<!-- Testimonial Section End -->



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

<?php
include("./base/footer.php");
?>



<script>
    document.querySelectorAll('.countdown').forEach(el => {
        let end = new Date(el.dataset.date).getTime();

        setInterval(() => {
            let now = new Date().getTime();
            let diff = end - now;

            if (diff <= 0) {
                el.innerHTML = "Passed";
                el.classList.add("passed");
                return;
            }

            let d = Math.floor(diff / (1000 * 60 * 60 * 24));
            let h = Math.floor((diff / (1000 * 60 * 60)) % 24);
            let m = Math.floor((diff / (1000 * 60)) % 60);

            el.innerHTML = d + "d " + h + "h " + m + "m";
        }, 1000);
    });
</script>