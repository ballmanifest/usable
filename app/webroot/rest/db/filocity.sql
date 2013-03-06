-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.22 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2012-12-07 11:26:50
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table filocity_final.alarms
CREATE TABLE IF NOT EXISTS `alarms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` smallint(2) NOT NULL COMMENT '0 - Email1 - Text2 - Site Notice',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.alarms: 0 rows
/*!40000 ALTER TABLE `alarms` DISABLE KEYS */;
/*!40000 ALTER TABLE `alarms` ENABLE KEYS */;


-- Dumping structure for table filocity_final.calendars
CREATE TABLE IF NOT EXISTS `calendars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.calendars: 4 rows
/*!40000 ALTER TABLE `calendars` DISABLE KEYS */;
INSERT INTO `calendars` (`id`, `user_id`, `name`, `created`, `modified`) VALUES
	(1, 1, 'Test calendar 1', '2012-10-26 22:32:16', '2012-10-26 22:32:19'),
	(2, 1, 'Test Calendar 2', '2012-10-26 22:32:16', '2012-10-26 22:32:16'),
	(3, 2, 'Calendar 1', '2012-10-26 22:32:16', '2012-10-26 22:32:16'),
	(4, 2, 'Calendar 2', '2012-10-26 22:32:16', '2012-10-26 22:32:16');
/*!40000 ALTER TABLE `calendars` ENABLE KEYS */;


-- Dumping structure for table filocity_final.calendar_adds
CREATE TABLE IF NOT EXISTS `calendar_adds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_add` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.calendar_adds: 2 rows
/*!40000 ALTER TABLE `calendar_adds` DISABLE KEYS */;
INSERT INTO `calendar_adds` (`id`, `user_id`, `user_add`, `created`, `modified`) VALUES
	(34, 1, 2, '2012-11-06 10:10:01', '2012-11-06 10:10:01'),
	(35, 1, 3, '2012-11-06 10:10:03', '2012-11-06 10:10:03');
/*!40000 ALTER TABLE `calendar_adds` ENABLE KEYS */;


-- Dumping structure for table filocity_final.calendar_events
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
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `color` varchar(6) DEFAULT NULL,
  `availability` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 -> Available, 1 -> Busy',
  `privacy` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0-> Default, 1 -> Public,  2 -> Private',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.calendar_events: 38 rows
/*!40000 ALTER TABLE `calendar_events` DISABLE KEYS */;
INSERT INTO `calendar_events` (`id`, `calendar_id`, `user_id`, `title`, `description`, `date_start`, `date_end`, `timezone`, `is_all_day`, `is_repeat`, `location`, `lat`, `lng`, `color`, `availability`, `privacy`, `created`, `modified`) VALUES
	(3, 2, 2, 'Event 1', 'have some description....', '2012-10-05 19:30:00', '2012-10-07 19:30:00', '', 0, 0, 'in Boston....', 0, 0, 'A3BBFE', 0, 0, '2012-10-05 19:31:03', '2012-10-06 19:31:03'),
	(4, 3, 2, 'Event 3', 'have some description....', '2012-10-11 19:30:00', '2012-10-16 19:30:00', '', 0, 0, 'some where....', 0, 0, '3BD6DC', 0, 0, '2012-10-11 19:31:13', '2012-10-11 19:31:13'),
	(5, 4, 1, 'Event 4', 'have some description....', '2012-11-08 19:30:00', '2012-10-14 19:30:00', '', 0, 0, 'in USA......', 0, 0, '74E8BE', 0, 0, '2012-10-12 19:31:17', '2012-10-12 19:31:17'),
	(6, 4, 3, 'Event 6', 'have some description....', '2012-10-18 19:30:00', '2012-10-26 19:30:00', '', 0, 0, 'in Market of NYC....', 0, 0, '4BB842', 0, 0, '2012-10-18 19:31:22', '2012-10-18 19:31:22'),
	(7, 3, 2, 'Event 7', 'have some description....', '2012-10-20 19:30:00', '2012-10-30 19:30:00', '', 0, 0, 'location belongs to earth..', 0, 0, 'FCD74E', 0, 0, '2012-10-20 19:31:26', '2012-10-22 19:31:26'),
	(8, 3, 1, 'Event 8', 'have some description....', '2012-11-08 19:30:00', '2012-10-31 19:30:00', '', 0, 0, 'Bermuda Triangle....', 0, 0, 'FFB871', 0, 0, '2012-10-19 19:31:30', '2012-10-25 19:31:30'),
	(9, 2, 2, 'Event 9', 'have some description....', '2012-10-25 19:30:00', '2012-10-30 19:30:00', '', 0, 0, 'Dead Sea...', 0, 0, 'FF8678', 0, 0, '2012-10-25 19:31:34', '2012-10-26 19:31:34'),
	(10, 2, 1, 'Event 10', 'have some description....', '2012-11-08 19:30:00', '2012-11-05 19:30:00', '', 0, 0, 'location.........', 0, 0, 'DE1D1D', 0, 0, '2012-10-17 19:31:38', '2012-10-25 19:31:38'),
	(11, 1, 3, 'My Event 3', 'have some description....', '2012-10-21 19:33:00', '2012-10-29 19:33:00', '', 0, 0, 'California....', 0, 0, 'DBAAFF', 0, 0, '2012-10-21 19:34:03', '2012-10-21 19:34:03'),
	(12, 3, 3, 'My Event 5', 'have some description....', '2012-10-13 19:34:00', '2012-10-26 19:34:00', '', 0, 0, 'some where........', 0, 0, 'E1E1E1', 0, 0, '2012-10-13 19:34:58', '2012-10-13 19:34:58'),
	(13, 4, 1, 'test event added by abdullah', 'have some description....', '2012-11-09 19:36:00', '2012-11-17 19:36:00', '', 0, 0, 'some location...........', 0, 0, 'E1E1E1', 0, 0, '2012-10-26 19:36:45', '2012-10-26 19:36:45'),
	(14, 2, 2, 'Abullah\'s test event', 'have some description....', '2012-10-26 19:41:00', '2012-11-02 19:41:00', '', 0, 0, NULL, 0, 0, 'CCCCCC', 0, 0, '2012-10-26 19:41:21', '2012-10-26 19:41:21'),
	(15, 1, 1, 'some event', NULL, '2012-11-09 13:07:00', '2012-10-27 13:07:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:07:39', '2012-10-27 13:07:39'),
	(17, 1, 1, 'the new event', 'some des...........', '2012-11-09 05:20:09', '2012-09-30 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:33:17', '2012-10-27 13:33:17'),
	(18, 1, 2, 'aabbbcccdddeee', 'some des...........', '2012-09-30 00:00:00', '2012-09-30 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:38:45', '2012-10-27 13:38:45'),
	(19, 1, 2, 'yyyy... new event', 'some des...........', '2012-09-30 00:00:00', '2012-09-30 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:42:16', '2012-10-27 13:42:16'),
	(20, 1, 2, 'rerender after new event add', 'some des...........', '2012-09-30 00:00:00', '2012-09-30 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:46:00', '2012-10-27 13:46:00'),
	(21, 1, 3, 'added another new event', 'some des...........', '2012-10-01 00:00:00', '2012-10-01 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:47:37', '2012-10-27 13:47:37'),
	(22, 4, 3, 'wow!! this work event', 'some des...........', '2012-10-01 00:00:00', '2012-10-01 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:48:15', '2012-10-27 13:48:15'),
	(23, 1, 3, 'sfdasfdasfdasf', 'some des...........', '2012-10-01 00:00:00', '2012-10-01 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:48:28', '2012-10-27 13:48:28'),
	(24, 1, 3, 'another event', 'some des...........', '2012-10-02 00:00:00', '2012-10-02 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:49:20', '2012-10-27 13:49:20'),
	(25, 1, 1, 'Add new event and update cal', 'some des...........', '2012-11-10 05:20:14', '2012-10-02 00:00:00', '', 0, 0, 'some loc...........', 0, 0, NULL, 0, 0, '2012-10-27 13:54:28', '2012-10-27 13:54:28'),
	(26, 1, 1, 'added', 'some des...........', '2012-10-12 03:18:25', '2012-10-12 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 13:58:37', '2012-10-27 13:58:37'),
	(27, 1, 1, 'last add', 'some des...........', '2012-10-03 00:00:00', '2012-10-05 00:00:00', '', 0, 0, 'some location...........', 0, 0, '5181EF', 0, 0, '2012-10-27 14:00:12', '2012-10-28 13:09:54'),
	(28, 1, 1, 'Latest add', 'some des...........', '2012-10-03 00:00:00', '2012-10-03 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 14:00:33', '2012-10-27 14:00:33'),
	(29, 1, 1, 'I add this', 'some des...........', '2012-10-17 00:00:00', '2012-10-17 00:00:00', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-27 14:02:00', '2012-10-27 14:02:00'),
	(31, 1, 1, 'gimme a title', 'some des...........', '2012-09-30 16:57:40', '2012-09-30 16:57:40', '', 0, 0, 'some location...........', 0, 0, NULL, 0, 0, '2012-10-28 06:57:47', '2012-10-28 06:57:47'),
	(32, 1, 1, 'Going to vacation', 'some description about my next vacation tour to village', '2012-10-08 17:12:58', '2012-10-12 05:12:00', '', 0, 0, 'some location...........', 0, 0, '74E8BE', 1, 1, '2012-10-28 07:13:44', '2012-10-28 13:37:20'),
	(33, 1, 1, 'some event and fun', 'some description....', '2012-10-01 20:58:18', '2012-10-01 09:58:00', '', 1, 1, 'somewhere in earth', 0, 0, 'A8A6FF', 0, 1, '2012-10-28 10:59:00', '2012-10-28 10:59:00'),
	(36, 1, 1, 'test', NULL, '2012-11-20 20:52:33', '2012-11-23 08:52:33', '', 0, 0, NULL, 0, 0, NULL, 0, 0, '2012-11-06 09:52:40', '2012-11-06 09:52:44'),
	(37, 2, 1, 'another test', NULL, '2012-11-26 20:52:45', '2012-12-05 08:52:45', '', 0, 0, NULL, 0, 0, NULL, 0, 0, '2012-11-06 09:52:54', '2012-11-06 09:52:57'),
	(38, 2, 1, 'testing event', NULL, '2012-11-05 20:52:58', '2012-11-14 08:52:58', '', 0, 0, NULL, 0, 0, NULL, 0, 0, '2012-11-06 09:53:07', '2012-11-06 09:53:10'),
	(39, 2, 2, 'test', NULL, '2012-10-28 21:07:17', '2012-10-31 09:07:17', '', 0, 0, NULL, 0, 0, NULL, 0, 0, '2012-11-06 10:07:21', '2012-11-06 10:07:23'),
	(40, 1, 2, 'another test', '', '2012-11-06 09:07:24', '2012-11-19 09:07:24', '', 1, 1, 'NY', 0, 0, '4BB842', 0, 1, '2012-11-06 10:07:40', '2012-11-06 10:07:46'),
	(41, 1, 2, 'another test 1', '', '2012-11-27 21:07:46', '2012-12-05 09:07:46', '', 1, 1, 'NY', 0, 0, '3BD6DC', 0, 1, '2012-11-06 10:07:56', '2012-11-06 10:08:00'),
	(42, 1, 3, 'testing', 'some des.........', '2012-11-05 21:08:16', '2012-11-20 09:08:16', '', 1, 1, 'NY', 0, 0, '3BD6DC', 0, 1, '2012-11-06 10:08:35', '2012-11-06 10:08:38'),
	(43, 3, 3, 'testing 1', 'some des 1.........', '2012-11-27 21:08:39', '2012-12-04 09:08:39', '', 1, 1, 'NYC', 0, 0, 'DBAAFF', 0, 0, '2012-11-06 10:08:53', '2012-11-06 10:08:56'),
	(44, 1, 1, 'a simple title', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2012-11-08 02:00:58', '2012-11-14 03:00:00', '', 1, 1, 'NYC', 0, 0, '3BD6DC', 0, 1, '2012-11-07 15:01:46', '2012-11-07 15:03:53');
/*!40000 ALTER TABLE `calendar_events` ENABLE KEYS */;


-- Dumping structure for table filocity_final.calendar_shares
CREATE TABLE IF NOT EXISTS `calendar_shares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `requester` int(11) NOT NULL COMMENT 'The person REQUESTING the user share.',
  `acceptor` int(11) NOT NULL COMMENT 'The person who needs to ACCEPT of REJECT share.  If share is rejected [ do something cool ].',
  `approved` tinyint(1) NOT NULL COMMENT '0 - Waiting (NO ACCESS)\n1 - Approved\n',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `calendar_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='map of users who share calendars';

-- Dumping data for table filocity_final.calendar_shares: 0 rows
/*!40000 ALTER TABLE `calendar_shares` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_shares` ENABLE KEYS */;


-- Dumping structure for table filocity_final.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `folder_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `comment` text NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COMMENT='This table stores all comments across the site.';

-- Dumping data for table filocity_final.comments: 20 rows
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `user_id`, `project_id`, `task_id`, `document_id`, `folder_id`, `created`, `comment`, `modified`) VALUES
	(1, 1, 1, 1, NULL, NULL, '2012-10-19 21:01:23', 'This is comment 1', '2012-10-19 21:01:23'),
	(2, 1, 1, 1, NULL, NULL, '2012-10-19 21:01:31', 'This is comment 2', '2012-10-19 21:01:31'),
	(3, 1, 1, 1, NULL, NULL, '2012-10-19 21:02:09', 'Comment 3', '2012-10-19 21:02:09'),
	(4, 1, 1, 1, NULL, NULL, '2012-10-19 21:02:15', 'Comment 4', '2012-10-19 21:02:15'),
	(5, 1, 1, 1, NULL, NULL, '2012-10-19 21:02:24', 'This is big comment 5', '2012-10-19 21:02:24'),
	(6, 2, 1, 1, NULL, NULL, '2012-10-19 21:02:34', 'Comment 6', '2012-10-19 21:02:34'),
	(7, 2, 1, 1, NULL, NULL, '2012-10-19 21:02:41', 'Comment 7', '2012-10-19 21:02:41'),
	(8, 3, 1, 1, NULL, NULL, '2012-10-19 21:02:47', 'Comment 8', '2012-10-19 21:02:47'),
	(9, 3, 1, 1, NULL, NULL, '2012-10-19 21:02:53', 'Comment 9', '2012-10-19 21:02:53'),
	(10, 1, 2, 2, NULL, NULL, '2012-10-19 21:03:06', 'Comment 1', '2012-10-19 21:03:06'),
	(11, 1, 2, 1, NULL, NULL, '2012-10-19 21:03:22', 'Comment 2\r\n', '2012-10-19 21:03:22'),
	(12, 2, 3, 1, NULL, NULL, '2012-10-19 21:03:38', 'Comment 1', '2012-10-19 21:03:38'),
	(13, 3, 3, 2, NULL, NULL, '2012-10-19 21:03:49', 'Comment 5', '2012-10-19 21:03:49'),
	(14, 1, NULL, NULL, 81, NULL, '2012-11-15 11:06:45', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text', '2012-11-15 11:06:45'),
	(15, 2, NULL, NULL, 81, NULL, '2012-11-15 11:06:53', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature', '2012-11-15 11:06:53'),
	(16, 3, NULL, NULL, 81, NULL, '2012-11-15 11:09:12', 'The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters', '2012-11-15 11:09:12'),
	(17, 1, NULL, NULL, 82, NULL, '2012-11-15 11:09:24', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour', '2012-11-15 11:09:24'),
	(18, 2, NULL, NULL, 82, NULL, '2012-11-15 11:09:36', 'The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters', '2012-11-15 11:09:36'),
	(19, 3, NULL, NULL, 83, NULL, '2012-11-15 11:12:05', 'The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc', '2012-11-15 11:12:05'),
	(20, 1, NULL, NULL, 83, NULL, '2012-11-15 11:12:09', 'generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc', '2012-11-15 11:12:09');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;


-- Dumping structure for table filocity_final.companies
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.companies: 10 rows
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;


-- Dumping structure for table filocity_final.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_position` varchar(150) NOT NULL,
  `street_1` varchar(255) NOT NULL,
  `street_2` varchar(255) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state_id` int(3) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `country_id` int(3) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `work_phone` varchar(45) NOT NULL,
  `mobile_phone` varchar(45) NOT NULL,
  `home_phone` varchar(45) NOT NULL,
  `toll_free_phone` varchar(45) NOT NULL,
  `work_fax` varchar(45) NOT NULL,
  `website` varchar(255) NOT NULL,
  `user_id2` int(11) unsigned NOT NULL DEFAULT '0',
  `contact_type` smallint(2) NOT NULL DEFAULT '0' COMMENT '0=PRIVATE;1=PUBLIC',
  `folder_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.contacts: 0 rows
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;


-- Dumping structure for table filocity_final.contacts_groups
CREATE TABLE IF NOT EXISTS `contacts_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.contacts_groups: 0 rows
/*!40000 ALTER TABLE `contacts_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts_groups` ENABLE KEYS */;


-- Dumping structure for table filocity_final.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.countries: 239 rows
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` (`id`, `name`) VALUES
	(1, 'Andorra'),
	(2, 'United Arab Emirates'),
	(3, 'Afghanistan'),
	(4, 'Antigua and Barbuda'),
	(5, 'Anguilla'),
	(6, 'Albania'),
	(7, 'Armenia'),
	(8, 'Netherlands Antilles'),
	(9, 'Angola'),
	(10, 'Antarctica'),
	(11, 'Argentina'),
	(12, 'American Samoa'),
	(13, 'Austria'),
	(14, 'Australia'),
	(15, 'Aruba'),
	(16, 'Azerbaijan'),
	(17, 'Bosnia and Herzegovina'),
	(18, 'Barbados'),
	(19, 'Bangladesh'),
	(20, 'Belgium'),
	(21, 'Burkina Faso'),
	(22, 'Bulgaria'),
	(23, 'Bahrain'),
	(24, 'Burundi'),
	(25, 'Benin'),
	(26, 'Bermuda'),
	(27, 'Brunei Darussalam'),
	(28, 'Bolivia'),
	(29, 'Brazil'),
	(30, 'Bahamas'),
	(31, 'Bhutan'),
	(32, 'Bouvet Island'),
	(33, 'Botswana'),
	(34, 'Belarus'),
	(35, 'Belize'),
	(36, 'Canada'),
	(37, 'Cocos (Keeling) Islands'),
	(38, 'Congo, the Democratic Republic of the'),
	(39, 'Central African Republic'),
	(40, 'Congo'),
	(41, 'Switzerland'),
	(42, 'Cote D\'Ivoire'),
	(43, 'Cook Islands'),
	(44, 'Chile'),
	(45, 'Cameroon'),
	(46, 'China'),
	(47, 'Colombia'),
	(48, 'Costa Rica'),
	(49, 'Serbia and Montenegro'),
	(50, 'Cuba'),
	(51, 'Cape Verde'),
	(52, 'Christmas Island'),
	(53, 'Cyprus'),
	(54, 'Czech Republic'),
	(55, 'Germany'),
	(56, 'Djibouti'),
	(57, 'Denmark'),
	(58, 'Dominica'),
	(59, 'Dominican Republic'),
	(60, 'Algeria'),
	(61, 'Ecuador'),
	(62, 'Estonia'),
	(63, 'Egypt'),
	(64, 'Western Sahara'),
	(65, 'Eritrea'),
	(66, 'Spain'),
	(67, 'Ethiopia'),
	(68, 'Finland'),
	(69, 'Fiji'),
	(70, 'Falkland Islands (Malvinas)'),
	(71, 'Micronesia, Federated States of'),
	(72, 'Faroe Islands'),
	(73, 'France'),
	(74, 'Gabon'),
	(75, 'United Kingdom'),
	(76, 'Grenada'),
	(77, 'Georgia'),
	(78, 'French Guiana'),
	(79, 'Ghana'),
	(80, 'Gibraltar'),
	(81, 'Greenland'),
	(82, 'Gambia'),
	(83, 'Guinea'),
	(84, 'Guadeloupe'),
	(85, 'Equatorial Guinea'),
	(86, 'Greece'),
	(87, 'South Georgia and the South Sandwich Islands'),
	(88, 'Guatemala'),
	(89, 'Guam'),
	(90, 'Guinea-Bissau'),
	(91, 'Guyana'),
	(92, 'Hong Kong'),
	(93, 'Heard Island and Mcdonald Islands'),
	(94, 'Honduras'),
	(95, 'Croatia'),
	(96, 'Haiti'),
	(97, 'Hungary'),
	(98, 'Indonesia'),
	(99, 'Ireland'),
	(100, 'Israel'),
	(101, 'India'),
	(102, 'British Indian Ocean Territory'),
	(103, 'Iraq'),
	(104, 'Iran, Islamic Republic of'),
	(105, 'Iceland'),
	(106, 'Italy'),
	(107, 'Jamaica'),
	(108, 'Jordan'),
	(109, 'Japan'),
	(110, 'Kenya'),
	(111, 'Kyrgyzstan'),
	(112, 'Cambodia'),
	(113, 'Kiribati'),
	(114, 'Comoros'),
	(115, 'Saint Kitts and Nevis'),
	(116, 'Korea, Democratic People\'s Republic of'),
	(117, 'Korea, Republic of'),
	(118, 'Kuwait'),
	(119, 'Cayman Islands'),
	(120, 'Kazakhstan'),
	(121, 'Lao People\'s Democratic Republic'),
	(122, 'Lebanon'),
	(123, 'Saint Lucia'),
	(124, 'Liechtenstein'),
	(125, 'Sri Lanka'),
	(126, 'Liberia'),
	(127, 'Lesotho'),
	(128, 'Lithuania'),
	(129, 'Luxembourg'),
	(130, 'Latvia'),
	(131, 'Libyan Arab Jamahiriya'),
	(132, 'Morocco'),
	(133, 'Monaco'),
	(134, 'Moldova, Republic of'),
	(135, 'Madagascar'),
	(136, 'Marshall Islands'),
	(137, 'Macedonia, the Former Yugoslav Republic of'),
	(138, 'Mali'),
	(139, 'Myanmar'),
	(140, 'Mongolia'),
	(141, 'Macao'),
	(142, 'Northern Mariana Islands'),
	(143, 'Martinique'),
	(144, 'Mauritania'),
	(145, 'Montserrat'),
	(146, 'Malta'),
	(147, 'Mauritius'),
	(148, 'Maldives'),
	(149, 'Malawi'),
	(150, 'Mexico'),
	(151, 'Malaysia'),
	(152, 'Mozambique'),
	(153, 'Namibia'),
	(154, 'New Caledonia'),
	(155, 'Niger'),
	(156, 'Norfolk Island'),
	(157, 'Nigeria'),
	(158, 'Nicaragua'),
	(159, 'Netherlands'),
	(160, 'Norway'),
	(161, 'Nepal'),
	(162, 'Nauru'),
	(163, 'Niue'),
	(164, 'New Zealand'),
	(165, 'Oman'),
	(166, 'Panama'),
	(167, 'Peru'),
	(168, 'French Polynesia'),
	(169, 'Papua New Guinea'),
	(170, 'Philippines'),
	(171, 'Pakistan'),
	(172, 'Poland'),
	(173, 'Saint Pierre and Miquelon'),
	(174, 'Pitcairn'),
	(175, 'Puerto Rico'),
	(176, 'Palestinian Territory, Occupied'),
	(177, 'Portugal'),
	(178, 'Palau'),
	(179, 'Paraguay'),
	(180, 'Qatar'),
	(181, 'Reunion'),
	(182, 'Romania'),
	(183, 'Russian Federation'),
	(184, 'Rwanda'),
	(185, 'Saudi Arabia'),
	(186, 'Solomon Islands'),
	(187, 'Seychelles'),
	(188, 'Sudan'),
	(189, 'Sweden'),
	(190, 'Singapore'),
	(191, 'Saint Helena'),
	(192, 'Slovenia'),
	(193, 'Svalbard and Jan Mayen'),
	(194, 'Slovakia'),
	(195, 'Sierra Leone'),
	(196, 'San Marino'),
	(197, 'Senegal'),
	(198, 'Somalia'),
	(199, 'Suriname'),
	(200, 'Sao Tome and Principe'),
	(201, 'El Salvador'),
	(202, 'Syrian Arab Republic'),
	(203, 'Swaziland'),
	(204, 'Turks and Caicos Islands'),
	(205, 'Chad'),
	(206, 'French Southern Territories'),
	(207, 'Togo'),
	(208, 'Thailand'),
	(209, 'Tajikistan'),
	(210, 'Tokelau'),
	(211, 'Timor-Leste'),
	(212, 'Turkmenistan'),
	(213, 'Tunisia'),
	(214, 'Tonga'),
	(215, 'Turkey'),
	(216, 'Trinidad and Tobago'),
	(217, 'Tuvalu'),
	(218, 'Taiwan, Province of China'),
	(219, 'Tanzania, United Republic of'),
	(220, 'Ukraine'),
	(221, 'Uganda'),
	(222, 'United States Minor Outlying Islands'),
	(223, 'United States'),
	(224, 'Uruguay'),
	(225, 'Uzbekistan'),
	(226, 'Holy See (Vatican City State)'),
	(227, 'Saint Vincent and the Grenadines'),
	(228, 'Venezuela'),
	(229, 'Virgin Islands, British'),
	(230, 'Virgin Islands, U.s.'),
	(231, 'Viet Nam'),
	(232, 'Vanuatu'),
	(233, 'Wallis and Futuna'),
	(234, 'Samoa'),
	(235, 'Yemen'),
	(236, 'Mayotte'),
	(237, 'South Africa'),
	(238, 'Zambia'),
	(239, 'Zimbabwe');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;


-- Dumping structure for table filocity_final.documents
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT 'Friendly name of the file.',
  `file` varchar(100) DEFAULT NULL,
  `ext` varchar(10) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `user_id` varchar(45) NOT NULL COMMENT 'ID of the user that added the file.',
  `folder_id` int(11) NOT NULL COMMENT 'This is the ID of the folder that this file goes within.',
  `status` tinyint(2) DEFAULT '1' COMMENT '0 - Disabled (access denied to all users).1 - Enabled to those with ownership rights.',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `in_progress` tinyint(2) DEFAULT '1' COMMENT '0 - fileupload completed  .1 - file upload is in progress.',
  `version` int(11) NOT NULL DEFAULT '1' COMMENT 'This is the version of the file goes within.',
  `createdby` varchar(50) DEFAULT NULL COMMENT 'Stores createdby username .',
  `modifiedby` varchar(50) DEFAULT NULL COMMENT 'Stores modifiedby username .',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=207 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.documents: 126 rows
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` (`id`, `name`, `file`, `ext`, `type`, `size`, `user_id`, `folder_id`, `status`, `created`, `modified`, `in_progress`, `version`, `createdby`, `modifiedby`) VALUES
	(81, 'One', '3-81.jpg', 'jpg', 'image/jpeg', '152355', '1', 3, 0, '2012-11-09 16:21:42', '2012-11-24 02:05:39', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(82, 'Two', '3-82.jpg', 'jpg', 'image/jpeg', '58598', '1', 3, 0, '2012-11-09 16:22:12', '2012-11-09 16:24:40', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(83, 'Three', '3-83.jpg', 'jpg', 'image/jpeg', '710726', '1', 3, 0, '2012-11-09 16:22:24', '2012-11-09 16:24:41', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(84, 'Four', '3-84.jpg', 'jpg', 'image/jpeg', '21926', '1', 3, 0, '2012-11-09 16:22:38', '2012-11-09 16:24:43', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(85, 'Koala', '1-85.jpg', 'jpg', 'image/jpeg', '780831', '1', 1, 0, '2012-11-09 16:26:48', '2012-11-09 16:26:48', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(86, 'New Microsoft Office Word Document', '86-26.docx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '0', '1', 26, 0, '2012-11-29 16:58:53', '2012-11-29 16:58:53', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(87, 'New Text Document', '87-26.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 26, 0, '2012-11-29 16:58:53', '2012-11-29 16:58:53', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(88, 'New Microsoft Office Word Document', '88-27.docx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '0', '1', 27, 0, '2012-11-29 16:59:03', '2012-11-29 16:59:03', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(89, 'New Text Document', '89-27.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 27, 0, '2012-11-29 16:59:03', '2012-11-29 16:59:03', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(90, 'Data for upload download', '90-27.docx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '11666', '1', 27, 1, '2012-11-29 17:00:09', '2012-11-29 17:00:09', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(91, 'Data for upload download', '91-27.docx-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '11666', '1', 27, 1, '2012-11-29 17:00:14', '2012-11-29 17:00:14', 0, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(92, 'Data for upload download', '92-27.docx-[[3]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '11666', '1', 27, 1, '2012-11-29 17:00:19', '2012-11-29 17:00:19', 0, 3, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(93, 'Data for upload download', '93-27.docx-[[4]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '11063', '1', 27, 1, '2012-11-29 17:00:55', '2012-11-29 17:00:55', 0, 4, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(94, 'Data for upload download', '94-23.docx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '11063', '1', 23, 1, '2012-11-29 17:14:16', '2012-11-29 17:14:16', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(95, 'Data for upload download', '95-23.docx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '11063', '1', 23, 1, '2012-11-29 17:14:16', '2012-11-29 17:14:16', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(96, '1', '96-25.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 25, 0, '2012-11-30 10:56:08', '2012-11-30 10:56:08', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(97, 'listing json', '97-25.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 25, 0, '2012-11-30 10:56:18', '2012-11-30 10:56:18', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(98, 'listing json', '98-25.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 25, 0, '2012-11-30 10:56:27', '2012-11-30 10:56:27', 0, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(99, 'new  2', '99-28.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2356', '1', 28, 0, '2012-11-30 11:21:54', '2012-11-30 11:21:54', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(100, '1', '100-28.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 28, 0, '2012-11-30 11:21:54', '2012-11-30 11:21:54', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(101, 'testupload', '101-28.xlsx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'xlsx', 'xlsx', '8188', '1', 28, 0, '2012-11-30 11:21:55', '2012-11-30 11:21:55', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(102, '1', '102-29.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 29, 0, '2012-11-30 11:22:01', '2012-11-30 11:22:01', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(103, '1', '103-28.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 28, 0, '2012-11-30 11:22:01', '2012-11-30 11:22:01', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(104, '1', '104-29.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 29, 0, '2012-11-30 11:22:04', '2012-11-30 11:22:04', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(105, 'listing json', '105-29.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 29, 0, '2012-11-30 11:22:04', '2012-11-30 11:22:04', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(106, 'path', '106-28.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '10', '1', 28, 0, '2012-11-30 11:22:42', '2012-11-30 11:22:42', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(107, '1', '107-30.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 30, 0, '2012-11-30 11:29:11', '2012-11-30 11:29:11', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(108, 'listing json', '108-30.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 30, 0, '2012-11-30 11:29:11', '2012-11-30 11:29:11', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(109, 'new  1', '109-3.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 3, 1, '2012-11-30 11:37:23', '2012-11-30 11:37:23', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(110, 'new  1', '110-3.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 3, 1, '2012-11-30 11:37:45', '2012-11-30 11:37:45', 0, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(111, 'new  1', '111-1.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 1, 0, '2012-11-30 11:37:52', '2012-11-30 11:37:52', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(112, 'c', '112-31.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1657', '1', 31, 1, '2012-11-30 11:38:11', '2012-11-30 11:38:11', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(113, '1', '113-31.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 31, 1, '2012-11-30 11:38:11', '2012-11-30 11:38:11', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(114, '1', '114-31.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 31, 1, '2012-11-30 11:38:14', '2012-11-30 11:38:14', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(115, 'listing json', '115-31.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 31, 0, '2012-11-30 11:38:14', '2012-11-30 11:38:14', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(116, '1', '116-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 32, 1, '2012-11-30 11:42:17', '2012-11-30 11:42:17', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(117, 'c', '117-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1657', '1', 32, 1, '2012-11-30 11:42:17', '2012-11-30 11:42:17', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(118, 'listing json', '118-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 32, 1, '2012-11-30 11:42:22', '2012-11-30 11:42:22', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(119, '1', '119-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 32, 1, '2012-11-30 11:42:22', '2012-11-30 11:42:22', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(120, '1', '120-1.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 1, 0, '2012-11-30 12:44:59', '2012-11-30 12:44:59', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(121, 'listing json', '121-1.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 1, 0, '2012-11-30 12:45:14', '2012-11-30 12:45:14', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(122, 'xx', '122-1.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 1, 0, '2012-11-30 12:46:48', '2012-11-30 12:46:48', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(123, '1', '123-33.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 33, 1, '2012-11-30 13:13:56', '2012-11-30 13:13:56', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(124, 'new  2', '124-33.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2356', '1', 33, 1, '2012-11-30 13:13:56', '2012-11-30 13:13:56', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(125, 'testupload', '125-33.xlsx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'xlsx', 'xlsx', '8188', '1', 33, 1, '2012-11-30 13:13:57', '2012-11-30 13:13:57', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(126, 'path', '126-33.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '10', '1', 33, 1, '2012-11-30 13:14:00', '2012-11-30 13:14:00', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(127, 'new  2', '127-33.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2356', '1', 33, 1, '2012-11-30 13:14:00', '2012-11-30 13:14:00', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(128, 'listing json', '128-34.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 34, 1, '2012-11-30 13:14:01', '2012-11-30 13:14:01', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(129, '1', '129-34.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 34, 1, '2012-11-30 13:14:01', '2012-11-30 13:14:01', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(130, 'listing json', '130-34.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 34, 1, '2012-11-30 13:14:04', '2012-11-30 13:14:04', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(131, '1', '131-34.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 34, 1, '2012-11-30 13:14:04', '2012-11-30 13:14:04', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(132, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 13:22:48', '2012-11-30 13:22:48', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(133, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 13:23:27', '2012-11-30 13:23:27', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(134, 'new  1', '134-1.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 1, 1, '2012-11-30 13:36:12', '2012-11-30 13:36:12', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(135, 'new  1', '135-1.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 1, 1, '2012-11-30 13:36:33', '2012-11-30 13:36:33', 0, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(136, 'c', '136-36.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1657', '1', 36, 1, '2012-11-30 13:37:27', '2012-11-30 13:37:27', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(137, '1', '137-36.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 36, 1, '2012-11-30 13:37:27', '2012-11-30 13:37:27', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(138, 'xx', '138-36.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 36, 1, '2012-11-30 13:37:32', '2012-11-30 13:37:32', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(139, '1', '139-36.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 36, 1, '2012-11-30 13:37:32', '2012-11-30 13:37:32', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(140, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 13:57:21', '2012-11-30 13:57:21', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(141, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 13:57:33', '2012-11-30 13:57:33', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(142, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 13:57:38', '2012-11-30 13:57:38', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(143, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 13:58:16', '2012-11-30 13:58:16', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(144, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 14:13:41', '2012-11-30 14:13:41', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(145, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 14:13:41', '2012-11-30 14:13:41', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(146, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 14:13:42', '2012-11-30 14:13:42', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(147, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 14:13:44', '2012-11-30 14:13:44', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(148, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 14:13:48', '2012-11-30 14:13:48', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(149, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 14:13:48', '2012-11-30 14:13:48', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(150, 'Proposed Solution using Google Maps API', '150-32.docx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '13531', '1', 32, 1, '2012-11-30 14:13:49', '2012-11-30 14:13:49', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(151, 'Proposed Solution using Google Maps API', '151-32.docx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'docx', 'docx', '13531', '1', 32, 1, '2012-11-30 14:13:50', '2012-11-30 14:13:50', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(152, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:17:43', '2012-11-30 14:17:43', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(153, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 32, 1, '2012-11-30 14:17:45', '2012-11-30 14:17:45', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(154, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 32, 1, '2012-11-30 14:17:57', '2012-11-30 14:17:57', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(155, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:17:57', '2012-11-30 14:17:57', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(156, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:17:59', '2012-11-30 14:17:59', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(157, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 32, 1, '2012-11-30 14:18:00', '2012-11-30 14:18:00', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(158, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:18:01', '2012-11-30 14:18:01', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(159, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:26:49', '2012-11-30 14:26:49', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(160, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:26:49', '2012-11-30 14:26:49', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(161, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:26:50', '2012-11-30 14:26:50', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(162, 'Query', '162-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:26:54', '2012-11-30 14:26:54', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(163, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:26:54', '2012-11-30 14:26:54', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(164, 'Query', '164-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2385', '1', 32, 1, '2012-11-30 14:26:55', '2012-11-30 14:26:55', 1, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(165, 'payback', '171-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '9', '1', 32, 1, '2012-11-30 14:27:14', '2012-11-30 14:27:14', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(166, 'payback', '166-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '9', '1', 32, 1, '2012-11-30 14:27:14', '2012-11-30 14:27:14', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(167, 'xx12', '167-35.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 35, 1, '2012-11-30 15:00:39', '2012-11-30 15:00:39', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(168, 'xx1223', '168-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 32, 1, '2012-11-30 15:02:57', '2012-11-30 15:02:57', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(169, 'xx1223', '169-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 32, 1, '2012-11-30 15:05:20', '2012-11-30 15:05:20', 0, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(170, 'payback', '171-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '9', '1', 32, 1, '2012-11-30 16:48:29', '2012-11-30 16:48:29', 1, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(171, 'payback', '171-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '9', '1', 32, 1, '2012-11-30 16:48:29', '2012-11-30 16:48:29', 1, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(172, 'xx1223', '173-32.txt-[[3]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 32, 1, '2012-11-30 16:48:44', '2012-11-30 16:48:44', 1, 3, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(173, 'xx1223', '173-32.txt-[[3]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '4122', '1', 32, 1, '2012-11-30 16:48:48', '2012-11-30 16:48:48', 1, 3, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(174, 'new  1', '174-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:49:58', '2012-11-30 16:49:58', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(175, 'new  1', '175-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:49:59', '2012-11-30 16:49:59', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(176, 'new  1', '176-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:50:38', '2012-11-30 16:50:38', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(177, 'new  1', '177-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:50:38', '2012-11-30 16:50:38', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(178, 'new  1', '178-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:50:45', '2012-11-30 16:50:45', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(179, 'new  1', '179-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:50:45', '2012-11-30 16:50:45', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(180, 'new  1', '180-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:50:48', '2012-11-30 16:50:48', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(181, 'new  1', '181-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:50:46', '2012-11-30 16:50:46', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(182, 'new  1', '182-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:51:54', '2012-11-30 16:51:54', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(183, 'new  1', '183-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2018', '1', 32, 1, '2012-11-30 16:51:54', '2012-11-30 16:51:54', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(184, 'offer', '184-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2782', '1', 32, 1, '2012-11-30 16:52:19', '2012-11-30 16:52:19', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(185, 'offer', '185-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '2782', '1', 32, 1, '2012-11-30 16:52:20', '2012-11-30 16:52:20', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(186, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 17:05:25', '2012-11-30 17:05:25', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(187, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-11-30 17:05:26', '2012-11-30 17:05:26', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(188, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 10:47:36', '2012-12-01 10:47:36', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(189, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 10:47:48', '2012-12-01 10:47:48', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(190, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 10:50:30', '2012-12-01 10:50:30', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(191, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 10:50:31', '2012-12-01 10:50:31', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(192, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 10:53:33', '2012-12-01 10:53:33', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(193, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 10:53:39', '2012-12-01 10:53:39', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(194, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 10:56:39', '2012-12-01 10:56:39', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(195, '17-10-2012', '195-34.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '214', '1', 34, 1, '2012-12-01 11:06:25', '2012-12-01 11:06:25', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(196, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 12:01:05', '2012-12-01 12:01:05', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(197, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 12:13:19', '2012-12-01 12:13:19', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(198, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 12:24:03', '2012-12-01 12:24:03', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(199, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 12:28:12', '2012-12-01 12:28:12', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(200, 'ProductComparisonImport', '200-32.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 12:35:55', '2012-12-01 12:35:55', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(201, 'ProductComparisonImport', '201-32.txt-[[2]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '1399', '1', 32, 1, '2012-12-01 12:41:42', '2012-12-01 12:41:42', 0, 2, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(202, '1', '202-37.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 37, 1, '2012-12-01 12:47:54', '2012-12-01 12:47:54', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(203, '1', '203-37.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '0', '1', 37, 1, '2012-12-01 12:47:54', '2012-12-01 12:47:54', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(204, '1', '204-38.txt-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'txt', 'txt', '5119', '1', 38, 1, '2012-12-03 07:58:51', '2012-12-03 07:58:51', 0, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(205, 'Match', '205-37.xlsx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'xlsx', 'xlsx', '16749', '1', 37, 1, '2012-12-03 08:48:15', '2012-12-03 08:48:15', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(206, 'Match', '206-37.xlsx-[[1]]e0aa0f7c72898ca8b1a7ef146c9fb35390b26d4d', 'xlsx', 'xlsx', '16749', '1', 37, 1, '2012-12-03 08:48:17', '2012-12-03 08:48:17', 1, 1, 'Abdullah Yousuf', 'Abdullah Yousuf');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;


-- Dumping structure for table filocity_final.folders
CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) DEFAULT NULL,
  `created` datetime NOT NULL,
  `name` varchar(45) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '0 - Disabled (access denied to all users).1 - Enabled to those with ownership rights.',
  `createdby` varchar(50) DEFAULT NULL COMMENT 'Stores createdby username .',
  `modifiedby` varchar(50) DEFAULT NULL COMMENT 'Stores modifiedby username .',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.folders: 35 rows
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` (`id`, `parent_id`, `created`, `name`, `user_id`, `modified`, `status`, `createdby`, `modifiedby`) VALUES
	(1, 0, '2012-11-09 16:21:15', 'My Files', 1, '2012-11-09 16:21:09', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(2, 1, '2012-11-09 16:21:15', 'Collections', 3, '2012-11-09 16:21:15', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(3, 2, '2012-11-09 16:21:15', 'Sport', 1, '2012-11-09 16:21:24', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(4, 3, '2012-11-09 16:21:15', 'Surfing', 3, '2012-11-09 16:21:15', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(5, 3, '2012-11-09 16:21:15', 'Extreme knitting', 1, '2012-11-09 16:21:15', 0, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(6, 2, '2012-11-09 16:21:15', 'Friends', 1, '2012-11-09 16:21:15', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(7, 6, '2012-11-09 16:21:15', 'Gerald', 1, '2012-11-09 16:21:15', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(8, 6, '2012-11-09 16:21:15', 'Gwendolyn', 1, '2012-11-09 16:21:15', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(9, 1, '2012-11-09 16:21:15', 'Work', 1, '2012-11-09 16:21:15', 0, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(10, 9, '2012-11-09 16:21:15', 'Reports', 1, '2012-11-09 16:21:15', 0, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(11, 10, '2012-11-09 16:21:15', 'Annual', 1, '2012-11-09 16:21:15', 0, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(12, 10, '2012-11-09 16:21:15', 'Status', 1, '2012-11-09 16:21:15', 0, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(13, 9, '2012-11-09 16:21:15', 'Trips', 1, '2012-11-09 16:21:15', 0, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(14, 10, '2012-11-09 16:21:15', 'National', 1, '2012-10-29 17:42:16', 0, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(15, 13, '2012-11-09 16:21:15', 'International', 1, '2012-11-09 16:21:15', 0, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(19, 0, '2012-11-09 16:21:15', 'My Categories 2', 1, '2012-11-09 16:21:15', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(20, 19, '2012-11-09 16:21:15', 'Fun 2', 1, '2012-11-09 16:21:15', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(21, 20, '2012-11-09 16:21:15', 'Sport 2', 1, '2012-11-09 16:21:15', 1, 'Abdullah Yousuf', 'Abdullah Yousuf'),
	(22, 1, '2012-11-29 16:48:13', 'try1', 3, '2012-11-29 16:48:13', 1, NULL, NULL),
	(23, 1, '2012-11-29 16:58:31', 'vsdvdsfv', 1, '2012-11-29 16:58:31', 0, NULL, NULL),
	(24, 3, '2012-11-29 16:58:34', 'vsfdvddfs', 1, '2012-11-29 16:58:34', 0, NULL, NULL),
	(25, 23, '2012-11-29 16:58:39', 'vsfdvsdfvsdf', 1, '2012-11-29 16:58:39', 0, NULL, NULL),
	(26, 25, '2012-11-29 16:58:53', 'try', 1, '2012-11-29 16:58:53', 0, NULL, NULL),
	(27, 1, '2012-11-29 16:59:03', 'try', 1, '2012-11-29 16:59:03', 0, NULL, NULL),
	(28, 29, '2012-11-30 11:21:54', 'testfo9r1', 1, '2012-11-30 11:21:54', 0, NULL, NULL),
	(29, 25, '2012-11-30 11:22:01', 'New folder', 1, '2012-11-30 11:22:01', 0, NULL, NULL),
	(30, 28, '2012-11-30 11:29:11', 'New1', 1, '2012-11-30 11:29:11', 0, NULL, NULL),
	(31, 1, '2012-11-30 11:38:11', 'mytest', 1, '2012-11-30 11:38:11', 1, NULL, NULL),
	(32, 31, '2012-11-30 11:42:17', 'mytest', 1, '2012-11-30 11:42:17', 1, NULL, NULL),
	(33, 32, '2012-11-30 13:13:56', 'testfo9r1', 1, '2012-11-30 13:13:56', 1, NULL, NULL),
	(34, 33, '2012-11-30 13:14:01', 'New folder', 1, '2012-11-30 13:14:01', 1, NULL, NULL),
	(35, 1, '2012-11-30 13:37:03', 'new', 1, '2012-11-30 13:37:03', 1, NULL, NULL),
	(36, 33, '2012-11-30 13:37:27', 'mytest', 1, '2012-11-30 13:37:27', 1, NULL, NULL),
	(37, 35, '2012-12-01 12:47:33', 'monitortest', 1, '2012-12-01 12:47:33', 1, NULL, NULL),
	(38, 35, '2012-12-03 07:50:20', 'testM', 1, '2012-12-03 07:50:20', 1, NULL, NULL);
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;


-- Dumping structure for table filocity_final.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `purpose` text NOT NULL,
  `is_for_account_users` tinyint(1) NOT NULL,
  `folder_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.groups: 0 rows
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


-- Dumping structure for table filocity_final.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.logs: 88 rows
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
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
	(54, 1, '2012-11-07 14:14:22', '2012-11-07 14:14:22'),
	(55, 1, '2012-11-10 11:52:59', '2012-11-10 11:52:59'),
	(56, 1, '2012-11-12 11:14:14', '2012-11-12 11:14:14'),
	(57, 1, '2012-11-12 11:16:48', '2012-11-12 11:16:48'),
	(58, 1, '2012-11-12 11:21:19', '2012-11-12 11:21:19'),
	(59, 1, '2012-11-12 11:22:57', '2012-11-12 11:22:57'),
	(60, 1, '2012-11-12 11:26:51', '2012-11-12 11:26:51'),
	(61, 1, '2012-11-12 11:31:50', '2012-11-12 11:31:50'),
	(62, 1, '2012-11-12 11:36:18', '2012-11-12 11:36:18'),
	(63, 1, '2012-11-12 11:38:56', '2012-11-12 11:38:56'),
	(64, 1, '2012-11-12 11:39:59', '2012-11-12 11:39:59'),
	(65, 1, '2012-11-12 11:41:07', '2012-11-12 11:41:07'),
	(66, 1, '2012-11-12 13:25:27', '2012-11-12 13:25:27'),
	(67, 1, '2012-11-13 07:03:00', '2012-11-13 07:03:00'),
	(68, 1, '2012-11-13 07:08:16', '2012-11-13 07:08:16'),
	(69, 1, '2012-11-13 08:17:59', '2012-11-13 08:17:59'),
	(70, 1, '2012-11-17 03:06:36', '2012-11-17 03:06:36'),
	(71, 1, '2012-11-17 03:08:26', '2012-11-17 03:08:26'),
	(72, 1, '2012-11-17 03:40:08', '2012-11-17 03:40:08'),
	(73, 1, '2012-11-19 10:05:19', '2012-11-19 10:05:19'),
	(74, 1, '2012-11-19 11:30:08', '2012-11-19 11:30:08'),
	(75, 1, '2012-11-19 11:30:31', '2012-11-19 11:30:31'),
	(76, 1, '2012-11-19 22:17:17', '2012-11-19 22:17:17'),
	(77, 1, '2012-11-20 10:02:24', '2012-11-20 10:02:24'),
	(78, 1, '2012-11-20 11:40:54', '2012-11-20 11:40:54'),
	(79, 1, '2012-11-20 13:25:18', '2012-11-20 13:25:18'),
	(80, 1, '2012-11-20 14:52:51', '2012-11-20 14:52:51'),
	(81, 1, '2012-11-23 11:16:45', '2012-11-23 11:16:45'),
	(82, 1, '2012-11-24 00:35:03', '2012-11-24 00:35:03'),
	(83, 1, '2012-11-24 04:33:53', '2012-11-24 04:33:53'),
	(84, 1, '2012-11-24 04:35:36', '2012-11-24 04:35:36'),
	(85, 1, '2012-11-24 04:48:55', '2012-11-24 04:48:55'),
	(86, 1, '2012-11-28 15:21:35', '2012-11-28 15:21:35'),
	(87, 1, '2012-11-28 15:28:03', '2012-11-28 15:28:03'),
	(88, 1, '2012-11-29 02:53:41', '2012-11-29 02:53:41');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;


-- Dumping structure for table filocity_final.notices
CREATE TABLE IF NOT EXISTS `notices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'The ID of the user who has committed the action.',
  `user2_id` int(11) NOT NULL COMMENT 'if a user comment to or add or do some action to another user, then this field will take the second user''s id',
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `calendar_event_id` int(11) NOT NULL,
  `notice_type` varchar(20) NOT NULL COMMENT '0 - New1 - Updated2 - Shared Accessed3 - Comment4 - Deleted',
  `itemid` int(11) DEFAULT NULL COMMENT 'Like file_id or folder_id, project_id, etc.  Whatever has been updated.',
  `item_type` varchar(100) NOT NULL,
  `description` text COMMENT 'Optional, some notice_type''s will use this.',
  `message` text NOT NULL,
  `short_message` text NOT NULL COMMENT 'Field to contain HTML block for '''' My Recent Activity''',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.notices: 6 rows
/*!40000 ALTER TABLE `notices` DISABLE KEYS */;
INSERT INTO `notices` (`id`, `user_id`, `user2_id`, `project_id`, `task_id`, `document_id`, `folder_id`, `calendar_event_id`, `notice_type`, `itemid`, `item_type`, `description`, `message`, `short_message`, `created`, `modified`) VALUES
	(1, 1, 3, 0, 0, 81, 0, 0, 'share', NULL, '', NULL, '&lt;div class=&quot;notice_block share_notice&quot; data-notice=&quot;share&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has shared image with &lt;a href=&quot;../users/view/3&quot;&gt;Bryan Potts&lt;/a&gt; at 04:14 pm&lt;/p&gt;&lt;p style=&quot;margin-top: 10px;vertical-align: middle&quot;&gt;&lt;img src=&quot;img/imagecache/3-81.jpg&quot; height=&quot;173&quot;&gt;&lt;/p&gt;&lt;/div&gt;', '&lt;td class=&quot;notice_des&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has shared &lt;a href=&quot;../img/imagecache/3-81.jpg&quot;&gt;3-81.jpg&lt;/a&gt; with &lt;a href=&quot;../users/view/3&quot;&gt;Bryan Potts&lt;/a&gt;&lt;/p&gt;&lt;/td&gt;', '2012-11-28 16:14:20', '2012-11-28 16:14:20'),
	(2, 1, 0, 0, 0, 81, 0, 0, 'add', NULL, '', NULL, '&lt;div class=&quot;notice_block notice_add&quot; data-notice=&quot;add&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has added image at 04:16 pm&lt;/p&gt;&lt;p style=&quot;margin-top: 10px;vertical-align: middle&quot;&gt;&lt;img src=&quot;img/imagecache/3-81.jpg&quot; height=&quot;173&quot;&gt;&lt;/p&gt;&lt;/div&gt;', '&lt;td class=&quot;notice_des&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has added &lt;a href=&quot;../img/imagecache/3-81.jpg&quot;&gt;3-81.jpg&lt;/a&gt;&lt;/p&gt;&lt;/td&gt;', '2012-11-28 16:16:53', '2012-11-28 16:16:53'),
	(3, 1, 3, 0, 0, 0, 0, 0, 'delete', NULL, '', NULL, '&lt;div class=&quot;notice_block notice_delete&quot; data-notice=&quot;delete&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has deleted user Bryan Potts at 04:17 pm&lt;/p&gt;&lt;/div&gt;', '&lt;td class=&quot;notice_des&quot;&gt;&lt;p&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has deleted user Bryan Potts&lt;/p&gt;&lt;/p&gt;&lt;/td&gt;', '2012-11-28 16:17:28', '2012-11-28 16:17:28'),
	(4, 1, 0, 1, 0, 0, 0, 0, 'join', NULL, '', NULL, '&lt;div class=&quot;notice_block notice_join&quot; data-notice=&quot;join&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has joined to project &lt;a href=&quot;../projects/view/1&quot;&gt;Project 1&lt;/a&gt; at 04:18 pm&lt;/p&gt;&lt;/div&gt;', '&lt;td class=&quot;notice_des&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has  joinded to project &lt;a href=&quot;../projects/view/1&quot;&gt;Project 1&lt;/a&gt;.&lt;/p&gt;&lt;/td&gt;', '2012-11-28 16:18:24', '2012-11-28 16:18:24'),
	(5, 1, 0, 1, 0, 0, 0, 0, 'comment', NULL, '', NULL, '&lt;div class=&quot;notice_block notice_comment&quot; data-notice=&quot;comment&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has commented on project &lt;a href=&quot;../projects/view/1&quot;&gt;Project 1&lt;/a&gt; at 04:19 pm&lt;/p&gt;&lt;/div&gt;', '&lt;td class=&quot;notice_des&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has commented on project &lt;a href=&quot;../projects/view/1&quot;&gt;Project 1&lt;/a&gt;&lt;/p&gt;&lt;/td&gt;', '2012-11-28 16:19:03', '2012-11-28 16:19:03'),
	(6, 1, 0, 0, 1, 0, 0, 0, 'comment', NULL, '', NULL, '&lt;div class=&quot;notice_block notice_comment&quot; data-notice=&quot;comment&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has commented on &lt;a href=&quot;../tasks/view/1&quot;&gt;Task 1&lt;/a&gt; task at 04:19 pm&lt;/p&gt;&lt;/div&gt;', '&lt;td class=&quot;notice_des&quot;&gt;&lt;p&gt;&lt;a href=&quot;../users/view/1&quot;&gt;Abdullah Yousuf&lt;/a&gt; has commented on &lt;a href=&quot;../tasks/view/1&quot;&gt;Task 1&lt;/a&gt;&lt;/p&gt;&lt;/td&gt;', '2012-11-28 16:19:54', '2012-11-28 16:19:54');
/*!40000 ALTER TABLE `notices` ENABLE KEYS */;


-- Dumping structure for table filocity_final.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `storage` int(11) NOT NULL,
  `max_member` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.packages: 6 rows
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` (`id`, `name`, `price`, `storage`, `max_member`, `created`, `modified`) VALUES
	(1, 'Package 1', 250, 250, 20, '2012-10-12 19:54:14', '2012-10-12 19:54:14'),
	(2, 'Package 2', 50, 50, 10, '2012-10-12 19:54:26', '2012-10-12 19:54:26'),
	(3, 'Package 4', 10, 10, 5, '2012-10-12 19:57:15', '2012-10-12 19:57:15'),
	(4, 'Package 3', 5, 5, 3, '2012-10-12 19:57:28', '2012-10-12 19:57:28'),
	(5, 'Packge 1', 9.95, 10, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(6, 'Package 2', 0, 25, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;


-- Dumping structure for table filocity_final.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL COMMENT 'Name of project.',
  `date_due` date DEFAULT NULL COMMENT 'Date that project is due (optional).',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.projects: 4 rows
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `user_id`, `name`, `date_due`, `created`, `modified`) VALUES
	(1, 1, 'Project 1', '2012-11-01', '2012-10-19 16:51:32', '2012-10-19 16:51:32'),
	(2, 1, 'Project 2', '2012-12-01', '2012-10-19 16:52:04', '2012-10-19 16:52:04'),
	(3, 1, 'Project 3', '2012-12-15', '2012-10-19 16:52:38', '2012-10-19 16:52:38'),
	(4, 1, 'Project 4', '2012-11-15', '2012-10-19 16:52:54', '2012-10-19 16:52:54');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;


-- Dumping structure for table filocity_final.projects_users
CREATE TABLE IF NOT EXISTS `projects_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='This table links members to projects.  If there are 10 membe';

-- Dumping data for table filocity_final.projects_users: 6 rows
/*!40000 ALTER TABLE `projects_users` DISABLE KEYS */;
INSERT INTO `projects_users` (`id`, `project_id`, `user_id`, `title`, `created`, `modified`) VALUES
	(1, 1, 2, 'Member 1 to Project 1', '2012-10-19 16:55:05', '2012-10-19 16:55:05'),
	(2, 1, 3, 'Member 2 to Project 1', '2012-10-19 16:55:29', '2012-10-19 17:00:07'),
	(3, 2, 3, 'Member 1 to Project 2', '2012-10-19 16:55:54', '2012-10-19 16:55:54'),
	(4, 2, 2, 'Member 2 to Project 2', '2012-10-19 16:59:03', '2012-10-19 16:59:10'),
	(5, 3, 2, 'Member 1 to Project 3', '2012-10-19 16:59:25', '2012-10-19 16:59:39'),
	(6, 3, 3, 'Member 2 to Project 3', '2012-10-19 16:59:51', '2012-10-19 16:59:51');
/*!40000 ALTER TABLE `projects_users` ENABLE KEYS */;


-- Dumping structure for table filocity_final.purchase_logs
CREATE TABLE IF NOT EXISTS `purchase_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `business_plan` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `member_since` date NOT NULL,
  `last_payment` double NOT NULL,
  `expires_on` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.purchase_logs: 2 rows
/*!40000 ALTER TABLE `purchase_logs` DISABLE KEYS */;
INSERT INTO `purchase_logs` (`id`, `user_id`, `full_name`, `email`, `business_plan`, `price`, `member_since`, `last_payment`, `expires_on`, `created`, `modified`) VALUES
	(1, 1, 'Simon Dugdale', 'simon.dugdale@gmail.com', 'Business Account', 14.25, '2012-11-12', 15.25, '2012-11-12', '2012-11-12 13:42:46', '2012-11-12 13:42:46'),
	(2, 1, 'avj', 'avj@gmail.com', 'Business Account', 14.25, '2012-11-12', 15.25, '2012-11-12', '2012-11-12 13:53:06', '2012-11-12 13:53:06');
/*!40000 ALTER TABLE `purchase_logs` ENABLE KEYS */;


-- Dumping structure for table filocity_final.shares
CREATE TABLE IF NOT EXISTS `shares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'This should NOT be used.',
  `project_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `access` varchar(10) NOT NULL,
  `is_view` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.shares: 1 rows
/*!40000 ALTER TABLE `shares` DISABLE KEYS */;
INSERT INTO `shares` (`id`, `project_id`, `document_id`, `task_id`, `folder_id`, `user_id`, `user2_id`, `access`, `is_view`, `created`, `modified`) VALUES
	(101, 0, 0, 0, 2, 3, 1, '1', 1, '2012-11-30 18:14:27', '2012-11-30 18:14:27');
/*!40000 ALTER TABLE `shares` ENABLE KEYS */;


-- Dumping structure for table filocity_final.states
CREATE TABLE IF NOT EXISTS `states` (
  `id` int(3) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.states: 52 rows
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` (`id`, `name`) VALUES
	(0, 'Other'),
	(1, 'Alabama'),
	(2, 'Alaska'),
	(3, 'Arizona'),
	(4, 'Arkansas'),
	(5, 'California'),
	(6, 'Colorado'),
	(7, 'Connecticut'),
	(8, 'Delaware'),
	(9, 'District of Columbia'),
	(10, 'Florida'),
	(11, 'Georgia'),
	(12, 'Hawaii'),
	(13, 'Idaho'),
	(14, 'Illinois'),
	(15, 'Indiana'),
	(16, 'Iowa'),
	(17, 'Kansas'),
	(18, 'Kentucky'),
	(19, 'Louisiana'),
	(20, 'Maine'),
	(21, 'Maryland'),
	(22, 'Massachusetts'),
	(23, 'Michigan'),
	(24, 'Minnesota'),
	(25, 'Mississippi'),
	(26, 'Missouri'),
	(27, 'Montana'),
	(28, 'Nebraska'),
	(29, 'Nevada'),
	(30, 'New Hampshire'),
	(31, 'New Jersey'),
	(32, 'New Mexico'),
	(33, 'New York'),
	(34, 'North Carolina'),
	(35, 'North Dakota'),
	(36, 'Ohio'),
	(37, 'Oklahoma'),
	(38, 'Oregon'),
	(39, 'Pennsylvania'),
	(40, 'Rhode Island'),
	(41, 'South Carolina'),
	(42, 'South Dakota'),
	(43, 'Tennessee'),
	(44, 'Texas'),
	(45, 'Utah'),
	(46, 'Vermont'),
	(47, 'Virginia'),
	(48, 'Washington'),
	(49, 'West Virginia'),
	(50, 'Wisconsin'),
	(51, 'Wyoming');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;


-- Dumping structure for table filocity_final.subtasks
CREATE TABLE IF NOT EXISTS `subtasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.subtasks: 2 rows
/*!40000 ALTER TABLE `subtasks` DISABLE KEYS */;
INSERT INTO `subtasks` (`id`, `task_id`, `description`, `created`, `modified`) VALUES
	(1, 1, 'Subtask 1', '2012-10-16 00:00:00', '2012-10-16 00:00:00'),
	(2, 1, 'Subtask 2', '2012-10-18 00:00:00', '2012-10-18 00:00:00');
/*!40000 ALTER TABLE `subtasks` ENABLE KEYS */;


-- Dumping structure for table filocity_final.tasks
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.tasks: 4 rows
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `project_id`, `title`, `description`, `requesterid`, `ownerid`, `date_due`, `status`, `task_type`, `points`, `star`, `created`, `user_id`, `modified`) VALUES
	(1, 1, 'Sample', 'Sample', 3, 2, NULL, 5, 1, 1, 1, '2012-11-10 02:32:34', 1, '2012-11-10 03:09:13'),
	(2, 2, 'BSample', 'BSample', 3, 3, NULL, 2, 2, 3, 2, '2012-11-21 12:18:12', 1, '2012-11-21 10:21:42'),
	(3, 1, 'a title', 'some description about task...', 3, 2, '2012-11-30 02:08:24', 5, 1, 5, 1, '2012-11-10 06:12:24', 1, '2012-11-10 09:18:16'),
	(4, 1, 'title 2', 'description 2', 2, 1, '2012-11-22 04:11:17', 1, 2, 3, 2, '2012-11-10 02:13:39', 1, '2012-10-24 06:17:34');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;


-- Dumping structure for table filocity_final.users
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
  `auth_key` varchar(50) NOT NULL,
  `company_space_id` int(11) NOT NULL,
  `my_space_id` int(11) NOT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table filocity_final.users: 3 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `department`, `state`, `zip`, `country`, `title`, `position`, `city`, `created`, `modified`, `status`, `role`, `trial_end`, `company_id`, `auth_key`, `company_space_id`, `my_space_id`, `timezone`) VALUES
	(1, 'Abdullah', 'Yousuf', 'test@test.com', 'e99a18c428cb38d5f260853678922e03', 'Web develop', 'Khulna', '9100', 'Bangladesh', 'The title', 'CTO', 'Khulna', '2012-10-12 19:52:54', '2012-10-12 19:52:54', 1, 1, '2012-12-12', 1, '123456', 1, 3, 'Pacific Time Zone'),
	(2, 'Test', 'lasttest', 'test1@test1.com', 'e99a18c428cb38d5f260853678922e03', 'dep. Test', 'state test', '0000', 'coutry test', 'title test', 'pos test', 'city test', '2012-10-12 20:02:39', '2012-10-12 20:02:39', 1, 1, '2012-12-12', 1, '1234567', 1, 19, 'Pacific Time Zone'),
	(3, 'Another', 'User', 'test2@test2.com', 'e99a18c428cb38d5f260853678922e03', 'dep. Test', 'state test', '0000', 'coutry test', 'The title', 'pos test.test', 'dfdasfasdfasdf', '2012-10-12 20:07:54', '2012-10-12 20:07:54', 1, 1, '2012-12-12', 2, '53254', 1, 3, 'Pacific Time Zone');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
