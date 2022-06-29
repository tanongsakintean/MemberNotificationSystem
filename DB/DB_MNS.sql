-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 24, 2022 at 04:26 PM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DB_MNS`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_data`
--

CREATE TABLE `admin_data` (
  `ad_id` int(11) NOT NULL,
  `ad_name` varchar(50) NOT NULL,
  `ad_tel` varchar(10) NOT NULL,
  `ad_email` varchar(50) NOT NULL,
  `ad_password` varchar(100) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ad_status` int(11) NOT NULL,
  `login_status` int(11) NOT NULL COMMENT 'สถานะlogin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_data`
--

INSERT INTO `admin_data` (`ad_id`, `ad_name`, `ad_tel`, `ad_email`, `ad_password`, `last_login`, `ad_status`, `login_status`) VALUES
(1, 'admin', '0987654321', 'admin@gmail.com', '1234', '2022-06-13 13:44:43', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `guest_data`
--

CREATE TABLE `guest_data` (
  `guest_id` int(11) NOT NULL COMMENT 'ไอดีคนทั่วไป',
  `noti_id` int(11) NOT NULL COMMENT 'ไอดีข้อควม',
  `guest_tel` varchar(10) NOT NULL COMMENT 'เบอร์โทรคนทั่วไป'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notify_data`
--

CREATE TABLE `notify_data` (
  `noti_id` int(11) NOT NULL COMMENT 'ไอดีของข้อความ',
  `sv_id` int(11) NOT NULL COMMENT 'ไอดีของบริการ',
  `noti_sender` varchar(100) NOT NULL COMMENT 'ชื่อผู้ส่ง',
  `noti_selected` int(11) NOT NULL COMMENT 'เก็บเบอร์ทั้งหมด',
  `noti_meg` text NOT NULL COMMENT 'เนื้อหาข้อความ',
  `noti_start` text NOT NULL COMMENT 'วันที่สร้างข้อความ',
  `noti_end` text COMMENT 'วันหมดอายุข้อความ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notify_data_item`
--

CREATE TABLE `notify_data_item` (
  `noti_id` int(11) NOT NULL COMMENT 'ไอดีข้อความ',
  `user_id` varchar(11) NOT NULL COMMENT 'ไอดีuser',
  `item_stauts` int(11) NOT NULL COMMENT 'สถานะสำเร็จไหม',
  `item_tranfer` text NOT NULL COMMENT 'เวลาที่ส่ง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `service_data`
--

CREATE TABLE `service_data` (
  `sv_id` int(11) NOT NULL COMMENT '	เซอร์วิสไอดี',
  `sv_name` varchar(100) NOT NULL COMMENT 'ชื่อบริการ',
  `sv_description` text NOT NULL COMMENT 'รายละเอียดของบริการ',
  `sv_start` text NOT NULL COMMENT 'วันแรกของการบริการ	',
  `sv_end` text NOT NULL COMMENT 'วันสุดท้ายของการบริการ	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_data`
--

INSERT INTO `service_data` (`sv_id`, `sv_name`, `sv_description`, `sv_start`, `sv_end`) VALUES
(1, 'TRUE SERVICE', 'THIS IS TRUE SERVICE ', '01/06/2565 22:53:00', '15/07/2565 22:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_tel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`user_id`, `user_name`, `user_email`, `user_tel`) VALUES
(8, 'ทนงศักดิ์ อินเทียน', 'tanongsakintean.5333@gmail.com', '0957203908'),
(10, 'as;jfsd', 'fddfsdsf@gasmoc.com', '2222222222'),
(11, 'asjf[pasfgpohdefb', 'apskdjfkpsdnf.@hotmail.com', '4444444444');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_data`
--
ALTER TABLE `admin_data`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `guest_data`
--
ALTER TABLE `guest_data`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `notify_data`
--
ALTER TABLE `notify_data`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `service_data`
--
ALTER TABLE `service_data`
  ADD PRIMARY KEY (`sv_id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_data`
--
ALTER TABLE `admin_data`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guest_data`
--
ALTER TABLE `guest_data`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีคนทั่วไป';

--
-- AUTO_INCREMENT for table `notify_data`
--
ALTER TABLE `notify_data`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีของข้อความ';

--
-- AUTO_INCREMENT for table `service_data`
--
ALTER TABLE `service_data`
  MODIFY `sv_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	เซอร์วิสไอดี', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
