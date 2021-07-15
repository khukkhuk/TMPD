-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2020 at 06:14 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testsql`
--
CREATE DATABASE IF NOT EXISTS `testsql` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `testsql`;

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE IF NOT EXISTS `activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `pos_target` int(11) DEFAULT NULL,
  `step` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `date_create` varchar(50) NOT NULL,
  `finish` varchar(50) NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_detail`
--

DROP TABLE IF EXISTS `activity_detail`;
CREATE TABLE IF NOT EXISTS `activity_detail` (
  `activity_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `step` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `step_detail_id` int(11) NOT NULL,
  `check_document` varchar(10) NOT NULL,
  `document_name` varchar(100) NOT NULL,
  `version` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`activity_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_type`
--

DROP TABLE IF EXISTS `activity_type`;
CREATE TABLE IF NOT EXISTS `activity_type` (
  `activity_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(60) NOT NULL,
  PRIMARY KEY (`activity_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `surname` varchar(60) NOT NULL,
  `status` varchar(10) NOT NULL,
  `position` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `line_token` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  KEY `position` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `name`, `surname`, `status`, `position`, `username`, `password`, `line_token`) VALUES
(1, 'ผู้ดูแล', 'ระบบ', 'on', 1, 'admin', '4d3283e4b0ff88dcb5d8b5a27c8e05f1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(60) NOT NULL,
  `position_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `position`, `position_type_id`) VALUES
(1, 'ผู้ดูแลระบบ',NULL);
-- --------------------------------------------------------

--
-- Table structure for table `position_type`
--

DROP TABLE IF EXISTS `position_type`;
CREATE TABLE IF NOT EXISTS `position_type` (
  `position_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `position_title` int(11) NOT NULL,
  PRIMARY KEY (`position_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `step`
--

DROP TABLE IF EXISTS `step`;
CREATE TABLE IF NOT EXISTS `step` (
  `step_id` int(11) NOT NULL AUTO_INCREMENT,
  `step` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`step_id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `step_detail`
--

DROP TABLE IF EXISTS `step_detail`;
CREATE TABLE IF NOT EXISTS `step_detail` (
  `step_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `step` int(11) NOT NULL,
  `document_name` varchar(50) NOT NULL,
  `document_status` varchar(50) NOT NULL,
  `version` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`step_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

DROP TABLE IF EXISTS `version`;
CREATE TABLE IF NOT EXISTS `version` (
  `version_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `status` varchar(3) NOT NULL,
  PRIMARY KEY (`version_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `version_detail`
--

DROP TABLE IF EXISTS `version_detail`;
CREATE TABLE IF NOT EXISTS `version_detail` (
  `version_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_id` int(11) NOT NULL,
  `detail` text NOT NULL,
  PRIMARY KEY (`version_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
