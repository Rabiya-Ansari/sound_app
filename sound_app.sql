-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2026 at 10:59 AM
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
(1, 'Imagine Dragons NightVision Disc 1', 2, 4, 2, 2020, NULL, 'album_698210790e93d.jpg'),
(2, 'Hastune Miku Pickup!', 14, 6, 6, 2016, NULL, 'album_69821068c98a8.jpg'),
(3, 'FallOutBoy Greatest hits', 13, 1, 5, 2021, NULL, 'album_6982100d70436.jpg');

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
(1, 'Ed Sheeran', NULL),
(2, 'Interworld', NULL),
(3, 'Lady Gaga', NULL),
(4, 'Hilzu', NULL),
(6, 'Micheal Jackson', NULL),
(7, 'Eminem', NULL),
(8, 'Neffex', NULL),
(9, 'LOVELI LORI', NULL),
(11, 'Rick Astley', NULL),
(12, 'Alan Walker', NULL),
(13, 'Fallout Boys', NULL),
(14, 'Hastune Miku ', NULL),
(15, 'Imagine Dragons ', NULL);

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
(1, 'Concert', 'karachi', '2026-02-19 00:05:00', '1770396923_event-2.jpg', 'upcoming', '2026-02-03 19:05:31'),
(2, 'Concert', 'karachi', '2026-02-02 00:17:00', '1770396965_event-1.jpg', 'passed', '2026-02-03 19:18:13');

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
(2, 'Electronic'),
(4, 'Classical'),
(6, 'pop'),
(7, 'Rock ');

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
(1, 'Russian'),
(2, 'Urdu'),
(3, 'French'),
(4, 'Chinese'),
(5, 'English'),
(6, 'Japanese'),
(7, 'Spanish');

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
(5, 'Never Gonna Give You Up', 11, NULL, 6, 5, 1987, '1770370745_Rick Astley - Never Gonna Give You Up.mpeg'),
(6, 'Together Forever', 11, NULL, 6, 5, 1988, '1770370821_Rick Astley - Together Forever (Reimagined).mpeg'),
(7, 'Whenever You Need Somebody', 11, NULL, 6, 5, 1987, '1770370917_Rick Astley - Whenever You Need Somebody.mpeg'),
(8, 'When I Fall in Love', 11, NULL, 6, 5, 1987, '1770371004_Rick Astley - When I Fall in Love.mpeg'),
(9, 'She Wants To Dance With Me', 11, NULL, 6, 5, 1988, '1770371044_Rick Astley - She Wants To Dance With Me.mpeg'),
(10, 'Cry For Help', 11, NULL, 6, 5, 1991, '1770371116_Rick Astley - Cry For Help.mpeg'),
(11, 'Try', 11, NULL, 6, 5, 2018, '1770371191_Rick Astley - Try.mpeg'),
(12, 'Keep Singing', 11, NULL, 6, 5, 2016, '1770371258_Rick Astley - Keep Singing.mpeg'),
(13, 'Angels on My Side', 11, NULL, 6, 5, 2016, '1770371291_Rick Astley - Angels on My Side.mpeg'),
(14, 'Beautiful Life', 11, NULL, 6, 5, 2018, '1770371318_Rick Astley - Beautiful Life (Reimagined).mpeg'),
(20, 'Faded', 12, NULL, 2, 5, 2015, '1770373563_Alan Walker - Faded.mpeg'),
(21, 'The Spectre', 12, NULL, 2, 5, 2017, '1770373626_Alan Walker - The Spectre.mpeg'),
(22, 'Alone', 12, NULL, 2, 5, 2016, '1770373684_Alan Walker - Alone.mpeg'),
(23, 'Diamond Heart', 12, NULL, 2, 5, 2018, '1770375104_Alan Walker - Diamond Heart.mpeg'),
(24, 'Ahrix – End of Time', 12, NULL, 2, 5, 2020, '1770375157_K-391, Alan Walker & Ahrix - End of Time.mpeg'),
(25, 'Lost Control (feat. Sorana)', 12, NULL, 2, 5, 2018, '1770375210_Alan Walker ‒ Lost Control (Lyrics) ft. Sorana.mpeg'),
(26, 'Ignite (feat. Julie Bergan & Seungri)', 12, NULL, 2, 5, 2018, '1770375252_K-391 & Alan Walker - Ignite feat. Julie Bergan & Seungri (Lyric Video).mpeg'),
(27, 'Darkside (feat. Au/Ra & Tomine Harket)', 12, NULL, 2, 5, 2018, '1770375298_Alan Walker - Darkside (Lyrics) ft. AuRa and Tomine Harket.mpeg'),
(28, 'On My Way', 12, NULL, 6, 5, 2019, '1770375377_Alan Walker On My way.mpeg'),
(29, 'Musics', 1, NULL, 2, 5, 2019, '1770457870_Ed Sheeran - New Man.mpeg'),
(30, 'Musics', 12, NULL, 4, 4, 2020, '1770457949_Ed Sheeran - Save Myself.mpeg'),
(31, 'hshh', 1, NULL, 2, 4, 2019, '1770458003_Ed Sheeran - New Man.mpeg'),
(32, 'nasn', 8, NULL, 2, 5, 2020, '1770458094_Ed Sheeran - Supermarket Flowers.mpeg'),
(33, 'jnsjn', 1, NULL, 2, 3, 2018, '1770458140_Ed Sheeran - Galway Girl.mpeg'),
(34, 'kskj', 7, NULL, 2, 5, 2018, '1770458165_Ed Sheeran - Happier.mpeg'),
(35, 'jsjn', 7, NULL, 1, 3, 2018, '1770458211_Ed Sheeran - Shape of You.mpeg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `review`, `created_at`, `rating`) VALUES
(1, 8, 'Hello', '2026-01-28 17:04:52', 0),
(4, 8, 'Hello!', '2026-02-03 18:24:25', 5),
(5, 10, 'Hello!', '2026-02-06 08:14:28', 4);

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
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Admin', 'admin@gmail.com', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'admin', 0),
(5, 'Rabiya', 'rabiyakanwalaptec@gmail.com', '2878812721e07bb8d912ae033b806939c5e36f3f', 'user', 0),
(8, 'ali', 'ali@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'user', 0),
(10, 'Rabiya Ansari', 'rabiya@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'user', 0),
(11, 'user1', 'user1@gmail.com', '3d5cbfed48ce23d2f0dc0a0baa3ec2ee93867b2b', 'user', 0);

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
(4, 'Concert', 2, 1, 2, 2020, '123762-729019600_small.mp4'),
(11, 'Concert', 3, 1, 1, 2020, '123762-729019600_small.mp4');

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
(1, '2020'),
(2, '2017'),
(3, '2015'),
(4, '2016'),
(5, '2018'),
(6, '1987'),
(7, '1988'),
(8, '1991'),
(9, '2019');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `musics`
--
ALTER TABLE `musics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
