-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 04:47 PM
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
-- Database: `subcsaa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `subject` enum('General Inquiry','Support','Feedback') NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `subject`, `message`, `submitted_at`) VALUES
(1, 'XX', 'XX', 'xx@gmailcom', '+8800000000', 'General Inquiry', 'Hello.', '2025-01-09 03:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('upcoming','past','featured') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `location`, `status`) VALUES
(1, 'SUBCSAA Conference', '1st ever conference hosted by SUBCSAA', '2025-01-10', 'Southern University Bangladesh, Auditorium 4501', 'upcoming'),
(2, 'SUB-CSE Fest 2024', 'First even grand fest hosted by SUBCC', '2024-02-20', 'Southern University Bangladesh, Gallery', 'past'),
(3, 'SUB-CSE Fest 2025', 'SUBCC is back again with another grand fest!!!', '2025-02-20', 'Southern University Bangladesh, Gallery', 'upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `reference` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pay_scale` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_title`, `position`, `deadline`, `reference`, `phone`, `pay_scale`, `description`, `created_at`) VALUES
(1, 'MERN Stack Developer', '2 Years of Experience', '2025-01-25', 'Jahangir Alam', '018-XXXXXXXXX', '14000 - 25000', 'XXX', '2025-01-09 01:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `job_experience`
--

CREATE TABLE `job_experience` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `year_start` int(11) DEFAULT NULL,
  `year_end` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_experience`
--

INSERT INTO `job_experience` (`id`, `user_id`, `company_name`, `position`, `year_start`, `year_end`) VALUES
(1, 5, 'Lifewood .Co', 'Project Executive', 2020, 2023),
(2, 5, '', '', 0, 0),
(3, 8, 'Stylex', 'Mobile App Developer', 2024, 2025),
(4, 12, 'Inifinix', 'React Developer', 2025, 2025),
(5, 14, 'Ubisoft', 'Game Developer', 2027, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `graduation_year` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `role` enum('admin','user','alumni') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `student_id`, `graduation_year`, `description`, `role`, `created_at`, `profile_image`) VALUES
(5, 'Vijoy Barua', 'vijoy.b', '$2y$10$aKUo4NHspigq.xbWGRzSoehcTk/38Yv5XMEsm8YMNNR2X.m7A7xEW', '666-59-17', 2026, 'My name is Vijoy :)', 'alumni', '2025-01-08 18:08:57', 'uploads/677ec6dc8ca3d_VIJOY.jpg'),
(7, 'Admin User', 'admin1', '$2y$10$9/FFwQ58rXkqLOkjtmtg1.PyMOj2Y8s5x2RTkC0jHskKMFxchwQG2', '0000', 2020, NULL, 'admin', '2025-01-08 18:13:42', NULL),
(8, 'Tahasin Ibanth', 'ibnathatah', '$2y$10$HZcql8t.kjin6ePq3pbAJun/Ab6kYfzpDe07JAD8fD0bRia3aLY9K', '666-59-20', 2026, 'Hi, my name is Tahasin Ibnath, I am a professional mobile app developer specializing in creating cross-platform application. ', 'alumni', '2025-01-08 19:08:04', 'uploads/B612_20240221_141831_627.jpg'),
(11, 'Abdur Rahman Mahmud', 'abmahmud', '$2y$10$gzywCK0gjZDE.zZqUWTGMe7iG0DAjcl6GZqJ.9Sn7U7H12QojY0.u', '666-59-41', 2026, '', 'alumni', '2025-01-08 20:44:41', 'uploads/IMG_4934.JPG'),
(12, 'Rafa Fowria Ramisa', 'rafa2', '$2y$10$5RpDzzFKCRSqexAU3GYFK.6BUKHle9QMTp0vAmawJLM9C1dz.lL0S', '666-59-22', 2026, 'Hello, my name is Rafa :)', 'alumni', '2025-01-08 20:54:14', 'uploads/IMG_4830.JPG'),
(13, 'Admin11', 'admin2', '$2y$10$6nSThtSQdMSKVvR6ZazpCexVJIf9qKkUenRukdcNDMThOi4kbvIEu', '666-00-00', 2010, NULL, 'admin', '2025-07-09 16:38:12', NULL),
(14, 'Tausif Akbar', 'tausif.akbar', '$2y$10$4O4qJqlRZWDJ/nZpyIaS5uvN30asU/pYd6zQpUdpB13KBKWzlSdqe', '666-59-01', 2026, 'Hi\' I am Tausif ', 'alumni', '2025-07-10 13:30:41', 'uploads/Screenshot 2025-07-10 193842.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_experience`
--
ALTER TABLE `job_experience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_experience`
--
ALTER TABLE `job_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_experience`
--
ALTER TABLE `job_experience`
  ADD CONSTRAINT `job_experience_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
