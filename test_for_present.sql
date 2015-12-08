-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2015 at 01:01 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(30) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`c_id`, `c_name`) VALUES
(1001, 'English'),
(1888, 'Philosophy'),
(1999, 'Maths');

-- --------------------------------------------------------

--
-- Table structure for table `course_sec`
--

CREATE TABLE IF NOT EXISTS `course_sec` (
  `c_sec_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  PRIMARY KEY (`c_sec_id`),
  KEY `course_sec_user_id_fk` (`user_id`),
  KEY `course_sec_c_id_fk` (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_sec`
--

INSERT INTO `course_sec` (`c_sec_id`, `user_id`, `c_id`) VALUES
(2111, 9999, 1001),
(2222, 9999, 1888),
(2333, 9777, 1001),
(2444, 9777, 1888),
(2555, 9777, 1999),
(2666, 9999, 1999);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE IF NOT EXISTS `exam` (
  `c_sec_id` int(11) NOT NULL,
  `room_id` varchar(30) NOT NULL,
  `exam_date` int(11) NOT NULL,
  `time_slot` varchar(30) NOT NULL,
  KEY `exam_c_sec_id_fk` (`c_sec_id`),
  KEY `exam_room_id_fk` (`room_id`),
  KEY `exam_exam_date_fk` (`exam_date`),
  KEY `exam_time_slot_fk` (`time_slot`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`c_sec_id`, `room_id`, `exam_date`, `time_slot`) VALUES
(2111, 'E417', 1, '08-10'),
(2222, 'J129', 1, '08-10'),
(2666, 'J132', 1, '08-10'),
(2333, 'E417', 1, '10-12'),
(2444, 'J129', 2, '08-10');

-- --------------------------------------------------------

--
-- Table structure for table `exam_date`
--

CREATE TABLE IF NOT EXISTS `exam_date` (
  `exam_date` varchar(30) NOT NULL,
  `date_id` int(11) NOT NULL,
  PRIMARY KEY (`date_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_date`
--

INSERT INTO `exam_date` (`exam_date`, `date_id`) VALUES
('Mon', 1),
('Tue', 2),
('Wed', 3),
('Thu', 4),
('Fri', 5);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `room_id` varchar(30) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`) VALUES
('E417'),
('J129'),
('J132');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE IF NOT EXISTS `time_slot` (
  `time_slot` varchar(30) NOT NULL,
  PRIMARY KEY (`time_slot`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`time_slot`) VALUES
('08-10'),
('10-12'),
('13-15'),
('15-17');

-- --------------------------------------------------------

--
-- Table structure for table `user_pwd`
--

CREATE TABLE IF NOT EXISTS `user_pwd` (
  `user_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `usr_grp` varchar(15) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_pwd`
--

INSERT INTO `user_pwd` (`user_id`, `name`, `password`, `usr_grp`) VALUES
(9001, 'admin', 'admin', 'adm'),
(9777, 'jane', 'jane', 'instructor'),
(9999, 'jeff', 'jeff', 'instructor');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_sec`
--
ALTER TABLE `course_sec`
  ADD CONSTRAINT `course_sec_c_id_fk` FOREIGN KEY (`c_id`) REFERENCES `course` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_sec_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user_pwd` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_c_sec_id_fk` FOREIGN KEY (`c_sec_id`) REFERENCES `course_sec` (`c_sec_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_exam_date_fk` FOREIGN KEY (`exam_date`) REFERENCES `exam_date` (`date_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_room_id_fk` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_time_slot_fk` FOREIGN KEY (`time_slot`) REFERENCES `time_slot` (`time_slot`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
