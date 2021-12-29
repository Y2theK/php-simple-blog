-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2021 at 02:48 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `category_id`, `slug`, `title`, `image`, `description`) VALUES
(47, 1, 3, 'what-is-php?-1629073370', 'What is php?', 'assets/image/cappuccino-2029-e80b7c6d318c7862df2c4c8623a11f99@1x.jpg', 'php'),
(49, 4, 3, 'what-is-correct-1629080426', 'What is correct', 'assets/image/correct.png', 'java'),
(51, 4, 3, 'what-is-javascript?-1629080381', 'What is Javascript?', 'assets/image/wholesomeyum-chef-salad-recipe-4.jpg', 'jvav'),
(52, 1, 1, 'what-is-css?-1629079954', 'What is css?', 'assets/image/google-plus.png', 'css');

-- --------------------------------------------------------

--
-- Table structure for table `article_comment`
--

CREATE TABLE `article_comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `article_comment`
--

INSERT INTO `article_comment` (`id`, `user_id`, `article_id`, `comment`) VALUES
(19, 1, 46, 'comment'),
(20, 1, 47, 'hello'),
(21, 4, 47, 'hey yo'),
(22, 4, 52, 'aww aa');

-- --------------------------------------------------------

--
-- Table structure for table `article_language`
--

CREATE TABLE `article_language` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `article_language`
--

INSERT INTO `article_language` (`id`, `article_id`, `language_id`) VALUES
(157, 47, 1),
(158, 49, 2),
(161, 51, 2),
(162, 52, 4);

-- --------------------------------------------------------

--
-- Table structure for table `article_like`
--

CREATE TABLE `article_like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `article_like`
--

INSERT INTO `article_like` (`id`, `user_id`, `article_id`) VALUES
(30, 1, 46),
(31, 1, 47),
(32, 0, 47),
(33, 4, 47),
(34, 4, 51),
(35, 4, 49),
(36, 1, 51),
(37, 1, 52),
(38, 4, 52);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `slug`, `name`) VALUES
(1, 'web-design', 'Web Design'),
(3, 'Web-dev', 'Web Development'),
(5, 'color-theory', 'Color Theory'),
(6, 'database', 'database');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `slug`, `name`) VALUES
(1, 'php', 'php'),
(2, 'java', 'java'),
(3, 'html', 'html'),
(4, 'css', 'css');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(233) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `slug`, `email`, `password`, `image`) VALUES
(1, 'admin', 'admin-12345', 'admin@a.com', '$2y$10$Ov.KDqsW.tV5yJfcITLQ9ORgN/i0FDTGRoC21mtxO2oNrUc1Msvfa', 'assets/user/500_F_293407591_xYrIut5L5WHYeosCK9k6mpAIHkLq6Dzt.jpg'),
(2, 'Jennie Kim', 'jennie', 'userone@one.comf', '$2y$10$i0AQw5lPKCqd9hUr3rChxORG3MBvIitvXodFkdAYSW8QskA.5UTOO', NULL),
(3, 'Y2theK', 'ye-yint-kyaw-1628975826', 'yeyintkyaw300@gmail.com', '$2y$10$V3OsmeNSuEKu.bHritpev.L/nqzs6FmZlqZuX1FMLTrdmsgII4/DC', 'assets/user/60817.png'),
(4, 'Jennie Kim', 'jennie-kim-1629077989', 'jenn@gmail.com', '$2y$10$YQNlHMiy/MB6xGQXwHPtvee3NcHAStTnCc/G4tc6eKHq6OXmXzb5u', 'assets/user/superhero.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_comment`
--
ALTER TABLE `article_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_language`
--
ALTER TABLE `article_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_like`
--
ALTER TABLE `article_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `article_comment`
--
ALTER TABLE `article_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `article_language`
--
ALTER TABLE `article_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `article_like`
--
ALTER TABLE `article_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
