-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2019 at 08:32 PM
-- Server version: 5.7.25-0ubuntu0.18.04.2
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP USER IF EXISTS 'londoners'@'localhost' ;

DROP DATABASE IF EXISTS Londoners;
CREATE DATABASE Londoners;



grant all privileges on Londoners.* to 'londoners'@'localhost' identified by 'London123!' ;


use Londoners;
--
-- Database: `Londoners`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_master`
--

CREATE TABLE `admin_master` (
  `admin_master_id` int(11) NOT NULL primary key AUTO_INCREMENT ,
  `admin_user_id` int(11) NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_master`
--

CREATE TABLE `category_master` (
  `category_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `code` varchar(3) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location_master`
--

CREATE TABLE `location_master` (
  `location_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `location_code` char(3) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `login_history_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `login_user_id` int(11) NOT NULL,
  `sign_in_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sign_out_time` timestamp NULL DEFAULT NULL,
  `comments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_profile`
--

CREATE TABLE `member_profile` (
  `member_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` char(1) CHARACTER SET latin1 NOT NULL,
  `inactive_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_action_type`
--

CREATE TABLE `post_action_type` (
  `action_type_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `type_code` char(2) NOT NULL,
  `type_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_master`
--

CREATE TABLE `post_master` (
  `post_master_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `post_heading` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contents` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime NOT NULL,
  `post_active` char(1) NOT NULL,
  `post_inactive_date` datetime NOT NULL,
  `post_viewer_action_id` int(11) NOT NULL,
  `comments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_threads`
--

CREATE TABLE `post_threads` (
  `post_thread_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `post_master_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `previous_thread_id` int(11) NOT NULL,
  `thread_created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `thread_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `province_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `name` varchar(60) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_type` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `user_type_code` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_type_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member_profile`
--
ALTER TABLE `member_profile`
  ADD KEY `province_id` (`province_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_action_type`
--


--
-- Indexes for table `post_master`
--
ALTER TABLE `post_master`
  ADD KEY `member_id` (`member_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `post_viewer_action_id` (`post_viewer_action_id`);

--
-- Indexes for table `post_threads`
--
ALTER TABLE `post_threads`
  ADD KEY `member_id` (`member_id`),
  ADD KEY `post_master_id` (`post_master_id`),
  ADD KEY `member_id_2` (`member_id`),
  ADD KEY `previous_thread_id` (`previous_thread_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD KEY `user_type` (`user_type`),
  ADD KEY `created_by` (`created_by`);



--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_master`
--
ALTER TABLE `admin_master`
  ADD CONSTRAINT `admin_master_ibfk_1` FOREIGN KEY (`admin_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`login_history_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `member_profile`
--
ALTER TABLE `member_profile`
  ADD CONSTRAINT `member_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_profile_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_profile_ibfk_3` FOREIGN KEY (`province_id`) REFERENCES `province` (`province_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_master`
--
ALTER TABLE `post_master`
  ADD CONSTRAINT `post_master_ibfk_1` FOREIGN KEY (`post_viewer_action_id`) REFERENCES `post_action_type` (`action_type_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_master_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category_master` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_master_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `location_master` (`location_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_threads`
--
ALTER TABLE `post_threads`
  ADD CONSTRAINT `post_threads_ibfk_1` FOREIGN KEY (`post_master_id`) REFERENCES `post_master` (`post_master_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_threads_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member_profile` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_threads_ibfk_3` FOREIGN KEY (`previous_thread_id`) REFERENCES `post_threads` (`post_thread_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `province`
--
ALTER TABLE `province`
  ADD CONSTRAINT `province_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`user_type_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- set primary data
-- insert country
insert into country values (Null,'CA', 'Canada');

-- insert province
INSERT INTO province (province_id, name, code,country_id)
VALUES
    (NULL, 'Alberta', 'AB',1),
    (NULL, 'British Columbia', 'BC',1),
    (NULL, 'Manitoba', 'MB',1),
    (NULL, 'New Brunswick', 'NB',1),
    (NULL, 'Newfoundland and Labrador', 'NL',1),
    (NULL, 'Northwest Territories', 'NT',1),
    (NULL, 'Nova Scotia', 'NS',1),
    (NULL, 'Nunavut', 'NU',1),
    (NULL, 'Ontario', 'ON',1),
    (NULL, 'Prince Edward Island', 'PE',1),
    (NULL, 'Quebec', 'QC',1),
    (NULL, 'Saskatchewan', 'SK',1),
    (NULL, 'Yukon', 'YT',1);


-- insert user_type

insert into user_type values (null,'mbr', 'Member');
insert into user_type values (null,'adm', 'Admin');
insert into user_type values (null,'cmr','Content Manager');

-- insert post_action_type

insert into post_action_type values (null,'N', 'New');
insert into post_action_type values (null,'R', 'Reply');
insert into post_action_type values (null,'C', 'comments');


insert into location_master values (null,'N', 'London North','London',current_timestamp);

CREATE TABLE `thread_comments` (
  `thread_comments_id` int(11) NOT NULL primary key AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `post_thread_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,  
  `thread_created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `thread_comments`  
  ADD  KEY `member_id` (`member_id`),
  ADD KEY `post_thread_id` (`post_thread_id`),
  ADD KEY `post_id` (`post_id`)
  ;

ALTER TABLE `thread_comments`
  ADD CONSTRAINT `thread_comments_ibfk_1` FOREIGN KEY (`post_thread_id`) REFERENCES `post_threads` (`post_thread_id`) ON DELETE CASCADE, 
  ADD CONSTRAINT `thread_comments_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member_profile` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thread_comments_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `post_master` (`post_master_id`) ON DELETE CASCADE;
