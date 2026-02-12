<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    <header class="header header--normal">
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