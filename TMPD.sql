-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 29, 2020 at 09:19 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TMPD`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL,
  `topic` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `pos_target` int(11) DEFAULT NULL,
  `step` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `date_create` varchar(50) NOT NULL,
  `finish` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_detail`
--

CREATE TABLE `activity_detail` (
  `activity_detail_id` int(11) NOT NULL,
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
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_type`
--

CREATE TABLE `activity_type` (
  `activity_type_id` int(11) NOT NULL,
  `type` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity_type`
--

INSERT INTO `activity_type` (`activity_type_id`, `type`) VALUES
(1, 'จัดซื้อ'),
(2, 'จัดจ้าง');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `surname` varchar(60) NOT NULL,
  `status` varchar(10) NOT NULL,
  `position` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `line_token` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `name`, `surname`, `status`, `position`, `username`, `password`, `line_token`) VALUES
(1, 'admin', 'istrator', 'on', 1, 'admin', '4d3283e4b0ff88dcb5d8b5a27c8e05f1', '');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` int(11) NOT NULL,
  `position` varchar(60) NOT NULL,
  `position_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `position`, `position_type_id`) VALUES
(1, 'ผู้ดูแลระบบ', NULL),
(2, 'งบประมาณ', NULL),
(3, 'อำนวยการ', NULL),
(4, 'พลาธิการ', NULL),
(6, 'ศูนย์คอม', 2),
(7, 'ฝ่ายช่าง', 2),
(98, 'ส่วนดูแล', 2),
(99, 'ส่งกำลัง', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `position_type`
--

CREATE TABLE `position_type` (
  `position_type_id` int(11) NOT NULL,
  `position_title` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `position_type`
--

INSERT INTO `position_type` (`position_type_id`, `position_title`) VALUES
(2, 98);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status`) VALUES
(1, 'จัดเตรียมข้อมูล'),
(2, 'ส่งข้อมูล'),
(3, 'รับข้อมูลแล้ว'),
(4, 'ส่งกลับ(ยกเลิกการรับ)'),
(5, 'ทดสอบ'),
(7, 'จบการทำงาน'),
(8, 'ส่งกลับ(แก้ไขเอกสาร)');

-- --------------------------------------------------------

--
-- Table structure for table `step`
--

CREATE TABLE `step` (
  `step_id` int(11) NOT NULL,
  `step` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `action_type` varchar(10) DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `step`
--

INSERT INTO `step` (`step_id`, `step`, `type_id`, `action_type`, `position_id`, `version`) VALUES
(1, 0, 1, NULL, 0, 1),
(2, 101, 1, 'one_way', 99, 1),
(3, 102, 1, 'one_way', 2, 1),
(4, 103, 1, 'one_way', 3, 1),
(5, 104, 1, 'one_way', 99, 1),
(6, 105, 1, 'one_way', 4, 1),
(7, 106, 1, 'one_way', 99, 1),
(8, 0, 2, NULL, 0, 1),
(9, 201, 2, 'one_way', 99, 1),
(10, 202, 2, 'one_way', 98, 1),
(11, 203, 2, 'two_way', 99, 1),
(12, 204, 2, 'one_way', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `step_detail`
--

CREATE TABLE `step_detail` (
  `step_detail_id` int(11) NOT NULL,
  `step` int(11) NOT NULL,
  `document_name` varchar(50) NOT NULL,
  `document_status` varchar(50) NOT NULL,
  `version` int(11) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE `version` (
  `version_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `status` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `version`
--

INSERT INTO `version` (`version_id`, `type_id`, `version`, `status`) VALUES
(1, 1, 1, 'on'),
(2, 2, 1, 'on');

-- --------------------------------------------------------

--
-- Table structure for table `version_detail`
--

CREATE TABLE `version_detail` (
  `version_detail_id` int(11) NOT NULL,
  `version_id` int(11) NOT NULL,
  `detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `activity_detail`
--
ALTER TABLE `activity_detail`
  ADD PRIMARY KEY (`activity_detail_id`);

--
-- Indexes for table `activity_type`
--
ALTER TABLE `activity_type`
  ADD PRIMARY KEY (`activity_type_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `position_type`
--
ALTER TABLE `position_type`
  ADD PRIMARY KEY (`position_type_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `step`
--
ALTER TABLE `step`
  ADD PRIMARY KEY (`step_id`);

--
-- Indexes for table `step_detail`
--
ALTER TABLE `step_detail`
  ADD PRIMARY KEY (`step_detail_id`);

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`version_id`);

--
-- Indexes for table `version_detail`
--
ALTER TABLE `version_detail`
  ADD PRIMARY KEY (`version_detail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_detail`
--
ALTER TABLE `activity_detail`
  MODIFY `activity_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_type`
--
ALTER TABLE `activity_type`
  MODIFY `activity_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `position_type`
--
ALTER TABLE `position_type`
  MODIFY `position_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `step`
--
ALTER TABLE `step`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `step_detail`
--
ALTER TABLE `step_detail`
  MODIFY `step_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `version`
--
ALTER TABLE `version`
  MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `version_detail`
--
ALTER TABLE `version_detail`
  MODIFY `version_detail_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
