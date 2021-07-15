-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2020 at 07:25 AM
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
-- Database: `tmpd`
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

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_id`, `topic`, `type`, `version`, `person_id`, `pos_target`, `step`, `count`, `status_id`, `date_create`, `finish`) VALUES
(1, 'อุปกรณ์เครือข่าย', 1, 1, 16, NULL, 0, 0, 2, '16/11/2563 13:13:10', ''),
(2, 'อุปกรณ์ทดสอบ', 1, 1, 14, NULL, 0, 0, 2, '17/11/2563 04:41:49', '');

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

--
-- Dumping data for table `activity_detail`
--

INSERT INTO `activity_detail` (`activity_detail_id`, `activity_id`, `person_id`, `step`, `count`, `step_detail_id`, `check_document`, `document_name`, `version`, `status_id`, `date`, `note`) VALUES
(1, 1, 16, 0, 0, 0, '', '', 1, 1, '16/11/2563 13:13:10', ''),
(2, 1, 16, 0, 0, 1, '', '1_จัดซื้อ01_2.pdf', 1, 0, '16/11/2563 13:14:24', ''),
(3, 1, 16, 0, 0, 2, 'reject', '1_จัดซื้อ01_3.docx', 1, 0, '16/11/2563 13:14:32', ''),
(4, 1, 16, 0, 0, 2, '', '1_จัดซื้อ01_4.docx', 1, 0, '16/11/2563 13:15:03', ''),
(5, 1, 16, 0, 0, 0, '', '', 1, 2, '16/11/2563 13:15:06', ''),
(6, 2, 14, 0, 0, 0, '', '', 1, 1, '17/11/2563 04:41:49', ''),
(7, 2, 14, 0, 0, 1, '', '2_จัดซื้อ01_2.txt', 1, 0, '17/11/2563 04:49:18', ''),
(8, 2, 14, 0, 0, 1, '', '2_จัดซื้อ01_3.json', 1, 0, '17/11/2563 05:01:02', ''),
(9, 0, 0, 0, 0, 0, '', '__1.docx', 0, 0, '17/11/2563 12:28:52', ''),
(10, 2, 14, 0, 0, 2, '', '2_จัดซื้อ01_4.docx', 1, 0, '17/11/2563 12:29:29', ''),
(11, 2, 14, 0, 0, 0, '', '', 1, 2, '17/11/2563 12:30:01', ''),
(12, 2, 14, 0, 0, 0, '', '', 1, 2, '17/11/2563 12:51:11', '');

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
  `title_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `surname` varchar(60) NOT NULL,
  `status` varchar(10) NOT NULL,
  `position` int(11) NOT NULL,
  `person_email` varchar(50) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `line_token` varchar(60) DEFAULT NULL,
  `user_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `title_id`, `name`, `surname`, `status`, `position`, `person_email`, `username`, `password`, `line_token`, `user_status`) VALUES
(1, 1, 'admin', 'istrator', 'on', 1, '', 'admin', '61730dd707a332050815922615b8dc09', '', 'activated'),
(12, 1, 'ส่ง', 'กำลัง', 'on', 99, '', 'pos99', '61730dd707a332050815922615b8dc09', NULL, 'activated'),
(13, 2, 'งบ', 'ประมาณ', 'on', 2, 'khuk1234@hotmail.com', 'pos2', '73440a383dbf647087463273add9b71e', NULL, 'activated'),
(14, 1, 'สรรเพชญ', 'กิจเปรื่อง', 'off', 3, 'khuk@hotmail.co.th', 'pos3', '1fe86ae99468f8900627004d0f5316e1', NULL, 'activated'),
(15, 3, 'พลา', 'ธิการ', 'on', 4, '', 'pos4', '61730dd707a332050815922615b8dc09', NULL, 'activated'),
(16, 2, 'ศูนย์', 'คอม', 'off', 6, '', 'commu', '61730dd707a332050815922615b8dc09', NULL, 'unactivated'),
(17, 1, 'สรรเพชญ', 'กิจเปรื่อง', '', 1, '', 'sanphet', '61730dd707a332050815922615b8dc09', NULL, 'activated'),
(18, 1, 'จักร', 'พง', 'on', 3, '', 'jugg', '61730dd707a332050815922615b8dc09', NULL, 'activated'),
(19, 1, 'สรรเพชญ', 'กิจเปรื่อง', 'off', 2, '', 'sanphetz', '61730dd707a332050815922615b8dc09', NULL, 'activated'),
(20, 1, 'อมรเทพ', 'ธรรมเมธา', 'off', 2, '', 'game', '61730dd707a332050815922615b8dc09', NULL, 'activated');

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

--
-- Dumping data for table `step_detail`
--

INSERT INTO `step_detail` (`step_detail_id`, `step`, `document_name`, `document_status`, `version`, `date`) VALUES
(1, 0, 'ตัวอย่างบันทึกข้อความ เสนอความต้องการ.docx', 'on', 1, '16/11/2563 13:09:17'),
(2, 0, 'ตัวอย่างขอบเขตของงาน.docx', 'on', 1, '16/11/2563 13:09:48'),
(3, 102, '8642_แบบตกลงราคาซื้อจ้าง.doc', 'on', 1, '16/11/2563 13:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `title`
--

CREATE TABLE `title` (
  `title_id` int(11) NOT NULL,
  `title_name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `title`
--

INSERT INTO `title` (`title_id`, `title_name`) VALUES
(1, 'นาย'),
(2, 'นาง'),
(3, 'นางสาว\r\n');

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
-- Indexes for table `title`
--
ALTER TABLE `title`
  ADD PRIMARY KEY (`title_id`);

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
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `activity_detail`
--
ALTER TABLE `activity_detail`
  MODIFY `activity_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `activity_type`
--
ALTER TABLE `activity_type`
  MODIFY `activity_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `step_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `title`
--
ALTER TABLE `title`
  MODIFY `title_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
