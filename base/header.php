<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Musify Template">
    <meta name="keywords" content="Musify, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Musify | Template</title>
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
    <style>
        .header__logo {
            display: flex;
            align-items: center;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            letter-spacing: 1px;
            font-family: 'Poppins', sans-serif;
        }

        .logo-text span {
            color: #a259ff;
        }
    </style>
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
                        <h1 class="logo-text">Musify</h1>
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
                                <div class="header__right__social">
                                    <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['name'])): ?>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle text-white">
                                                <i class="fa fa-user"></i>
                                                <?= htmlspecialchars($_SESSION['name']) ?>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="/sound/user/logout.php">
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

                            </ul>

                        </nav>

                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- js search -->
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