-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2012 at 10:39 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `filocity2`
--

-- --------------------------------------------------------

--
-- Table structure for table `alarms`
--

DROP TABLE IF EXISTS `alarms`;
CREATE TABLE IF NOT EXISTS `alarms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` smallint(2) NOT NULL COMMENT '0 - Email1 - Text2 - Site Notice',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `calendars`
--

DROP TABLE IF EXISTS `calendars`;
CREATE TABLE IF NOT EXISTS `calendars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `calendars`
--

INSERT INTO `calendars` (`id`, `user_id`, `name`, `created`, `modified`) VALUES
(1, 1, 'Test calendar 1', '2012-10-26 22:32:16', '2012-10-26 22:32:19'),
(2, 1, 'Test Calendar 2', '2012-10-26 22:32:16', '2012-10-26 22:32:16'),
(3, 2, 'Calendar 1', '2012-10-26 22:32:16', '2012-10-26 22:32:16'),
(4, 2, 'Calendar 2', '2012-10-26 22:32:16', '2012-10-26 22:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_adds`
--

DROP TABLE IF EXISTS `calendar_adds`;
CREATE TABLE IF NOT EXISTS `calendar_adds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_add` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `calendar_adds`
--

INSERT INTO `calendar_adds` (`id`, `user_id`, `user_add`, `created`, `modified`) VALUES
(34, 1, 2, '2012-11-06 10:10:01', '2012-11-06 10:10:01'),
(35, 1, 3, '2012-11-06 10:10:03', '2012-11-06 10:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
CREATE TABLE IF NOT EXISTS `calendar_events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `timezone` varchar(45) NOT NULL,
  `is_all_day` tinyint(1) NOT NULL DEFAULT '0',
  `is_repeat` tinyint(1) NOT NULL DEFAULT '0',
  `location` text,
  `color` varchar(6) DEFAULT NULL,
  `availability` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 -> Available, 1 -> Busy',
  `privacy` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0-> Default, 1 -> Public,  2 -> Private',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `calendar_events`
--

INSERT INTO `calendar_events` (`id`, `calendar_id`, `user_id`, `title`, `description`, `date_start`, `date_end`, `timezone`, `is_all_day`, `is_repeat`, `location`, `color`, `availability`, `privacy`, `created`, `modified`) VALUES
(3, 2, 2, 'Event 1', 'have some description....', '2012-10-05 19:30:00', '2012-10-07 19:30:00', '', 0, 0, 'in Boston....', 'A3BBFE', 0, 0, '2012-10-05 19:31:03', '2012-10-06 19:31:03'),
(4, 3, 2, 'Event 3', 'have some description....', '2012-10-11 19:30:00', '2012-10-16 19:30:00', '', 0, 0, 'some where....', '3BD6DC', 0, 0, '2012-10-11 19:31:13', '2012-10-11 19:31:13'),
(5, 4, 1, 'Event 4', 'have some description....', '2012-11-08 19:30:00', '2012-10-14 19:30:00', '', 0, 0, 'in USA......', '74E8BE', 0, 0, '2012-10-12 19:31:17', '2012-10-12 19:31:17'),
(6, 4, 3, 'Event 6', 'have some description....', '2012-10-18 19:30:00', '2012-10-26 19:30:00', '', 0, 0, 'in Market of NYC....', '4BB842', 0, 0, '2012-10-18 19:31:22', '2012-10-18 19:31:22'),
(7, 3, 2, 'Event 7', 'have some description....', '2012-10-20 19:30:00', '2012-10-30 19:30:00', '', 0, 0, 'location belongs to earth..', 'FCD74E', 0, 0, '2012-10-20 19:31:26', '2012-10-22 19:31:26'),
(8, 3, 1, 'Event 8', 'have some description....', '2012-11-08 19:30:00', '2012-10-31 19:30:00', '', 0, 0, 'Bermuda Triangle....', 'FFB871', 0, 0, '2012-10-19 19:31:30', '2012-10-25 19:31:30'),
(9, 2, 2, 'Event 9', 'have some description....', '2012-10-25 19:30:00', '2012-10-30 19:30:00', '', 0, 0, 'Dead Sea...', 'FF8678', 0, 0, '2012-10-25 19:31:34', '2012-10-26 19:31:34'),
(10, 2, 1, 'Event 10', 'have some description....', '2012-11-08 19:30:00', '2012-11-05 19:30:00', '', 0, 0, 'location.........', 'DE1D1D', 0, 0, '2012-10-17 19:31:38', '2012-10-25 19:31:38'),
(11, 1, 3, 'My Event 3', 'have some description....', '2012-10-21 19:33:00', '2012-10-29 19:33:00', '', 0, 0, 'California....', 'DBAAFF', 0, 0, '2012-10-21 19:34:03', '2012-10-21 19:34:03'),
(12, 3, 3, 'My Event 5', 'have some description....', '2012-10-13 19:34:00', '2012-10-26 19:34:00', '', 0, 0, 'some where........', 'E1E1E1', 0, 0, '2012-10-13 19:34:58', '2012-10-13 19:34:58'),
(13, 4, 1, 'test event added by abdullah', 'have some description....', '2012-11-09 19:36:00', '2012-11-17 19:36:00', '', 0, 0, 'some location...........', 'E1E1E1', 0, 0, '2012-10-26 19:36:45', '2012-10-26 19:36:45'),
(14, 2, 2, 'Abullah''s test event', 'have some description....', '2012-10-26 19:41:00', '2012-11-02 19:41:00', '', 0, 0, NULL, 'CCCCCC', 0, 0, '2012-10-26 19:41:21', '2012-10-26 19:41:21'),
(15, 1, 1, 'some event', NULL, '2012-11-09 13:07:00', '2012-10-27 13:07:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:07:39', '2012-10-27 13:07:39'),
(17, 1, 1, 'the new event', 'some des...........', '2012-11-09 05:20:09', '2012-09-30 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:33:17', '2012-10-27 13:33:17'),
(18, 1, 2, 'aabbbcccdddeee', 'some des...........', '2012-09-30 00:00:00', '2012-09-30 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:38:45', '2012-10-27 13:38:45'),
(19, 1, 2, 'yyyy... new event', 'some des...........', '2012-09-30 00:00:00', '2012-09-30 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:42:16', '2012-10-27 13:42:16'),
(20, 1, 2, 'rerender after new event add', 'some des...........', '2012-09-30 00:00:00', '2012-09-30 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:46:00', '2012-10-27 13:46:00'),
(21, 1, 3, 'added another new event', 'some des...........', '2012-10-01 00:00:00', '2012-10-01 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:47:37', '2012-10-27 13:47:37'),
(22, 4, 3, 'wow!! this work event', 'some des...........', '2012-10-01 00:00:00', '2012-10-01 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:48:15', '2012-10-27 13:48:15'),
(23, 1, 3, 'sfdasfdasfdasf', 'some des...........', '2012-10-01 00:00:00', '2012-10-01 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:48:28', '2012-10-27 13:48:28'),
(24, 1, 3, 'another event', 'some des...........', '2012-10-02 00:00:00', '2012-10-02 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:49:20', '2012-10-27 13:49:20'),
(25, 1, 1, 'Add new event and update cal', 'some des...........', '2012-11-10 05:20:14', '2012-10-02 00:00:00', '', 0, 0, 'some loc...........', NULL, 0, 0, '2012-10-27 13:54:28', '2012-10-27 13:54:28'),
(26, 1, 1, 'added', 'some des...........', '2012-10-12 03:18:25', '2012-10-12 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 13:58:37', '2012-10-27 13:58:37'),
(27, 1, 1, 'last add', 'some des...........', '2012-10-03 00:00:00', '2012-10-05 00:00:00', '', 0, 0, 'some location...........', '5181EF', 0, 0, '2012-10-27 14:00:12', '2012-10-28 13:09:54'),
(28, 1, 1, 'Latest add', 'some des...........', '2012-10-03 00:00:00', '2012-10-03 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 14:00:33', '2012-10-27 14:00:33'),
(29, 1, 1, 'I add this', 'some des...........', '2012-10-17 00:00:00', '2012-10-17 00:00:00', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-27 14:02:00', '2012-10-27 14:02:00'),
(31, 1, 1, 'gimme a title', 'some des...........', '2012-09-30 16:57:40', '2012-09-30 16:57:40', '', 0, 0, 'some location...........', NULL, 0, 0, '2012-10-28 06:57:47', '2012-10-28 06:57:47'),
(32, 1, 1, 'Going to vacation', 'some description about my next vacation tour to village', '2012-10-08 17:12:58', '2012-10-12 05:12:00', '', 0, 0, 'some location...........', '74E8BE', 1, 1, '2012-10-28 07:13:44', '2012-10-28 13:37:20'),
(33, 1, 1, 'some event and fun', 'some description....', '2012-10-01 20:58:18', '2012-10-01 09:58:00', '', 1, 1, 'somewhere in earth', 'A8A6FF', 0, 1, '2012-10-28 10:59:00', '2012-10-28 10:59:00'),
(36, 1, 1, 'test', NULL, '2012-11-20 20:52:33', '2012-11-23 08:52:33', '', 0, 0, NULL, NULL, 0, 0, '2012-11-06 09:52:40', '2012-11-06 09:52:44'),
(37, 2, 1, 'another test', NULL, '2012-11-26 20:52:45', '2012-12-05 08:52:45', '', 0, 0, NULL, NULL, 0, 0, '2012-11-06 09:52:54', '2012-11-06 09:52:57'),
(38, 2, 1, 'testing event', NULL, '2012-11-05 20:52:58', '2012-11-14 08:52:58', '', 0, 0, NULL, NULL, 0, 0, '2012-11-06 09:53:07', '2012-11-06 09:53:10'),
(39, 2, 2, 'test', NULL, '2012-10-28 21:07:17', '2012-10-31 09:07:17', '', 0, 0, NULL, NULL, 0, 0, '2012-11-06 10:07:21', '2012-11-06 10:07:23'),
(40, 1, 2, 'another test', '', '2012-11-06 09:07:24', '2012-11-19 09:07:24', '', 1, 1, 'NY', '4BB842', 0, 1, '2012-11-06 10:07:40', '2012-11-06 10:07:46'),
(41, 1, 2, 'another test 1', '', '2012-11-27 21:07:46', '2012-12-05 09:07:46', '', 1, 1, 'NY', '3BD6DC', 0, 1, '2012-11-06 10:07:56', '2012-11-06 10:08:00'),
(42, 1, 3, 'testing', 'some des.........', '2012-11-05 21:08:16', '2012-11-20 09:08:16', '', 1, 1, 'NY', '3BD6DC', 0, 1, '2012-11-06 10:08:35', '2012-11-06 10:08:38'),
(43, 3, 3, 'testing 1', 'some des 1.........', '2012-11-27 21:08:39', '2012-12-04 09:08:39', '', 1, 1, 'NYC', 'DBAAFF', 0, 0, '2012-11-06 10:08:53', '2012-11-06 10:08:56'),
(44, 1, 1, 'a simple title', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2012-11-08 02:00:58', '2012-11-14 03:00:00', '', 1, 1, 'NYC', '3BD6DC', 0, 1, '2012-11-07 15:01:46', '2012-11-07 15:03:53');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_shares`
--

DROP TABLE IF EXISTS `calendar_shares`;
CREATE TABLE IF NOT EXISTS `calendar_shares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `requester` int(11) NOT NULL COMMENT 'The person REQUESTING the user share.',
  `acceptor` int(11) NOT NULL COMMENT 'The person who needs to ACCEPT of REJECT share.  If share is rejected [ do something cool ].',
  `approved` tinyint(1) NOT NULL COMMENT '0 - Waiting (NO ACCESS)\n1 - Approved\n',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `calendar_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='map of users who share calendars' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `comment` text NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table stores all comments across the site.' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `project_id`, `task_id`, `created`, `comment`, `modified`) VALUES
(1, 1, 1, 1, '2012-10-19 21:01:23', 'This is comment 1', '2012-10-19 21:01:23'),
(2, 1, 1, 1, '2012-10-19 21:01:31', 'This is comment 2', '2012-10-19 21:01:31'),
(3, 1, 1, 1, '2012-10-19 21:02:09', 'Comment 3', '2012-10-19 21:02:09'),
(4, 1, 1, 1, '2012-10-19 21:02:15', 'Comment 4', '2012-10-19 21:02:15'),
(5, 1, 1, 1, '2012-10-19 21:02:24', 'This is big comment 5', '2012-10-19 21:02:24'),
(6, 2, 1, 1, '2012-10-19 21:02:34', 'Comment 6', '2012-10-19 21:02:34'),
(7, 2, 1, 1, '2012-10-19 21:02:41', 'Comment 7', '2012-10-19 21:02:41'),
(8, 3, 1, 1, '2012-10-19 21:02:47', 'Comment 8', '2012-10-19 21:02:47'),
(9, 3, 1, 1, '2012-10-19 21:02:53', 'Comment 9', '2012-10-19 21:02:53'),
(10, 1, 2, 2, '2012-10-19 21:03:06', 'Comment 1', '2012-10-19 21:03:06'),
(11, 1, 2, 1, '2012-10-19 21:03:22', 'Comment 2\r\n', '2012-10-19 21:03:22'),
(12, 2, 3, 1, '2012-10-19 21:03:38', 'Comment 1', '2012-10-19 21:03:38'),
(13, 3, 3, 2, '2012-10-19 21:03:49', 'Comment 5', '2012-10-19 21:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `package_id`, `name`, `created`, `modified`) VALUES
(1, 1, 'ABCoder', '2012-10-12 19:58:06', '2012-10-12 19:58:06'),
(2, 1, 'Filocity', '2012-10-12 19:58:12', '2012-10-12 19:58:12'),
(3, 2, 'Codereliable', '2012-10-12 19:58:22', '2012-10-12 19:58:22'),
(4, 1, 'Company 1', '2012-10-12 19:59:08', '2012-10-12 19:59:08'),
(5, 2, 'Company 2', '2012-10-12 19:59:14', '2012-10-12 19:59:14'),
(6, 2, 'Company 3', '2012-10-12 19:59:22', '2012-10-12 19:59:22'),
(7, 3, 'Company 4', '2012-10-12 20:00:10', '2012-10-12 20:00:10'),
(8, 3, 'Company 5', '2012-10-12 20:00:16', '2012-10-12 20:00:16'),
(9, 3, 'Company 6', '2012-10-12 20:00:23', '2012-10-12 20:00:23'),
(10, 1, 'Company 7', '2012-10-12 20:00:29', '2012-10-12 20:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT 'Friendly name of the file.',
  `content` longblob,
  `ext` varchar(10) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `user_id` varchar(45) NOT NULL COMMENT 'ID of the user that added the file.',
  `folder_id` int(11) NOT NULL COMMENT 'This is the ID of the folder that this file goes within.',
  `status` tinyint(2) DEFAULT '1' COMMENT '0 - Disabled (access denied to all users).1 - Enabled to those with ownership rights.',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

DROP TABLE IF EXISTS `folders`;
CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) DEFAULT NULL,
  `created` datetime NOT NULL,
  `name` varchar(45) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `parent_id`, `created`, `name`, `user_id`, `modified`) VALUES
(1, 0, '0000-00-00 00:00:00', 'My Categories 1', 1, '0000-00-00 00:00:00'),
(2, 1, '0000-00-00 00:00:00', 'Fun', 1, '0000-00-00 00:00:00'),
(3, 2, '0000-00-00 00:00:00', 'Sport', 1, '0000-00-00 00:00:00'),
(4, 3, '0000-00-00 00:00:00', 'Surfing', 1, '0000-00-00 00:00:00'),
(5, 3, '0000-00-00 00:00:00', 'Extreme knitting', 1, '0000-00-00 00:00:00'),
(6, 2, '0000-00-00 00:00:00', 'Friends', 1, '0000-00-00 00:00:00'),
(7, 6, '0000-00-00 00:00:00', 'Gerald', 1, '0000-00-00 00:00:00'),
(8, 6, '0000-00-00 00:00:00', 'Gwendolyn', 1, '0000-00-00 00:00:00'),
(9, 1, '0000-00-00 00:00:00', 'Work', 1, '0000-00-00 00:00:00'),
(10, 9, '0000-00-00 00:00:00', 'Reports', 1, '0000-00-00 00:00:00'),
(11, 10, '0000-00-00 00:00:00', 'Annual', 1, '0000-00-00 00:00:00'),
(12, 10, '0000-00-00 00:00:00', 'Status', 1, '0000-00-00 00:00:00'),
(13, 9, '0000-00-00 00:00:00', 'Trips', 1, '0000-00-00 00:00:00'),
(14, 10, '0000-00-00 00:00:00', 'National', 1, '2012-10-29 17:42:16'),
(15, 13, '0000-00-00 00:00:00', 'International', 1, '0000-00-00 00:00:00'),
(19, 0, '0000-00-00 00:00:00', 'My Categories 2', 1, '0000-00-00 00:00:00'),
(20, 19, '0000-00-00 00:00:00', 'Fun 2', 1, '0000-00-00 00:00:00'),
(21, 20, '0000-00-00 00:00:00', 'Sport 2', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `created`, `modified`) VALUES
(1, 1, '2012-10-13 14:23:17', '2012-10-13 14:23:17'),
(2, 1, '2012-10-13 14:23:20', '2012-10-13 14:23:20'),
(3, 2, '2012-10-13 14:24:20', '2012-10-13 14:24:20'),
(4, 3, '2012-10-13 14:24:29', '2012-10-13 14:24:29'),
(5, 2, '2012-10-13 14:24:54', '2012-10-13 14:24:54'),
(6, 1, '2012-10-13 18:25:46', '2012-10-13 18:25:46'),
(7, 1, '2012-10-14 17:02:40', '2012-10-14 17:02:40'),
(8, 1, '2012-10-16 19:13:31', '2012-10-16 19:13:31'),
(9, 1, '2012-10-17 15:33:51', '2012-10-17 15:33:51'),
(10, 1, '2012-10-19 00:31:24', '2012-10-19 00:31:24'),
(11, 1, '2012-10-19 00:32:03', '2012-10-19 00:32:03'),
(12, 1, '2012-10-19 07:26:54', '2012-10-19 07:26:54'),
(13, 1, '2012-10-19 08:30:47', '2012-10-19 08:30:47'),
(14, 1, '2012-10-19 16:47:16', '2012-10-19 16:47:16'),
(15, 1, '2012-10-19 13:02:16', '2012-10-19 13:02:16'),
(16, 1, '2012-10-19 14:13:09', '2012-10-19 14:13:09'),
(17, 1, '2012-10-19 14:21:00', '2012-10-19 14:21:00'),
(18, 1, '2012-10-19 20:44:29', '2012-10-19 20:44:29'),
(19, 1, '2012-10-19 15:26:50', '2012-10-19 15:26:50'),
(20, 1, '2012-10-20 00:19:01', '2012-10-20 00:19:01'),
(21, 1, '2012-10-21 18:25:19', '2012-10-21 18:25:19'),
(22, 1, '2012-10-22 12:27:39', '2012-10-22 12:27:39'),
(23, 1, '2012-10-25 21:27:01', '2012-10-25 21:27:01'),
(24, 1, '2012-10-26 05:26:32', '2012-10-26 05:26:32'),
(25, 1, '2012-10-26 17:41:07', '2012-10-26 17:41:07'),
(26, 1, '2012-10-26 18:37:06', '2012-10-26 18:37:06'),
(27, 1, '2012-10-26 21:31:51', '2012-10-26 21:31:51'),
(28, 1, '2012-10-27 01:32:15', '2012-10-27 01:32:15'),
(29, 1, '2012-10-28 01:49:00', '2012-10-28 01:49:00'),
(30, 1, '2012-10-28 05:41:14', '2012-10-28 05:41:14'),
(31, 1, '2012-10-28 05:48:45', '2012-10-28 05:48:45'),
(32, 1, '2012-10-28 10:34:34', '2012-10-28 10:34:34'),
(33, 1, '2012-10-29 13:51:15', '2012-10-29 13:51:15'),
(34, 1, '2012-10-29 18:35:04', '2012-10-29 18:35:04'),
(35, 1, '2012-10-30 08:32:37', '2012-10-30 08:32:37'),
(36, 1, '2012-10-30 10:00:47', '2012-10-30 10:00:47'),
(37, 1, '2012-10-30 10:27:17', '2012-10-30 10:27:17'),
(38, 1, '2012-10-30 11:54:24', '2012-10-30 11:54:24'),
(39, 1, '2012-11-01 22:21:06', '2012-11-01 22:21:06'),
(40, 1, '2012-11-03 15:45:28', '2012-11-03 15:45:28'),
(41, 1, '2012-11-05 09:13:56', '2012-11-05 09:13:56'),
(42, 1, '2012-11-05 13:12:22', '2012-11-05 13:12:22'),
(43, 3, '2012-11-06 09:52:15', '2012-11-06 09:52:15'),
(44, 1, '2012-11-06 09:52:28', '2012-11-06 09:52:28'),
(45, 2, '2012-11-06 10:07:13', '2012-11-06 10:07:13'),
(46, 3, '2012-11-06 10:08:13', '2012-11-06 10:08:13'),
(47, 1, '2012-11-06 10:09:06', '2012-11-06 10:09:06'),
(48, 1, '2012-11-06 23:49:47', '2012-11-06 23:49:47'),
(49, 1, '2012-11-07 01:51:19', '2012-11-07 01:51:19'),
(50, 1, '2012-11-07 02:16:09', '2012-11-07 02:16:09'),
(51, 1, '2012-11-07 02:23:01', '2012-11-07 02:23:01'),
(52, 1, '2012-11-07 10:11:07', '2012-11-07 10:11:07'),
(53, 1, '2012-11-07 12:55:42', '2012-11-07 12:55:42'),
(54, 1, '2012-11-07 14:14:22', '2012-11-07 14:14:22');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

DROP TABLE IF EXISTS `notices`;
CREATE TABLE IF NOT EXISTS `notices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'The ID of the user who has committed the action.',
  `notice_type` tinyint(2) NOT NULL COMMENT '0 - New1 - Updated2 - Shared Accessed3 - Comment4 - Deleted',
  `itemid` int(11) DEFAULT NULL COMMENT 'Like file_id or folder_id, project_id, etc.  Whatever has been updated.',
  `item_type` varchar(100) NOT NULL,
  `description` text COMMENT 'Optional, some notice_type''s will use this.',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `user_id`, `notice_type`, `itemid`, `item_type`, `description`, `created`, `modified`) VALUES
(1, 1, 0, 1, 'file', 'abdulla added a file named test.docs', '2012-10-13 20:22:57', '2012-10-13 20:26:00'),
(2, 1, 0, 2, 'file', 'added new file named test2.pdf', '2012-10-13 20:23:33', '2012-10-13 20:26:06'),
(3, 1, 1, 3, 'project', 'abdullah assigned a new project', '2012-10-12 20:25:13', '2012-10-12 20:25:13'),
(4, 1, 2, 4, 'project', 'another project finished by abdullah', '2012-10-12 20:26:56', '2012-10-12 20:26:56'),
(5, 1, 3, 7, 'file', 'added', '2012-10-14 17:03:26', '2012-10-14 17:03:26'),
(6, 1, 3, 8, 'file', 'adddddd', '2012-10-14 17:03:43', '2012-10-14 17:03:43'),
(7, 1, 4, 6, 'project', 'adddd', '2012-10-14 17:04:14', '2012-10-14 17:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `storage` int(11) NOT NULL,
  `max_member` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `price`, `storage`, `max_member`, `created`, `modified`) VALUES
(1, 'Package 1', 250, 250, 20, '2012-10-12 19:54:14', '2012-10-12 19:54:14'),
(2, 'Package 2', 50, 50, 10, '2012-10-12 19:54:26', '2012-10-12 19:54:26'),
(3, 'Package 4', 10, 10, 5, '2012-10-12 19:57:15', '2012-10-12 19:57:15'),
(4, 'Package 3', 5, 5, 3, '2012-10-12 19:57:28', '2012-10-12 19:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL COMMENT 'Name of project.',
  `date_due` date DEFAULT NULL COMMENT 'Date that project is due (optional).',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `name`, `date_due`, `created`, `modified`) VALUES
(1, 1, 'Project 1', '2012-11-01', '2012-10-19 16:51:32', '2012-10-19 16:51:32'),
(2, 1, 'Project 2', '2012-12-01', '2012-10-19 16:52:04', '2012-10-19 16:52:04'),
(3, 1, 'Project 3', '2012-12-15', '2012-10-19 16:52:38', '2012-10-19 16:52:38'),
(4, 1, 'Project 4', '2012-11-15', '2012-10-19 16:52:54', '2012-10-19 16:52:54');

-- --------------------------------------------------------

--
-- Table structure for table `projects_users`
--

DROP TABLE IF EXISTS `projects_users`;
CREATE TABLE IF NOT EXISTS `projects_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table links members to projects.  If there are 10 membe' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `projects_users`
--

INSERT INTO `projects_users` (`id`, `project_id`, `user_id`, `title`, `created`, `modified`) VALUES
(1, 1, 2, 'Member 1 to Project 1', '2012-10-19 16:55:05', '2012-10-19 16:55:05'),
(2, 1, 3, 'Member 2 to Project 1', '2012-10-19 16:55:29', '2012-10-19 17:00:07'),
(3, 2, 3, 'Member 1 to Project 2', '2012-10-19 16:55:54', '2012-10-19 16:55:54'),
(4, 2, 2, 'Member 2 to Project 2', '2012-10-19 16:59:03', '2012-10-19 16:59:10'),
(5, 3, 2, 'Member 1 to Project 3', '2012-10-19 16:59:25', '2012-10-19 16:59:39'),
(6, 3, 3, 'Member 2 to Project 3', '2012-10-19 16:59:51', '2012-10-19 16:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

DROP TABLE IF EXISTS `shares`;
CREATE TABLE IF NOT EXISTS `shares` (
  `shares_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'This should NOT be used.',
  `user1_id` smallint(6) NOT NULL COMMENT 'This is the original user who is sharing the document with another user.  In other words, user1 shares the document with user2.\n\nAlso, user1 can share a document with a group.  \n\nA single row cannot share with a user and group on the same row.  \n\nEach share should be stored on a separate row.  So if you want to share a file with 100 people, that means there are 100 rows in this table.',
  `user2_id` smallint(6) DEFAULT NULL COMMENT 'This is the original user who is sharing the document with another user.  In other words, user1 shares the document with user2.\n\nAlso, user1 can share a document with a group.  \n\nA single row cannot share with a user and group on the same row.  \n\nEach share should be stored on a separate row.  So if you want to share a file with 100 people, that means there are 100 rows in this table.',
  `group_id` smallint(6) DEFAULT NULL COMMENT 'This is the group that the item is being shared with.',
  `type` smallint(6) NOT NULL COMMENT 'This field is used to help select the correct item to share.  There are 2 types of shares:\n\n0 - Folder\n1 - File\n\nNote:  This may change over time.\n',
  `date_create` datetime DEFAULT NULL,
  `is_viewed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If the person who has been shared with (not the original sharer) sees the item, this field should be updated to 1.\n\n0 - not viewed item\n1 - viewed item',
  `item_id` int(11) DEFAULT NULL COMMENT 'The id of the item.  This works together with the type to create the correct mapping to the item.\n\nitem can be referenced by:\n\n"item_type" . "-" . "item_id"',
  PRIMARY KEY (`shares_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

DROP TABLE IF EXISTS `subtasks`;
CREATE TABLE IF NOT EXISTS `subtasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`id`, `task_id`, `description`, `created`, `modified`) VALUES
(1, 1, 'Subtask 1', '2012-10-16 00:00:00', '2012-10-16 00:00:00'),
(2, 1, 'Subtask 2', '2012-10-18 00:00:00', '2012-10-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text,
  `requesterid` int(11) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `date_due` datetime DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `task_type` int(2) DEFAULT NULL,
  `points` smallint(6) DEFAULT NULL,
  `star` tinyint(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `title`, `description`, `requesterid`, `ownerid`, `date_due`, `status`, `task_type`, `points`, `star`, `created`, `user_id`, `modified`) VALUES
(1, 1, 'Sample', 'Sample', 3, 2, NULL, 3, 1, 1, 1, '0000-00-00 00:00:00', 1, NULL),
(2, 2, 'BSample', 'BSample', 3, 3, NULL, 2, 2, 3, 2, '0000-00-00 00:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `department` varchar(100) NOT NULL,
  `state` varchar(30) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `position` varchar(150) NOT NULL,
  `city` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `role` tinyint(4) NOT NULL DEFAULT '1',
  `trial_end` date NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `department`, `state`, `zip`, `country`, `title`, `position`, `city`, `created`, `modified`, `status`, `role`, `trial_end`, `company_id`) VALUES
(1, 'Abdullah', 'Yousuf', 'test@test.com', 'c0fea0b2a66813d431a7e946cf23eb5a5d35b51a', 'Web develop', 'Khulna', '9100', 'Bangladesh', 'The title', 'CTO', 'Khulna', '2012-10-12 19:52:54', '2012-10-12 19:52:54', 0, 1, '2012-11-12', 1),
(2, 'Test', 'lasttest', 'test1@test1.com', 'c0fea0b2a66813d431a7e946cf23eb5a5d35b51a', 'dep. Test', 'state test', '0000', 'coutry test', 'title test', 'pos test', 'city test', '2012-10-12 20:02:39', '2012-10-12 20:02:39', 0, 1, '2012-12-12', 1),
(3, 'Another', 'User', 'test2@test2.com', 'c0fea0b2a66813d431a7e946cf23eb5a5d35b51a', 'dep. Test', 'state test', '0000', 'coutry test', 'The title', 'pos test.test', 'dfdasfasdfasdf', '2012-10-12 20:07:54', '2012-10-12 20:07:54', 0, 1, '2012-12-12', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
