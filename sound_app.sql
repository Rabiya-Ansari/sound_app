-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2026 at 10:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sound_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `album_name` varchar(255) DEFAULT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `album_image` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `album_name`, `artist_id`, `genre_id`, `language_id`, `release_year`, `album_image`, `image`) VALUES
(9, 'The Fame', 33, 18, 1, 2008, NULL, 'album_6990cf0d882c4.jpg'),
(10, 'Chromatica', 33, 15, 1, 2020, NULL, 'album_6990cf7d419a4.jpg'),
(11, 'New Beginnings', 30, 18, 1, 2020, NULL, 'album_6990d019de74c.jpg'),
(12, 'SOMETHING YOU COULD NEVER OWN', 30, 15, 1, 2021, NULL, 'album_6990d044e5985.jpg'),
(13, '50', 28, 16, 1, 2016, NULL, 'album_6990d0adec4f0.jpg'),
(14, 'Beautiful Life', 28, 16, 1, 2018, NULL, 'album_6990d0d56abc1.jpg'),
(15, 'Different World', 21, 15, 1, 2018, NULL, 'album_6990d1619e6ef.jpg'),
(16, 'World of Walker', 21, 15, 1, 2021, NULL, 'album_6990d19d7216c.jpg'),
(17, 'Raabta', 35, 9, 13, 2017, NULL, 'album_6990e2af1537b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `artist_name` varchar(255) DEFAULT NULL,
  `artist_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `artist_name`, `artist_image`) VALUES
(1, 'Imagine Dragons ', '1771058049_7135.jpg'),
(2, 'Ed Sheeran', '1771058297_8454.webp'),
(3, 'Interworld', '1771058246_4327.jfif'),
(4, 'Honey Singh', '1771051924_5579.jpg'),
(17, 'Talha Anjum', '1771052163_2442.jpg'),
(18, 'Eric Chou', '1771051823_8507.jpg'),
(19, 'Hebe Tien', '1771051873_3874.jpg'),
(20, 'Jay Chou', '1771051964_5766.jpg'),
(21, 'Alan Walker', '1771051509_3611.jpg'),
(22, 'Rema', '1771052019_9729.jpg'),
(23, 'Dua Lipa', '1771051784_2355.jpg'),
(24, 'Rose', '1771052074_2157.jpg'),
(25, 'Wiz Khalifa', '1771052215_9185.jpg'),
(26, 'Sidhu Moose Wala', '1771052118_4652.jpg'),
(27, 'Diljit dosanjh', '1771051727_1293.jpg'),
(28, 'Rick Astley', '1771075297_1960.jpg'),
(29, 'LOVELI LORI', '1771075465_3696.jpg'),
(30, 'Neffex', '1771075556_2745.jpg'),
(31, 'Eminem', '1771075642_4506.jpg'),
(32, 'Hilzu', '1771075788_8109.jpg'),
(33, 'Lady Gaga', '1771075895_2329.jpg'),
(34, 'Micheal Jackson', '1771075964_1629.jpg'),
(35, 'Atif Aslam', '1771102797_5055.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('upcoming','passed') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `location`, `event_date`, `image`, `status`, `created_at`) VALUES
(2, 'Alan Walker', 'London', '2026-02-02 00:17:00', '1771099444_alen.jpg', 'passed', '2026-02-03 19:18:13'),
(3, 'lady gaga', 'Paris', '2026-04-17 12:57:00', '1771099074lady.gpg.jpg', 'upcoming', '2026-02-14 19:57:54'),
(4, 'Atif Aslam', 'karachi', '2026-05-15 12:59:00', '1771099218a.jpg', 'upcoming', '2026-02-14 20:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `genre_name`) VALUES
(1, 'Hip/hop'),
(2, 'calming'),
(4, 'Classical'),
(8, 'Ballads'),
(9, 'Multi-Genre'),
(10, 'Desi Hip Hop'),
(11, 'Melodic'),
(12, 'Rap'),
(13, 'Dance'),
(14, 'Afrobeats'),
(15, 'Electronic'),
(16, 'Pop'),
(17, 'Hip-hop / Rap rock'),
(18, 'Pop / Dance-pop');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language_name`) VALUES
(1, 'English'),
(3, 'Tamil'),
(4, 'Bengali'),
(5, 'Punjabi'),
(8, 'Chinese'),
(9, 'Urdu'),
(10, 'Hindi'),
(11, 'Gujarati'),
(12, 'Instrumental'),
(13, 'Multi languages');

-- --------------------------------------------------------

--
-- Table structure for table `musics`
--

CREATE TABLE `musics` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `music_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `musics`
--

INSERT INTO `musics` (`id`, `title`, `artist_id`, `album_id`, `genre_id`, `language_id`, `release_year`, `music_file`) VALUES
(24, 'Ahrix – End of Time', 21, NULL, 15, 1, 2020, '1771076655_K-391, Alan Walker & Ahrix - End of Time.mpeg'),
(25, 'Lost Control (feat. Sorana)', 21, NULL, 15, 1, 2018, '1771076539_Alan Walker ‒ Lost Control (Lyrics) ft. Sorana.mpeg'),
(26, 'Ignite (feat. Julie Bergan & Seungri)', 21, NULL, 15, 1, 2018, '1771076468_K-391 & Alan Walker - Ignite feat. Julie Bergan & Seungri (Lyric Video).mpeg'),
(27, 'Darkside (feat. Au/Ra & Tomine Harket)', 21, NULL, 15, 1, 2018, '1771076263_Alan Walker - Darkside (Lyrics) ft. AuRa and Tomine Harket.mpeg'),
(28, 'On My Way', 21, NULL, 1, 1, 2019, '1771074820_Alan Walker On My way.mpeg'),
(44, 'Never Gonna Give You Up', 28, NULL, 16, 1, 1987, '1771077938_Rick Astley - Never Gonna Give You Up.mpeg'),
(45, 'Together Forever', 28, NULL, 16, 1, 2021, '1771078055_Rick Astley - Together Forever (Reimagined).mpeg'),
(46, 'Beautiful Life', 28, NULL, 16, 1, 2021, '1771078118_Rick Astley - Beautiful Life (Reimagined).mpeg'),
(47, 'Keep Singing', 28, NULL, 16, 1, 2016, '1771078156_Rick Astley - Keep Singing.mpeg'),
(48, 'Angels on My Side', 28, NULL, 16, 1, 2016, '1771078193_Rick Astley - Angels on My Side.mpeg'),
(49, 'Love For You', 29, NULL, 1, 1, 2020, '1771078497_Love For You - loveli lori & ovg!.mpeg'),
(50, 'Mad ft. QKReign', 29, NULL, 1, 1, 2020, '1771078584_LOVELI LORI - Mad ft. QKReign.mpeg'),
(51, 'Get U Off My Mind', 29, NULL, 16, 1, 2021, '1771078644_LOVELI LORI get u off my mind.mpeg'),
(52, 'Grateful', 30, NULL, 1, 1, 2019, '1771078823_NEFFEX - Grateful.mpeg'),
(53, 'Cold', 30, NULL, 17, 1, 2017, '1771078887_NEFFEX - Cold.mpeg'),
(54, 'Fight Back', 30, NULL, 17, 1, 2017, '1771078941_NEFFEX - Fight Back.mpeg'),
(55, 'Best of Me', 30, NULL, 1, 1, 2017, '1771079003_NEFFEX - Best of Me.mpeg'),
(56, 'Numb', 30, NULL, 1, 1, 2018, '1771079055_NEFFEX - Numb.mpeg'),
(57, 'Rap God', 31, NULL, 1, 1, 2013, '1771079203_Eminem - Rap God.mpeg'),
(58, 'Godzilla (feat. Juice WRLD)', 31, NULL, 1, 1, 2020, '1771079258_Godzilla (feat. Juice WRLD).mpeg'),
(59, 'Venom', 31, NULL, 17, 1, 2018, '1771079291_Eminem - Venom.mpeg'),
(60, 'BONK!', 3, NULL, 4, 12, 2022, '1771079476_Interworld  BONK!.mpeg'),
(61, 'Rapture', 3, NULL, 4, 12, 2021, '1771079613_Interworld Rature.mpeg'),
(62, 'Somnium', 3, NULL, 4, 12, 2022, '1771079658_SOMNIUM Interworld.mpeg'),
(63, 'Aftermath - The Way You Are', 32, NULL, 15, 1, 2022, '1771079845_MMV - Aftermath - The way You Are.mpeg'),
(64, 'Demon Lord (by Hilzu)', 32, NULL, 4, 12, 2022, '1771079891_Hilzu - Demon Lord.mpeg'),
(65, 'Plain Jane (by KEAN DYSSO)', 32, NULL, 15, 1, 2022, '1771079942_hilzu - MMV - KEAN DYSSO - Plain Jane.mpeg'),
(66, 'New Man', 2, NULL, 16, 1, 2017, '1771080149_Ed Sheeran - New Man.mpeg'),
(67, 'Save Myself', 2, NULL, 16, 1, 2017, '1771080279_Ed Sheeran - Save Myself.mpeg'),
(68, 'Supermarket Flowers', 2, NULL, 16, 1, 2017, '1771080366_Ed Sheeran - Supermarket Flowers.mpeg'),
(69, 'Bloody Mary', 33, NULL, 16, 1, 2011, '1771087422_Lady Gaga - Bloody Mary.mpeg'),
(70, 'Judas', 33, NULL, 15, 1, 2011, '1771087484_Lady Gaga - Judas.mpeg'),
(71, 'Bad Kids', 33, NULL, 18, 1, 2011, '1771087633_Lady Gaga - Bad Kids.mpeg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_type` varchar(20) NOT NULL,
  `item_id` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `item_type`, `item_id`, `review`, `created_at`, `rating`) VALUES
(10, 23, '', 0, 'gfghfdgh', '2026-02-14 12:32:44', 4),
(11, 23, '', 0, 'gfgjhg', '2026-02-14 12:32:58', 2),
(12, 23, '', 0, 'bvhvhbn', '2026-02-14 12:33:11', 2),
(13, 23, '', 0, 'bnm,nknm,n', '2026-02-14 12:33:22', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Admin', 'admin@gmail.com', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'admin', 0),
(2, 'Rabiya', 'rabiyakanwal2025@gmail.com', '$2y$10$jYhKpaJIw/MVbvFgRGkJQ..G8TP3rixBCa9XudFjR9QxqhBh2V6A2', 'user', 1),
(11, 'Aaliyan', 'aaliyan@gmail.com', '$2y$10$Z8tY/AJJASdS0AP1meOIwOvwwPYwCah3AUXgVdIyETUKG75QVOtvC', 'admin', 1),
(19, 'user', 'user@gmail.com', '95c946bf622ef93b0a211cd0fd028dfdfcf7e39e', 'user', 1),
(22, 'test', 'test@gmail.com', '7288edd0fc3ffcbe93a0cf06e3568e28521687bc', 'user', 1),
(23, 'Rabiya', 'rabiya@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'user', 0);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `artist_id`, `genre_id`, `language_id`, `release_year`, `video_file`) VALUES
(18, 'Dunki O Maahi', 1, 4, 10, 2023, '1771004684_Dunki__O_Maahi__Full_Video.mp4'),
(19, 'Gerua', 1, 9, 10, 2015, '1771004797_Gerua_.mp4'),
(20, 'Humdard', 1, 4, 10, 2014, '1771004830_Humdard.mp4'),
(21, 'jawan', 1, 4, 10, 2023, '1771004876_JAWAN_.mp4'),
(22, 'khairiyat', 1, 4, 10, 2019, '1771004915_KHAIRIYAT.mp4'),
(23, 'Pehli Dafa', 3, 4, 9, 2017, '1771004994_Atif_Aslam__Pehli_Dafa_Song.mp4'),
(24, 'Dil Diyan Gallan', 3, 4, 9, 2017, '1771005044_Dil_Diyan_Gallan_Song__.mp4'),
(25, 'Hona tha Pyar', 3, 4, 9, 2011, '1771005079_Hona_Tha_Pyar_.mp4'),
(26, 'Moonrise', 3, 9, 9, 2022, '1771005114_Moonrise_.mp4'),
(27, 'Rafta Rafta', 3, 9, 9, 2021, '1771005153_Rafta_Rafta_-_Official.mp4'),
(28, 'Gone girl', 2, 8, 10, 2023, '1771005402_Badshah_-_Gone_Girl.mp4'),
(29, 'Jugnu', 2, 4, 10, 2021, '1771005484_Badshah_-_Jugnu__Official.mp4'),
(30, 'Mercy', 2, 8, 10, 2017, '1771005564_Mercy_-_Badshah_Feat..mp4'),
(31, 'Morni', 2, 9, 10, 2024, '1771005621_Morni__Official_Video____Badshah.mp4'),
(32, 'O Sajna', 2, 10, 10, 2024, '1771005656_O_Sajna__Official_Video__-_Badshah.mp4'),
(33, '6 AM', 4, 4, 10, 2025, '1771005783_6_AM__Official_Video___YO_YO_HONEY_SINGH.mp4'),
(34, 'Blue Eyes', 4, 10, 10, 2013, '1771005841_Blue_Eyes_Full_Video_Song_Yo_Yo_Honey_Singh___Blockbuster_Song_Of_2013(360p).mp4'),
(35, 'Exclusive', 4, 8, 10, 2025, '1771005964_Exclusive__LOVE_DOSE_Full_Video_Song___Yo_Yo_Honey_Singh,_Urvashi_Rautela___Desi_Kalakaar(360p).mp4'),
(36, 'Payal', 4, 9, 10, 2024, '1771005998_PAYAL_SONG__Official_Video___YO_YO_HONEY_SINGH___NORA_FATEHI___PARADOX___GLORY___BHUSHAN_KUMAR(360p).mp4'),
(37, 'Dil Chori', 4, 11, 10, 2017, '1771006060_Yo_Yo_Honey_Singh__DIL_CHORI__Video__Simar_Kaur,_Ishers___Hans_Raj_Hans___Sonu_Ke_Titu_Ki_Sweety(360p).mp4'),
(38, 'Afsanay', 17, 12, 9, 2021, '1771006222_AFSANAY_-_Young_Stunners___Talhah_Yunus___Talha_Anjum___Prod._By_Jokhay__Official_Music_Video_(360p).mp4'),
(39, 'Downers at Dusk', 17, 12, 9, 2023, '1771006285_Downers_At_Dusk_-_Talha_Anjum___Prod._by_Umair__Official_Music_Video_(360p).mp4'),
(40, 'Gumaan', 17, 12, 9, 2020, '1771006314_GUMAAN_-_Young_Stunners___Talha_Anjum___Talhah_Yunus___Prod._By_Jokhay__Official_Music_Video_(360p).mp4'),
(42, 'Heartbreak Kid', 17, 12, 9, 2024, '1771006428_Talha_Anjum_-_Heartbreak_Kid___Prod._by_Umair__Official_Music_Video_(360p).mp4'),
(43, 'Eric', 18, 1, 8, 2014, '1771007471_Eric.mp4'),
(44, 'Eric 2', 18, 1, 8, 2016, '1771007513_Eric (2).mp4'),
(45, 'A little Happiness', 19, 2, 8, 2015, '1771007607__A_Little_HappinesOfficial_MV.mp4'),
(46, 'EMO', 20, 11, 8, 2024, '1771007709_EMO.mp4'),
(47, 'G.E.M', 20, 9, 8, 2016, '1771007791_G.E.M..mp4'),
(48, 'Alone', 21, 13, 1, 2016, '1771008185_Alan_Walker.mp4'),
(49, 'baby calm down', 22, 14, 1, 2022, '1771008268_Baby_Calm_Down.mp4'),
(50, 'Levitating', 23, 1, 1, 2020, '1771008373_Dua_Lipa_.mp4'),
(51, 'How you like that', 24, 11, 1, 2020, '1771008478_ROSE.mp4'),
(52, 'We Own it', 25, 9, 1, 2013, '1771008563_Wiz_Khalifa.mp4'),
(53, '295', 26, 10, 5, 2021, '1771008635_295__Official.mp4'),
(54, 'GOAT', 27, 4, 5, 2020, '1771008701_Diljit_Dosanjh_.mp4'),
(55, 'GOAT', 26, 10, 5, 2021, '1771008751_GOAT_.mp4'),
(56, 'Jatti Jeone Morh Wargi', 26, 10, 5, 2019, '1771008830_Jatti_Jeone_Morh_Wargi.mp4'),
(57, 'lehenga', 27, 8, 5, 2019, '1771008893_LEHNGA___DILJIT_DOSANJH__.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` int(11) NOT NULL,
  `release_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `release_year`) VALUES
(2, '2017'),
(4, '2016'),
(5, '2018'),
(9, '2019'),
(10, '2015'),
(11, '2014'),
(12, '2013'),
(13, '2012'),
(14, '2011'),
(16, '2020'),
(17, '2021'),
(18, '2022'),
(19, '2023'),
(20, '2024'),
(21, '2025'),
(22, '2026'),
(23, '2010'),
(24, '1987');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `musics`
--
ALTER TABLE `musics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `musics`
--
ALTER TABLE `musics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
