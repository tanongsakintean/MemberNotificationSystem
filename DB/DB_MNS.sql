-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 29, 2022 at 11:33 AM
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
  `login_status` int(11) NOT NULL COMMENT 'สถานะlogin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_data`
--

INSERT INTO `admin_data` (`ad_id`, `ad_name`, `ad_tel`, `ad_email`, `ad_password`, `last_login`, `login_status`) VALUES
(1, 'admin', '0987654321', 'admin@gmail.com', '123', '2022-06-29 00:43:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `guest_data`
--

CREATE TABLE `guest_data` (
  `guest_id` int(11) NOT NULL COMMENT 'ไอดีคนทั่วไป',
  `noti_id` int(11) NOT NULL COMMENT 'ไอดีข้อควม',
  `guest_tel` varchar(20) NOT NULL COMMENT 'เบอร์โทรคนทั่วไป'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guest_data`
--

INSERT INTO `guest_data` (`guest_id`, `noti_id`, `guest_tel`) VALUES
(65, 42, '1010101010'),
(66, 35, '0987654537'),
(67, 43, '9999999999'),
(68, 47, '1111112222');

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
  `noti_end` text COMMENT 'วันหมดอายุข้อความ',
  `noti_status` int(1) NOT NULL COMMENT 'สถานะหมดอายุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notify_data`
--

INSERT INTO `notify_data` (`noti_id`, `sv_id`, `noti_sender`, `noti_selected`, `noti_meg`, `noti_start`, `noti_end`, `noti_status`) VALUES
(34, 0, 'Force', 1, '22222', '26/06/2565 23:39', '26/06/2565 23:39', 1),
(35, 11, 'REMARK', 1, 'this', '25/06/2565 18:07', '30/06/2565 18:06', 2),
(37, 0, 'Peivileged', 1, 'ddd', '26/06/2565 23:41', '28/06/2565 00:00', 1),
(38, 11, 'Force', 1, 'dsdsds', '26/06/2565 23:52', '29/06/2565 23:52', 2),
(39, 13, 'Peivileged', 1, 'fddffdfd', '28/06/2565 10:54', '29/07/2565 10:54', 0),
(40, 13, 'Force', 0, 'dfdffdfd', '28/06/2565 10:55', '14/07/2565 10:55', 0),
(41, 11, 'Force', 1, 'dsdsdsds', '28/06/2565 11:06', '29/06/2565 11:06', 2),
(42, 0, 'NOWW', 1, 'ewweewwe', '28/06/2565 14:45', '01/07/2565 14:45', 2),
(43, 11, 'NOWW', 1, 'iooo', '29/06/2565 07:08', '09/07/2565 07:08', 0),
(44, 11, 'REMARK', 0, 'lllllll', '29/06/2565 07:12', '08/07/2565 07:12', 0),
(45, 11, 'Force', 1, ';;;kk', '29/06/2565 07:20', '09/07/2565 07:19', 0),
(46, 11, 'Peivileged', 0, 'kkk', '29/06/2565 07:21', '09/07/2565 07:21', 0),
(47, 11, 'Peivileged', 1, '22s', '24/06/2565 07:31', '15/07/2565 07:31', 0);

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

--
-- Dumping data for table `notify_data_item`
--

INSERT INTO `notify_data_item` (`noti_id`, `user_id`, `item_stauts`, `item_tranfer`) VALUES
(38, '10', 1, '26/06/2565 23:52'),
(38, '11', 1, '26/06/2565 23:52'),
(38, '13', 1, '26/06/2565 23:52'),
(37, '10', 1, '2022-07-12T23:41'),
(37, '11', 1, '2022-07-12T23:41'),
(37, '13', 1, '2022-07-12T23:41'),
(41, '11', 1, '28/06/2565 11:06'),
(42, '11', 1, '28/06/2565 14:45'),
(42, '17', 1, '28/06/2565 14:45'),
(35, '11', 1, '2022-06-29 00:07'),
(35, '19', 1, '2022-06-29 00:07'),
(35, '20', 1, '2022-06-29 00:07'),
(35, '21', 1, '2022-06-29 00:07'),
(35, '22', 1, '2022-06-29 00:07'),
(35, '23', 1, '2022-06-29 00:07'),
(35, '24', 1, '2022-06-29 00:07'),
(35, '25', 1, '2022-06-29 00:07'),
(43, '11', 1, '29/06/2565 7:08'),
(43, '20', 1, '2022-07-09T07:08'),
(44, '17', 1, '29/06/2565 7:12'),
(45, '11', 1, '29/06/2565 7:20'),
(45, '17', 1, '29/06/2565 7:20'),
(45, '19', 1, '29/06/2565 7:20'),
(45, '20', 1, '29/06/2565 7:20'),
(45, '21', 1, '29/06/2565 7:20'),
(45, '22', 1, '29/06/2565 7:20'),
(45, '23', 1, '29/06/2565 7:20'),
(45, '24', 1, '29/06/2565 7:20'),
(45, '25', 1, '29/06/2565 7:20'),
(46, '11', 1, '29/06/2565 7:21'),
(47, '11', 1, '29/06/2565 7:31');

-- --------------------------------------------------------

--
-- Table structure for table `service_data`
--

CREATE TABLE `service_data` (
  `sv_id` int(11) NOT NULL COMMENT '	เซอร์วิสไอดี',
  `sv_name` varchar(100) NOT NULL COMMENT 'ชื่อบริการ',
  `sv_description` text NOT NULL COMMENT 'รายละเอียดของบริการ',
  `sv_start` text NOT NULL COMMENT 'วันแรกของการบริการ	',
  `sv_end` text NOT NULL COMMENT 'วันสุดท้ายของการบริการ	',
  `sv_status` int(11) NOT NULL COMMENT 'สถานะหมดอายุ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_data`
--

INSERT INTO `service_data` (`sv_id`, `sv_name`, `sv_description`, `sv_start`, `sv_end`, `sv_status`) VALUES
(11, 'THURE SERVICE', 'df', '25/06/2565 15:18', '01/07/2565 00:00', 2),
(15, 'fdsasdffaaaaaaaaaaaaaa', 'sadfsadfsdafsasfsfsf', '29/06/2565 01:44:00', '30/06/2565 01:44:00', 2);

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
(11, 'asjf[pasfgpohdefb', 'apskdjfkpsdnf.@hotmail.com', '4444444444'),
(17, 'ddsdsds', 'sdd@gmial.com', '0000000001'),
(19, 'dsds', 'ds@gmail.com', 'dsfaaaaaaa'),
(20, 'dfas', 'saf@gmial.com', 'asdfffffff'),
(21, 'fdfgfdf', 'fdfd@gmail.com', 'fasdfsadfs'),
(22, 'dsdsds', 'd!@gmial.com', 'dsssssssss'),
(23, 'dsds', 'dsd@gmailcom', 'fdsaaaaaaa'),
(24, 'asdfdfas', 'sdf@gmail.com', 'adfsadsfds'),
(25, 'fddf', 'fd@gmail.com', 'dfdfffffff');

-- --------------------------------------------------------

--
-- Table structure for table `warn_noti`
--

CREATE TABLE `warn_noti` (
  `warn_id` int(11) NOT NULL COMMENT 'ไอดีแจ้วเตือน',
  `noti_id` int(11) NOT NULL COMMENT 'ไอดีข้อความ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `warn_sv`
--

CREATE TABLE `warn_sv` (
  `warn_id` int(11) NOT NULL COMMENT 'ไอดีแจ้งเตือน',
  `sv_id` int(11) NOT NULL COMMENT 'ไอดีบริการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Indexes for table `warn_noti`
--
ALTER TABLE `warn_noti`
  ADD PRIMARY KEY (`warn_id`);

--
-- Indexes for table `warn_sv`
--
ALTER TABLE `warn_sv`
  ADD PRIMARY KEY (`warn_id`);

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
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีคนทั่วไป', AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `notify_data`
--
ALTER TABLE `notify_data`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีของข้อความ', AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `service_data`
--
ALTER TABLE `service_data`
  MODIFY `sv_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	เซอร์วิสไอดี', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `warn_noti`
--
ALTER TABLE `warn_noti`
  MODIFY `warn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีแจ้วเตือน';

--
-- AUTO_INCREMENT for table `warn_sv`
--
ALTER TABLE `warn_sv`
  MODIFY `warn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีแจ้งเตือน';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
