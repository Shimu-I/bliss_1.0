-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:5222
-- Generation Time: Jan 20, 2025 at 01:24 AM
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
-- Database: `day_care`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_id`, `activity_type`, `description`, `date`, `time`, `child_id`) VALUES
(1, 'Art Class', 'Painting and drawing activities for kids', '2025-01-21', '10:00:00', 1),
(2, 'Music Class', 'Learning basic music instruments', '2025-01-22', '11:00:00', 2),
(3, 'Story Time', 'Reading children’s books', '2025-01-23', '09:30:00', 3),
(4, 'Outdoor Games', 'Running and playing outdoors', '2025-01-24', '14:00:00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `date`, `status`, `child_id`) VALUES
(1, '2025-01-21', 'Present', 1),
(2, '2025-01-22', 'Absent', 2),
(3, '2025-01-23', 'Present', 3),
(4, '2025-01-24', 'Present', 4);

-- --------------------------------------------------------

--
-- Table structure for table `bill_payment`
--

CREATE TABLE `bill_payment` (
  `bill_id` int(11) NOT NULL,
  `section_type` varchar(50) NOT NULL,
  `section_description` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_status` enum('Paid','Pending','Overdue') NOT NULL,
  `user_id` int(11) NOT NULL,
  `child_type` enum('Normal','Special') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_payment`
--

INSERT INTO `bill_payment` (`bill_id`, `section_type`, `section_description`, `total_amount`, `payment_date`, `payment_status`, `user_id`, `child_type`) VALUES
(1, 'Tuition', 'Payment for the semester', 500.00, '2025-01-20', 'Paid', 1, 'Normal'),
(2, 'Meal', 'Meals for children during the month', 300.00, '2025-01-19', 'Pending', 2, 'Special');

-- --------------------------------------------------------

--
-- Table structure for table `caregivers`
--

CREATE TABLE `caregivers` (
  `caregiver_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience` int(11) NOT NULL,
  `special_training` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `caregivers`
--

INSERT INTO `caregivers` (`caregiver_id`, `name`, `email`, `password`, `qualification`, `experience`, `special_training`, `profile_image`) VALUES
(1, 'Emma Green', 'emma.green@example.com', 'password123', 'Nursing', 5, 'Pediatric Care', 'emma_green.jpg'),
(2, 'Olivia Brown', 'olivia.brown@example.com', 'password123', 'Psychology', 3, 'Child Therapy', 'olivia_brown.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE `child` (
  `child_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `medical_history` text DEFAULT NULL,
  `special_needs` enum('Yes','No') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`child_id`, `name`, `date_of_birth`, `gender`, `medical_history`, `special_needs`, `user_id`) VALUES
(1, 'Alice Doe', '2010-01-01', 'female', 'None', 'No', 1),
(2, 'Charlie Doe', '2012-02-15', 'male', 'Asthma', 'Yes', 1),
(3, 'Sophia Smith', '2013-04-20', 'female', 'None', 'No', 2),
(4, 'Liam Smith', '2015-06-30', 'male', 'Allergies', 'Yes', 2);

-- --------------------------------------------------------

--
-- Table structure for table `child_caregiver`
--

CREATE TABLE `child_caregiver` (
  `child_id` int(11) NOT NULL,
  `caregiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `child_caregiver`
--

INSERT INTO `child_caregiver` (`child_id`, `caregiver_id`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `learning`
--

CREATE TABLE `learning` (
  `learning_id` int(11) NOT NULL,
  `learning_type` varchar(255) NOT NULL,
  `progress_notes` text DEFAULT NULL,
  `date` date NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learning`
--

INSERT INTO `learning` (`learning_id`, `learning_type`, `progress_notes`, `date`, `child_id`) VALUES
(1, 'Math', 'Good progress in arithmetic', '2025-01-20', 1),
(2, 'Science', 'Needs improvement in experiments', '2025-01-19', 2),
(3, 'Reading', 'Improved comprehension', '2025-01-18', 3),
(4, 'Writing', 'Needs help with handwriting', '2025-01-17', 4);

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE `meal` (
  `meal_id` int(11) NOT NULL,
  `meal_name` varchar(100) NOT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `child_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal`
--

INSERT INTO `meal` (`meal_id`, `meal_name`, `allergies`, `date`, `child_id`, `bill_id`) VALUES
(1, 'Pasta', 'None', '2025-01-21', 1, 1),
(2, 'Sandwich', 'Peanut', '2025-01-22', 2, 2),
(3, 'Fruit Salad', 'None', '2025-01-23', 3, 1),
(4, 'Rice and Chicken', 'None', '2025-01-24', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `notification_type` varchar(50) NOT NULL,
  `status` enum('Unread','Read') NOT NULL,
  `created_at` datetime NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `child_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `message`, `notification_type`, `status`, `created_at`, `sent_at`, `read_at`, `user_id`, `child_id`) VALUES
(1, 'Your child Alice has completed the art class.', 'Activity Completed', 'Unread', '2025-01-21 10:00:00', NULL, NULL, 1, 1),
(2, 'Your child Sophia has been marked present.', 'Attendance', 'Read', '2025-01-23 09:00:00', '2025-01-23 09:05:00', '2025-01-23 09:10:00', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pickdrop`
--

CREATE TABLE `pickdrop` (
  `pickdrop_id` int(11) NOT NULL,
  `time` time NOT NULL,
  `status` enum('Picked','Dropped') NOT NULL,
  `notification_status` enum('Sent','Not Sent') NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pickdrop`
--

INSERT INTO `pickdrop` (`pickdrop_id`, `time`, `status`, `notification_status`, `child_id`) VALUES
(1, '08:00:00', 'Picked', 'Sent', 1),
(2, '08:30:00', 'Dropped', 'Sent', 2),
(3, '09:00:00', 'Picked', 'Not Sent', 3),
(4, '09:30:00', 'Dropped', 'Not Sent', 4);

-- --------------------------------------------------------

--
-- Table structure for table `specialcare`
--

CREATE TABLE `specialcare` (
  `special_care_id` int(11) NOT NULL,
  `medical_condition` text NOT NULL,
  `support_type` varchar(255) NOT NULL,
  `child_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specialcare`
--

INSERT INTO `specialcare` (`special_care_id`, `medical_condition`, `support_type`, `child_id`, `bill_id`) VALUES
(1, 'Asthma', 'Inhaler Usage', 2, 2),
(2, 'Allergies', 'Avoidance of certain foods', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('Parent','Admin','Caregiver') NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_info` varchar(15) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `role`, `password`, `contact_info`, `profile_image`) VALUES
(1, 'John Doe', 'john.doe@example.com', 'Parent', 'password123', '123-456-7890', 'john_doe.jpg'),
(2, 'Jane Smith', 'jane.smith@example.com', 'Parent', 'password123', '987-654-3210', 'jane_smith.jpg'),
(3, 'Admin', 'admin@gmail.com', 'Admin', 'admin', '555-123-4567', 'admin.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `bill_payment`
--
ALTER TABLE `bill_payment`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `caregivers`
--
ALTER TABLE `caregivers`
  ADD PRIMARY KEY (`caregiver_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `child`
--
ALTER TABLE `child`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `child_caregiver`
--
ALTER TABLE `child_caregiver`
  ADD PRIMARY KEY (`child_id`,`caregiver_id`),
  ADD KEY `caregiver_id` (`caregiver_id`);

--
-- Indexes for table `learning`
--
ALTER TABLE `learning`
  ADD PRIMARY KEY (`learning_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`meal_id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `pickdrop`
--
ALTER TABLE `pickdrop`
  ADD PRIMARY KEY (`pickdrop_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `specialcare`
--
ALTER TABLE `specialcare`
  ADD PRIMARY KEY (`special_care_id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bill_payment`
--
ALTER TABLE `bill_payment`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `caregivers`
--
ALTER TABLE `caregivers`
  MODIFY `caregiver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `child`
--
ALTER TABLE `child`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `learning`
--
ALTER TABLE `learning`
  MODIFY `learning_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
  MODIFY `meal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pickdrop`
--
ALTER TABLE `pickdrop`
  MODIFY `pickdrop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `specialcare`
--
ALTER TABLE `specialcare`
  MODIFY `special_care_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`);

--
-- Constraints for table `bill_payment`
--
ALTER TABLE `bill_payment`
  ADD CONSTRAINT `bill_payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `child`
--
ALTER TABLE `child`
  ADD CONSTRAINT `child_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `child_caregiver`
--
ALTER TABLE `child_caregiver`
  ADD CONSTRAINT `child_caregiver_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`),
  ADD CONSTRAINT `child_caregiver_ibfk_2` FOREIGN KEY (`caregiver_id`) REFERENCES `caregivers` (`caregiver_id`);

--
-- Constraints for table `learning`
--
ALTER TABLE `learning`
  ADD CONSTRAINT `learning_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`);

--
-- Constraints for table `meal`
--
ALTER TABLE `meal`
  ADD CONSTRAINT `meal_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`),
  ADD CONSTRAINT `meal_ibfk_2` FOREIGN KEY (`bill_id`) REFERENCES `bill_payment` (`bill_id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`);

--
-- Constraints for table `pickdrop`
--
ALTER TABLE `pickdrop`
  ADD CONSTRAINT `pickdrop_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`);

--
-- Constraints for table `specialcare`
--
ALTER TABLE `specialcare`
  ADD CONSTRAINT `specialcare_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`),
  ADD CONSTRAINT `specialcare_ibfk_2` FOREIGN KEY (`bill_id`) REFERENCES `bill_payment` (`bill_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
