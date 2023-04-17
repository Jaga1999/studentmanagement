-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2023 at 11:47 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `education_id` int(11) NOT NULL,
  `institution_name` varchar(255) DEFAULT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `year_of_passing` int(11) DEFAULT NULL,
  `grade_obtained` float DEFAULT NULL,
  `board` varchar(255) DEFAULT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`education_id`, `institution_name`, `course_name`, `year_of_passing`, `grade_obtained`, `board`, `student_id`) VALUES
(1, 'MGR College', 'BSc computer science', 2020, 7, 'Periyar University', 7),
(9, 'mgr college', 'BCA', 2020, 8, 'Periyar University', 15),
(10, 'mgr college', 'BSc computer science', 2020, 6, 'Periyar University', 16),
(12, 'mgr college', 'BSc computer science', 2020, 7, 'Periyar University', 18);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `staff_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `access_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`staff_id`, `username`, `password`, `email`, `access_level`) VALUES
(47, 'jagasiva1999@gmail.com', '$2y$10$zD5q8YuPqE0Bmo9/SC9/5.zfRSwDZZCw1NwUT9rMeGDYgzcVz0zOm', 'jagasiva1999@gmail.com', 1),
(48, 'JagadeepS', '$2y$10$jb8Cmld2SkdAi5M5o3IbJeSoN3p/7jhLllDdvM4kg1WWY6aJLWpl6', 'jagasiva1999@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  `par_name` varchar(255) NOT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `par_phone` varchar(20) DEFAULT NULL,
  `par_email` varchar(255) DEFAULT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `par_name`, `occupation`, `par_phone`, `par_email`, `student_id`) VALUES
(2, 'sivaraman', 'tailor', '+919677911033', 'sivaraman@gmail.com', 7),
(7, 'Ramappa', 'Farmer', '9992227773', 'ramappa@gmail.com', 15),
(8, 'Raj', 'Lawyer', '9992227773', 'raj@gmail.com', 16),
(10, 'Ramesh', 'Farmer', '9803728264', 'ramesh@gmail.com', 18);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `stu_name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `stu_name`, `dob`, `gender`, `email`, `phone`, `address`) VALUES
(7, 'Jagadeep S', '1999-10-18', 'male', 'jagasiva1999@gmail.com', '08825660084', '111/1 Gadipalayam HCF post mathigiri'),
(15, 'Ramesh', '1999-01-10', 'male', 'rameshbabu@gmail.com', '9876543212', 'Hosur'),
(16, 'dinesh', '2002-04-23', 'male', 'dinesh@gmail.com', '9569392049', 'Hosur'),
(18, 'Akash', '2002-09-20', 'male', 'Akash29@gmail.com', '9837837292', 'Hosur\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`education_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `education_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
