-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2023 at 01:26 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be18_cr5_animal_adoption_rehovic`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoptions`
--

CREATE TABLE `adoptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `animal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoptions`
--

INSERT INTO `adoptions` (`id`, `user_id`, `animal_id`) VALUES
(1, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `age` int(2) NOT NULL,
  `breed` varchar(60) DEFAULT NULL,
  `size` varchar(6) NOT NULL DEFAULT 'large',
  `address` varchar(255) NOT NULL,
  `description` varchar(2047) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `vaccinated` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `age`, `breed`, `size`, `address`, `description`, `picture`, `vaccinated`, `status`) VALUES
(4, 'snowy', 8, 'dog', 'small', 'Praterstraße 1, 1020 wien', 'cute white pup', 'https://cdn.pixabay.com/photo/2016/12/13/05/15/puppy-1903313_960_720.jpg', 1, 0),
(5, 'Tiger', 10, 'Chausie', 'small', 'Dutra D4K-B, Roseggergasse, 1160 Wien', '', 'https://cdn.pixabay.com/photo/2014/04/13/20/49/cat-323262__340.jpg', 1, 1),
(6, 'Lightning', 8, 'American Curl', 'small', 'Eßlinger Hauptstraße 128, 1220 Wien', 'very fast, likes running around', 'https://cdn.pixabay.com/photo/2015/06/19/14/20/cat-814952_960_720.jpg', 1, 1),
(7, 'Liver', 9, 'rhodesian ridgeback', 'large', 'Riedbachstrasse 150, 3027 Bern, Switzerland', '', 'https://cdn.pixabay.com/photo/2017/09/07/23/02/rhodesian-ridgeback-2727035__340.jpg', 1, 1),
(8, 'Barley', 2, 'Raven', 'small', 'Pleine-Eau 5, 2710 Tavannes, Switzerland', 'very smart birb', 'https://cdn.pixabay.com/photo/2017/03/21/18/46/raven-2162966_960_720.jpg', 1, 1),
(9, 'Fruit', 5, 'Bird', 'small', 'Stephansplatz 1, 1010 Wien', '', 'https://cdn.pixabay.com/photo/2023/03/25/16/02/hummingbird-7876355__340.jpg', 0, 1),
(10, 'Donald', 4, 'Duck', 'large', 'Somestreet 24, 10011 NYC', 'cool birbs', 'https://cdn.pixabay.com/photo/2023/03/19/12/24/chick-7862460__340.jpg', 1, 1),
(13, 'swan', 3, 'swan', 'large', 'Randomaddress 41, 2341 Rome', '', 'https://cdn.pixabay.com/photo/2023/03/04/07/41/swan-7829092__340.jpg', 0, 1),
(14, 'Bux', 3, 'Bunny', 'small', 'Oneadress 1, 1111 One', 'very cute bunny', 'https://cdn.pixabay.com/photo/2023/03/19/20/59/rabbit-7863312_960_720.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` varchar(4) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `date_of_birth`, `address`, `phone`, `picture`, `status`) VALUES
(2, 'joseph.tester@gmail.com', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'Joseph', 'Tester', '2000-12-31', 'Stephansplatz 1, Wien 1010', '+43 123 456 321', 'https://cdn.pixabay.com/photo/2017/05/30/14/08/stefan-2357089_960_720.jpg', 'user'),
(3, 'joseph.tester.alt@gmail.com', '8a9bcf1e51e812d0af8465a8dbcc9f741064bf0af3b3d08e6b0246437c19f7fb', 'Joseph', 'Tester', '2000-12-31', 'Stephansplatz 1, Wien 1010', '+43 123 321 456', 'https://cdn.pixabay.com/photo/2017/05/30/14/08/stefan-2357089_960_720.jpg', 'admn'),
(4, 'kevin.tester@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Kevin', 'Tester', '2000-12-12', 'Praterstraße 1, Wien 1020', '6761231231', 'no', 'user'),
(5, 'peter.tester.alt@gmail.com', '120430fb30db8711709a2066d4651c8fbb99e1db0c44b91c2d6681fe00cd805b', 'peter', 'tester', '2000-03-22', 'Ennsgasse 7-11/5/19', '6769063216', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoptions`
--
ALTER TABLE `adoptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
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
-- AUTO_INCREMENT for table `adoptions`
--
ALTER TABLE `adoptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoptions`
--
ALTER TABLE `adoptions`
  ADD CONSTRAINT `adoptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `adoptions_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
