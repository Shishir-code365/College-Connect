-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2025 at 02:53 PM
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
-- Database: `cb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `chat_feedback`
--

CREATE TABLE `chat_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `rating` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_feedback`
--

INSERT INTO `chat_feedback` (`id`, `user_id`, `feedback`, `rating`, `category`, `reply`, `created_at`, `is_read`) VALUES
(2, 2, 'Where is the location', 3, 'General Comment', 'ktm', '2025-08-23 15:23:59', 1),
(3, 2, 'GOod', 5, 'General Comment', 'oj', '2025-08-23 15:28:38', 1),
(4, 2, 'How are you?', 3, 'General Comment', 'fine', '2025-08-23 15:39:32', 1),
(5, 2, 'Whatsup', 4, 'Bug Report', NULL, '2025-08-23 15:45:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_forms`
--

CREATE TABLE `student_forms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `contact_number` varchar(10) DEFAULT NULL,
  `gender` enum('M','F','Others') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `see_gpa` decimal(4,2) DEFAULT NULL,
  `college_name` varchar(255) DEFAULT NULL,
  `plus2_gpa` decimal(4,2) DEFAULT NULL,
  `iost_marks` int(11) DEFAULT NULL,
  `faculty` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_forms`
--

INSERT INTO `student_forms` (`id`, `user_id`, `fname`, `lname`, `dob`, `contact_number`, `gender`, `email`, `school_name`, `see_gpa`, `college_name`, `plus2_gpa`, `iost_marks`, `faculty`, `file_path`, `status`, `created_at`) VALUES
(2, 3, 'Shishir', 'Dhakal', '2003-02-05', '9845678901', 'M', 'dhakal.shishir2059@gmail.com', 'Prithwi secondary boarding school', 3.60, 'SWSC', 3.65, 0, 'BSc.CSIT', '1755966049_2025_04_26_19_47_IMG_8440.PNG', 'Rejected', '2025-08-23 16:20:49'),
(3, 4, 'Kiran', 'Ghimire', '2000-05-02', '9845623658', 'M', 'kiranghimire363@gmail.com', 'Prithwi secondary boarding school', 3.60, 'swsc', 3.20, 0, 'BIT', '1755970603_2025_04_26_19_48_IMG_8441.PNG', 'Rejected', '2025-08-23 17:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`) VALUES
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@gmail.com'),
(3, 'Shishir', 'ee11cbb19052e40b07aac0ca060c23ee', 'dhakal.shishir2059@gmail.com'),
(4, 'Kiran', 'ee11cbb19052e40b07aac0ca060c23ee', 'kiranghimire363@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_feedback`
--
ALTER TABLE `chat_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `student_forms`
--
ALTER TABLE `student_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat_feedback`
--
ALTER TABLE `chat_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_forms`
--
ALTER TABLE `student_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_feedback`
--
ALTER TABLE `chat_feedback`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_forms`
--
ALTER TABLE `student_forms`
  ADD CONSTRAINT `student_forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
