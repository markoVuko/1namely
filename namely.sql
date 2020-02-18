-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2020 at 07:03 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `namely`
--

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `IdFollow` int(11) NOT NULL,
  `Followed` int(11) NOT NULL,
  `Follows` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`IdFollow`, `Followed`, `Follows`) VALUES
(30, 1, 2),
(31, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `IdLike` int(11) NOT NULL,
  `IdPost` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`IdLike`, `IdPost`, `IdUser`) VALUES
(17, 12, 4),
(18, 9, 4),
(19, 10, 4),
(20, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `Id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`Id`, `title`, `text`, `path`, `alt`, `IdUser`) VALUES
(1, 'aaa', 'aaa', NULL, NULL, 1),
(2, 'Post title', 'Post text post text post text', NULL, NULL, 1),
(4, 'This is a post', 'And this is text, concerning this post.', 'assets/img/15818858661f5ff.png', '1f5ff', 1),
(5, 'Chinese flag', 'This is a chinese flag', 'assets/img/1581889241(China)_Chinese_People\'s_Republic_Flag.png', '(China)_Chinese_People\'s_Republic_Flag', 1),
(6, 'Something', 'lorem ipsum lorem ipsum lorem ipsum ', 'assets/img/158189053510k fists.jpg', '10k fists', 1),
(7, 'Post', 'post post post post', 'assets/img/158189063545 blok.jpg', '45 blok', 1),
(8, 'Just a lil testin post', 'Just a lil testin post', 'assets/img/1581891358i am the night.jpg', 'i am the night', 1),
(9, 'another testing post', 'text regarding the post that is a test post with text', NULL, NULL, 1),
(10, 'Hoho', 'Weeeeeeeeeeeeeeeeee', 'assets/img/1581904615QCFZsDJ.png', 'QCFZsDJ', 2),
(11, 'Very real post', 'This is a description of a very real post', 'assets/img/15819046372000px-Naval_ensign_of_Indonesia.svg.png', '2000px-Naval_ensign_of_Indonesia', 2),
(12, 'admin post', 'admin post', NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sent`
--

CREATE TABLE `sent` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Surname` varchar(255) NOT NULL,
  `Num` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sent`
--

INSERT INTO `sent` (`Id`, `Name`, `Surname`, `Num`, `Email`, `Gender`, `Text`) VALUES
(1, 'Mirko', 'Mirkovic', '062 321 224', 'mirko@gmail.com', 'Male', 'aaaaaaaa aaaaaaaaaa aaaa');

-- --------------------------------------------------------

--
-- Table structure for table `userimages`
--

CREATE TABLE `userimages` (
  `Id` int(11) NOT NULL,
  `Path` varchar(255) NOT NULL,
  `Alt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userimages`
--

INSERT INTO `userimages` (`Id`, `Path`, `Alt`) VALUES
(18, 'assets/img/1581891850badabing.jpg', 'badabing'),
(19, 'assets/img/158189195720-512.png', '20-512'),
(20, 'assets/img/1581892015badabing.jpg', 'badabing'),
(21, 'assets/img/1581903107tone robe.png', 'tone robe'),
(22, 'assets/img/1581978368united islands.png', 'united islands'),
(23, 'assets/img/1581978442(China)_Chinese_People\'s_Republic_Flag.png', '(China)_Chinese_People\'s_Republic_Flag'),
(24, 'assets/img/1581978474chernobog2.png', 'chernobog2'),
(25, 'assets/img/1581978870C:\\xampp\\tmp\\php8A8B.tmp', 'C:\\xampp\\tmp\\php8A8B'),
(26, 'assets/img/1581979290cardinal copia.png', 'cardinal copia'),
(27, 'assets/img/1581979561100px-Eastern_roman_empire_flag.png', '100px-Eastern_roman_empire_flag'),
(28, 'assets/img/1581979647gingerbreadman.jpg', 'gingerbreadman'),
(29, 'assets/img/1581979690gingerbreadman.jpg', 'gingerbreadman'),
(30, 'assets/img/1581992681imperium of man.png', 'imperium of man'),
(31, 'assets/img/1581992701imperium of man.png', 'imperium of man'),
(32, 'assets/img/1582000739purple priests avatar.jpg', 'purple priests avatar');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `IdUser` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `gmail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `IdProfile` int(11) DEFAULT NULL,
  `Role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`IdUser`, `username`, `gmail`, `password`, `gender`, `IdProfile`, `Role`) VALUES
(1, 'test', 'test@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'male', 20, 2),
(2, 'logger', 'logger@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'male', 21, 2),
(3, 'uga', 'uga@gmail.com', '2b7a41cf36fb4ac6566c11ada01c6778', 'other', 29, 2),
(4, 'admin', 'admin@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'male', 32, 1),
(5, 'unet', 'uneta@gmail.com', '6d364cd803a2fa63a552880289461481', 'female', 31, 2),
(6, 'wow', 'wow@ict.edu.rs', 'a2f93583a5d1b8bc8ed13c11830353c7', 'Female', NULL, 2),
(10, 'new', 'new@gmail.com', '5501ac7145081fbe7f19a8560167f459', 'Male', NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`IdFollow`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`IdLike`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `sent`
--
ALTER TABLE `sent`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `userimages`
--
ALTER TABLE `userimages`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Path` (`Path`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`IdUser`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `gmail` (`gmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `IdFollow` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `IdLike` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sent`
--
ALTER TABLE `sent`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userimages`
--
ALTER TABLE `userimages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
