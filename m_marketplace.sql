-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 19. Jun 2017 um 19:38
-- Server-Version: 5.6.35-1~dotdeb+7.1
-- PHP-Version: 5.6.30-1~dotdeb+7.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `m_marketplace`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admins`
--

CREATE TABLE `admins` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `admin_name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `admins`
--

INSERT INTO `admins` (`id`, `admin_name`, `password`) VALUES
(3, 'RK', 'c51dcc4e0deaee00fa5af30e29b6e1acbf32fcb3cea8c4b5cdeaecece8e248df439b2da1b834cb67bbafd2fa07d02f49');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bans`
--

CREATE TABLE `bans` (
  `id` int(11) NOT NULL,
  `ban_type` varchar(20) NOT NULL,
  `ban_value` varchar(255) NOT NULL,
  `ban_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid_days` varchar(50) NOT NULL,
  `bid_hours` int(11) NOT NULL,
  `bid_amount` mediumint(9) NOT NULL,
  `bid_time` int(11) NOT NULL,
  `bid_desc` text CHARACTER SET utf8 NOT NULL,
  `lowbid_notify` enum('0','1') CHARACTER SET utf8 NOT NULL,
  `escrow_flag` smallint(6) NOT NULL,
  `team_member_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `bids`
--

INSERT INTO `bids` (`id`, `job_id`, `user_id`, `bid_days`, `bid_hours`, `bid_amount`, `bid_time`, `bid_desc`, `lowbid_notify`, `escrow_flag`, `team_member_id`) VALUES
(71, 7, 5, '30', 0, 4000, 1419339546, 'Bid Description', '1', 0, 0),
(72, 15, 8, '20', 3, 12, 1422085340, 'Bid Description', '1', 0, 0),
(73, 19, 8, '12', 16, 12, 1423008901, 'Bid Description', '1', 0, 0),
(74, 19, 14, '12', 3, 14, 1423039853, 'Bid Description', '1', 0, 0),
(75, 18, 8, '50', 1, 45, 1423185567, 'Bid Description', '1', 0, 0),
(76, 20, 8, '30', 300, 90, 1423274818, 'Bid Description', '0', 0, 0),
(77, 21, 8, '30', 300, 90, 1423278409, 'Bid Description', '0', 0, 0),
(78, 22, 8, '10', 50, 25, 1423447675, 'Bid Description', '0', 0, 0),
(79, 23, 8, '30', 50, 25, 1423448628, 'Bid Description', '0', 0, 0),
(80, 24, 8, '30', 50, 25, 1423449820, 'Bid Description', '0', 0, 0),
(81, 25, 8, '5', 20, 10, 1423558450, 'Bid Description', '0', 0, 0),
(82, 26, 8, '60', 300, 15, 1423726480, 'Bid Description', '0', 0, 0),
(84, 27, 8, '5', 20, 15, 1424071363, 'Bid Description', '0', 0, 0),
(85, 29, 8, '5', 20, 15, 1425280720, 'Bid Description', '0', 0, 0),
(86, 30, 8, '5', 20, 15, 1425285809, 'Bid Description', '0', 0, 0),
(87, 31, 8, '5', 20, 15, 1425285969, 'Bid Description', '0', 0, 0),
(88, 32, 8, '5', 20, 15, 1425290724, 'Bid Description', '0', 0, 0),
(89, 43, 8, '5', 20, 9, 1427192009, 'Bid Description', '0', 0, 0),
(90, 44, 8, '5', 20, 9, 1427192870, 'Bid Description', '0', 0, 0),
(91, 45, 8, '5', 20, 9, 1427272812, 'Bid Description', '0', 0, 0),
(92, 50, 8, '5', 20, 10, 1429772001, 'Bid Description', '0', 0, 0),
(93, 59, 8, '5', 5, 15, 1479873315, 'Bid Description', '0', 0, 0),
(94, 56, 8, '5', 5, 10, 1480565265, 'Bid Description', '0', 0, 0),
(95, 63, 8, '4', 4, 10, 1481610535, 'Bid Description', '0', 0, 0),
(96, 67, 8, '4', 4, 31, 1485765636, 'Bid Description', '0', 0, 40),
(97, 68, 8, '12', 30, 41, 1485767519, 'Bid Description', '0', 0, 0),
(100, 69, 8, '2017-02-10', 0, 45, 1486029599, '', '1', 0, 0),
(101, 207, 17, '2017-03-29', 0, 30, 1490703261, '', '0', 0, 0),
(122, 208, 8, '2017-04-15', 0, 50, 1493031702, 'Bid Desc ', '0', 0, 0),
(103, 206, 8, '2017-05-01', 0, 50, 1491195512, 'Project Description', '0', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookmark`
--

CREATE TABLE `bookmark` (
  `id` int(11) NOT NULL,
  `creator_id` varchar(128) NOT NULL,
  `creator_name` varchar(128) NOT NULL,
  `job_id` varchar(128) NOT NULL,
  `job_name` varchar(128) NOT NULL,
  `job_creator` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `bookmark`
--

INSERT INTO `bookmark` (`id`, `creator_id`, `creator_name`, `job_id`, `job_name`, `job_creator`) VALUES
(31, '7', 'owner', '15', 'fsdfvxcvcxv', '7'),
(32, '8', 'employee', '25', 'Test Project For document', '7'),
(33, '7', 'owner', '29', 'Overall Testing 2', '7');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `category_name_encry` varchar(255) CHARACTER SET utf8 NOT NULL,
  `group_id` smallint(6) UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `attachment_url` longtext NOT NULL,
  `attachment_name` varchar(60) NOT NULL,
  `page_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `meta_keywords` text CHARACTER SET utf8 NOT NULL,
  `meta_description` text CHARACTER SET utf8 NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_name_encry`, `group_id`, `description`, `attachment_url`, `attachment_name`, `page_title`, `meta_keywords`, `meta_description`, `is_active`, `created`, `modified`) VALUES
(14, 'Self Paced Training', '4372889b77c08a18e6c7678959dfae5f', 11, 'Self Paced Training', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Self Paced Training', 'Self Paced Training', 'Self Paced Training', 1, 1419279594, 1421727874),
(15, 'Mentoring', '089011f59ea2749a842c1cb289c52c5d', 11, 'Mentoring', 'fbdd8798cdb42f814410bdba5e73237f.png', '', 'Mentoring', 'Mentoring', 'Mentoring', 1, 1419279778, 1423794377),
(16, 'On the Job Training', '45c1a51912d3278521105a38797197d6', 11, 'On the Job Training', '429408bc69ad751e399dfbd071007a3b.png', '', 'On the Job Training', 'On the Job Training', 'On the Job Training', 1, 1419279828, 1423795773),
(17, 'University/Classroom', '4300cc3a3c73093817f2819998be78d1', 11, 'University/Classroom', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'University/Classroom', 'University/Classroom', 'University/Classroom', 1, 1419279878, 1419279878),
(18, 'University/eLearning', 'ecc1096e75897a6a418aa54cc6309b95', 11, 'University/eLearning', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'University/eLearning', 'University/eLearning', 'University/eLearning', 1, 1419279947, 1419279947),
(21, 'Webinar', '50dd9fb6d93c81e15cec36ffc49cd0f8', 11, 'Webinar', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Webinar', 'Webinar', 'Webinar', 1, 1419369869, 1419369869),
(22, 'Train the Trainer', '8364a35733b4c01bb57ce49b93bfd34d', 11, 'Train the Trainer', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Train the Trainer', 'Train the Trainer', 'Train the Trainer', 1, 1419369934, 1419369934),
(177, 'Self Paced Training', '4372889b77c08a18e6c7678959dfae5f', 12, 'dsfdsfdsf', '6674d0107b44570db8ff5b1d8f838694.png', 'france.png', 'dsfsdf', 'sdfdsf', 'dsfsdfsdf', 1, 1421199715, 1423805839),
(23, 'One on One Training', '6bc8941a87ee611117eaa07cec48769d', 11, 'Enterprise Organization', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Enterprise Organization', 'Enterprise Organization', 'Enterprise Organization', 0, 0, 1421198980),
(24, 'Business Development', 'db01e6ae90744aebba2ed0faefb8ceed', 28, 'Business Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Business Development', 'Business Development', 'Business Development', 0, 0, 1421198980),
(25, 'Business Excellence', 'e9ae981cdb970ff2cf37ea58fc3fc93f', 28, 'Business Excellencee', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Business Excellence', 'Business Excellence', 'Business Excellence', 0, 0, 1421722641),
(26, 'Organization Development', '423b89e54151ef282fc4441fd7e9d292', 28, 'Organization Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Organization Development', 'Organization Development', 'Organization Development', 1, 0, 0),
(27, 'Vision/Mission Development', '1bc3afe672a2a14262e8303c69068715', 28, 'Vision/Mission Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Vision/Mission Development', 'Vision/Mission Development', 'Vision/Mission Development', 1, 0, 0),
(28, 'Balanced Scorecard', '997a159a6c0ec092f40ecadf6240e924', 28, 'Balanced Scorecard', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Balanced Scorecard', 'Balanced Scorecard', 'Balanced Scorecard', 1, 0, 0),
(29, 'Decission Making', '10cb0bbbf2fab9eaf406ff8a6e927d9b', 28, 'Decission Making', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Decission Making', 'Decission Making', 'Decission Making', 1, 0, 0),
(30, 'Enterprise Organization', '104e349a614e24418a716ce1da04fdad', 28, 'Enterprise Organization', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Enterprise Organization', 'Enterprise Organization', 'Enterprise Organization', 1, 0, 0),
(31, 'Hiring', 'ad47487ba9f55206809cda9b8c26970e', 12, 'Hiring', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Hiring', 'Hiring', 'Hiring', 1, 0, 0),
(32, 'Talent Management', '098dffccb099681e86da846acfc18f82', 12, 'Talent Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Talent Management', 'Talent Management', 'Talent Management', 1, 0, 0),
(33, 'Payment Systems', 'f9c8caf36e4edd9019ad377a3e5913f9', 12, 'Payment Systems', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Payment Systems', 'Payment Systems', 'Payment Systems', 1, 0, 0),
(34, 'Employment Law regulations', '31b0ec3b99b07738721de18143026073', 12, 'Employment Law regulations', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Employment Law regulations', 'Employment Law regulations', 'Employment Law regulations', 1, 0, 0),
(35, 'Employee Motivation', '605710b2b9973ce56e579e7fe7ca40bd', 12, 'Employee Motivation', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Employee Motivation', 'Employee Motivation', 'Employee Motivation', 1, 0, 0),
(36, 'Wage accounting', '9f605b329a26309b79602288ca91566e', 12, 'Wage accounting', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Wage accounting', 'Wage accounting', 'Wage accounting', 1, 0, 0),
(37, 'Public Relations', '97ac0992b3214632ef41a3075b0c6e9b', 13, 'Public Relations', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Public Relations', 'Public Relations', 'Public Relations', 1, 0, 0),
(38, 'Internal Communication', '00251b5dece63be7afb8f5fcdd3e83ce', 13, 'Internal Communication', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Internal Communication', 'Internal Communication', 'Internal Communication', 1, 0, 0),
(39, 'Employee Information', '5ae646bae06e16daec5fa3612e1444a2', 13, 'Employee Information', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Employee Information', 'Employee Information', 'Employee Information', 1, 0, 0),
(40, 'Translation Service', '54d1a8b447435ee325e306b8a58f58c9', 13, 'Translation Service', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Translation Service', 'Translation Service', 'Translation Service', 1, 0, 0),
(41, 'Problem Definition', '1f2e4e60dc657345243d64f97fb1bbfe', 14, 'Problem Definition', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Problem Definition', 'Problem Definition', 'Problem Definition', 1, 0, 0),
(42, 'Idea Generation', '26e11ac3f33f80d997e361a593645a11', 14, 'Idea Generation', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Idea Generation', 'Idea Generation', 'Idea Generation', 1, 0, 0),
(43, 'Idea Selection', 'f87cc7da43b9e091d3860ddea56d5cca', 14, 'Idea Selection', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Idea Selection', 'Idea Selection', 'Idea Selection', 1, 0, 0),
(44, 'Idea Implementation', '643ad5bde5f29c59d835653f105d74c7', 14, 'Idea Implementation', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Idea Implementation', 'Idea Implementation', 'Idea Implementation', 1, 0, 0),
(45, 'Production Planning', '4c89dbee82b7b1dd9d379c2d00562947', 15, 'Production Planning', '0c1ed712028e14d3501e124e9dbc5788.png', '', 'Production Planning', 'Production Planning', 'Production Planning', 1, 0, 1421213388),
(46, 'Sequencing', 'f770364d234fdd52dafa02b6e16f3fb6', 15, 'Sequencing', 'd777ea78d7be703ebbd509243afccb5b.png', 'china.png', 'Sequencing', 'Sequencing', 'Sequencing', 1, 0, 1421213793),
(47, 'Production', '756d97bb256b8580d4d71ee0c547804e', 15, 'Production', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Production', 'Production', 'Production', 1, 0, 0),
(48, 'Know How Management', '5368b55efe0fdf484d59fced5bdf8fc7', 15, 'Know How Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Know How Management', 'Know How Management', 'Know How Management', 1, 0, 0),
(49, 'Employee Recognition', '547d767efe9c787101db5cf00e485e60', 15, 'Employee Recognition', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Employee Recognition', 'Employee Recognition', 'Employee Recognition', 1, 0, 0),
(50, 'Autonomous Workgroups', '793cb79980d3fa094ef13dcf866c482a', 15, 'Autonomous Workgroups', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Autonomous Workgroups', 'Autonomous Workgroups', 'Autonomous Workgroups', 1, 0, 0),
(51, 'Supply Chain Management', 'bd5476e8f33749530f87777476eeda72', 16, 'Supply Chain Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Supply Chain Management', 'Supply Chain Management', 'Supply Chain Management', 1, 0, 0),
(52, 'Purchasing', '5f95f5c48171ba26e9f8aa9d8c7ce6c4', 16, 'Purchasing', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Purchasing', 'Purchasing', 'Purchasing', 1, 0, 0),
(53, 'Warehouse', '6416e8cb5fc0a208d94fa7f5a300dbc4', 16, 'Warehouse', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Warehouse', 'Warehouse', 'Warehouse', 1, 0, 0),
(54, 'Distribution', 'f0bac093bb884df2891d32385d053788', 16, 'Distribution', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Distribution', 'Distribution', 'Distribution', 1, 0, 0),
(55, 'Factory Layout', '0071d27c3fcd29f13466286ba27549f1', 17, 'Factory Layout', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Factory Layout', 'Factory Layout', 'Factory Layout', 1, 0, 0),
(56, 'Time and Motion Studies', '2c97da4ff8eeb0aaa053239b5d972811', 17, 'Time and Motion Studies', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Time and Motion Studies', 'Time and Motion Studies', 'Time and Motion Studies', 0, 0, 1423794676),
(57, 'Material Flow', 'f96a488a27759c15ea3fc6289fe8149b', 17, 'Material Flow', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Material Flow', 'Material Flow', 'Material Flow', 0, 0, 1423794681),
(58, 'Headcount', 'f8a053bb569e4d338c87e99484da266d', 17, 'Headcount', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Headcount', 'Headcount', 'Headcount', 0, 0, 1423794682),
(59, 'Incentive Systems', '45fc8de324847819ee095188817556ea', 17, 'Incentive Systems', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Incentive Systems', 'Incentive Systems', 'Incentive Systems', 1, 0, 0),
(60, 'Shift Systems', '178a871d63ced55a2a1245794348a740', 17, 'Shift Systems', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Shift Systems', 'Shift Systems', 'Shift Systems', 1, 0, 0),
(61, 'Continous Improvement', '7143e90e4612aa3b540583722ae15d4c', 17, 'Continous Improvement', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Continous Improvement', 'Continous Improvement', 'Continous Improvement', 1, 0, 0),
(62, 'PDCA', '10292e05addacebdb23b68a122ce92bf', 17, 'PDCA', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'PDCA', 'PDCA', 'PDCA', 1, 0, 0),
(63, 'Idea Management', '07d29f397a557ef1fa21c012675df35b', 17, 'Idea Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Idea Management', 'Idea Management', 'Idea Management', 1, 0, 0),
(64, 'Work in Process (WIP)', '88ad9e73c65193f428cf567e91d80800', 17, 'Work in Process (WIP)', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Work in Process (WIP)', 'Work in Process (WIP)', 'Work in Process (WIP)', 0, 0, 1421198892),
(65, 'Key Performance Indicator (KPI)', '1f04b185d898e6cd1ea20be2459f1a2f', 17, 'Key Performance Indicator (KPI)', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Key Performance Indicator (KPI)', 'Key Performance Indicator (KPI)', 'Key Performance Indicator (KPI)', 1, 0, 0),
(66, 'Method Development', 'd43226ef4371e98a283f50db3069037e', 17, 'Method Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Method Development', 'Method Development', 'Method Development', 1, 0, 0),
(67, 'Factory Simulation', 'cab4b63c8575bbd3a342b5fbad426339', 17, 'Factory Simulation', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Factory Simulation', 'Factory Simulation', 'Factory Simulation', 1, 0, 0),
(68, 'Computer Aided Manufacturing (CAM)', '22f1c6f52c654280e8091ebba7912a4f', 17, 'Computer Aided Manufacturing (CAM)', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Computer Aided Manufacturing (CAM)', 'Computer Aided Manufacturing (CAM)', 'Computer Aided Manufacturing (CAM)', 1, 0, 0),
(69, 'Job Design', 'e17258ab2bd1400d4492aed7407801c9', 17, 'Job Design', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Job Design', 'Job Design', 'Job Design', 1, 0, 0),
(70, 'Value Stream Map', '671f1a5e1fd5c8e1779b375ae3740935', 18, 'Value Stream Map', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Value Stream Map', 'Value Stream Map', 'Value Stream Map', 1, 0, 0),
(71, '5s', 'f20a81adfd4dc563c9c150f62b5e5014', 18, '5s', '27bf1f39c668d93cc3ef33c613b1f541.png', '', '5s', '5s', '5s', 0, 0, 1421041876),
(72, '7 Wastes', '90390d7103ba02946426372d5bbd95e2', 18, '7 Wastes', '27bf1f39c668d93cc3ef33c613b1f541.png', '', '7 Wastes', '7 Wastes', '7 Wastes', 0, 0, 1421041887),
(73, 'Kaizen', 'd418a4f13569b41b3734d2dac34cbf02', 18, 'Kaizen', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Kaizen', 'Kaizen', 'Kaizen', 1, 0, 0),
(74, 'Kanban', '39b32dd45982038aa5704ca2728334ee', 18, 'Kanban', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Kanban', 'Kanban', 'Kanban', 1, 0, 0),
(75, 'Poka Yoke', '755a5a56d1c89f4ff179c6f66e9e255a', 18, 'Poka Yoke', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Poka Yoke', 'Poka Yoke', 'Poka Yoke', 1, 0, 0),
(76, 'SMED', '11c5be36641bc05b251dac68b2243b3a', 18, 'SMED', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'SMED', 'SMED', 'Single Minute Excahange of Die, Change over time, SMED', 1, 0, 0),
(77, 'Workflow Optimization', 'd81ecc4e96ad229a33764b7e2182f6ee', 18, 'Workflow Optimization', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Workflow Optimization', 'Workflow Optimization', 'Workflow Optimization', 1, 0, 0),
(78, 'Office Process Flow Optimization', '2a694503a666ca6d33d0d8e0de261af3', 18, 'Office Process Flow Optimization', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Office Process Flow Optimization', 'Office Process Flow Optimization', 'Office Process Flow Optimization', 1, 0, 0),
(79, 'Production Process Flow Optimization', 'e4ff0b8025c94e620fcf21095812d891', 18, 'Production Process Flow Optimization', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Production Process Flow Optimization', 'Production Process Flow Optimization', 'Production Process Flow Optimization', 1, 0, 0),
(80, 'PDCA/A3/8D', '33ae0b4428adfa3ceea9f35bdc6a1a07', 18, 'PDCA/A3/8D', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'PDCA/A3/8D', 'PDCA/A3/8D', 'PDCA/A3/8D', 1, 0, 0),
(81, 'Know How Management', '5368b55efe0fdf484d59fced5bdf8fc7', 19, 'Know How Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Know How Management', 'Know How Management', 'Know How Management', 1, 0, 0),
(82, 'Knowledge Database', '1fadb673213c21e8b380f22fa60a87fa', 19, 'Knowledge Database', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Knowledge Database', 'Knowledge Database', 'Knowledge Database', 1, 0, 0),
(83, 'Know How Documentation', 'cae286e917b10ab8e6b67028f587fef5', 19, 'Know How Documentation', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Know How Documentation', 'Know How Documentation', 'Know How Documentation', 1, 0, 0),
(84, 'Process Documentation', '30d14e12406a7580919dce129f5b4b70', 19, 'Process Documentation', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Process Documentation', 'Process Documentation', 'Process Documentation', 1, 0, 0),
(85, 'Collaboration', '337e8f4aa741ef97ec3ed8fd7b1accb7', 19, 'Collaboration', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Collaboration', 'Collaboration', 'Collaboration', 1, 0, 0),
(86, 'Best Practice', '39d9903201320a83d45d3b36d512f051', 19, 'Best Practice', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Best Practice', 'Best Practice', 'Best Practice', 1, 0, 0),
(87, 'Knowledge Mapping', 'e58ca0ad724728414e09d0fe31575380', 19, 'Knowledge Mapping', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Knowledge Mapping', 'Knowledge Mapping', 'Knowledge Mapping', 1, 0, 0),
(88, 'Six Sigma', 'f07975a00f5b3d1e025709beaf8958db', 20, 'Six Sigma', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Six Sigma', 'Six Sigma', 'Six Sigma', 1, 0, 0),
(89, 'ISO 9000ff', 'cc007258ed6ad7c5f333ab4c9fcc3d58', 20, 'ISO 9000ff', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'ISO 9000ff', 'ISO 9000ff', 'ISO 9000ff', 1, 0, 0),
(90, 'TS 16949', 'f005154db5e4a784e86ddd52a325b7e1', 20, 'TS 16949', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'TS 16949', 'TS 16949', 'TS 16949', 1, 0, 0),
(91, 'VDA', '82f11e8df84d4b474718abcaaadf7f0e', 20, 'VDA', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'VDA', 'VDA', 'VDA', 1, 0, 0),
(92, 'QS 9000', 'c2b3cbff032f7dc67086a8bb3868132a', 20, 'QS 9000', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'QS 9000', 'QS 9000', 'QS 9000', 1, 0, 0),
(93, 'EAQF', '29d45de4626630a95dccf42d97c8a52c', 20, 'EAQF', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'EAQF', 'EAQF', 'EAQF', 1, 0, 0),
(94, 'AVSQ', '23d574908eb584d0340bad2f92123783', 20, 'AVSQ', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'AVSQ', 'AVSQ', 'AVSQ', 1, 0, 0),
(95, 'ISO 22000', '0810b9dab1e5f9165452b688fc237160', 20, 'ISO 22000', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'ISO 22000', 'ISO 22000', 'ISO 22000', 1, 0, 0),
(96, 'HACCP', 'c38d1935edec2f6cf463602abdfbabf0', 20, 'HACCP', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'HACCP', 'HACCP', 'HACCP', 1, 0, 0),
(97, 'Problem Solving', '6a03a97072a01181059654e8389b992e', 20, 'Problem Solving', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Problem Solving', 'Problem Solving', 'Problem Solving', 1, 0, 0),
(98, 'Quality Statistics', '53ddc4f8e376c0be7f0f2165eae761bc', 20, 'Quality Statistics', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Quality Statistics', 'Quality Statistics', 'Quality Statistics', 1, 0, 0),
(99, 'Statistic Process Control (SPC)', '8aba034abd1545772ac75f305ef5e73c', 20, 'Statistic Process Control (SPC)', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Statistic Process Control (SPC)', 'Statistic Process Control (SPC)', 'Statistic Process Control (SPC)', 1, 0, 0),
(100, 'Capability Studies', '960ceabd53770a66b60398b278698c07', 20, 'Capability Studies', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Capability Studies', 'Capability Studies, cp, cm, cg, cpk, cmk, cgk', 'Capability Studies', 1, 0, 0),
(101, 'Total Quality Management (TQM)', '60633124df065496444d63301ad9bbbf', 20, 'Total Quality Management (TQM)', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Total Quality Management (TQM)', 'Total Quality Management (TQM)', 'Total Quality Management (TQM)', 1, 0, 0),
(102, 'Quality Function Deployment (QFD)', 'cb20a6a674789289063f69aaceeeeee2', 20, 'Quality Function Deployment (QFD)', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Quality Function Deployment (QFD)', 'Quality Function Deployment (QFD)', 'Quality Function Deployment (QFD)', 1, 0, 0),
(103, 'Quality Circle', 'b3b607ce1da0ff572e5cfe191b6b601f', 20, 'Quality Circle', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Quality Circle', 'Quality Circle', 'Quality Circle', 1, 0, 0),
(104, 'Taguchi', 'b03f732d0b64bf01947a595828fe0888', 20, 'Taguchi', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Taguchi', 'Taguchi', 'Taguchi', 1, 0, 0),
(105, 'Kansei Engineering', 'ee8222c94dcd7d3c1d20cf33edd86ffd', 20, 'Kansei Engineering', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Kansei Engineering', 'Kansei Engineering', 'Kansei Engineering', 1, 0, 0),
(106, 'Business Process Reegineering (BPR)', '7bf848c679d5474b18c355a3b84e9f9c', 20, 'Business Process Reegineering (BPR)', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Business Process Reegineering (BPR)', 'Business Process Reegineering (BPR)', 'Business Process Reegineering (BPR)', 1, 0, 0),
(107, 'Object Oriented Quality and Risk Management (OQRM)', 'c0a422495f053de689303175bda764e7', 20, 'Object Oriented Quality and Risk Management (OQRM)', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Object Oriented Quality and Risk Management (OQRM)', 'Object Oriented Quality and Risk Management (OQRM)', 'Object Oriented Quality and Risk Management (OQRM)', 1, 0, 0),
(108, 'Quality Tools', 'c2f1f4cbc26e018d0502ab9ef1047555', 20, 'Quality Tools', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Quality Tools', 'Quality Tools', 'Quality Tools', 1, 0, 0),
(109, 'FMEA', '313b11a9b82d9a829f6ef0ef797aca11', 20, 'FMEA', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'FMEA', 'FMEA', 'FMEA', 1, 0, 0),
(110, 'APQP', '7ede7cdb7772374809887807f2f41db8', 20, 'APQP', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'APQP', 'APQP', 'APQP', 1, 0, 0),
(111, 'PPAP', 'd1db7a240300bcd7f59731bdab271b67', 20, 'PPAP', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'PPAP', 'PPAP', 'PPAP', 1, 0, 0),
(112, 'Document Management', '04ab7e9520f65aa6c1c1c1eb8c397873', 20, 'Document Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Document Management', 'Document Management', 'Document Management', 1, 0, 0),
(113, 'Project Management', '9c1330f0dda3f188a3813b9840d1143f', 21, 'Project Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Project Management', 'Project Management', 'Project Management', 1, 0, 0),
(114, 'Logistics', '68c16c941c3fb4e5dad94a7837ea7d1e', 22, 'Logistics', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Logistics', 'Logistics', 'Logistics', 1, 0, 0),
(115, 'Market Analysis', '69c0225744326087a7c430c3e9bf72dc', 23, 'Market Analysis', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Market Analysis', 'Market Analysis', 'Market Analysis', 1, 0, 0),
(116, 'Brand Management', 'b934621127c601f5d5b3893340e95b7c', 23, 'Brand Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Brand Management', 'Brand Management', 'Brand Management', 1, 0, 0),
(117, 'Market Research', '023157b1a3d9ee4f0ed14b9801a26ac4', 23, 'Market Research', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Market Research', 'Market Research', 'Market Research', 1, 0, 0),
(118, 'Pricing', 'e22ac25b066b201473de7aa700ef5d92', 23, 'Pricing', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Pricing', 'Pricing', 'Pricing', 1, 0, 0),
(119, 'Promotion', '626a54d37d402d449d6d7541911e0952', 23, 'Promotion', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Promotion', 'Promotion', 'Promotion', 1, 0, 0),
(120, 'Sales', '11ff9f68afb6b8b5b8eda218d7c83a65', 23, 'Sales', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Sales', 'Sales', 'Sales', 1, 0, 0),
(121, 'After Sales Service', 'd40d436df0bbeb1ba05079dd0aedc967', 23, 'After Sales Service', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'After Sales Service', 'After Sales Service', 'After Sales Service', 1, 0, 0),
(122, 'E-Commerce', 'a9f7ecebb493e129aafb4cbfd73e85df', 23, 'E-Commerce', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'E-Commerce', 'E-Commerce', 'E-Commerce', 1, 0, 0),
(123, 'Distribution', 'f0bac093bb884df2891d32385d053788', 23, 'Distribution', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Distribution', 'Distribution', 'Distribution', 1, 0, 0),
(124, 'Consumer Theory', 'fdb40afa0d285233ba2249b2b1d3e109', 23, 'Consumer Theory', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Consumer Theory', 'Consumer Theory', 'Consumer Theory', 1, 0, 0),
(125, 'Economics', '7e1e3f377648773863a504d18b367ea3', 23, 'Economics', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Economics', 'Economics', 'Economics', 1, 0, 0),
(126, 'Advertising', '2ce5fc289845ce826261032b9c6749ea', 23, 'Advertising', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Advertising', 'Advertising', 'Advertising', 1, 0, 0),
(127, 'Patent rights', '07744fec5b5a8ed1562fecd32a488416', 24, 'Patent rights', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Patent rights', 'Patent rights', 'Patent rights', 1, 0, 0),
(128, 'Start up', '79c8716e036aef2b15b59c04ec787d43', 24, 'Start up', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Start up', 'Start up', 'Start up', 1, 0, 0),
(129, 'Employer Obligations', 'f22c85e9d23b0b99a63cca2720ca5f71', 24, 'Employer Obligations', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Employer Obligations', 'Employer Obligations', 'Employer Obligations', 1, 0, 0),
(130, 'Employee Rights', '68a362caa596e9391b409126518e0f30', 24, 'Employee Rights', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Employee Rights', 'Employee Rights', 'Employee Rights', 1, 0, 0),
(131, 'Maintenance', '10d0de28911c5f66463b9c8783f8148a', 25, 'Maintenance', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Maintenance', 'Maintenance', 'Maintenance', 1, 0, 0),
(132, 'Machine procurement', '2af2adf212edd655e2f8274304e88f9f', 25, 'Machine procurement', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Machine procurement', 'Machine procurement', 'Machine procurement', 1, 0, 0),
(133, 'Project Management', '9c1330f0dda3f188a3813b9840d1143f', 25, 'Project Management', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Project Management', 'Project Management', 'Project Management', 1, 0, 0),
(134, 'Machine Development', '84cfca6dce7809b0f7eafaa8127e34dd', 25, 'Machine Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Machine Development', 'Machine Development', 'Machine Development', 1, 0, 0),
(135, 'Automation Technologies', '49f5799a2db35743d039f344e5834945', 25, 'Automation Technologies', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Automation Technologies', 'Automation Technologies', 'Automation Technologies', 1, 0, 0),
(136, 'Transport Systems', '4e27832af76c2e7f0546182b3fbbb5b2', 25, 'Transport Systems', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Transport Systems', 'Transport Systems', 'Transport Systems', 1, 0, 0),
(137, 'Technical Documentation', '0fc75709621519dfa4730a0da953a784', 25, 'Technical Documentation', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Technical Documentation', 'Technical Documentation', 'Technical Documentation', 1, 0, 0),
(138, 'Material Research', 'fb6a9fd41b6dacf08edca2fed35e0ce1', 26, 'Material Research', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Material Research', 'Material Research', 'Material Research', 1, 0, 0),
(139, 'Process Research', '41643b5dfdbaa1cb3e1d6ce39fe59c5a', 26, 'Process Research', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Process Research', 'Process Research', 'Process Research', 1, 0, 0),
(140, 'Material Development', '2da2bb28a9c28d8b9b60062e0535e99f', 26, 'Material Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Material Development', 'Material Development', 'Material Development', 1, 0, 0),
(141, 'Process Development', '7170bf578f2ee33a8e998acf46a7eb01', 26, 'Process Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Process Development', 'Process Development', 'Process Development', 1, 0, 0),
(142, 'Machine Development', '84cfca6dce7809b0f7eafaa8127e34dd', 26, 'Machine Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Machine Development', 'Machine Development', 'Machine Development', 1, 0, 0),
(143, 'Method Development', 'd43226ef4371e98a283f50db3069037e', 26, 'Method Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Method Development', 'Method Development', 'Method Development', 1, 0, 0),
(144, 'Software Development', 'f287f429e4026672e5754c1201691e49', 26, 'Software Development', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Software Development', 'Software Development', 'Software Development', 1, 0, 0),
(145, 'SAP', '999bc6b18351bbe817d26f559ba408ae', 32, 'SAP', 'f2bc01eea9d26b3e63f79e3dba82ea6c.jpg', 'm_g5.jpg', 'SAP', 'SAP', 'SAP', 1, 0, 1422594416),
(146, 'ERP', '5202bfaff162a71345cc0f3dde1940a4', 32, 'ERP', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'ERP', 'ERP', 'ERP', 1, 0, 0),
(147, 'SCADA', '8ebe43fc79c5288888cac7b7106b0045', 32, 'SCADA', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'SCADA', 'SCADA', 'SCADA', 1, 0, 0),
(148, 'OPC', 'ad9f5325bab7d34c910fc2c7bce6e65c', 32, 'OPC', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'OPC', 'OPC', 'OPC', 1, 0, 0),
(149, 'Controls & Drives', 'fb54423c392d107161ddab675631a59b', 32, 'Controls & Drives', '4c221b8e5109a876444a06966f46cf27.png', '', 'Controls & Drives', 'Controls & Drives', 'Controls & Drives', 1, 0, 1421723945),
(150, 'Software', '719d067b229178f03bcfa1da4ac4dede', 32, 'Software', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Software', 'Software', 'Software', 1, 0, 0),
(151, 'IT Infrastructure', 'a8b0cb5c066d2e5f3cad8be0b01ecb00', 32, 'IT Infrastructure', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'IT Infrastructure', 'IT Infrastructure', 'IT Infrastructure', 1, 0, 0),
(152, 'Accounting', '9bbd45bad55cfc620803907f2d8a0217', 29, 'Accounting', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Accounting', 'Accounting', 'Accounting', 0, 0, 1421041888),
(153, 'Controlling', 'f72e450345fa11da2e3ebf51e6cfcd81', 29, 'Controlling', '0828c1fc01f5d8fc6e337547eaf442a1.jpg', 'm_g2.jpg', 'Controlling', 'Controlling', 'Controlling', 1, 0, 1422594586),
(154, 'Treasury', '20e968a2ef4cbdc5bea5e34d0b1e7333', 29, 'Treasury', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Treasury', 'Treasury', 'Treasury', 1, 0, 0),
(155, 'Insurance', 'eaff1bdf24fcffe0e14e29a1bff51a12', 29, 'Insurance', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Insurance', 'Insurance', 'Insurance', 1, 0, 0),
(156, 'Tax', '4b78ac8eb158840e9638a3aeb26c4a9d', 29, 'Tax', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Tax', 'Tax', 'Tax', 1, 0, 0),
(157, 'Business Coaching', 'cd3f03e0eaa08524a619ac43bb735d55', 30, 'Business Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Business Coaching', 'Business Coaching', 'Business Coaching', 1, 0, 0),
(158, 'Executive Coaching', '3e315e261e7cde16668b94fcac2c469f', 30, 'Executive Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Executive Coaching', 'Executive Coaching', 'Executive Coaching', 1, 0, 0),
(159, 'Control Theory', '7404bb042db8f04206202357fcc7774a', 30, 'Control Theory', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Control Theory', 'Control Theory', 'Control Theory', 1, 0, 0),
(160, 'Expat Coaching', 'd2c398974b08231aa67a130a50c01cb2', 30, 'Expat Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Expat Coaching', 'Expat Coaching', 'Expat Coaching', 1, 0, 0),
(161, 'Career Coaching', 'b346eb676fb28bc55656d0e11e608b89', 30, 'Career Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Career Coaching', 'Career Coaching', 'Career Coaching', 1, 0, 0),
(162, 'Financial Coaching', 'e635323340042e108778b5170a0a21f0', 30, 'Financial Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Financial Coaching', 'Financial Coaching', 'Financial Coaching', 1, 0, 0),
(163, 'Career Coaching', 'b346eb676fb28bc55656d0e11e608b89', 30, 'Career Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Career Coaching', 'Career Coaching', 'Career Coaching', 1, 0, 0),
(164, 'Personal Coaching', '380962a21071392c6585849451241715', 30, 'Personal Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Personal Coaching', 'Personal Coaching', 'Personal Coaching', 1, 0, 0),
(165, 'Style Coaching', '499c1f432e8f11a44d8da1efddbdec5c', 30, 'Style Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Style Coaching', 'Style Coaching', 'Style Coaching', 1, 0, 0),
(166, 'Systemic Coaching', '1345bba2ef769675b6c9aff32da21def', 30, 'Systemic Coaching', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Systemic Coaching', 'Systemic Coaching', 'Systemic Coaching', 1, 0, 0),
(167, 'Energy Saving', 'ef9ad9a5dbb7550d49bf3bf2a1c3d22d', 31, 'Energy Saving', '50b559f452badbac879504421316d792.jpg', 'm_s3.jpg', 'Energy Saving', 'Energy Saving', 'Energy Saving', 1, 0, 1422594551),
(168, 'Work Condition', '7fd57e0f8b6ed120a66b1c0c55603b0b', 31, 'Work Condition', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Work Condition', 'Work Condition', 'Work Condition', 0, 0, 1421198894),
(169, 'Enviromental Protection', 'bff7737497f5910fa3c976a93e7e57a3', 31, 'Enviromental Protection', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Enviromental Protection', 'Enviromental Protection', 'Enviromental Protection', 1, 0, 0),
(170, 'Environmental Certification', '7b1f06c45ef58c37f17fda4eb8103e1a', 31, 'Environmental Certification', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Environmental Certification', 'Environmental Certification', 'Environmental Certification', 1, 0, 0),
(171, 'Work Ergonomics', 'e1e9ab9c59c96a5cb4f511bfa8c88cb5', 31, 'Work Ergonomics', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Work Ergonomics', 'Work Ergonomics', 'Work Ergonomics', 0, 0, 1421198893),
(172, 'Safety', '6472ce41c26babff27b4c28028093d77', 31, 'Safety', '27bf1f39c668d93cc3ef33c613b1f541.png', '', 'Safety', 'Safety', 'Safety', 1, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chat_last_seen`
--

CREATE TABLE `chat_last_seen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` enum('0','1') NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `from`, `to`, `message`, `is_read`, `time`) VALUES
(3, 8, 7, 'Hi owner', '1', '2017-02-08 09:58:23'),
(4, 7, 8, 'yes', '1', '2017-02-08 10:05:55'),
(5, 8, 7, 'H r u?', '1', '2017-02-08 10:06:50'),
(6, 7, 8, 'fine', '1', '2017-02-08 10:09:02'),
(7, 8, 7, 'what about the proejct?', '1', '2017-02-08 10:11:07'),
(8, 7, 8, 'going fine', '1', '2017-02-08 10:11:40'),
(9, 8, 7, 'ok fine', '1', '2017-02-08 10:14:36'),
(10, 7, 8, 'are u working on ?', '1', '2017-02-08 10:18:06'),
(11, 8, 7, 'chat module', '1', '2017-02-08 10:20:19'),
(12, 7, 8, 'ok good', '1', '2017-02-08 10:20:42'),
(13, 8, 7, 'next module?', '1', '2017-02-08 10:23:52'),
(14, 7, 8, 'Team online', '1', '2017-02-08 10:24:21'),
(15, 8, 7, 'ok', '1', '2017-02-08 14:15:03'),
(16, 8, 7, 'egese', '1', '2017-02-15 12:08:04'),
(17, 8, 7, 'blkensejng.gnklgnklgbsef.bns.bnslbns elkgh wiergh arlgh awrlgh asrgahgk llasrgtsh ', '1', '2017-02-15 12:08:13'),
(18, 8, 7, 'gndg wkgb wkrg kwrgb nawrkga kgakwrg kwargkawrg krg kg kgkgnks fbgkbgk sbgk bkagb kagb kagbskg kbksfgb', '1', '2017-02-17 05:38:11'),
(19, 7, 8, 'answer here', '1', '2017-05-04 12:45:06'),
(20, 7, 8, 'dsss', '1', '2017-05-12 08:23:19'),
(21, 8, 7, 'Ok', '1', '2017-05-12 10:25:44'),
(22, 8, 7, 'ok', '1', '2017-05-12 10:28:20'),
(23, 46, 49, 'Hi', '1', '2017-05-24 18:10:33'),
(24, 46, 49, 'Welcome on board', '1', '2017-05-24 18:10:46'),
(25, 7, 8, 'test message', '1', '2017-06-03 21:50:26');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `clickthroughs`
--

CREATE TABLE `clickthroughs` (
  `id` int(5) NOT NULL,
  `refid` varchar(20) DEFAULT 'none',
  `created_date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `browser` varchar(200) DEFAULT 'Could Not Find This Data',
  `ipaddress` varchar(50) DEFAULT 'Could Not Find This Data',
  `refferalurl` varchar(200) DEFAULT 'none detected (maybe a direct link)',
  `buy` varchar(10) DEFAULT 'NO'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contacts`
--

CREATE TABLE `contacts` (
  `id` int(12) NOT NULL,
  `email_id` varchar(128) NOT NULL,
  `subject` varchar(128) CHARACTER SET utf8 NOT NULL,
  `comments` text CHARACTER SET utf8 NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `country`
--

CREATE TABLE `country` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_symbol` varchar(3) CHARACTER SET utf8 NOT NULL,
  `country_name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `country`
--

INSERT INTO `country` (`id`, `country_symbol`, `country_name`) VALUES
(1, 'US', 'United States'),
(2, 'AF', 'Afghanistan'),
(3, 'AL', 'Albania'),
(4, 'DZ', 'Algeria'),
(5, 'AS', 'American Samoa'),
(6, 'AD', 'Andorra'),
(7, 'AO', 'Angola'),
(8, 'AI', 'Anguilla'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'VG', 'British Virgin Islands'),
(33, 'BN', 'Brunei'),
(34, 'BG', 'Bulgaria'),
(35, 'BF', 'Burkina Faso'),
(36, 'BI', 'Burundi'),
(37, 'KH', 'Cambodia'),
(38, 'CM', 'Cameroon'),
(39, 'CA', 'Canada'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CD', 'Congo - Democratic Republic of'),
(52, 'CK', 'Cook Islands'),
(53, 'CR', 'Costa Rica'),
(54, 'HR', 'Croatia'),
(55, 'CU', 'Cuba'),
(56, 'CY', 'Cyprus'),
(57, 'CZ', 'Czech Republic'),
(58, 'DK', 'Denmark'),
(59, 'DJ', 'Djibouti'),
(60, 'DM', 'Dominica'),
(61, 'DO', 'Dominican Republic'),
(62, 'TP', 'East Timor'),
(63, 'EC', 'Ecuador'),
(64, 'EG', 'Egypt'),
(65, 'SV', 'El Salvador'),
(66, 'GQ', 'Equitorial Guinea'),
(67, 'ER', 'Eritrea'),
(68, 'EE', 'Estonia'),
(69, 'ET', 'Ethiopia'),
(70, 'FK', 'Falkland Islands (Islas Malvinas)'),
(71, 'FO', 'Faroe Islands'),
(72, 'FJ', 'Fiji'),
(73, 'FI', 'Finland'),
(74, 'FR', 'France'),
(75, 'GF', 'French Guyana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern and Antarctic Lands'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GZ', 'Gaza Strip'),
(81, 'GE', 'Georgia'),
(82, 'DE', 'Germany'),
(83, 'GH', 'Ghana'),
(84, 'GI', 'Gibraltar'),
(85, 'GR', 'Greece'),
(86, 'GL', 'Greenland'),
(87, 'GD', 'Grenada'),
(88, 'GP', 'Guadeloupe'),
(89, 'GU', 'Guam'),
(90, 'GT', 'Guatemala'),
(91, 'GN', 'Guinea'),
(92, 'GW', 'Guinea-Bissau'),
(93, 'GY', 'Guyana'),
(94, 'HT', 'Haiti'),
(95, 'HM', 'Heard Island and McDonald Islands'),
(96, 'VA', 'Holy See (Vatican City)'),
(97, 'HN', 'Honduras'),
(98, 'HK', 'Hong Kong'),
(99, 'HU', 'Hungary'),
(100, 'IS', 'Iceland'),
(101, 'IN', 'India'),
(102, 'ID', 'Indonesia'),
(103, 'IR', 'Iran'),
(104, 'IQ', 'Iraq'),
(105, 'IE', 'Ireland'),
(106, 'IL', 'Israel'),
(107, 'IT', 'Italy'),
(108, 'JM', 'Jamaica'),
(109, 'JP', 'Japan'),
(110, 'JO', 'Jordan'),
(111, 'KZ', 'Kazakhstan'),
(112, 'KE', 'Kenya'),
(113, 'KI', 'Kiribati'),
(114, 'KW', 'Kuwait'),
(115, 'KG', 'Kyrgyzstan'),
(116, 'LA', 'Laos'),
(117, 'LV', 'Latvia'),
(118, 'LB', 'Lebanon'),
(119, 'LS', 'Lesotho'),
(120, 'LR', 'Liberia'),
(121, 'LY', 'Libya'),
(122, 'LI', 'Liechtenstein'),
(123, 'LT', 'Lithuania'),
(124, 'LU', 'Luxembourg'),
(125, 'MO', 'Macau'),
(126, 'MK', 'Macedonia - The Former Yugoslav Republic of'),
(127, 'MG', 'Madagascar'),
(128, 'MW', 'Malawi'),
(129, 'MY', 'Malaysia'),
(130, 'MV', 'Maldives'),
(131, 'ML', 'Mali'),
(132, 'MT', 'Malta'),
(133, 'MH', 'Marshall Islands'),
(134, 'MQ', 'Martinique'),
(135, 'MR', 'Mauritania'),
(136, 'MU', 'Mauritius'),
(137, 'YT', 'Mayotte'),
(138, 'MX', 'Mexico'),
(139, 'FM', 'Micronesia - Federated States of'),
(140, 'MD', 'Moldova'),
(141, 'MC', 'Monaco'),
(142, 'MN', 'Mongolia'),
(143, 'MS', 'Montserrat'),
(144, 'MA', 'Morocco'),
(145, 'MZ', 'Mozambique'),
(146, 'MM', 'Myanmar'),
(147, 'NA', 'Namibia'),
(148, 'NR', 'Naura'),
(149, 'NP', 'Nepal'),
(150, 'NL', 'Netherlands'),
(151, 'AN', 'Netherlands Antilles'),
(152, 'NC', 'New Caledonia'),
(153, 'NZ', 'New Zealand'),
(154, 'NI', 'Nicaragua'),
(155, 'NE', 'Niger'),
(156, 'NG', 'Nigeria'),
(157, 'NU', 'Niue'),
(158, 'NF', 'Norfolk Island'),
(159, 'KP', 'North Korea'),
(160, 'MP', 'Northern Mariana Islands'),
(161, 'NO', 'Norway'),
(162, 'OM', 'Oman'),
(163, 'PK', 'Pakistan'),
(164, 'PW', 'Palau'),
(165, 'PA', 'Panama'),
(166, 'PG', 'Papua New Guinea'),
(167, 'PY', 'Paraguay'),
(168, 'PE', 'Peru'),
(169, 'PH', 'Philippines'),
(170, 'PN', 'Pitcairn Islands'),
(171, 'PL', 'Poland'),
(172, 'PT', 'Portugal'),
(173, 'PR', 'Puerto Rico'),
(174, 'QA', 'Qatar'),
(175, 'RE', 'Reunion'),
(176, 'RO', 'Romania'),
(177, 'RU', 'Russia'),
(178, 'RW', 'wanda'),
(179, 'KN', 'Saint Kitts and Nevis'),
(180, 'LC', 'Saint Lucia'),
(181, 'VC', 'Saint Vincent and the Grenadines'),
(182, 'WS', 'Samoa'),
(183, 'SM', 'San Marino'),
(184, 'ST', 'Sao Tome and Principe'),
(185, 'SA', 'Saudi Arabia'),
(186, 'SN', 'Senegal'),
(187, 'CS', 'Serbia and Montenegro'),
(188, 'SC', 'Seychelles'),
(189, 'SL', 'Sierra Leone'),
(190, 'SG', 'Singapore'),
(191, 'SK', 'Slovakia'),
(192, 'SI', 'Slovenia'),
(193, 'SB', 'Solomon Islands'),
(194, 'SO', 'Somalia'),
(195, 'ZA', 'South Africa'),
(196, 'GS', 'South Georgia and the South Sandwich Islands'),
(197, 'KR', 'South Korea'),
(198, 'ES', 'Spain'),
(199, 'LK', 'Sri Lanka'),
(200, 'SH', 'St. Helena'),
(201, 'PM', 'St. Pierre and Miquelon'),
(202, 'SD', 'Sudan'),
(203, 'SR', 'Suriname'),
(204, 'SJ', 'Svalbard'),
(205, 'SZ', 'Swaziland'),
(206, 'SE', 'Sweden'),
(207, 'CH', 'Switzerland'),
(208, 'SY', 'Syria'),
(209, 'TW', 'Taiwan'),
(210, 'TJ', 'Tajikistan'),
(211, 'TZ', 'Tanzania'),
(212, 'TH', 'Thailand'),
(213, 'TG', 'Togo'),
(214, 'TK', 'Tokelau'),
(215, 'TO', 'Tonga'),
(216, 'TT', 'Trinidad and Tobago'),
(217, 'TN', 'Tunisia'),
(218, 'TR', 'Turkey'),
(219, 'TM', 'Turkmenistan'),
(220, 'TC', 'Turks and Caicos Islands'),
(221, 'TV', 'Tuvalu'),
(222, 'UG', 'Uganda'),
(223, 'UA', 'Ukraine'),
(224, 'AE', 'United Arab Emirates'),
(225, 'GB', 'United Kingdom'),
(226, 'VI', 'United States Virgin Islands'),
(227, 'UY', 'Uruguay'),
(228, 'UZ', 'Uzbekistan'),
(229, 'VU', 'Vanuatu'),
(230, 'VE', 'Venezuela'),
(231, 'VN', 'Vietnam'),
(232, 'WF', 'Wallis and Futuna'),
(233, 'PS', 'West Bank'),
(234, 'EH', 'Western Sahara'),
(235, 'YE', 'Yemen'),
(236, 'ZM', 'Zambia'),
(237, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `currency`
--

CREATE TABLE `currency` (
  `id` int(10) NOT NULL,
  `currency_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `currency_type` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `currency_symbol` varchar(10) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Daten für Tabelle `currency`
--

INSERT INTO `currency` (`id`, `currency_name`, `currency_type`, `currency_symbol`) VALUES
(1, 'U.S. Dollar', 'USD', '$'),
(2, 'Euro', 'EUR', '€'),
(3, 'British Pound', 'GBP', '£'),
(4, 'Australian Dollar', 'AUD', 'A $'),
(5, 'Canadian Dollar', 'CAD', 'C $'),
(6, 'Japanese Yen', 'JPY', '¥'),
(7, 'New Zealand Dollar', 'NZD', '$'),
(8, 'Hong Kong Dollar', 'HKD', '$'),
(9, 'Singapore Dollar', 'SGD', '$'),
(10, 'Swiss Franc', 'CHF', ''),
(11, 'Swedish Krona', 'SEK', ''),
(12, 'Danish Krone', 'DKK', ''),
(13, 'Polish Zloty', 'PLN', ''),
(14, 'Norwegian Krone', 'NOK', ''),
(15, 'Hungarian Forint', 'HUF', ''),
(16, 'Czech Koruna', 'CZK', ''),
(17, 'Israeli New Shekel', 'ILS', ''),
(18, 'Mexican Peso', 'MXN', ''),
(19, 'Brazilian Real ', 'BRL', ''),
(20, 'Malaysian Ringgit', 'MYR', ''),
(21, 'Philippine Peso', 'PHP', ''),
(22, 'New Taiwan Dollar', 'TWD', ''),
(23, 'Thai Baht', 'THB', ''),
(24, 'Turkish Lira', 'TRY', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dispute_agree`
--

CREATE TABLE `dispute_agree` (
  `id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `owner_agree` enum('disagree','agree') NOT NULL,
  `employee_agree` enum('disagree','agree') NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `draftjobs`
--

CREATE TABLE `draftjobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `job_status` enum('0','1','2','3') NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `milestone` varchar(50) NOT NULL,
  `job_categories` text CHARACTER SET utf8 NOT NULL,
  `manual_job` text CHARACTER SET utf8 NOT NULL,
  `budget_min` int(11) UNSIGNED DEFAULT '0',
  `budget_max` int(11) UNSIGNED DEFAULT '0',
  `is_feature` int(1) DEFAULT NULL,
  `is_urgent` int(1) DEFAULT NULL,
  `is_hide_bids` int(1) DEFAULT NULL,
  `creator_id` int(10) UNSIGNED NOT NULL,
  `created` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `checkstamp` varchar(50) NOT NULL,
  `owner_rated` enum('0','1') NOT NULL,
  `employee_rated` enum('0','1') NOT NULL,
  `job_paid` enum('0','1') NOT NULL,
  `is_private` int(11) DEFAULT NULL,
  `contact` text NOT NULL,
  `salary` varchar(15) NOT NULL,
  `flag` int(1) NOT NULL,
  `salarytype` varchar(100) NOT NULL,
  `private_users` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `draftjobs`
--

INSERT INTO `draftjobs` (`id`, `job_name`, `job_status`, `description`, `country`, `state`, `city`, `milestone`, `job_categories`, `manual_job`, `budget_min`, `budget_max`, `is_feature`, `is_urgent`, `is_hide_bids`, `creator_id`, `created`, `enddate`, `employee_id`, `checkstamp`, `owner_rated`, `employee_rated`, `job_paid`, `is_private`, `contact`, `salary`, `flag`, `salarytype`, `private_users`) VALUES
(1, 'meineurl.com', '0', 'my project', '', '', '', '', 'e-learning WBT,One on One Training,University/Classroom', '', 0, 0, 1, 0, 0, 4, 1419534097, 1420743697, 0, '', '0', '0', '0', 0, '', '', 0, '', ''),
(4, 'sdfdsfsdf', '0', 'asdfdsfsdfsdf', 'American Samoa', 'Ballyallinan', 'chennai', '0', 'Self Paced Training,SAP,ERP,OPC,Controls & Drives,IT Infrastructure', 'sdfdsf', 0, 0, 1, 1, 0, 7, 1422951383, 1424160983, 0, '', '0', '0', '0', NULL, '', '', 0, '', NULL),
(5, 'Draft Check', '0', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf', 'India', 'Tamilnadu', 'Madurai', '2', 'University/Classroom,University/eLearning,Webinar', 'skill1,skill2', 9, 10, 1, 0, 0, 7, 1427193984, 1428403584, 0, '', '0', '0', '0', NULL, '', '', 0, '', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(64) CHARACTER SET utf8 NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `mail_subject` text CHARACTER SET utf8 NOT NULL,
  `mail_body` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `email_templates`
--

INSERT INTO `email_templates` (`id`, `type`, `title`, `mail_subject`, `mail_body`) VALUES
(1, 'employees_signup', 'employees signup', 'Confirmation mail for !site_title', 'Thanks for choosing !site_title \n\nPlease click here to complete the signup process. \nYour activation link: !activation_url \n\nFor any questions contact our support team at !contact_url our team will help on any issue.'),
(4, 'owners_signup', 'owners signup', 'Confirmation mail for !site_name', 'Thanks for choosing !site_title \n\nPlease click here to complete the signup process. \nYour activation link: !activation_url \n\nFor any questions contact our support team at !contact_url our team will help on any issue.'),
(5, 'awardBid', 'Award Job', 'Confirmation for bidding on !project_title', 'You were choosen for the job named !project_title.\n\nImportant: You must first accept (or deny) this offer by going to the following URL: !bid_url\nAs long as you didn\'t accept, the offered project still can be assigned to another consultant! Accept the bid as soon as possible, to finalize the contract.\n\nIf you have any problems with this step you can contact !contact_url'),
(6, 'project_accepted_buyer', 'Job accepted - owner', 'Your project offer has been accepted', 'The consultant "!programmer_username" accepted your project offer, named "!project_title".\n\nYou may contact this consultant by mail !programmer_email or via our portal:\n\n!contact_url'),
(7, 'project_accepted_programmer', 'Job accepted - Employee', 'Job start', 'You have won and accepted the job named "!project_title".\r\n\r\nYou may contact the jobs owner "!buyer_username" at !buyer_email.\r\n\r\nIf you have any problems with this email you can contact !contact_url'),
(8, 'project_denied_buyer', 'Job denying', 'Job denied', 'The Employee "!provider_username" did not accept the job named "!project_title".\r\n\r\nThe Job is now open again for bidding.\r\n\r\nIf you have any problems with this email you can contact !contact_url'),
(9, 'privateInvitation', 'Private Job Invitation', '!site_title Favorite Private Job Invitation', 'The Owner !buyername! has posted a private job (!projectname!)\r\nand has invited you to bid on it. Only invited users can bid on private\r\njobs.\r\nYou may login and view this job at \r\n!projecturl!\r\n\r\n\r\n--------------------------------------------------\r\nThis message has been sent automatically by !site_title.\r\nIf you need to contact us go to !siteurl!'),
(10, 'publicInvitation', 'Job Invitation', 'Job Invitation', '!buyername! has just invited you to place a bid on their job. The name of the Job is "!projectname!" and you can view it at the following\r\nURL: !projecturl!\r\n\r\n--------------------------------------------------\r\nThis message has been sent automatically by ScriptLance.\r\nIf you need to contact us go to !siteurl!'),
(11, 'forget_password', 'Forget Password', 'New Password for Login', 'Thank you for creating an account at !url\r\n\r\nYour username: !username\r\nYour password: !newpassword'),
(12, 'projectpost_notification', 'New Job Post', 'New Job', '!username !\r\nThank you !username for Post job on !site_name site.\r\n\r\nJob Id   : !projectid\r\nJob Name : !projectname\r\nCreate Date  : !date\r\nProfile      : !profile'),
(13, 'project_cancelled', 'cancel Jobs', 'Job cancelled', 'Dear !buyer_name\r\n\r\nYour Job "!project_name" is cancelled.\r\n\r\nIf you have any problems with this email you can contact !contact_url'),
(14, 'project_end', 'Job End', 'Job End', 'The Job !projectname has just ended. Unfortunately your bid was not chosen.\r\n\r\n\r\nThis message has been sent by !sitetitle. Do not reply to this email. Click here to !contact_url support.'),
(15, 'bid_notice', 'Bid notice', '!site_name Job Bid Notice', 'The Employee !provider_name has just bid !bid_amt in !bid_time on your Job !project_name\r\n<br><br>\r\nIf you have any problems with this email you can contact !contact_url'),
(16, 'lowbid_notify', 'Low bid notification', 'Low bid notification', 'The Employee "!provider_name" has just bid !bid_amt for the job !project_name lower than your bid amount !bid_amt2\r\n<br><br>\r\nIf you have any problems with this email you can contact !contact_url'),
(17, 'registration', 'New Registration', '!site_name New Registration', 'Hello !username,\r\nThank you for register in !siteurl. \r\n\r\nYou are successfully register in !siteurl as !usertype using the following information.\r\n\r\nUsername : !username\r\nPassword : !password\r\n\r\nYou should not post any questions or queries to this email. You can post any queries into the following url !contact_url. \r\n\r\nThank and Regards,\r\nAdmin '),
(18, 'transaction', 'Amount Transaction', '!site_name Amount Transaction', 'Hello !username,\r\n\r\nThank you for using !site_name.\r\n\r\nYour transaction is work in progress. After completion of the Transaction you will be receive an Email from !site_name.\r\n\r\nYour Transaction details as follows,\r\n\r\nCreator name      : !username\r\nTransaction Type  : !type\r\nAmount            :  !amount\r\n!others\r\n!others1\r\n\r\nYou should not post any queries to this Email. Please post any question or queries to the url !contact_url.\r\n\r\nThanks and Regards,\r\n\r\nAdmin\r\n!site_name'),
(19, 'message_template', 'Message Template', 'New Message Received on !site_name', 'Hello !username,<br>\r\n\r\nYou are received new message from !sender_name regarding !reason on !site_name.<br>\r\n\r\nYou can login into !site_url and view your new messages. <br>\r\n\r\nYou should not post any question or comments to this email. Please post your comments or question to the url !contact_url.<br>\r\n\r\nThanks and Regards,<br>\r\n\r\nAdmin<br>\r\n!site_name'),
(20, 'buyer_review', 'Owner review', 'You\'ve got a review from !site_title', 'The Owner <b>!buyer_name</b> have just posted a review for you on the job <b>!project_name</b> you did.\r\n<br><br>\r\nRegards,<br>\r\n!site_name'),
(21, 'profile_update', 'Profile Update Notification', 'Profile Update Notification on !site_name', 'Hello !username,<br>\r\n\r\nThanks for using !site_name. \r\n\r\nYour profile has been successfully updated. <br>\r\nYour update profile datas are as follows, \r\n\r\n!data1\r\n!data2\r\n!data3\r\n!data4\r\n!data5\r\n!data6\r\n!data7\r\n!data8\r\n!data9\r\n!data10\r\n!data11\r\n!data12\r\n!data13\r\n\r\nYou should not post any question or comments to this email. Please post your comments or question to the url !contact_url.\r\n\r\nThanks and Regards,\r\n\r\nAdmin\r\n!site_name'),
(22, 'programmer_review', 'Employee review', 'You\'ve got a review from !site_title', 'The Employee <b>!programmer_name</b> have just posted a review for your job <b>!project_name</b> you did.\r\n\r\nRegards,\r\n!site_name'),
(23, 'project_cancel', 'Job Cancel', 'Job Cancel on !site_name', 'Hello !username,\r\n\r\nThank you for using !site_name.\r\n\r\nYour job has been cancelled by !creatorname in !site_url. \r\n\r\nThe details as follows,\r\n\r\nJob ID   : !projectid <br>\r\n\r\nJob Name : !projectname <br>\r\n\r\nCreator Name : !creatorname <br>\r\n\r\nYou want to reactive the job, please  login into !site_url. <br>\r\n\r\nYou should not post any question or comments to this email. Please post your comments or question to the url !contact_url.<br>\r\n\r\nThanks and Regards,<br>\r\n\r\nAdmin<br>\r\n!site_name\r\n'),
(24, 'consolidate_bids', 'Consolidate Bids Details', 'Consolidate Bids Details', 'Hello !username,\r\n\r\nThanks for Using !site_name. <br>\r\n\r\nThe consolidate job bids for your job !projectname as follows, <br>\r\n\r\n!records<br>\r\n\r\nYou should not post any question or comments to this email. Please post your comments or question to the url !contact_url.<br>\r\n\r\nThanks and Regards,<br>\r\n\r\nAdmin<br>\r\n!site_name\r\n\r\n'),
(25, 'email_banned', 'Email Banned', 'Email Baned in !site_name', 'Hello !username,<br>\r\n\r\nThanks for using !site_name.<br>\r\n\r\nYour !type has been Banned by !site_url.<br>\r\nIf you want to reactive, please contact !site_name or contact admin. <br>\r\n\r\nYou should not post any question or comments to this email. Please post your comments or question to the url !contact_url.<br>\r\n\r\nThanks and Regards,<br>\r\n\r\nAdmin<br>\r\n!site_name\r\n'),
(28, 'ticket_post', 'Ticket Post', 'Ticket Post', '!username !\r\nThank you !username for Post Ticket on !site_name site.\r\n\r\nCall Id           : !callid\r\nCategory          : !category\r\nSubject           : !subject\r\nDescription       : !description\r\nPriority          : !priority\r\nStatus            : !status'),
(27, 'response_ticket', 'Response Ticket', 'Response for your Post from !site_name. !question', '!username !\n\nThank you !username for Post Ticket on !site_name site.\n\nCall Id           : !callid\nSubject           : !subject\nDescription       : !description\n\n!response'),
(29, 'privateproject_post', 'Private Job', 'Private Job', '!username !\r\nThank you !username for Posting job on !site_name site.\r\n\r\nJob Id   : !projectid\r\nJob Name : !projectname\r\nCreate Date  : !date\r\nProfile      : !profile\r\nPrivate employees:\r\n!privateproviders'),
(30, 'private_project_provider', 'Private Job', 'Private Job on !site_name', 'Hello !username,<br>\r\n\r\nThank you for using !site_name.<br>\r\n\r\nThe following  job has been created by !creatorname in !site_name for private job. <br>\r\n\r\nThe details as follows,<br>\r\n\r\nJob ID   : !projectid <br>\r\n\r\nJob Name : !projectname <br>\r\n\r\nCreator Name : !creatorname <br>\r\n\r\nView Job : !projecturl <br>\r\n\r\nThanks and Regards,<br>\r\n\r\nAdmin<br>\r\n!site_name\r\n'),
(31, 'project_cancel_admin', 'Admin acknowledgement', 'Job cancellation case opened', 'A cancellation case opened on the Job "!project_name" by the !user_type - "!user".<br><br>The case id is - !case_id'),
(32, 'cancellation_case', 'Job cancellation', '!site_title Job cancellation', 'Dear !other_user,<br><br>!user opened a cancellation case on the Job "!project_name"<br><br>Please click on the link to see the opened case !link<br><br>If you have any problems with this email you can contact !contact_url'),
(33, 'respond_case', 'Response for cancellation/dispute', 'Response from !user for "!pr_name" cancellation', 'Dear !other_user,<br><br>!user has responded for the cancellation case for the shippment "!project_name"<br><br>Please click on the link to see the case details !link<br><br>If you have any problems with this email you can contact !contact_url'),
(34, 'response_case_admin', 'response acknowledgment', 'Response for cancellation case', 'A response from the !user_type - "!user" for the cancellation case on the Shippment "!project_name".<br><br>The case id is - !case_id'),
(35, 'email_suspended', 'Email Suspended', 'Email Suspended in !site_name', 'Hello !username,<br>\r\n\r\nThanks for using !site_name.<br>\r\n\r\nYour !type has been suspended by !site_url.<br>\r\nIf you want to reactive, please contact !site_name or contact admin. <br>\r\n\r\nYou should not post any question or comments to this email. Please post your comments or question to the url !contact_url.<br>\r\n\r\nThanks and Regards,<br>\r\n\r\nAdmin<br>\r\n!site_name\r\n'),
(36, 'changeto_dispute_case', 'Cancellation case to dispute case', 'Cancellation case changed to dispute case', 'Dear !user,<br><br>Cancellation case of the Job\r\n"!project_name" has been changed to dispute case<br><br>Please click on the link to see the case details !link<br><br>If you have any problems with this email you can contact !contact_url'),
(37, 'remove_review', 'remove_review', '!site_title - Review Removed Admin', 'Hello !user, \n\nThe review for the Job !project_title has been removed.\n\nURL : !project_name\n\nIf you have any problems with this email you can contact !contact_url'),
(38, 'project_cancelled_admin', 'Admin acknowledgement', 'Project cancellation case opened', 'A cancellation case opened on the Job "!project_name" by the "!user_type" - "!user".<br><br>The case id is - "!case_id"'),
(39, 'case_closed', 'Case closed by admin', 'Shippment cancellation/Dispute case closed', 'Dear !user,<br><br>Cancellation case of the Job "!project_name" hase been closed by administrator<br><br>Please click on the link to see the case details !link<br><br>If you have any problems with this email you can contact !contact_url'),
(40, 'milestone_status', 'Milestone Status', 'Milestone Notification', 'Hello !username,\r\n\r\nYou are received new !milestatus from !sender_name\r\n\r\nfor the job " !project_name "'),
(41, 'team_member_signup', 'Team Member Signup', 'Confirmation mail for !site_title', '!invitation\r\n\r\nPlease click here to complete the signup process. \r\nYour activation link: !activation_url \r\n\r\nFor any questions contact our support team at !contact_url our team will help on any issue.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `employee_milestone`
--

CREATE TABLE `employee_milestone` (
  `employee_milestone_id` int(11) NOT NULL,
  `employee_milestone_name` varchar(250) NOT NULL,
  `employee_milestone_date` date NOT NULL,
  `employee_milestone_quote` double NOT NULL,
  `employee_milestone_description` text NOT NULL,
  `employee_milestone_escrow_flag` tinyint(4) NOT NULL,
  `employee_milestone_lowbid_notify` tinyint(4) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `owner_milestone_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `employee_milestone_employee_id` int(11) NOT NULL,
  `inserted_by_employee` tinyint(4) NOT NULL,
  `is_template` tinyint(4) NOT NULL,
  `is_draft` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `employee_milestone`
--

INSERT INTO `employee_milestone` (`employee_milestone_id`, `employee_milestone_name`, `employee_milestone_date`, `employee_milestone_quote`, `employee_milestone_description`, `employee_milestone_escrow_flag`, `employee_milestone_lowbid_notify`, `bid_id`, `owner_milestone_id`, `job_id`, `employee_milestone_employee_id`, `inserted_by_employee`, `is_template`, `is_draft`) VALUES
(5, 'Milestone 1', '2017-02-12', 10, 'Milestone 1 Description', 1, 1, 100, 0, 0, 0, 0, 0, 0),
(6, 'Milestone 2', '2017-02-14', 15, 'Milestone 2 Description', 0, 1, 100, 0, 0, 0, 0, 0, 0),
(7, 'Milestone 3', '2017-02-23', 12, 'Milestone 3 Description', 0, 0, 100, 0, 0, 0, 0, 0, 0),
(8, 'Milestone#1', '2017-03-30', 10, '', 0, 0, 101, 0, 0, 0, 0, 0, 0),
(9, 'Milestone#2', '2017-03-31', 10, '', 0, 0, 101, 0, 0, 0, 0, 0, 0),
(10, 'Milestone#3', '2017-04-07', 10, '', 0, 0, 101, 0, 0, 0, 0, 0, 0),
(13, 'Milestone#1', '2017-03-21', 10, 'Milestone 1 Description', 1, 0, 103, 337, 0, 0, 0, 0, 0),
(14, 'Milestone#2', '2017-03-30', 20, 'Milestone#2 Description', 1, 1, 103, 338, 0, 0, 0, 0, 0),
(15, 'Milestone#3', '2017-04-26', 10, '', 0, 0, 103, 0, 0, 0, 0, 0, 0),
(16, 'Milestone#4', '2017-05-12', 5, 'Milestone#4 description', 0, 1, 103, 0, 0, 0, 0, 0, 0),
(18, 'Milestone#5', '2017-05-10', 5, 'Milestone#5 Description', 0, 0, 103, 0, 0, 0, 0, 0, 0),
(86, 'MilestoneBid#1', '2017-04-15', 10, '', 0, 0, 122, 339, 208, 8, 1, 0, 0),
(87, 'MilestoneBid#2', '2017-04-20', 20, 'MilestoneBid#2 Description', 1, 0, 122, 340, 208, 8, 1, 0, 0),
(107, 'MilestoneBid#4', '2017-04-30', 10, 'MilestoneBid#4 Description', 1, 0, 122, 0, 208, 8, 1, 0, 0),
(106, 'MilestoneBid#3', '2017-05-03', 10, 'MilestoneBid#3 Description', 1, 1, 122, 0, 208, 8, 1, 0, 0),
(108, 'BidTemplate#1', '2017-04-26', 10, 'BidTemplate#1', 1, 0, 0, 0, 0, 8, 1, 1, 0),
(109, 'BidDraft#1', '2017-04-27', 15, 'BidDraft#1 Description', 1, 1, 122, 0, 208, 8, 1, 0, 0),
(110, 'MilestoneBid#2', '2017-04-20', 20, 'MilestoneBid#2 Description', 0, 1, 0, 0, 0, 8, 1, 0, 1),
(113, 'EditDraft#1', '2017-04-30', 10, 'MilestoneBid#4 Description', 0, 1, 0, 0, 0, 8, 1, 1, 0),
(114, 'Template With 2 attachments', '2017-04-28', 10, 'Template With 2 attachments ', 1, 1, 0, 0, 0, 8, 1, 1, 0),
(115, 'Template With 2 attachments', '2017-04-28', 10, 'Template With 2 attachments', 1, 0, 122, 0, 208, 8, 1, 0, 0),
(116, 'BidTemplate#1', '2017-04-26', 10, 'BidTemplate#1', 1, 0, 122, 0, 208, 8, 1, 0, 0),
(117, 'Milestone#1', '2017-03-29', 10, '', 0, 0, 0, 334, 207, 8, 0, 0, 0),
(118, 'Milestone#2', '2017-03-15', 20, '', 0, 0, 0, 335, 207, 8, 0, 0, 0),
(119, 'Milestone#3', '2017-03-28', 30, '', 0, 0, 0, 336, 207, 8, 0, 0, 0),
(120, 'MilestoneBidTemplate#1', '2017-04-30', 5, '', 0, 0, 0, 343, 205, 8, 0, 0, 0),
(121, 'Milestone#2', '2017-04-30', 5, 'Milestone Details', 1, 0, 0, 0, 205, 8, 1, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `escrow_release_request`
--

CREATE TABLE `escrow_release_request` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(128) NOT NULL,
  `request_date` varchar(128) NOT NULL,
  `status` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `escrow_release_request`
--

INSERT INTO `escrow_release_request` (`id`, `transaction_id`, `request_date`, `status`) VALUES
(58, '9', '1419682183', 'Release'),
(59, '12', '1421016477', 'Release'),
(60, '13', '1423322127', 'Release'),
(61, '30', '1460771288', 'Release');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `faq_category_id` int(10) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `is_frequent` char(1) NOT NULL DEFAULT 'N',
  `created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `faqs`
--

INSERT INTO `faqs` (`id`, `faq_category_id`, `question`, `answer`, `is_frequent`, `created`) VALUES
(5, 3, 'What are the costs per project for a consultant?', 'As a consultant you will get paid in full for the amount you offered. There will be no deduction.', '0', 1420839344);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `category_name`, `created`) VALUES
(3, 'Membership', 1420839111);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `browser` varchar(250) NOT NULL,
  `language` varchar(100) NOT NULL,
  `feedback_type` tinyint(4) NOT NULL COMMENT '1- Suggestion 2-Missing Function 3-Error Report 4- Question',
  `memo_text` varchar(3000) NOT NULL,
  `page_reference` varchar(5000) NOT NULL,
  `geo_location` varchar(2000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `time_stamp`, `browser`, `language`, `feedback_type`, `memo_text`, `page_reference`, `geo_location`) VALUES
(10, 8, '2017-02-01 13:14:27', 'Firefox-52.0', 'english', 1, 'Feedback message', 'http://demo.maventricks.com/machinery_market/users/feedback', '171.49.199.83'),
(9, 8, '2017-02-01 13:12:56', 'Firefox-52.0', 'english', 1, 'Feedback Message', '/machinery_market/search/index', '171.49.199.83'),
(11, 8, '2017-02-01 13:16:43', 'Firefox-52.0', 'english', 1, 'Feedback message', 'http://demo.maventricks.com/machinery_market/users/feedback', '171.49.199.83'),
(12, 8, '2017-02-01 13:18:26', 'Firefox-52.0', 'english', 1, 'Feedback message', 'http://demo.maventricks.com/machinery_market/search/index', '171.49.199.83'),
(13, 8, '2017-02-06 08:11:51', 'Firefox-52.0', 'english', 2, 'Feedback', 'http://demo.maventricks.com/machinery_market/search/index', '171.60.208.236'),
(14, 8, '2017-02-06 08:12:11', 'Firefox-52.0', 'english', 1, 'Message 1', 'http://demo.maventricks.com/machinery_market/search/index', '171.60.208.236'),
(15, 7, '2017-05-04 12:48:32', 'Firefox-53.0', 'english', 1, 'test suggestion', 'http://marketplace.oprocon.eu/file/index/user', '87.133.27.181'),
(16, 7, '2017-05-05 12:17:41', 'Firefox-53.0', 'english', 4, 'sadrhwrnb', 'http://marketplace.oprocon.eu/messages/viewMessage', '87.133.27.181'),
(17, 7, '2017-05-05 12:18:01', 'Firefox-53.0', 'english', 3, 'ydvxcbsdgnms', 'http://marketplace.oprocon.eu/messages/viewMessage', '87.133.27.181'),
(18, 7, '2017-05-11 11:15:01', 'Firefox-54.0', 'english', 1, 'Feeback message', 'http://marketplace.oprocon.eu/search/findMachinery', '171.49.181.176'),
(19, 7, '2017-05-11 11:15:23', 'Firefox-54.0', 'english', 2, 'Feebback', 'http://marketplace.oprocon.eu/search/findMachinery', '171.49.181.176'),
(20, 7, '2017-05-31 08:41:54', 'Firefox-54.0', 'english', 1, 'Testing Messages', 'http://marketplace.oprocon.eu/file', '122.178.17.4'),
(21, 7, '2017-05-31 08:52:28', 'Firefox-54.0', 'english', 1, 'testing', 'http://marketplace.oprocon.eu/file', '122.178.17.4'),
(22, 7, '2017-05-31 08:52:56', 'Firefox-54.0', 'english', 2, 'testing', 'http://marketplace.oprocon.eu/file', '122.178.17.4'),
(23, 7, '2017-05-31 08:55:52', 'Firefox-54.0', 'english', 4, 'PROVIDE FEEDBACK', 'http://marketplace.oprocon.eu/file', '122.178.17.4'),
(24, 7, '2017-05-31 08:58:27', 'Firefox-54.0', 'english', 1, 'Testing Feddback', 'http://marketplace.oprocon.eu/file', '122.178.17.4');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `files`
--

CREATE TABLE `files` (
  `id` int(12) NOT NULL,
  `user_id` int(128) NOT NULL,
  `folder_id` int(128) NOT NULL,
  `user_folder_id` int(128) NOT NULL,
  `job_id` int(128) NOT NULL,
  `expiry_date` date NOT NULL,
  `location` varchar(128) CHARACTER SET utf8 NOT NULL,
  `created` int(11) NOT NULL,
  `delete` int(11) NOT NULL,
  `key` varchar(128) CHARACTER SET utf8 NOT NULL,
  `description` varchar(128) CHARACTER SET utf8 NOT NULL,
  `file_size` int(128) NOT NULL,
  `file_type` varchar(128) CHARACTER SET utf8 NOT NULL,
  `original_name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `file_type_identify` tinyint(4) NOT NULL,
  `move_to_user` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `files`
--

INSERT INTO `files` (`id`, `user_id`, `folder_id`, `user_folder_id`, `job_id`, `expiry_date`, `location`, `created`, `delete`, `key`, `description`, `file_size`, `file_type`, `original_name`, `file_type_identify`, `move_to_user`) VALUES
(89, 8, 6, 0, 57, '2016-12-02', 'eac7c304422c52b98fa2b3ee4ad0938d.jpg', 1480335973, 1480335976, '9d44c4048cd2527476f6a4fe3e85fd7c', 'Attach 3 with folder3', 79, '.jpg', 'email-send-ss-1920-800x450.jpg', 1, 0),
(88, 8, 0, 0, 59, '2016-11-30', 'bc23145e8f33e721fb87e9bba5a00238.jpg', 1480335706, 1480335709, 'adf18a71b7a99e6ddd1c04489ea9ad95', 'Attach 3 with folder2', 17, '.jpg', 'company.jpg', 1, 0),
(73, 8, 0, 0, 0, '0000-00-00', '3aa22b4ead7de3dcf2c629e89334fbb4.jpg', 1479870283, 1479870286, 'b6271f0636f1a8fef554446b04270771', 'Attach 11', 79, '.jpg', 'email-send-ss-1920-800x450.jpg', 3, 0),
(74, 8, 0, 0, 0, '0000-00-00', '1297d81d67f217587b94ce449b05de7a.jpg', 1479870382, 1479870385, '9ed93184511aff5594393bdc74c1edfe', 'Attach 9', 17, '.jpg', 'company.jpg', 3, 0),
(87, 8, 4, 0, 56, '2016-11-28', '03552db72e64424b9a54406c8f938c72.jpg', 1480318081, 1480318084, '79c10efaaa8c842b73c75accdda2dcc7', 'Attach 3 with folder1', 3, '.jpg', 'photo1.jpg', 1, 0),
(90, 8, 4, 0, 57, '2016-11-29', '50338449a61f23b9370041a6753b3a3c.jpg', 1480406598, 1480406601, 'c52f0556dfab54f5d52ffa00d680a1f3', 'Attach 4 with folder1', 79, '.jpg', 'email-send-ss-1920-800x450.jpg', 1, 0),
(91, 8, 5, 0, 62, '2016-12-08', '86f5b3ff5d665bd4d5863a7891cdba72.jpg', 1480407713, 1480407716, '625ca26293528de769782df3f03cef02', 'Attach 4 with folder2', 3, '.jpg', 'photo1.jpg', 1, 0),
(93, 8, 6, 0, 59, '2016-11-30', 'ee9f058ad38f25538475c6569677e8c4.jpg', 1480409477, 1480409480, '411ce5ba15b18a5c5cf4e3cea4b20ea8', 'without folder', 79, '.jpg', 'email-send-ss-1920-800x450.jpg', 1, 0),
(94, 8, 0, 0, 62, '2016-11-29', '71b1815fe50fd904c5215eff7f37efcf.jpg', 1480414710, 1480414713, 'f994cb41ba74de44ae7c2cdf06fc8a1c', 'without folder', 3, '.jpg', 'photo1.jpg', 1, 0),
(109, 8, 0, 0, 0, '0000-00-00', '1e03cdfe831356846a25b26959b103c8.jpg', 1481700654, 1481700657, 'a013e27efb1965bd5b66e74a555babab', 'attach 9', 3, '.jpg', 'photo1.jpg', 2, 0),
(120, 8, 8, 0, 0, '0000-00-00', '850bbcb56640758e3da50c0bbf789d36.jpg', 1481880270, 1481880273, '850bbcb56640758e3da50c0bbf789d36', 'attach 9', 3, '.jpg', 'photo1.jpg', 4, 0),
(122, 8, 9, 0, 0, '0000-00-00', '297c9e89c9d117a5bba7131d9d483f5e.jpg', 1481887900, 1481887903, '297c9e89c9d117a5bba7131d9d483f5e', 'Attach 11', 79, '.jpg', 'email-send-ss-1920-800x450.jpg', 4, 0),
(123, 8, 10, 0, 0, '0000-00-00', 'e289e71158bf2e3f2fd740776f0c41c9.jpg', 1481979517, 1481979520, 'dc3b5641824e8af1ae2d47be6791d4e9', 'invoice attachmentt', 3, '.jpg', 'photo1.jpg', 4, 0),
(124, 8, 10, 0, 0, '0000-00-00', '1f9dd7789f81ba58949a0cb8c0ff2417.jpg', 1481890929, 1481890932, 'de35619718e40826c82e7e14fe5c808d', 'Portfolio attachment 3', 17, '.jpg', 'company.jpg', 4, 0),
(125, 8, 0, 0, 0, '0000-00-00', '553601478dfadaf9e47cd66557a36804.jpg', 1482204577, 1482204580, '5917eadb210020a223e3577c86eac59e', 'Manual Upload', 3, '.jpg', 'photo1.jpg', 4, 0),
(126, 8, 7, 0, 64, '2016-12-21', '9ce5899ec3d7eb175f1441b185ffad68.jpg', 1482205269, 1482205272, '19b784fd3809240a154647eb937aa7a5', 'Latest attachment', 79, '.jpg', 'email-send-ss-1920-800x450.jpg', 1, 0),
(127, 8, 0, 0, 0, '0000-00-00', 'ee11c49a149679ff11345ab1ee54ebe4.jpg', 1482205818, 1482205821, '26ded4539b29ea0823b544676b9e70e7', 'invoice attachment 1', 3, '.jpg', 'photo1.jpg', 5, 0),
(128, 8, 0, 0, 0, '0000-00-00', 'c612faaaf51bac61e060d13d93912dae.jpg', 1482206009, 1482206012, '46e93d994ab6664216b09e6b61a772ff', 'attach 10', 17, '.jpg', 'company.jpg', 2, 0),
(129, 8, 0, 0, 0, '0000-00-00', 'cc12aad0bbdc1f47029166bd89e00fd2.jpg', 1482206082, 1482206085, '4bbf49359bd8c3ec81848f837c46f8bc', 'invoice attachment 3', 3, '.jpg', 'photo1.jpg', 5, 0),
(131, 7, 5, 0, 208, '0000-00-00', '5976fcc6f85b47c35ac105c31a250d3e.docx', 1493603852, 1493603855, 'a8860c7ec508507bd58c55c48b41dbeb', '', 322, '.docx', 'Dropdown_explanation.docx', 1, 0),
(132, 7, 10, 0, 0, '0000-00-00', '10c2cb0b3b36b854cc3d0641f06b5e78.jpg', 1493883766, 1493883769, '31c81865789a4e7756bb26cef1fc0df0', '', 144, '.jpg', 'spanndecken-und-spannwaende-ausstellung.jpg', 4, 0),
(133, 7, 8, 0, 0, '0000-00-00', 'f02eff8e6be8f3c152eae0e2afacd888.docx', 1496866238, 1496866241, 'f02eff8e6be8f3c152eae0e2afacd888', '', 322, '.docx', 'Dropdown_explanation.docx', 4, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `folders`
--

CREATE TABLE `folders` (
  `folder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `folder_name` varchar(500) NOT NULL,
  `folder_section` tinyint(4) NOT NULL COMMENT '1- project 2- user section 3-portfolio'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `folders`
--

INSERT INTO `folders` (`folder_id`, `user_id`, `folder_name`, `folder_section`) VALUES
(5, 8, 'Folder2', 1),
(4, 8, 'Folder1', 1),
(6, 8, 'Folder3', 1),
(7, 8, 'folder4', 1),
(8, 8, 'user folder 1', 2),
(9, 8, 'user folder 2', 2),
(10, 8, 'user folder 3', 2),
(11, 8, 'Portfolio folder1', 3),
(12, 8, 'Portfolio folder2', 3),
(13, 8, 'Portfolio folder3', 3),
(14, 8, 'Portfolio folder 4', 3),
(15, 8, 'user folder 4', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE `groups` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `group_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descritpion` text CHARACTER SET utf8,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `attachment_url` longtext,
  `attachment_name` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `descritpion`, `created`, `modified`, `attachment_url`, `attachment_name`) VALUES
(11, 'Education', 'Education', 1255432734, 1423801133, 'f1caa1cf2c53dab9db87d463d1a9d9e3.png', 'chart8-00193.png'),
(12, 'Human Resource', 'Human Resources', 1419276710, 1423899726, '6674d0107b44570db8ff5b1d8f838694.png', '9d34057d932b549064f8f68c41351b8b_thumb.png'),
(13, 'Communicationn', 'Communication', 1419276737, 1421053399, 'cdeb2405381353a87ffc69554c363ffd.jpg', 'industries.jpg'),
(14, 'Creativity Technique', 'creativity technique', 1419276972, 1419276972, NULL, NULL),
(15, 'Operations', 'operations', 1419277023, 1419277023, NULL, NULL),
(16, 'Supply Chain', 'supply chain', 1419277049, 1419277049, NULL, NULL),
(17, 'Industrial Engineering', 'Industrial Engineering', 1419277104, 1419277104, NULL, NULL),
(18, 'Lean Management', 'Lean Management', 1419277155, 1419277155, NULL, NULL),
(19, 'Knowledge Management', 'Knowledge Management', 1419277264, 1419277264, NULL, NULL),
(20, 'Quality Management', 'Quality Management', 1419277373, 1419277373, NULL, NULL),
(21, 'Project Management', 'Project Management', 1419277513, 1419277513, NULL, NULL),
(22, 'Logistics', 'Logistics', 1419277565, 1419277565, NULL, NULL),
(23, 'Marketing', 'Marketing', 1419277719, 1419277832, NULL, NULL),
(24, 'Lawyer', 'Lawyer', 1419277850, 1419277850, NULL, NULL),
(25, 'Engineering', 'Engineering', 1419277884, 1419277884, NULL, NULL),
(26, 'Research & Development', 'Research & Development', 1419277918, 1419277918, NULL, NULL),
(27, 'Legal', 'Legal', 1419277952, 1419277952, '', ''),
(28, 'Executive Management', 'Executive Management', 1419432227, 1419432227, NULL, NULL),
(29, 'Finance', 'Finance', 1419432305, 1419432305, NULL, NULL),
(30, 'Coaching', 'Coaching', 1419432387, 1419432387, NULL, NULL),
(31, 'Environment Safety Health', 'Environment Safety Health', 1419432492, 1422594502, '650df74a4231d29041ff4fecd611c4e0.jpg', 'm_g4.jpg'),
(32, 'Information Technology', 'Information Technology', 1419432525, 1422594451, '1d06762c642e1df33cb34bd188ad6926.jpg', 'm_g6.jpg'),
(33, 'Other', 'Tell us if we forgot something here', 0, 0, NULL, NULL),
(34, 'erewrewrwe', '', 1421048869, 1421048869, NULL, NULL),
(35, 'cleaning', 'dsfdsfsdf', 1421048895, 1421048895, NULL, NULL),
(36, 'cleaningg', 'asdsdas asdsadsa sadsd', 1421049349, 1421049349, 'f80438493e6287a0c223ee7b645cef8d.jpg', '46320-logo.jpg'),
(37, 'dasdas', '', 1421049659, 1421049659, '', ''),
(38, 'dasdasd', '', 1421049787, 1421049787, '4b2af1dd8aec5bdb7f3f8a8dfb941a9d.png', 'slider.png'),
(39, 'fdsfdsf', 'sdfsdfsdf', 1421906969, 1421906969, '2bbaf53927084f9dcd07265d15447c0f.png', 'slide2.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group_permission`
--

CREATE TABLE `group_permission` (
  `group_permission_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_name` varchar(250) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `new_quotes` tinyint(4) NOT NULL,
  `edit_all_quotes` tinyint(4) NOT NULL,
  `edit_own_quotes` tinyint(4) NOT NULL,
  `view_all_project` tinyint(4) NOT NULL,
  `view_assigned_project` tinyint(4) NOT NULL,
  `new_portfolio` tinyint(4) NOT NULL,
  `view_portfolio` tinyint(4) NOT NULL,
  `edit_all_portfolio` tinyint(4) NOT NULL,
  `edit_own_portfolio` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1-active 0- inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `group_permission`
--

INSERT INTO `group_permission` (`group_permission_id`, `user_id`, `group_name`, `admin`, `new_quotes`, `edit_all_quotes`, `edit_own_quotes`, `view_all_project`, `view_assigned_project`, `new_portfolio`, `view_portfolio`, `edit_all_portfolio`, `edit_own_portfolio`, `status`) VALUES
(2, 8, 'Team#1', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(1, 8, 'Team#2', 0, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1),
(3, 8, 'Team#3', 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1),
(7, 8, 'Team#4', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 7, 'Project Manager', 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1),
(10, 7, 'Admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(11, 7, 'Marketing', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0),
(13, 46, 'Admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(14, 46, 'Substitute', 0, 1, 0, 0, 1, 0, 1, 1, 0, 1, 1),
(15, 49, 'Admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `invite_suppliers`
--

CREATE TABLE `invite_suppliers` (
  `invite_suppliers_id` int(11) NOT NULL,
  `invite_suppliers_job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invite_suppliers_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `invite_suppliers`
--

INSERT INTO `invite_suppliers` (`invite_suppliers_id`, `invite_suppliers_job_id`, `user_id`, `invite_suppliers_status`) VALUES
(1, 207, 8, 0),
(2, 206, 8, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ipn_return`
--

CREATE TABLE `ipn_return` (
  `invoice` int(100) UNSIGNED NOT NULL,
  `receiver_email` varchar(60) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_number` varchar(10) DEFAULT NULL,
  `quantity` varchar(6) DEFAULT NULL,
  `payment_status` varchar(10) DEFAULT NULL,
  `pending_reason` varchar(10) DEFAULT NULL,
  `payment_date` varchar(20) DEFAULT NULL,
  `mc_gross` varchar(20) DEFAULT NULL,
  `mc_fee` varchar(20) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `mc_currency` varchar(3) DEFAULT NULL,
  `txn_id` varchar(20) DEFAULT NULL,
  `txn_type` varchar(10) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `address_street` varchar(50) DEFAULT NULL,
  `address_city` varchar(30) DEFAULT NULL,
  `address_state` varchar(30) DEFAULT NULL,
  `address_zip` varchar(20) DEFAULT NULL,
  `address_country` varchar(30) DEFAULT NULL,
  `address_status` varchar(10) DEFAULT NULL,
  `payer_email` varchar(60) DEFAULT NULL,
  `payer_status` varchar(10) DEFAULT NULL,
  `payment_type` varchar(10) DEFAULT NULL,
  `notify_version` varchar(10) DEFAULT NULL,
  `verify_sign` varchar(10) DEFAULT NULL,
  `referrer_id` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `job_status` enum('0','1','2','3') CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `due_date` date NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `milestone` varchar(50) NOT NULL,
  `mile_notify` int(50) NOT NULL,
  `job_categories` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `job_categories_encrypt` text CHARACTER SET utf8 NOT NULL,
  `manual_job` text CHARACTER SET utf8 NOT NULL,
  `budget_min` int(11) UNSIGNED DEFAULT '0',
  `budget_max` int(11) UNSIGNED DEFAULT '0',
  `is_feature` int(1) DEFAULT NULL,
  `is_urgent` int(1) DEFAULT NULL,
  `is_hide_bids` int(1) NOT NULL DEFAULT '0',
  `creator_id` int(10) UNSIGNED NOT NULL,
  `created` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `checkstamp` varchar(50) CHARACTER SET utf8 NOT NULL,
  `owner_rated` enum('0','1') CHARACTER SET utf8 NOT NULL,
  `employee_rated` enum('0','1') CHARACTER SET utf8 NOT NULL,
  `job_paid` enum('0','1') CHARACTER SET utf8 NOT NULL,
  `job_award_date` int(11) NOT NULL,
  `notification_status` int(11) NOT NULL DEFAULT '0',
  `attachment_url` longtext NOT NULL,
  `attachment_name` varchar(60) DEFAULT NULL,
  `attachment_url1` longtext NOT NULL,
  `attachment_name1` varchar(60) NOT NULL,
  `attachment_url2` longtext NOT NULL,
  `attachment_name2` varchar(60) NOT NULL,
  `is_private` int(11) NOT NULL DEFAULT '0',
  `private_users` text,
  `contact` text NOT NULL,
  `salary` varchar(15) NOT NULL,
  `flag` int(1) NOT NULL,
  `salarytype` varchar(100) NOT NULL,
  `escrow_due` int(11) NOT NULL,
  `invite_suppliers` varchar(124) NOT NULL,
  `team_member_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `jobs`
--

INSERT INTO `jobs` (`id`, `job_name`, `job_status`, `description`, `due_date`, `country`, `state`, `city`, `milestone`, `mile_notify`, `job_categories`, `job_categories_encrypt`, `manual_job`, `budget_min`, `budget_max`, `is_feature`, `is_urgent`, `is_hide_bids`, `creator_id`, `created`, `enddate`, `employee_id`, `checkstamp`, `owner_rated`, `employee_rated`, `job_paid`, `job_award_date`, `notification_status`, `attachment_url`, `attachment_name`, `attachment_url1`, `attachment_name1`, `attachment_url2`, `attachment_name2`, `is_private`, `private_users`, `contact`, `salary`, `flag`, `salarytype`, `escrow_due`, `invite_suppliers`, `team_member_id`) VALUES
(7, 'SMED Workshops to reduce change over times', '3', 'In our production we have 3 different machine types with 3 different stup types each. For all machines and all 4 shift crews a setup SMED workshop should be carried out including SMED optimization frontup.<br>', '0000-00-00', 'United States', 'SC', 'Charleston', '', 0, 'Lean Management,SAP', 'c9a4fadb0e532330d5530d6bcc4a3d1c,999bc6b18351bbe817d26f559ba408ae', '', 0, 5000, 0, 0, 0, 4, 1419338124, 1426973110, 5, 'dcfe5b95b8550b54b76da0849a831ecb', '1', '1', '0', 1419684980, 1, '', '', '', '', '', '', 0, '', '', '', 0, '', 0, '', 0),
(8, 'Testing Project', '3', 'This page is to contract a freelancer to complete a single project. If you want to post a help wanted ad to find a long-term employee/partner, please click here to post a project listing instead.This page is to contract a freelancer to complete a single project. If you want to post a help wanted ad to find a long-term employee/partner, please click here to post a project listing instead.<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '', 0, 'Controls & Drives', 'fb54423c392d107161ddab675631a59b', '', 6, 12, 0, 1, 0, 7, 1420434671, 1421644271, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(9, 'test jan 13', '3', 'qwuyeiwqy iqw eiuwqye iwquy  qwiuey qwieuq<br/>', '0000-00-00', 'Anguilla', 'qewqe', 'qwewqewqe', '', 0, 'Production Planning,Sequencing,SAP', '4c89dbee82b7b1dd9d379c2d00562947,f770364d234fdd52dafa02b6e16f3fb6,999bc6b18351bbe817d26f559ba408ae', '', 14, 20, 0, 0, 0, 6, 1421134382, 1422343982, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(10, 'Engineering', '3', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br/>', '0000-00-00', 'India', 'Tamil Nadu', 'chennai', '', 0, 'Machine procurement,Machine Development,Technical Documentation,SAP', '2af2adf212edd655e2f8274304e88f9f,84cfca6dce7809b0f7eafaa8127e34dd,0fc75709621519dfa4730a0da953a784,999bc6b18351bbe817d26f559ba408ae', '', 15, 50, 1, 1, 0, 7, 1421738862, 1423728010, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 1, NULL, '', '', 0, '', 0, '', 0),
(11, 'education', '3', 'asgdjhs jsgadjsah dsjak dsgjadgh sajkdghs ajkdh skajd<br/>', '0000-00-00', 'India', 'Tamilnadu', 'madurai', '', 0, 'University/eLearning,Employee Information,Balanced Scorecard', 'ecc1096e75897a6a418aa54cc6309b95,5ae646bae06e16daec5fa3612e1444a2,997a159a6c0ec092f40ecadf6240e924', '', 15, 20, 0, 0, 0, 7, 1421743209, 1422952809, 0, '', '0', '0', '0', 0, 0, 'a5be850ebfd5d91d5644a26f5512dc62.png', 'slide2.png', '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(12, 'ENVIRONMENT SAFETY HEALTH', '3', 'ENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTHENVIRONMENT SAFETY HEALTH<br/>', '0000-00-00', 'Germany', 'Berlin', 'Berlin', '', 0, 'Energy Saving,Enviromental Protection,Environmental Certification,Safety', 'ef9ad9a5dbb7550d49bf3bf2a1c3d22d,bff7737497f5910fa3c976a93e7e57a3,7b1f06c45ef58c37f17fda4eb8103e1a,6472ce41c26babff27b4c28028093d77', '', 200, 400, 1, 0, 0, 7, 1421746659, 1422956259, 0, '', '0', '0', '0', 0, 0, '044734fec99815f15e950096e74c85a3.png', 'img3.png', '', '', '', '', 1, NULL, '', '', 0, '', 0, '', 0),
(13, 'environmental', '3', 'Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.<br/>', '0000-00-00', 'Malta', 'Muscat', 'Oman', '', 0, 'Controlling,Treasury,Insurance,Tax', 'f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d', '', 15, 300, 0, 1, 0, 7, 1421817693, 1423027293, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(14, 'dfsfsd', '3', 'My Saved Projects:  \r\n\r\nNOTE :  Note: This page is to contract a freelancer to complete a single project. If you want to post a help wanted ad to find a long-term employee/partner, please click here to post a project listing instead.\r\n\r\nACCOUNT LOGIN DETAILS...\r\nYou are currently logged in as owner (Logout).\r\n\r\nREQUIRED PROJECT DETAILS...\r\nProject Name\r\n\r\nDo not put a domain/URL in your project name<br/>', '0000-00-00', 'United States', 'Ballybaun', 'sdfdfdsf', '', 0, 'Problem Definition,Energy Saving', '1f2e4e60dc657345243d64f97fb1bbfe,ef9ad9a5dbb7550d49bf3bf2a1c3d22d', '', 40, 70, 0, 0, 0, 7, 1422065911, 1423275511, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 1, '8', '', '', 0, '', 0, '', 0),
(15, 'fsdfvxcvcxv', '3', 'My Saved Projects:  \r\n\r\nNOTE :  Note: This page is to contract a freelancer to complete a single project. If you want to post a help wanted ad to find a long-term employee/partner, please click here to post a project listing instead.\r\n\r\nACCOUNT LOGIN DETAILS...\r\nYou are currently logged in as owner (Logout).\r\n\r\nREQUIRED PROJECT DETAILS... <br/>', '0000-00-00', 'Bahamas', 'Ballybaun', 'cxvxcv', '', 0, 'Self Paced Training,Enterprise Organization', '4372889b77c08a18e6c7678959dfae5f,104e349a614e24418a716ce1da04fdad', 'fdsfsdfds,fsdfsdfdsf,sdfsdfsdf', 30, 60, 0, 0, 0, 7, 1422429516, 1423639116, 8, '6c516243644b8cfcfcb3fbaa1cc697d1', '0', '1', '0', 1422086548, 1, '', NULL, '', '', '', '', 1, '8', '', '', 0, '', 0, '', 0),
(16, 'sajdhjk', '3', 'Note: This page is to contract a freelancer to complete a single project. If you want to post a help wanted ad to find a long-term employee/partner, please click here to post a project listing instead.<br/>', '0000-00-00', 'Angola', 'Ballybaun', 'chennai', '', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer,Self Paced Training,Enterprise Organization,Hiring,Talent Management,Payment Systems,Employment Law regulations,Employee Motivation,Wage accounting,Public Relations,Internal Communication,Employee Information,Translation Service,Problem Definition,Idea Generation,Idea Selection,Idea Implementation,Production Planning,Sequencing,Production,Know How Management,Employee Recognition,Autonomous Workgroups,Supply Chain Management,Purchasing,Warehouse,Distribution,Factory Layout,Time and Motion Studies,Material Flow,Headcount,Incentive Systems,Shift Systems,Continous Improvement,PDCA,Idea Management,Key Performance Indicator (KPI),Method Development,Factory Simulation,Computer Aided Manufacturing (CAM),Job Design,Value Stream Map,Kaizen,Kanban,Poka Yoke,SMED,Workflow Optimization,Office Process Flow Optimization,Production Process Flow Optimization,PDCA/A3/8D,Know How Management,Knowledge Database,Know How Documentation,Process Documentation,Collaboration,Best Practice,Knowledge Mapping,Six Sigma,ISO 9000ff,TS 16949,VDA,QS 9000,EAQF,AVSQ,ISO 22000,HACCP,Problem Solving,Quality Statistics,Statistic Process Control (SPC),Capability Studies,Total Quality Management (TQM),Quality Function Deployment (QFD),Quality Circle,Taguchi,Kansei Engineering,Business Process Reegineering (BPR),Object Oriented Quality and Risk Management (OQRM),Quality Tools,FMEA,APQP,PPAP,Document Management,Project Management,Logistics,Market Analysis,Brand Management,Market Research,Pricing,Promotion,Sales,After Sales Service,E-Commerce,Distribution,Consumer Theory,Economics,Advertising,Patent rights,Start up,Employer Obligations,Employee Rights,Maintenance,Machine procurement,Project Management,Machine Development,Automation Technologies,Transport Systems,Technical Documentation,Material Research,Process Research,Material Development,Process Development,Machine Development,Method Development,Software Development,Organization Development,Vision/Mission Development,Balanced Scorecard,Decission Making,Controlling,Treasury,Insurance,Tax,Business Coaching,Executive Coaching,Control Theory,Expat Coaching,Career Coaching,Financial Coaching,Career Coaching,Personal Coaching,Style Coaching,Systemic Coaching,Energy Saving,Enviromental Protection,Environmental Certification,Safety,SAP,ERP,SCADA,OPC,Controls & Drives,Software,IT Infrastructure', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,4372889b77c08a18e6c7678959dfae5f,ad47487ba9f55206809cda9b8c26970e,098dffccb099681e86da846acfc18f82,f9c8caf36e4edd9019ad377a3e5913f9,31b0ec3b99b07738721de18143026073,605710b2b9973ce56e579e7fe7ca40bd,9f605b329a26309b79602288ca91566e,97ac0992b3214632ef41a3075b0c6e9b,00251b5dece63be7afb8f5fcdd3e83ce,5ae646bae06e16daec5fa3612e1444a2,54d1a8b447435ee325e306b8a58f58c9,1f2e4e60dc657345243d64f97fb1bbfe,26e11ac3f33f80d997e361a593645a11,f87cc7da43b9e091d3860ddea56d5cca,643ad5bde5f29c59d835653f105d74c7,4c89dbee82b7b1dd9d379c2d00562947,f770364d234fdd52dafa02b6e16f3fb6,756d97bb256b8580d4d71ee0c547804e,5368b55efe0fdf484d59fced5bdf8fc7,547d767efe9c787101db5cf00e485e60,793cb79980d3fa094ef13dcf866c482a,bd5476e8f33749530f87777476eeda72,5f95f5c48171ba26e9f8aa9d8c7ce6c4,6416e8cb5fc0a208d94fa7f5a300dbc4,f0bac093bb884df2891d32385d053788,0071d27c3fcd29f13466286ba27549f1,45fc8de324847819ee095188817556ea,178a871d63ced55a2a1245794348a740,7143e90e4612aa3b540583722ae15d4c,10292e05addacebdb23b68a122ce92bf,07d29f397a557ef1fa21c012675df35b,1f04b185d898e6cd1ea20be2459f1a2f,d43226ef4371e98a283f50db3069037e,cab4b63c8575bbd3a342b5fbad426339,22f1c6f52c654280e8091ebba7912a4f,e17258ab2bd1400d4492aed7407801c9,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,11c5be36641bc05b251dac68b2243b3a,d81ecc4e96ad229a33764b7e2182f6ee,2a694503a666ca6d33d0d8e0de261af3,e4ff0b8025c94e620fcf21095812d891,33ae0b4428adfa3ceea9f35bdc6a1a07,5368b55efe0fdf484d59fced5bdf8fc7,1fadb673213c21e8b380f22fa60a87fa,cae286e917b10ab8e6b67028f587fef5,30d14e12406a7580919dce129f5b4b70,337e8f4aa741ef97ec3ed8fd7b1accb7,39d9903201320a83d45d3b36d512f051,e58ca0ad724728414e09d0fe31575380,f07975a00f5b3d1e025709beaf8958db,cc007258ed6ad7c5f333ab4c9fcc3d58,f005154db5e4a784e86ddd52a325b7e1,82f11e8df84d4b474718abcaaadf7f0e,c2b3cbff032f7dc67086a8bb3868132a,29d45de4626630a95dccf42d97c8a52c,23d574908eb584d0340bad2f92123783,0810b9dab1e5f9165452b688fc237160,c38d1935edec2f6cf463602abdfbabf0,6a03a97072a01181059654e8389b992e,53ddc4f8e376c0be7f0f2165eae761bc,8aba034abd1545772ac75f305ef5e73c,960ceabd53770a66b60398b278698c07,60633124df065496444d63301ad9bbbf,cb20a6a674789289063f69aaceeeeee2,b3b607ce1da0ff572e5cfe191b6b601f,b03f732d0b64bf01947a595828fe0888,ee8222c94dcd7d3c1d20cf33edd86ffd,7bf848c679d5474b18c355a3b84e9f9c,c0a422495f053de689303175bda764e7,c2f1f4cbc26e018d0502ab9ef1047555,313b11a9b82d9a829f6ef0ef797aca11,7ede7cdb7772374809887807f2f41db8,d1db7a240300bcd7f59731bdab271b67,04ab7e9520f65aa6c1c1c1eb8c397873,9c1330f0dda3f188a3813b9840d1143f,68c16c941c3fb4e5dad94a7837ea7d1e,69c0225744326087a7c430c3e9bf72dc,b934621127c601f5d5b3893340e95b7c,023157b1a3d9ee4f0ed14b9801a26ac4,e22ac25b066b201473de7aa700ef5d92,626a54d37d402d449d6d7541911e0952,11ff9f68afb6b8b5b8eda218d7c83a65,d40d436df0bbeb1ba05079dd0aedc967,a9f7ecebb493e129aafb4cbfd73e85df,f0bac093bb884df2891d32385d053788,fdb40afa0d285233ba2249b2b1d3e109,7e1e3f377648773863a504d18b367ea3,2ce5fc289845ce826261032b9c6749ea,07744fec5b5a8ed1562fecd32a488416,79c8716e036aef2b15b59c04ec787d43,f22c85e9d23b0b99a63cca2720ca5f71,68a362caa596e9391b409126518e0f30,10d0de28911c5f66463b9c8783f8148a,2af2adf212edd655e2f8274304e88f9f,9c1330f0dda3f188a3813b9840d1143f,84cfca6dce7809b0f7eafaa8127e34dd,49f5799a2db35743d039f344e5834945,4e27832af76c2e7f0546182b3fbbb5b2,0fc75709621519dfa4730a0da953a784,fb6a9fd41b6dacf08edca2fed35e0ce1,41643b5dfdbaa1cb3e1d6ce39fe59c5a,2da2bb28a9c28d8b9b60062e0535e99f,7170bf578f2ee33a8e998acf46a7eb01,84cfca6dce7809b0f7eafaa8127e34dd,d43226ef4371e98a283f50db3069037e,f287f429e4026672e5754c1201691e49,423b89e54151ef282fc4441fd7e9d292,1bc3afe672a2a14262e8303c69068715,997a159a6c0ec092f40ecadf6240e924,10cb0bbbf2fab9eaf406ff8a6e927d9b,104e349a614e24418a716ce1da04fdad,f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d,cd3f03e0eaa08524a619ac43bb735d55,3e315e261e7cde16668b94fcac2c469f,7404bb042db8f04206202357fcc7774a,d2c398974b08231aa67a130a50c01cb2,b346eb676fb28bc55656d0e11e608b89,e635323340042e108778b5170a0a21f0,b346eb676fb28bc55656d0e11e608b89,380962a21071392c6585849451241715,499c1f432e8f11a44d8da1efddbdec5c,1345bba2ef769675b6c9aff32da21def,ef9ad9a5dbb7550d49bf3bf2a1c3d22d,bff7737497f5910fa3c976a93e7e57a3,7b1f06c45ef58c37f17fda4eb8103e1a,6472ce41c26babff27b4c28028093d77,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4,8ebe43fc79c5288888cac7b7106b0045,ad9f5325bab7d34c910fc2c7bce6e65c,fb54423c392d107161ddab675631a59b,719d067b229178f03bcfa1da4ac4dede,a8b0cb5c066d2e5f3cad8be0b01ecb00', 'dsdsad,Sadsadsad', 15, 20, 0, 0, 0, 7, 1422938796, 1423543596, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(17, 'kjfhsdkf', '3', 'Note: This page is to contract a freelancer to complete a single project. If you want to post a help wanted ad to find a long-term employee/partner, please click here to post a project listing instead.<br/>', '0000-00-00', 'Algeria', 'Ballybaun', 'chennai', '', 0, '', '', 'asdas,fsdfdfsdf', 40, 60, 0, 0, 1, 7, 1422939631, 1424149231, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(18, 'milesss', '3', 'Note: This page is to contract a freelancer to complete a single project. If you want to post a help wanted ad to find a long-term employee/partner, please click here to post a project listing instead.\r\n\r\nACCOUNT LOGIN DETAILS...<br/>', '0000-00-00', 'Anguilla', 'Ballybaun', 'chennai', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer,Self Paced Training,Enterprise Organization,Hiring,Talent Management,Payment Systems,Employment Law regulations,Employee Motivation,Wage accounting,Public Relations,Internal Communication,Employee Information,Translation Service,Problem Definition,Idea Generation,Idea Selection,Idea Implementation,Production Planning,Sequencing,Production,Know How Management,Employee Recognition,Autonomous Workgroups,Supply Chain Management,Purchasing,Warehouse,Distribution,Factory Layout,Time and Motion Studies,Material Flow,Headcount,Incentive Systems,Shift Systems,Continous Improvement,PDCA,Idea Management,Key Performance Indicator (KPI),Method Development,Factory Simulation,Computer Aided Manufacturing (CAM),Job Design,Value Stream Map,Kaizen,Kanban,Poka Yoke,SMED,Workflow Optimization,Office Process Flow Optimization,Production Process Flow Optimization,PDCA/A3/8D,Know How Management,Knowledge Database,Know How Documentation,Process Documentation,Collaboration,Best Practice,Knowledge Mapping,Six Sigma,ISO 9000ff,TS 16949,VDA,QS 9000,EAQF,AVSQ,ISO 22000,HACCP,Problem Solving,Quality Statistics,Statistic Process Control (SPC),Capability Studies,Total Quality Management (TQM),Quality Function Deployment (QFD),Quality Circle,Taguchi,Kansei Engineering,Business Process Reegineering (BPR),Object Oriented Quality and Risk Management (OQRM),Quality Tools,FMEA,APQP,PPAP,Document Management,Project Management,Logistics,Market Analysis,Brand Management,Market Research,Pricing,Promotion,Sales,After Sales Service,E-Commerce,Distribution,Consumer Theory,Economics,Advertising,Patent rights,Start up,Employer Obligations,Employee Rights,Maintenance,Machine procurement,Project Management,Machine Development,Automation Technologies,Transport Systems,Technical Documentation,Material Research,Process Research,Material Development,Process Development,Machine Development,Method Development,Software Development,Organization Development,Vision/Mission Development,Balanced Scorecard,Decission Making,Controlling,Treasury,Insurance,Tax,Business Coaching,Executive Coaching,Control Theory,Expat Coaching,Career Coaching,Financial Coaching,Career Coaching,Personal Coaching,Style Coaching,Systemic Coaching,Energy Saving,Enviromental Protection,Environmental Certification,Safety,SAP,ERP,SCADA,OPC,Controls & Drives,Software,IT Infrastructure', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,4372889b77c08a18e6c7678959dfae5f,ad47487ba9f55206809cda9b8c26970e,098dffccb099681e86da846acfc18f82,f9c8caf36e4edd9019ad377a3e5913f9,31b0ec3b99b07738721de18143026073,605710b2b9973ce56e579e7fe7ca40bd,9f605b329a26309b79602288ca91566e,97ac0992b3214632ef41a3075b0c6e9b,00251b5dece63be7afb8f5fcdd3e83ce,5ae646bae06e16daec5fa3612e1444a2,54d1a8b447435ee325e306b8a58f58c9,1f2e4e60dc657345243d64f97fb1bbfe,26e11ac3f33f80d997e361a593645a11,f87cc7da43b9e091d3860ddea56d5cca,643ad5bde5f29c59d835653f105d74c7,4c89dbee82b7b1dd9d379c2d00562947,f770364d234fdd52dafa02b6e16f3fb6,756d97bb256b8580d4d71ee0c547804e,5368b55efe0fdf484d59fced5bdf8fc7,547d767efe9c787101db5cf00e485e60,793cb79980d3fa094ef13dcf866c482a,bd5476e8f33749530f87777476eeda72,5f95f5c48171ba26e9f8aa9d8c7ce6c4,6416e8cb5fc0a208d94fa7f5a300dbc4,f0bac093bb884df2891d32385d053788,0071d27c3fcd29f13466286ba27549f1,45fc8de324847819ee095188817556ea,178a871d63ced55a2a1245794348a740,7143e90e4612aa3b540583722ae15d4c,10292e05addacebdb23b68a122ce92bf,07d29f397a557ef1fa21c012675df35b,1f04b185d898e6cd1ea20be2459f1a2f,d43226ef4371e98a283f50db3069037e,cab4b63c8575bbd3a342b5fbad426339,22f1c6f52c654280e8091ebba7912a4f,e17258ab2bd1400d4492aed7407801c9,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,11c5be36641bc05b251dac68b2243b3a,d81ecc4e96ad229a33764b7e2182f6ee,2a694503a666ca6d33d0d8e0de261af3,e4ff0b8025c94e620fcf21095812d891,33ae0b4428adfa3ceea9f35bdc6a1a07,5368b55efe0fdf484d59fced5bdf8fc7,1fadb673213c21e8b380f22fa60a87fa,cae286e917b10ab8e6b67028f587fef5,30d14e12406a7580919dce129f5b4b70,337e8f4aa741ef97ec3ed8fd7b1accb7,39d9903201320a83d45d3b36d512f051,e58ca0ad724728414e09d0fe31575380,f07975a00f5b3d1e025709beaf8958db,cc007258ed6ad7c5f333ab4c9fcc3d58,f005154db5e4a784e86ddd52a325b7e1,82f11e8df84d4b474718abcaaadf7f0e,c2b3cbff032f7dc67086a8bb3868132a,29d45de4626630a95dccf42d97c8a52c,23d574908eb584d0340bad2f92123783,0810b9dab1e5f9165452b688fc237160,c38d1935edec2f6cf463602abdfbabf0,6a03a97072a01181059654e8389b992e,53ddc4f8e376c0be7f0f2165eae761bc,8aba034abd1545772ac75f305ef5e73c,960ceabd53770a66b60398b278698c07,60633124df065496444d63301ad9bbbf,cb20a6a674789289063f69aaceeeeee2,b3b607ce1da0ff572e5cfe191b6b601f,b03f732d0b64bf01947a595828fe0888,ee8222c94dcd7d3c1d20cf33edd86ffd,7bf848c679d5474b18c355a3b84e9f9c,c0a422495f053de689303175bda764e7,c2f1f4cbc26e018d0502ab9ef1047555,313b11a9b82d9a829f6ef0ef797aca11,7ede7cdb7772374809887807f2f41db8,d1db7a240300bcd7f59731bdab271b67,04ab7e9520f65aa6c1c1c1eb8c397873,9c1330f0dda3f188a3813b9840d1143f,68c16c941c3fb4e5dad94a7837ea7d1e,69c0225744326087a7c430c3e9bf72dc,b934621127c601f5d5b3893340e95b7c,023157b1a3d9ee4f0ed14b9801a26ac4,e22ac25b066b201473de7aa700ef5d92,626a54d37d402d449d6d7541911e0952,11ff9f68afb6b8b5b8eda218d7c83a65,d40d436df0bbeb1ba05079dd0aedc967,a9f7ecebb493e129aafb4cbfd73e85df,f0bac093bb884df2891d32385d053788,fdb40afa0d285233ba2249b2b1d3e109,7e1e3f377648773863a504d18b367ea3,2ce5fc289845ce826261032b9c6749ea,07744fec5b5a8ed1562fecd32a488416,79c8716e036aef2b15b59c04ec787d43,f22c85e9d23b0b99a63cca2720ca5f71,68a362caa596e9391b409126518e0f30,10d0de28911c5f66463b9c8783f8148a,2af2adf212edd655e2f8274304e88f9f,9c1330f0dda3f188a3813b9840d1143f,84cfca6dce7809b0f7eafaa8127e34dd,49f5799a2db35743d039f344e5834945,4e27832af76c2e7f0546182b3fbbb5b2,0fc75709621519dfa4730a0da953a784,fb6a9fd41b6dacf08edca2fed35e0ce1,41643b5dfdbaa1cb3e1d6ce39fe59c5a,2da2bb28a9c28d8b9b60062e0535e99f,7170bf578f2ee33a8e998acf46a7eb01,84cfca6dce7809b0f7eafaa8127e34dd,d43226ef4371e98a283f50db3069037e,f287f429e4026672e5754c1201691e49,423b89e54151ef282fc4441fd7e9d292,1bc3afe672a2a14262e8303c69068715,997a159a6c0ec092f40ecadf6240e924,10cb0bbbf2fab9eaf406ff8a6e927d9b,104e349a614e24418a716ce1da04fdad,f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d,cd3f03e0eaa08524a619ac43bb735d55,3e315e261e7cde16668b94fcac2c469f,7404bb042db8f04206202357fcc7774a,d2c398974b08231aa67a130a50c01cb2,b346eb676fb28bc55656d0e11e608b89,e635323340042e108778b5170a0a21f0,b346eb676fb28bc55656d0e11e608b89,380962a21071392c6585849451241715,499c1f432e8f11a44d8da1efddbdec5c,1345bba2ef769675b6c9aff32da21def,ef9ad9a5dbb7550d49bf3bf2a1c3d22d,bff7737497f5910fa3c976a93e7e57a3,7b1f06c45ef58c37f17fda4eb8103e1a,6472ce41c26babff27b4c28028093d77,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4,8ebe43fc79c5288888cac7b7106b0045,ad9f5325bab7d34c910fc2c7bce6e65c,fb54423c392d107161ddab675631a59b,719d067b229178f03bcfa1da4ac4dede,a8b0cb5c066d2e5f3cad8be0b01ecb00', 'saSADSA,DSADSAD', 40, 60, 1, 0, 0, 7, 1422943273, 1423548073, 8, '5bff4b58145054357f08f0ccbc7fb665', '0', '0', '0', 1423188093, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(19, 'milesss1', '3', 'Note: This page is to contract a freelancer to complete a single project. If you want to post a help wanted ad to find a long-term employee/partner, please click here to post a project listing instead.\r\n\r\nACCOUNT LOGIN DETAILS...<br/><br/>', '0000-00-00', 'Anguilla', 'Ballybaun', 'chennai', '1', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer,Self Paced Training,Enterprise Organization,Hiring,Talent Management,Payment Systems,Employment Law regulations,Employee Motivation,Wage accounting,Public Relations,Internal Communication,Employee Information,Translation Service,Problem Definition,Idea Generation,Idea Selection,Idea Implementation,Production Planning,Sequencing,Production,Know How Management,Employee Recognition,Autonomous Workgroups,Supply Chain Management,Purchasing,Warehouse,Distribution,Factory Layout,Time and Motion Studies,Material Flow,Headcount,Incentive Systems,Shift Systems,Continous Improvement,PDCA,Idea Management,Work in Process (WIP),Key Performance Indicator (KPI),Method Development,Factory Simulation,Computer Aided Manufacturing (CAM),Job Design,Value Stream Map,5s,7 Wastes,Kaizen,Kanban,Poka Yoke,SMED,Workflow Optimization,Office Process Flow Optimization,Production Process Flow Optimization,PDCA/A3/8D,Know How Management,Knowledge Database,Know How Documentation,Process Documentation,Collaboration,Best Practice,Knowledge Mapping,Six Sigma,ISO 9000ff,TS 16949,VDA,QS 9000,EAQF,AVSQ,ISO 22000,HACCP,Problem Solving,Quality Statistics,Statistic Process Control (SPC),Capability Studies,Total Quality Management (TQM),Quality Function Deployment (QFD),Quality Circle,Taguchi,Kansei Engineering,Business Process Reegineering (BPR),Object Oriented Quality and Risk Management (OQRM),Quality Tools,FMEA,APQP,PPAP,Document Management,Project Management,Logistics,Market Analysis,Brand Management,Market Research,Pricing,Promotion,Sales,After Sales Service,E-Commerce,Distribution,Consumer Theory,Economics,Advertising,Patent rights,Start up,Employer Obligations,Employee Rights,Maintenance,Machine procurement,Project Management,Machine Development,Automation Technologies,Transport Systems,Technical Documentation,Material Research,Process Research,Material Development,Process Development,Machine Development,Method Development,Software Development,One on One Training,Business Development,Business Excellence,Organization Development,Vision/Mission Development,Balanced Scorecard,Decission Making,Accounting,Controlling,Treasury,Insurance,Tax,Business Coaching,Executive Coaching,Control Theory,Expat Coaching,Career Coaching,Financial Coaching,Career Coaching,Personal Coaching,Style Coaching,Systemic Coaching,Energy Saving,Work Condition,Enviromental Protection,Environmental Certification,Work Ergonomics,Safety,SAP,ERP,SCADA,OPC,Controls & Drives,Software,IT Infrastructure', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,4372889b77c08a18e6c7678959dfae5f,ad47487ba9f55206809cda9b8c26970e,098dffccb099681e86da846acfc18f82,f9c8caf36e4edd9019ad377a3e5913f9,31b0ec3b99b07738721de18143026073,605710b2b9973ce56e579e7fe7ca40bd,9f605b329a26309b79602288ca91566e,97ac0992b3214632ef41a3075b0c6e9b,00251b5dece63be7afb8f5fcdd3e83ce,5ae646bae06e16daec5fa3612e1444a2,54d1a8b447435ee325e306b8a58f58c9,1f2e4e60dc657345243d64f97fb1bbfe,26e11ac3f33f80d997e361a593645a11,f87cc7da43b9e091d3860ddea56d5cca,643ad5bde5f29c59d835653f105d74c7,4c89dbee82b7b1dd9d379c2d00562947,f770364d234fdd52dafa02b6e16f3fb6,756d97bb256b8580d4d71ee0c547804e,5368b55efe0fdf484d59fced5bdf8fc7,547d767efe9c787101db5cf00e485e60,793cb79980d3fa094ef13dcf866c482a,bd5476e8f33749530f87777476eeda72,5f95f5c48171ba26e9f8aa9d8c7ce6c4,6416e8cb5fc0a208d94fa7f5a300dbc4,f0bac093bb884df2891d32385d053788,0071d27c3fcd29f13466286ba27549f1,45fc8de324847819ee095188817556ea,178a871d63ced55a2a1245794348a740,7143e90e4612aa3b540583722ae15d4c,10292e05addacebdb23b68a122ce92bf,07d29f397a557ef1fa21c012675df35b,1f04b185d898e6cd1ea20be2459f1a2f,d43226ef4371e98a283f50db3069037e,cab4b63c8575bbd3a342b5fbad426339,22f1c6f52c654280e8091ebba7912a4f,e17258ab2bd1400d4492aed7407801c9,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,11c5be36641bc05b251dac68b2243b3a,d81ecc4e96ad229a33764b7e2182f6ee,2a694503a666ca6d33d0d8e0de261af3,e4ff0b8025c94e620fcf21095812d891,33ae0b4428adfa3ceea9f35bdc6a1a07,5368b55efe0fdf484d59fced5bdf8fc7,1fadb673213c21e8b380f22fa60a87fa,cae286e917b10ab8e6b67028f587fef5,30d14e12406a7580919dce129f5b4b70,337e8f4aa741ef97ec3ed8fd7b1accb7,39d9903201320a83d45d3b36d512f051,e58ca0ad724728414e09d0fe31575380,f07975a00f5b3d1e025709beaf8958db,cc007258ed6ad7c5f333ab4c9fcc3d58,f005154db5e4a784e86ddd52a325b7e1,82f11e8df84d4b474718abcaaadf7f0e,c2b3cbff032f7dc67086a8bb3868132a,29d45de4626630a95dccf42d97c8a52c,23d574908eb584d0340bad2f92123783,0810b9dab1e5f9165452b688fc237160,c38d1935edec2f6cf463602abdfbabf0,6a03a97072a01181059654e8389b992e,53ddc4f8e376c0be7f0f2165eae761bc,8aba034abd1545772ac75f305ef5e73c,960ceabd53770a66b60398b278698c07,60633124df065496444d63301ad9bbbf,cb20a6a674789289063f69aaceeeeee2,b3b607ce1da0ff572e5cfe191b6b601f,b03f732d0b64bf01947a595828fe0888,ee8222c94dcd7d3c1d20cf33edd86ffd,7bf848c679d5474b18c355a3b84e9f9c,c0a422495f053de689303175bda764e7,c2f1f4cbc26e018d0502ab9ef1047555,313b11a9b82d9a829f6ef0ef797aca11,7ede7cdb7772374809887807f2f41db8,d1db7a240300bcd7f59731bdab271b67,04ab7e9520f65aa6c1c1c1eb8c397873,9c1330f0dda3f188a3813b9840d1143f,68c16c941c3fb4e5dad94a7837ea7d1e,69c0225744326087a7c430c3e9bf72dc,b934621127c601f5d5b3893340e95b7c,023157b1a3d9ee4f0ed14b9801a26ac4,e22ac25b066b201473de7aa700ef5d92,626a54d37d402d449d6d7541911e0952,11ff9f68afb6b8b5b8eda218d7c83a65,d40d436df0bbeb1ba05079dd0aedc967,a9f7ecebb493e129aafb4cbfd73e85df,f0bac093bb884df2891d32385d053788,fdb40afa0d285233ba2249b2b1d3e109,7e1e3f377648773863a504d18b367ea3,2ce5fc289845ce826261032b9c6749ea,07744fec5b5a8ed1562fecd32a488416,79c8716e036aef2b15b59c04ec787d43,f22c85e9d23b0b99a63cca2720ca5f71,68a362caa596e9391b409126518e0f30,10d0de28911c5f66463b9c8783f8148a,2af2adf212edd655e2f8274304e88f9f,9c1330f0dda3f188a3813b9840d1143f,84cfca6dce7809b0f7eafaa8127e34dd,49f5799a2db35743d039f344e5834945,4e27832af76c2e7f0546182b3fbbb5b2,0fc75709621519dfa4730a0da953a784,fb6a9fd41b6dacf08edca2fed35e0ce1,41643b5dfdbaa1cb3e1d6ce39fe59c5a,2da2bb28a9c28d8b9b60062e0535e99f,7170bf578f2ee33a8e998acf46a7eb01,84cfca6dce7809b0f7eafaa8127e34dd,d43226ef4371e98a283f50db3069037e,f287f429e4026672e5754c1201691e49,423b89e54151ef282fc4441fd7e9d292,1bc3afe672a2a14262e8303c69068715,997a159a6c0ec092f40ecadf6240e924,10cb0bbbf2fab9eaf406ff8a6e927d9b,104e349a614e24418a716ce1da04fdad,f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d,cd3f03e0eaa08524a619ac43bb735d55,3e315e261e7cde16668b94fcac2c469f,7404bb042db8f04206202357fcc7774a,d2c398974b08231aa67a130a50c01cb2,b346eb676fb28bc55656d0e11e608b89,e635323340042e108778b5170a0a21f0,b346eb676fb28bc55656d0e11e608b89,380962a21071392c6585849451241715,499c1f432e8f11a44d8da1efddbdec5c,1345bba2ef769675b6c9aff32da21def,ef9ad9a5dbb7550d49bf3bf2a1c3d22d,bff7737497f5910fa3c976a93e7e57a3,7b1f06c45ef58c37f17fda4eb8103e1a,6472ce41c26babff27b4c28028093d77,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4,8ebe43fc79c5288888cac7b7106b0045,ad9f5325bab7d34c910fc2c7bce6e65c,fb54423c392d107161ddab675631a59b,719d067b229178f03bcfa1da4ac4dede,a8b0cb5c066d2e5f3cad8be0b01ecb00', 'DSADSAD,heyyyyyyyyyy', 40, 60, 1, 0, 0, 7, 1422950534, 1424824303, 8, 'abd68a2f934f058c5a319165ab867fb0', '0', '0', '0', 1423104666, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(20, 'My test for mile stone', '3', 'Tessdfjkshfkjshdfkjshfkj shfkjshfkjshfkjshfkjshfkjshfkjshfkjsfsfsfsfasfasfas<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '0', 0, '', '', '', 0, 100, 0, 0, 0, 7, 1423274602, 1424484202, 8, '2b0771e8d134c6c02c7a5661bc4a722e', '0', '0', '0', 1423826788, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(21, 'My test for mile stone 1', '3', 'dsfsgdfsdgdfsgdfhb db fdgdfgds gdgdsgdsgdsgdsgdgdsgsdgdsgsd<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, '', '', '', 0, 100, 0, 0, 0, 7, 1423277720, 1424487320, 8, '936b9ceea60a329fde51decb617961d6', '0', '0', '0', 1423281008, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(22, 'demo 1 for testing', '3', 'dsdsaffassa sfgsgdsgdsg dgdsg dgdsgsdgdsgdsg dgds gdgdsgdsgd<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, '', '', '', 0, 30, 0, 0, 0, 7, 1423447457, 1424657057, 8, '4f108061d3501f4e972e7b320a63c190', '0', '0', '0', 1423448146, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(23, 'demo 2 for testing', '3', 'sdfdsfdfgh gdfhdfh fdhdfh fhfhf hdfh fddgdfg<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, '', '', '', 0, 30, 0, 0, 0, 7, 1423448454, 1424658054, 8, 'e7858789b563a464bd4c7e9ff104f3d0', '0', '0', '0', 1423448819, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(24, 'demo 3 for testing', '3', 'jhsdfjhsufh jfdshfuish fhsuhfuis hfshfuishfuishf<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, '', '', '', 0, 30, 0, 0, 0, 7, 1423449752, 1424659352, 8, '7d048d1fe96bd7315240f710f6c367d1', '0', '0', '0', 1423454787, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(25, 'Test Project For document', '3', 'dsfsd sfs sfs fsfs sfsdfsf sfsfs fsfsfs ssdf<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, '', '', '', 0, 10, 0, 0, 0, 7, 1423557991, 1424767591, 8, '8a452b608349f2e2fa6f38b71dd1c6dc', '1', '0', '0', 1423559023, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(26, 'Overall Testing', '3', 'sdfdfsdfffaf sdf sfsfasfsf sfsfsfsaf fs fsfsafas fsf fsf sfsaf fasf afsdsf<br/>', '0000-00-00', 'India', 'Tamilnadu', 'madurai', '1', 0, 'Mentoring,On the Job Training,University/Classroom,Payment Systems,Employee Motivation,SAP,ERP', '089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,f9c8caf36e4edd9019ad377a3e5913f9,605710b2b9973ce56e579e7fe7ca40bd,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4', '', 10, 20, 0, 1, 1, 7, 1423725918, 1424935518, 0, '', '0', '0', '0', 0, 0, '7f7ba6cc51b1acc8fd2a1273a9c7d648.docx', 'WHEN_LIFE.docx', '', '', '', '', 1, '8', '', '', 0, '', 0, '', 0),
(27, 'Overall Testing 1', '3', 'hgdhsgfh hjsdgfh gshjfghjsd gfhjsdgfdhjs gdhjsgfhjsdgfhjsdg hjsghjsgf  <br/>', '0000-00-00', 'India', 'Tamilnadu', 'madurai', '2', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer,Self Paced Training', '4372889b77c08a18e6c7678959dfae5f,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,4372889b77c08a18e6c7678959dfae5f', '', 10, 20, 1, 1, 0, 7, 1425283348, 1426492948, 8, '6d2e16e72ed1f58b9b298a03a1709f2a', '0', '0', '0', 1424071391, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(28, 'Kanban production planning', '3', 'Our actual push system have to be replaced by a Kanban pull system to increase the efficiency and the output of our production.<br/>', '0000-00-00', 'United States', 'SC', 'Columbia', '1', 0, '', '', '', 0, 10, 1, 0, 0, 4, 1425154995, 1426364595, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(29, 'Overall Testing 2', '3', 'asd asd asdasdadadasdasdasdad dada sdasdasdada<br/>', '0000-00-00', 'India', 'Tamilnadu', 'chennai', '1', 0, '', '', '', 10, 20, 1, 0, 0, 7, 1425280111, 1426489711, 8, 'cd2fb77f866408cece3183e233112bce', '0', '0', '0', 1425282144, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(30, 'Overall Testing 3', '3', 'sdfd dsf sdfdsfsfs fds sdfdsfsfsd fsfsfsfsfsff sfsfsfssfsfsf<br/>', '0000-00-00', 'India', 'Tamilnadu', 'chennai', '1', 1, 'Public Relations,Internal Communication,Employee Information,Translation Service', '97ac0992b3214632ef41a3075b0c6e9b,00251b5dece63be7afb8f5fcdd3e83ce,5ae646bae06e16daec5fa3612e1444a2,54d1a8b447435ee325e306b8a58f58c9', '', 10, 20, 1, 1, 1, 7, 1425283439, 1426493039, 8, '72d12fb4c102c73719665063a6a78597', '0', '0', '0', 1429770989, 1, '', NULL, '', '', '', '', 1, '8', '', '', 0, '', 0, '', 0),
(31, 'Milestone issue', '3', 'sdfsdfsf asdfsfsfsdf safsad fdasfdsafasf<br/>', '0000-00-00', 'India', 'Tamilnadu', 'madurai', '1', 1, 'On the Job Training,University/Classroom', '45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1', '', 10, 20, 0, 0, 0, 7, 1425285938, 1426495538, 8, '4e475f826952e69994d0b0f441254660', '0', '0', '0', 1425291315, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(32, 'MIlestone Testing', '3', 'fds sdfsd sdfs sfsfsa fsfsafsafs fsafsafsafsaf<br/>', '0000-00-00', 'India', 'Tamilnadu', 'madurai', '1', 0, '', '', '', 10, 20, 0, 0, 0, 7, 1425290686, 1426500286, 8, '0d8a5ae4d037b91522733ee761277dcf', '0', '0', '0', 1426756183, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(38, 'URL Testing', '3', 'dsdsfsfsfs sdfsfsfsfsfs sdfsdfsfsfsfs sfsfsfsfssf fsfs fsfs fsfsfsf<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '2', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer,Self Paced Training,Hiring,Talent Management,Payment Systems,Employment Law regulations,Employee Motivation,Wage accounting,Public Relations,Internal Communication,Employee Information,Translation Service,Problem Definition,Idea Generation,Idea Selection,Idea Implementation,Production Planning,Sequencing,Production,Know How Management,Employee Recognition,Autonomous Workgroups,Supply Chain Management,Purchasing,Warehouse,Distribution,Factory Layout,Incentive Systems,Shift Systems,Continous Improvement,PDCA,Idea Management,Key Performance Indicator (KPI),Method Development,Factory Simulation,Computer Aided Manufacturing (CAM),Job Design,Value Stream Map,Kaizen,Kanban,Poka Yoke,SMED,Workflow Optimization,Office Process Flow Optimization,Production Process Flow Optimization,PDCA/A3/8D,Know How Management,Knowledge Database,Know How Documentation,Process Documentation,Collaboration,Best Practice,Knowledge Mapping,Six Sigma,ISO 9000ff,TS 16949,VDA,QS 9000,EAQF,AVSQ,ISO 22000,HACCP,Problem Solving,Quality Statistics,Statistic Process Control (SPC),Capability Studies,Total Quality Management (TQM),Quality Function Deployment (QFD),Quality Circle,Taguchi,Kansei Engineering,Business Process Reegineering (BPR),Object Oriented Quality and Risk Management (OQRM),Quality Tools,FMEA,APQP,PPAP,Document Management,Project Management,Logistics,Market Analysis,Brand Management,Market Research,Pricing,Promotion,Sales,After Sales Service,E-Commerce,Distribution,Consumer Theory,Economics,Advertising,Patent rights,Start up,Employer Obligations,Employee Rights,Maintenance,Machine procurement,Project Management,Machine Development,Automation Technologies,Transport Systems,Technical Documentation,Material Research,Process Research,Material Development,Process Development,Machine Development,Method Development,Software Development,Organization Development,Vision/Mission Development,Balanced Scorecard,Decission Making,Enterprise Organization,Controlling,Treasury,Insurance,Tax,Business Coaching,Executive Coaching,Control Theory,Expat Coaching,Career Coaching,Financial Coaching,Career Coaching,Personal Coaching,Style Coaching,Systemic Coaching,Energy Saving,Enviromental Protection,Environmental Certification,Safety,SAP,ERP,SCADA,OPC,Controls & Drives,Software,IT Infrastructure', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,4372889b77c08a18e6c7678959dfae5f,ad47487ba9f55206809cda9b8c26970e,098dffccb099681e86da846acfc18f82,f9c8caf36e4edd9019ad377a3e5913f9,31b0ec3b99b07738721de18143026073,605710b2b9973ce56e579e7fe7ca40bd,9f605b329a26309b79602288ca91566e,97ac0992b3214632ef41a3075b0c6e9b,00251b5dece63be7afb8f5fcdd3e83ce,5ae646bae06e16daec5fa3612e1444a2,54d1a8b447435ee325e306b8a58f58c9,1f2e4e60dc657345243d64f97fb1bbfe,26e11ac3f33f80d997e361a593645a11,f87cc7da43b9e091d3860ddea56d5cca,643ad5bde5f29c59d835653f105d74c7,4c89dbee82b7b1dd9d379c2d00562947,f770364d234fdd52dafa02b6e16f3fb6,756d97bb256b8580d4d71ee0c547804e,5368b55efe0fdf484d59fced5bdf8fc7,547d767efe9c787101db5cf00e485e60,793cb79980d3fa094ef13dcf866c482a,bd5476e8f33749530f87777476eeda72,5f95f5c48171ba26e9f8aa9d8c7ce6c4,6416e8cb5fc0a208d94fa7f5a300dbc4,f0bac093bb884df2891d32385d053788,0071d27c3fcd29f13466286ba27549f1,45fc8de324847819ee095188817556ea,178a871d63ced55a2a1245794348a740,7143e90e4612aa3b540583722ae15d4c,10292e05addacebdb23b68a122ce92bf,07d29f397a557ef1fa21c012675df35b,1f04b185d898e6cd1ea20be2459f1a2f,d43226ef4371e98a283f50db3069037e,cab4b63c8575bbd3a342b5fbad426339,22f1c6f52c654280e8091ebba7912a4f,e17258ab2bd1400d4492aed7407801c9,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,11c5be36641bc05b251dac68b2243b3a,d81ecc4e96ad229a33764b7e2182f6ee,2a694503a666ca6d33d0d8e0de261af3,e4ff0b8025c94e620fcf21095812d891,33ae0b4428adfa3ceea9f35bdc6a1a07,5368b55efe0fdf484d59fced5bdf8fc7,1fadb673213c21e8b380f22fa60a87fa,cae286e917b10ab8e6b67028f587fef5,30d14e12406a7580919dce129f5b4b70,337e8f4aa741ef97ec3ed8fd7b1accb7,39d9903201320a83d45d3b36d512f051,e58ca0ad724728414e09d0fe31575380,f07975a00f5b3d1e025709beaf8958db,cc007258ed6ad7c5f333ab4c9fcc3d58,f005154db5e4a784e86ddd52a325b7e1,82f11e8df84d4b474718abcaaadf7f0e,c2b3cbff032f7dc67086a8bb3868132a,29d45de4626630a95dccf42d97c8a52c,23d574908eb584d0340bad2f92123783,0810b9dab1e5f9165452b688fc237160,c38d1935edec2f6cf463602abdfbabf0,6a03a97072a01181059654e8389b992e,53ddc4f8e376c0be7f0f2165eae761bc,8aba034abd1545772ac75f305ef5e73c,960ceabd53770a66b60398b278698c07,60633124df065496444d63301ad9bbbf,cb20a6a674789289063f69aaceeeeee2,b3b607ce1da0ff572e5cfe191b6b601f,b03f732d0b64bf01947a595828fe0888,ee8222c94dcd7d3c1d20cf33edd86ffd,7bf848c679d5474b18c355a3b84e9f9c,c0a422495f053de689303175bda764e7,c2f1f4cbc26e018d0502ab9ef1047555,313b11a9b82d9a829f6ef0ef797aca11,7ede7cdb7772374809887807f2f41db8,d1db7a240300bcd7f59731bdab271b67,04ab7e9520f65aa6c1c1c1eb8c397873,9c1330f0dda3f188a3813b9840d1143f,68c16c941c3fb4e5dad94a7837ea7d1e,69c0225744326087a7c430c3e9bf72dc,b934621127c601f5d5b3893340e95b7c,023157b1a3d9ee4f0ed14b9801a26ac4,e22ac25b066b201473de7aa700ef5d92,626a54d37d402d449d6d7541911e0952,11ff9f68afb6b8b5b8eda218d7c83a65,d40d436df0bbeb1ba05079dd0aedc967,a9f7ecebb493e129aafb4cbfd73e85df,f0bac093bb884df2891d32385d053788,fdb40afa0d285233ba2249b2b1d3e109,7e1e3f377648773863a504d18b367ea3,2ce5fc289845ce826261032b9c6749ea,07744fec5b5a8ed1562fecd32a488416,79c8716e036aef2b15b59c04ec787d43,f22c85e9d23b0b99a63cca2720ca5f71,68a362caa596e9391b409126518e0f30,10d0de28911c5f66463b9c8783f8148a,2af2adf212edd655e2f8274304e88f9f,9c1330f0dda3f188a3813b9840d1143f,84cfca6dce7809b0f7eafaa8127e34dd,49f5799a2db35743d039f344e5834945,4e27832af76c2e7f0546182b3fbbb5b2,0fc75709621519dfa4730a0da953a784,fb6a9fd41b6dacf08edca2fed35e0ce1,41643b5dfdbaa1cb3e1d6ce39fe59c5a,2da2bb28a9c28d8b9b60062e0535e99f,7170bf578f2ee33a8e998acf46a7eb01,84cfca6dce7809b0f7eafaa8127e34dd,d43226ef4371e98a283f50db3069037e,f287f429e4026672e5754c1201691e49,423b89e54151ef282fc4441fd7e9d292,1bc3afe672a2a14262e8303c69068715,997a159a6c0ec092f40ecadf6240e924,10cb0bbbf2fab9eaf406ff8a6e927d9b,104e349a614e24418a716ce1da04fdad,f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d,cd3f03e0eaa08524a619ac43bb735d55,3e315e261e7cde16668b94fcac2c469f,7404bb042db8f04206202357fcc7774a,d2c398974b08231aa67a130a50c01cb2,b346eb676fb28bc55656d0e11e608b89,e635323340042e108778b5170a0a21f0,b346eb676fb28bc55656d0e11e608b89,380962a21071392c6585849451241715,499c1f432e8f11a44d8da1efddbdec5c,1345bba2ef769675b6c9aff32da21def,ef9ad9a5dbb7550d49bf3bf2a1c3d22d,bff7737497f5910fa3c976a93e7e57a3,7b1f06c45ef58c37f17fda4eb8103e1a,6472ce41c26babff27b4c28028093d77,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4,8ebe43fc79c5288888cac7b7106b0045,ad9f5325bab7d34c910fc2c7bce6e65c,fb54423c392d107161ddab675631a59b,719d067b229178f03bcfa1da4ac4dede,a8b0cb5c066d2e5f3cad8be0b01ecb00', '', 9, 20, 0, 0, 0, 7, 1425462510, 1426672110, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0);
INSERT INTO `jobs` (`id`, `job_name`, `job_status`, `description`, `due_date`, `country`, `state`, `city`, `milestone`, `mile_notify`, `job_categories`, `job_categories_encrypt`, `manual_job`, `budget_min`, `budget_max`, `is_feature`, `is_urgent`, `is_hide_bids`, `creator_id`, `created`, `enddate`, `employee_id`, `checkstamp`, `owner_rated`, `employee_rated`, `job_paid`, `job_award_date`, `notification_status`, `attachment_url`, `attachment_name`, `attachment_url1`, `attachment_name1`, `attachment_url2`, `attachment_name2`, `is_private`, `private_users`, `contact`, `salary`, `flag`, `salarytype`, `escrow_due`, `invite_suppliers`, `team_member_id`) VALUES
(39, 'URL Testing 1', '3', 'dsfsfsfs sdfsfsfsf sdfsfsfsf sdfsfsfs sdfsfsfs sdfsfsfsf sfsfsfsf<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer,Self Paced Training,Hiring,Talent Management,Payment Systems,Employment Law regulations,Employee Motivation,Wage accounting,Public Relations,Internal Communication,Employee Information,Translation Service,Problem Definition,Idea Generation,Idea Selection,Idea Implementation,Production Planning,Sequencing,Production,Know How Management,Employee Recognition,Autonomous Workgroups,Supply Chain Management,Purchasing,Warehouse,Distribution,Factory Layout,Incentive Systems,Shift Systems,Continous Improvement,PDCA,Idea Management,Key Performance Indicator (KPI),Method Development,Factory Simulation,Computer Aided Manufacturing (CAM),Job Design,Value Stream Map,Kaizen,Kanban,Poka Yoke,SMED,Workflow Optimization,Office Process Flow Optimization,Production Process Flow Optimization,PDCA/A3/8D,Know How Management,Knowledge Database,Know How Documentation,Process Documentation,Collaboration,Best Practice,Knowledge Mapping,Six Sigma,ISO 9000ff,TS 16949,VDA,QS 9000,EAQF,AVSQ,ISO 22000,HACCP,Problem Solving,Quality Statistics,Statistic Process Control (SPC),Capability Studies,Total Quality Management (TQM),Quality Function Deployment (QFD),Quality Circle,Taguchi,Kansei Engineering,Business Process Reegineering (BPR),Object Oriented Quality and Risk Management (OQRM),Quality Tools,FMEA,APQP,PPAP,Document Management,Project Management,Logistics,Market Analysis,Brand Management,Market Research,Pricing,Promotion,Sales,After Sales Service,E-Commerce,Distribution,Consumer Theory,Economics,Advertising,Patent rights,Start up,Employer Obligations,Employee Rights,Maintenance,Machine procurement,Project Management,Machine Development,Automation Technologies,Transport Systems,Technical Documentation,Material Research,Process Research,Material Development,Process Development,Machine Development,Method Development,Software Development,Organization Development,Vision/Mission Development,Balanced Scorecard,Decission Making,Enterprise Organization,Controlling,Treasury,Insurance,Tax,Business Coaching,Executive Coaching,Control Theory,Expat Coaching,Career Coaching,Financial Coaching,Career Coaching,Personal Coaching,Style Coaching,Systemic Coaching,Energy Saving,Enviromental Protection,Environmental Certification,Safety,SAP,ERP,SCADA,OPC,Controls & Drives,Software,IT Infrastructure', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,4372889b77c08a18e6c7678959dfae5f,ad47487ba9f55206809cda9b8c26970e,098dffccb099681e86da846acfc18f82,f9c8caf36e4edd9019ad377a3e5913f9,31b0ec3b99b07738721de18143026073,605710b2b9973ce56e579e7fe7ca40bd,9f605b329a26309b79602288ca91566e,97ac0992b3214632ef41a3075b0c6e9b,00251b5dece63be7afb8f5fcdd3e83ce,5ae646bae06e16daec5fa3612e1444a2,54d1a8b447435ee325e306b8a58f58c9,1f2e4e60dc657345243d64f97fb1bbfe,26e11ac3f33f80d997e361a593645a11,f87cc7da43b9e091d3860ddea56d5cca,643ad5bde5f29c59d835653f105d74c7,4c89dbee82b7b1dd9d379c2d00562947,f770364d234fdd52dafa02b6e16f3fb6,756d97bb256b8580d4d71ee0c547804e,5368b55efe0fdf484d59fced5bdf8fc7,547d767efe9c787101db5cf00e485e60,793cb79980d3fa094ef13dcf866c482a,bd5476e8f33749530f87777476eeda72,5f95f5c48171ba26e9f8aa9d8c7ce6c4,6416e8cb5fc0a208d94fa7f5a300dbc4,f0bac093bb884df2891d32385d053788,0071d27c3fcd29f13466286ba27549f1,45fc8de324847819ee095188817556ea,178a871d63ced55a2a1245794348a740,7143e90e4612aa3b540583722ae15d4c,10292e05addacebdb23b68a122ce92bf,07d29f397a557ef1fa21c012675df35b,1f04b185d898e6cd1ea20be2459f1a2f,d43226ef4371e98a283f50db3069037e,cab4b63c8575bbd3a342b5fbad426339,22f1c6f52c654280e8091ebba7912a4f,e17258ab2bd1400d4492aed7407801c9,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,11c5be36641bc05b251dac68b2243b3a,d81ecc4e96ad229a33764b7e2182f6ee,2a694503a666ca6d33d0d8e0de261af3,e4ff0b8025c94e620fcf21095812d891,33ae0b4428adfa3ceea9f35bdc6a1a07,5368b55efe0fdf484d59fced5bdf8fc7,1fadb673213c21e8b380f22fa60a87fa,cae286e917b10ab8e6b67028f587fef5,30d14e12406a7580919dce129f5b4b70,337e8f4aa741ef97ec3ed8fd7b1accb7,39d9903201320a83d45d3b36d512f051,e58ca0ad724728414e09d0fe31575380,f07975a00f5b3d1e025709beaf8958db,cc007258ed6ad7c5f333ab4c9fcc3d58,f005154db5e4a784e86ddd52a325b7e1,82f11e8df84d4b474718abcaaadf7f0e,c2b3cbff032f7dc67086a8bb3868132a,29d45de4626630a95dccf42d97c8a52c,23d574908eb584d0340bad2f92123783,0810b9dab1e5f9165452b688fc237160,c38d1935edec2f6cf463602abdfbabf0,6a03a97072a01181059654e8389b992e,53ddc4f8e376c0be7f0f2165eae761bc,8aba034abd1545772ac75f305ef5e73c,960ceabd53770a66b60398b278698c07,60633124df065496444d63301ad9bbbf,cb20a6a674789289063f69aaceeeeee2,b3b607ce1da0ff572e5cfe191b6b601f,b03f732d0b64bf01947a595828fe0888,ee8222c94dcd7d3c1d20cf33edd86ffd,7bf848c679d5474b18c355a3b84e9f9c,c0a422495f053de689303175bda764e7,c2f1f4cbc26e018d0502ab9ef1047555,313b11a9b82d9a829f6ef0ef797aca11,7ede7cdb7772374809887807f2f41db8,d1db7a240300bcd7f59731bdab271b67,04ab7e9520f65aa6c1c1c1eb8c397873,9c1330f0dda3f188a3813b9840d1143f,68c16c941c3fb4e5dad94a7837ea7d1e,69c0225744326087a7c430c3e9bf72dc,b934621127c601f5d5b3893340e95b7c,023157b1a3d9ee4f0ed14b9801a26ac4,e22ac25b066b201473de7aa700ef5d92,626a54d37d402d449d6d7541911e0952,11ff9f68afb6b8b5b8eda218d7c83a65,d40d436df0bbeb1ba05079dd0aedc967,a9f7ecebb493e129aafb4cbfd73e85df,f0bac093bb884df2891d32385d053788,fdb40afa0d285233ba2249b2b1d3e109,7e1e3f377648773863a504d18b367ea3,2ce5fc289845ce826261032b9c6749ea,07744fec5b5a8ed1562fecd32a488416,79c8716e036aef2b15b59c04ec787d43,f22c85e9d23b0b99a63cca2720ca5f71,68a362caa596e9391b409126518e0f30,10d0de28911c5f66463b9c8783f8148a,2af2adf212edd655e2f8274304e88f9f,9c1330f0dda3f188a3813b9840d1143f,84cfca6dce7809b0f7eafaa8127e34dd,49f5799a2db35743d039f344e5834945,4e27832af76c2e7f0546182b3fbbb5b2,0fc75709621519dfa4730a0da953a784,fb6a9fd41b6dacf08edca2fed35e0ce1,41643b5dfdbaa1cb3e1d6ce39fe59c5a,2da2bb28a9c28d8b9b60062e0535e99f,7170bf578f2ee33a8e998acf46a7eb01,84cfca6dce7809b0f7eafaa8127e34dd,d43226ef4371e98a283f50db3069037e,f287f429e4026672e5754c1201691e49,423b89e54151ef282fc4441fd7e9d292,1bc3afe672a2a14262e8303c69068715,997a159a6c0ec092f40ecadf6240e924,10cb0bbbf2fab9eaf406ff8a6e927d9b,104e349a614e24418a716ce1da04fdad,f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d,cd3f03e0eaa08524a619ac43bb735d55,3e315e261e7cde16668b94fcac2c469f,7404bb042db8f04206202357fcc7774a,d2c398974b08231aa67a130a50c01cb2,b346eb676fb28bc55656d0e11e608b89,e635323340042e108778b5170a0a21f0,b346eb676fb28bc55656d0e11e608b89,380962a21071392c6585849451241715,499c1f432e8f11a44d8da1efddbdec5c,1345bba2ef769675b6c9aff32da21def,ef9ad9a5dbb7550d49bf3bf2a1c3d22d,bff7737497f5910fa3c976a93e7e57a3,7b1f06c45ef58c37f17fda4eb8103e1a,6472ce41c26babff27b4c28028093d77,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4,8ebe43fc79c5288888cac7b7106b0045,ad9f5325bab7d34c910fc2c7bce6e65c,fb54423c392d107161ddab675631a59b,719d067b229178f03bcfa1da4ac4dede,a8b0cb5c066d2e5f3cad8be0b01ecb00', '', 9, 20, 0, 0, 0, 7, 1425463114, 1426672714, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(40, 'URL Testing 2', '3', 'asdasdas dadsasd asdasdasdsadas asdasdad adadadad asdasdadd<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '2', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 9, 20, 0, 0, 0, 7, 1425542775, 1426752375, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(41, 'testcdeggh', '0', 'dg <br/>', '0000-00-00', 'United States', 'sc', 'orlando', '1', 0, '', '', '', 0, 50, 0, 0, 0, 4, 1427045957, 1428255557, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 1, NULL, '', '', 0, '', 0, '', 0),
(46, 'Test Project Private', '3', 'Private Project Private Project Private Project Private Project Private Project Private Project Private Project<br/>', '0000-00-00', 'India', 'California', 'Los Angeles', '1', 1, 'Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Value Stream Map,Kaizen,Kanban,Poka Yoke,Controlling,Treasury,Insurance,Tax', '089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d', 'Finance,IT', 10, 12, 0, 0, 0, 7, 1429493940, 1430703540, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 1, '8', '', '', 0, '', 0, '', 0),
(45, 'Project Milestone Test1', '3', 'asdd ads sda ds ad ad sadad ad sd adada d adadsad ads asd sa sad sadd adsa ad sada sad sada asd<br/>', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95', 'skill1,skill2,skill3', 10, 15, 0, 0, 0, 7, 1427263350, 1428472950, 8, 'e6679efa4d83d9ac436c3f1750fa14dd', '0', '0', '0', 1427355877, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(47, 'Test Project Private 1', '3', 'Describe the project  Describe the project  Describe the project  Describe the project  Describe the project  Describe the project  Describe the project  Describe the project  Describe the project<br/>', '0000-00-00', 'United States', 'California', 'Los Angeles', '2', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Value Stream Map,Kaizen,Kanban,Poka Yoke,SMED,Maintenance,Machine procurement,Project Management,Machine Development', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,11c5be36641bc05b251dac68b2243b3a,10d0de28911c5f66463b9c8783f8148a,2af2adf212edd655e2f8274304e88f9f,9c1330f0dda3f188a3813b9840d1143f,84cfca6dce7809b0f7eafaa8127e34dd', '', 10, 14, 0, 0, 0, 7, 1429496141, 1430705741, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 1, '17', '', '', 0, '', 0, '', 0),
(49, 'Test Project Private 2', '3', 'Test Project PrivateTest Project PrivateTest Project PrivateTest Project PrivateTest Project PrivateTest Project PrivateTest Project PrivateTest Project PrivateTest Project PrivateTest Project Private<br/>', '0000-00-00', 'United States', 'California', 'Los Angeles', '2', 1, 'Self Paced Training,Mentoring,On the Job Training', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6', '', 10, 12, 0, 0, 0, 7, 1429510365, 1430719965, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 1, '8,17', '', '', 0, '', 0, '', 0),
(50, 'Project Documentation', '3', 'Documentation Documentation Documentation Documentation Documentation Documentation Documentation Documentation Documentation Documentation Documentation Documentation Documentation<br/>', '0000-00-00', 'United States', 'California', 'Los Angeles', '1', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Value Stream Map,Kaizen,Kanban,Poka Yoke', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a', '', 10, 12, 0, 0, 0, 7, 1429771865, 1430981465, 8, '460a1c2fc782fcc4a56f3e52d06581fc', '0', '0', '0', 1429772103, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(51, 'TEST for Syed', '3', 'if this works, Syed can start using it....', '0000-00-00', 'United States', 'South Carolina', 'Myrtle Beach', '2', 1, 'Self Paced Training', '4372889b77c08a18e6c7678959dfae5f', '', 0, 100, NULL, NULL, 0, 7, 1471355018, 1472564618, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(52, 'Market place', '3', 'Describe the project in detail Describe the project in detail  Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '2', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer,Self Paced Training,Hiring,Talent Management,Payment Systems,Employment Law regulations,Employee Motivation,Wage accounting,Public Relations,Internal Communication,Employee Information,Translation Service,Problem Definition,Idea Generation,Idea Selection,Idea Implementation,Production Planning,Sequencing,Production,Know How Management,Employee Recognition,Autonomous Workgroups,Supply Chain Management,Purchasing,Warehouse,Distribution,Factory Layout,Incentive Systems,Shift Systems,Continous Improvement,PDCA,Idea Management,Key Performance Indicator (KPI),Method Development,Factory Simulation,Computer Aided Manufacturing (CAM),Job Design,Value Stream Map,Kaizen,Kanban,Poka Yoke,SMED,Workflow Optimization,Office Process Flow Optimization,Production Process Flow Optimization,PDCA/A3/8D,Know How Management,Knowledge Database,Know How Documentation,Process Documentation,Collaboration,Best Practice,Knowledge Mapping,Six Sigma,ISO 9000ff,TS 16949,VDA,QS 9000,EAQF,AVSQ,ISO 22000,HACCP,Problem Solving,Quality Statistics,Statistic Process Control (SPC),Capability Studies,Total Quality Management (TQM),Quality Function Deployment (QFD),Quality Circle,Taguchi,Kansei Engineering,Business Process Reegineering (BPR),Object Oriented Quality and Risk Management (OQRM),Quality Tools,FMEA,APQP,PPAP,Document Management,Project Management,Logistics,Market Analysis,Brand Management,Market Research,Pricing,Promotion,Sales,After Sales Service,E-Commerce,Distribution,Consumer Theory,Economics,Advertising,Patent rights,Start up,Employer Obligations,Employee Rights,Maintenance,Machine procurement,Project Management,Machine Development,Automation Technologies,Transport Systems,Technical Documentation,Material Research,Process Research,Material Development,Process Development,Machine Development,Method Development,Software Development,Organization Development,Vision/Mission Development,Balanced Scorecard,Decission Making,Enterprise Organization,Controlling,Treasury,Insurance,Tax,Business Coaching,Executive Coaching,Control Theory,Expat Coaching,Career Coaching,Financial Coaching,Career Coaching,Personal Coaching,Style Coaching,Systemic Coaching,Energy Saving,Enviromental Protection,Environmental Certification,Safety,SAP,ERP,SCADA,OPC,Controls & Drives,Software,IT Infrastructure', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,4372889b77c08a18e6c7678959dfae5f,ad47487ba9f55206809cda9b8c26970e,098dffccb099681e86da846acfc18f82,f9c8caf36e4edd9019ad377a3e5913f9,31b0ec3b99b07738721de18143026073,605710b2b9973ce56e579e7fe7ca40bd,9f605b329a26309b79602288ca91566e,97ac0992b3214632ef41a3075b0c6e9b,00251b5dece63be7afb8f5fcdd3e83ce,5ae646bae06e16daec5fa3612e1444a2,54d1a8b447435ee325e306b8a58f58c9,1f2e4e60dc657345243d64f97fb1bbfe,26e11ac3f33f80d997e361a593645a11,f87cc7da43b9e091d3860ddea56d5cca,643ad5bde5f29c59d835653f105d74c7,4c89dbee82b7b1dd9d379c2d00562947,f770364d234fdd52dafa02b6e16f3fb6,756d97bb256b8580d4d71ee0c547804e,5368b55efe0fdf484d59fced5bdf8fc7,547d767efe9c787101db5cf00e485e60,793cb79980d3fa094ef13dcf866c482a,bd5476e8f33749530f87777476eeda72,5f95f5c48171ba26e9f8aa9d8c7ce6c4,6416e8cb5fc0a208d94fa7f5a300dbc4,f0bac093bb884df2891d32385d053788,0071d27c3fcd29f13466286ba27549f1,45fc8de324847819ee095188817556ea,178a871d63ced55a2a1245794348a740,7143e90e4612aa3b540583722ae15d4c,10292e05addacebdb23b68a122ce92bf,07d29f397a557ef1fa21c012675df35b,1f04b185d898e6cd1ea20be2459f1a2f,d43226ef4371e98a283f50db3069037e,cab4b63c8575bbd3a342b5fbad426339,22f1c6f52c654280e8091ebba7912a4f,e17258ab2bd1400d4492aed7407801c9,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,11c5be36641bc05b251dac68b2243b3a,d81ecc4e96ad229a33764b7e2182f6ee,2a694503a666ca6d33d0d8e0de261af3,e4ff0b8025c94e620fcf21095812d891,33ae0b4428adfa3ceea9f35bdc6a1a07,5368b55efe0fdf484d59fced5bdf8fc7,1fadb673213c21e8b380f22fa60a87fa,cae286e917b10ab8e6b67028f587fef5,30d14e12406a7580919dce129f5b4b70,337e8f4aa741ef97ec3ed8fd7b1accb7,39d9903201320a83d45d3b36d512f051,e58ca0ad724728414e09d0fe31575380,f07975a00f5b3d1e025709beaf8958db,cc007258ed6ad7c5f333ab4c9fcc3d58,f005154db5e4a784e86ddd52a325b7e1,82f11e8df84d4b474718abcaaadf7f0e,c2b3cbff032f7dc67086a8bb3868132a,29d45de4626630a95dccf42d97c8a52c,23d574908eb584d0340bad2f92123783,0810b9dab1e5f9165452b688fc237160,c38d1935edec2f6cf463602abdfbabf0,6a03a97072a01181059654e8389b992e,53ddc4f8e376c0be7f0f2165eae761bc,8aba034abd1545772ac75f305ef5e73c,960ceabd53770a66b60398b278698c07,60633124df065496444d63301ad9bbbf,cb20a6a674789289063f69aaceeeeee2,b3b607ce1da0ff572e5cfe191b6b601f,b03f732d0b64bf01947a595828fe0888,ee8222c94dcd7d3c1d20cf33edd86ffd,7bf848c679d5474b18c355a3b84e9f9c,c0a422495f053de689303175bda764e7,c2f1f4cbc26e018d0502ab9ef1047555,313b11a9b82d9a829f6ef0ef797aca11,7ede7cdb7772374809887807f2f41db8,d1db7a240300bcd7f59731bdab271b67,04ab7e9520f65aa6c1c1c1eb8c397873,9c1330f0dda3f188a3813b9840d1143f,68c16c941c3fb4e5dad94a7837ea7d1e,69c0225744326087a7c430c3e9bf72dc,b934621127c601f5d5b3893340e95b7c,023157b1a3d9ee4f0ed14b9801a26ac4,e22ac25b066b201473de7aa700ef5d92,626a54d37d402d449d6d7541911e0952,11ff9f68afb6b8b5b8eda218d7c83a65,d40d436df0bbeb1ba05079dd0aedc967,a9f7ecebb493e129aafb4cbfd73e85df,f0bac093bb884df2891d32385d053788,fdb40afa0d285233ba2249b2b1d3e109,7e1e3f377648773863a504d18b367ea3,2ce5fc289845ce826261032b9c6749ea,07744fec5b5a8ed1562fecd32a488416,79c8716e036aef2b15b59c04ec787d43,f22c85e9d23b0b99a63cca2720ca5f71,68a362caa596e9391b409126518e0f30,10d0de28911c5f66463b9c8783f8148a,2af2adf212edd655e2f8274304e88f9f,9c1330f0dda3f188a3813b9840d1143f,84cfca6dce7809b0f7eafaa8127e34dd,49f5799a2db35743d039f344e5834945,4e27832af76c2e7f0546182b3fbbb5b2,0fc75709621519dfa4730a0da953a784,fb6a9fd41b6dacf08edca2fed35e0ce1,41643b5dfdbaa1cb3e1d6ce39fe59c5a,2da2bb28a9c28d8b9b60062e0535e99f,7170bf578f2ee33a8e998acf46a7eb01,84cfca6dce7809b0f7eafaa8127e34dd,d43226ef4371e98a283f50db3069037e,f287f429e4026672e5754c1201691e49,423b89e54151ef282fc4441fd7e9d292,1bc3afe672a2a14262e8303c69068715,997a159a6c0ec092f40ecadf6240e924,10cb0bbbf2fab9eaf406ff8a6e927d9b,104e349a614e24418a716ce1da04fdad,f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d,cd3f03e0eaa08524a619ac43bb735d55,3e315e261e7cde16668b94fcac2c469f,7404bb042db8f04206202357fcc7774a,d2c398974b08231aa67a130a50c01cb2,b346eb676fb28bc55656d0e11e608b89,e635323340042e108778b5170a0a21f0,b346eb676fb28bc55656d0e11e608b89,380962a21071392c6585849451241715,499c1f432e8f11a44d8da1efddbdec5c,1345bba2ef769675b6c9aff32da21def,ef9ad9a5dbb7550d49bf3bf2a1c3d22d,bff7737497f5910fa3c976a93e7e57a3,7b1f06c45ef58c37f17fda4eb8103e1a,6472ce41c26babff27b4c28028093d77,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4,8ebe43fc79c5288888cac7b7106b0045,ad9f5325bab7d34c910fc2c7bce6e65c,fb54423c392d107161ddab675631a59b,719d067b229178f03bcfa1da4ac4dede,a8b0cb5c066d2e5f3cad8be0b01ecb00', '', 10, 20, NULL, NULL, 0, 7, 1477896120, 1479105720, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(53, 'Market place - Self Paced Training', '3', 'Self Paced Training Self Paced Training Self Paced Training', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '2', 1, 'Self Paced Training', '4372889b77c08a18e6c7678959dfae5f', 'Training', 30, 40, NULL, NULL, 0, 7, 1477982491, 1479192091, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(54, 'Market place - Mentoring', '3', 'Mentoring Mentoring Mentoring Mentoring', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '2', 1, 'Mentoring', '089011f59ea2749a842c1cb289c52c5d', '', 15, 20, NULL, NULL, 0, 7, 1477982564, 1479192164, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(55, 'Market place - Project Management', '0', 'Project Management  Project Management  Project Management', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '2', 1, 'Project Management', '9c1330f0dda3f188a3813b9840d1143f', '', 40, 50, NULL, NULL, 0, 7, 1477982645, 1479192245, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(56, 'Market place - Self Paced Training', '3', 'Market place - Self Paced Training Market place - Self Paced Training Market place - Self Paced Training Market place - Self Paced Training Market place - Self Paced Training Market place - Self Paced Training', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training', '4372889b77c08a18e6c7678959dfae5f', 'Training', 8, 10, NULL, NULL, 0, 7, 1479729212, 1480938812, 8, 'fb99baa034e4b89c4a9a2d2117f02777', '0', '0', '0', 1480573187, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(57, 'Market place - Mentoring', '3', 'Market place - Mentoring Market place - Mentoring Market place - Mentoring Market place - Mentoring Market place - Mentoring Market place - Mentoring Market place - Mentoring Market place - Mentoring Market place - Mentoring Market place - Mentoring Market place - Mentoring', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Mentoring', '089011f59ea2749a842c1cb289c52c5d', '', 30, 35, NULL, NULL, 0, 7, 1479729319, 1480938919, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(58, 'Market place - Project Management', '0', 'Market place - Project Management Market place - Project Management Market place - Project Management Market place - Project Management Market place - Project Management Market place - Project Management Market place - Project Management Market place - Project Management Market place - Project Management', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Project Management', '9c1330f0dda3f188a3813b9840d1143f', '', 21, 24, NULL, NULL, 0, 7, 1479729506, 1480939106, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(59, 'Market place', '3', 'Market place Market place Market place Market place Market place Market place Market place Market place Market place Market place Market place Market place', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer,Self Paced Training,Hiring,Talent Management,Payment Systems,Employment Law regulations,Employee Motivation,Wage accounting,Public Relations,Internal Communication,Employee Information,Translation Service,Problem Definition,Idea Generation,Idea Selection,Idea Implementation,Production Planning,Sequencing,Production,Know How Management,Employee Recognition,Autonomous Workgroups,Supply Chain Management,Purchasing,Warehouse,Distribution,Factory Layout,Incentive Systems,Shift Systems,Continous Improvement,PDCA,Idea Management,Key Performance Indicator (KPI),Method Development,Factory Simulation,Computer Aided Manufacturing (CAM),Job Design,Value Stream Map,Kaizen,Kanban,Poka Yoke,SMED,Workflow Optimization,Office Process Flow Optimization,Production Process Flow Optimization,PDCA/A3/8D,Know How Management,Knowledge Database,Know How Documentation,Process Documentation,Collaboration,Best Practice,Knowledge Mapping,Six Sigma,ISO 9000ff,TS 16949,VDA,QS 9000,EAQF,AVSQ,ISO 22000,HACCP,Problem Solving,Quality Statistics,Statistic Process Control (SPC),Capability Studies,Total Quality Management (TQM),Quality Function Deployment (QFD),Quality Circle,Taguchi,Kansei Engineering,Business Process Reegineering (BPR),Object Oriented Quality and Risk Management (OQRM),Quality Tools,FMEA,APQP,PPAP,Document Management,Project Management,Logistics,Market Analysis,Brand Management,Market Research,Pricing,Promotion,Sales,After Sales Service,E-Commerce,Distribution,Consumer Theory,Economics,Advertising,Patent rights,Start up,Employer Obligations,Employee Rights,Maintenance,Machine procurement,Project Management,Machine Development,Automation Technologies,Transport Systems,Technical Documentation,Material Research,Process Research,Material Development,Process Development,Machine Development,Method Development,Software Development,Organization Development,Vision/Mission Development,Balanced Scorecard,Decission Making,Enterprise Organization,Controlling,Treasury,Insurance,Tax,Business Coaching,Executive Coaching,Control Theory,Expat Coaching,Career Coaching,Financial Coaching,Career Coaching,Personal Coaching,Style Coaching,Systemic Coaching,Energy Saving,Enviromental Protection,Environmental Certification,Safety,SAP,ERP,SCADA,OPC,Controls & Drives,Software,IT Infrastructure', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,4372889b77c08a18e6c7678959dfae5f,ad47487ba9f55206809cda9b8c26970e,098dffccb099681e86da846acfc18f82,f9c8caf36e4edd9019ad377a3e5913f9,31b0ec3b99b07738721de18143026073,605710b2b9973ce56e579e7fe7ca40bd,9f605b329a26309b79602288ca91566e,97ac0992b3214632ef41a3075b0c6e9b,00251b5dece63be7afb8f5fcdd3e83ce,5ae646bae06e16daec5fa3612e1444a2,54d1a8b447435ee325e306b8a58f58c9,1f2e4e60dc657345243d64f97fb1bbfe,26e11ac3f33f80d997e361a593645a11,f87cc7da43b9e091d3860ddea56d5cca,643ad5bde5f29c59d835653f105d74c7,4c89dbee82b7b1dd9d379c2d00562947,f770364d234fdd52dafa02b6e16f3fb6,756d97bb256b8580d4d71ee0c547804e,5368b55efe0fdf484d59fced5bdf8fc7,547d767efe9c787101db5cf00e485e60,793cb79980d3fa094ef13dcf866c482a,bd5476e8f33749530f87777476eeda72,5f95f5c48171ba26e9f8aa9d8c7ce6c4,6416e8cb5fc0a208d94fa7f5a300dbc4,f0bac093bb884df2891d32385d053788,0071d27c3fcd29f13466286ba27549f1,45fc8de324847819ee095188817556ea,178a871d63ced55a2a1245794348a740,7143e90e4612aa3b540583722ae15d4c,10292e05addacebdb23b68a122ce92bf,07d29f397a557ef1fa21c012675df35b,1f04b185d898e6cd1ea20be2459f1a2f,d43226ef4371e98a283f50db3069037e,cab4b63c8575bbd3a342b5fbad426339,22f1c6f52c654280e8091ebba7912a4f,e17258ab2bd1400d4492aed7407801c9,671f1a5e1fd5c8e1779b375ae3740935,d418a4f13569b41b3734d2dac34cbf02,39b32dd45982038aa5704ca2728334ee,755a5a56d1c89f4ff179c6f66e9e255a,11c5be36641bc05b251dac68b2243b3a,d81ecc4e96ad229a33764b7e2182f6ee,2a694503a666ca6d33d0d8e0de261af3,e4ff0b8025c94e620fcf21095812d891,33ae0b4428adfa3ceea9f35bdc6a1a07,5368b55efe0fdf484d59fced5bdf8fc7,1fadb673213c21e8b380f22fa60a87fa,cae286e917b10ab8e6b67028f587fef5,30d14e12406a7580919dce129f5b4b70,337e8f4aa741ef97ec3ed8fd7b1accb7,39d9903201320a83d45d3b36d512f051,e58ca0ad724728414e09d0fe31575380,f07975a00f5b3d1e025709beaf8958db,cc007258ed6ad7c5f333ab4c9fcc3d58,f005154db5e4a784e86ddd52a325b7e1,82f11e8df84d4b474718abcaaadf7f0e,c2b3cbff032f7dc67086a8bb3868132a,29d45de4626630a95dccf42d97c8a52c,23d574908eb584d0340bad2f92123783,0810b9dab1e5f9165452b688fc237160,c38d1935edec2f6cf463602abdfbabf0,6a03a97072a01181059654e8389b992e,53ddc4f8e376c0be7f0f2165eae761bc,8aba034abd1545772ac75f305ef5e73c,960ceabd53770a66b60398b278698c07,60633124df065496444d63301ad9bbbf,cb20a6a674789289063f69aaceeeeee2,b3b607ce1da0ff572e5cfe191b6b601f,b03f732d0b64bf01947a595828fe0888,ee8222c94dcd7d3c1d20cf33edd86ffd,7bf848c679d5474b18c355a3b84e9f9c,c0a422495f053de689303175bda764e7,c2f1f4cbc26e018d0502ab9ef1047555,313b11a9b82d9a829f6ef0ef797aca11,7ede7cdb7772374809887807f2f41db8,d1db7a240300bcd7f59731bdab271b67,04ab7e9520f65aa6c1c1c1eb8c397873,9c1330f0dda3f188a3813b9840d1143f,68c16c941c3fb4e5dad94a7837ea7d1e,69c0225744326087a7c430c3e9bf72dc,b934621127c601f5d5b3893340e95b7c,023157b1a3d9ee4f0ed14b9801a26ac4,e22ac25b066b201473de7aa700ef5d92,626a54d37d402d449d6d7541911e0952,11ff9f68afb6b8b5b8eda218d7c83a65,d40d436df0bbeb1ba05079dd0aedc967,a9f7ecebb493e129aafb4cbfd73e85df,f0bac093bb884df2891d32385d053788,fdb40afa0d285233ba2249b2b1d3e109,7e1e3f377648773863a504d18b367ea3,2ce5fc289845ce826261032b9c6749ea,07744fec5b5a8ed1562fecd32a488416,79c8716e036aef2b15b59c04ec787d43,f22c85e9d23b0b99a63cca2720ca5f71,68a362caa596e9391b409126518e0f30,10d0de28911c5f66463b9c8783f8148a,2af2adf212edd655e2f8274304e88f9f,9c1330f0dda3f188a3813b9840d1143f,84cfca6dce7809b0f7eafaa8127e34dd,49f5799a2db35743d039f344e5834945,4e27832af76c2e7f0546182b3fbbb5b2,0fc75709621519dfa4730a0da953a784,fb6a9fd41b6dacf08edca2fed35e0ce1,41643b5dfdbaa1cb3e1d6ce39fe59c5a,2da2bb28a9c28d8b9b60062e0535e99f,7170bf578f2ee33a8e998acf46a7eb01,84cfca6dce7809b0f7eafaa8127e34dd,d43226ef4371e98a283f50db3069037e,f287f429e4026672e5754c1201691e49,423b89e54151ef282fc4441fd7e9d292,1bc3afe672a2a14262e8303c69068715,997a159a6c0ec092f40ecadf6240e924,10cb0bbbf2fab9eaf406ff8a6e927d9b,104e349a614e24418a716ce1da04fdad,f72e450345fa11da2e3ebf51e6cfcd81,20e968a2ef4cbdc5bea5e34d0b1e7333,eaff1bdf24fcffe0e14e29a1bff51a12,4b78ac8eb158840e9638a3aeb26c4a9d,cd3f03e0eaa08524a619ac43bb735d55,3e315e261e7cde16668b94fcac2c469f,7404bb042db8f04206202357fcc7774a,d2c398974b08231aa67a130a50c01cb2,b346eb676fb28bc55656d0e11e608b89,e635323340042e108778b5170a0a21f0,b346eb676fb28bc55656d0e11e608b89,380962a21071392c6585849451241715,499c1f432e8f11a44d8da1efddbdec5c,1345bba2ef769675b6c9aff32da21def,ef9ad9a5dbb7550d49bf3bf2a1c3d22d,bff7737497f5910fa3c976a93e7e57a3,7b1f06c45ef58c37f17fda4eb8103e1a,6472ce41c26babff27b4c28028093d77,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4,8ebe43fc79c5288888cac7b7106b0045,ad9f5325bab7d34c910fc2c7bce6e65c,fb54423c392d107161ddab675631a59b,719d067b229178f03bcfa1da4ac4dede,a8b0cb5c066d2e5f3cad8be0b01ecb00', '', 15, 18, NULL, NULL, 0, 7, 1479729863, 1480939463, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(60, 'Market place - Project Management', '3', 'Market place - Project Management Market place - Project Management Market place - Project Management Market place - Project Management Market place - Project ManagementMarket place - Project Management Market place - Project ManagementMarket place - Project Management Market place - Project Management', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Project Management', '9c1330f0dda3f188a3813b9840d1143f', '', 20, 25, NULL, NULL, 0, 7, 1479883590, 1481093190, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(61, 'Market place - train the trainer', '3', 'Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer Market place - train the trainer', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Train the Trainer', '8364a35733b4c01bb57ce49b93bfd34d', '', 10, 15, NULL, NULL, 0, 7, 1479886170, 1481095770, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(62, 'testss', '3', 'sfbdb sfg sfg ag wth wth wthg reth seth werjh rejaesh wsetj styjh rtsh seth steh steh sth sth', '0000-00-00', 'Aruba', 'wrat', 'wfv', '2', 1, 'Mentoring,On the Job Training,University/Classroom,University/eLearning', '089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95', '<div style=', 11, 12, 1, 1, 0, 7, 1480147111, 1481356711, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(63, 'Testing Project 1', '2', 'Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail: Describe the project in detail:', '0000-00-00', 'India', 'tamilnadu', 'india', '1', 1, 'University/Classroom,University/eLearning,Webinar', '4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8', 'test,demo', 10, 15, NULL, NULL, 0, 7, 1481607580, 1482817180, 8, 'b61e05fae508c58e8df24bac77be28e8', '0', '0', '0', 1481610755, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(64, 'Demo#1', '3', 'Describe the project in detailDescribe the project in detailDescribe the project in detailDescribe the project in detailDescribe the project in detailDescribe the project in detailDescribe the project in detailDescribe the project in detailDescribe the project in detailDescribe the project in detail', '0000-00-00', 'India', 'tamilnadu', 'madurai', '1', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,Webinar', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,50dd9fb6d93c81e15cec36ffc49cd0f8', 'eaducation', 10, 15, NULL, NULL, 0, 7, 1482135213, 1483344813, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(65, 'New Project # 1', '3', 'Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,University/eLearning,Patent rights,Start up,Employer Obligations', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,ecc1096e75897a6a418aa54cc6309b95,07744fec5b5a8ed1562fecd32a488416,79c8716e036aef2b15b59c04ec787d43,f22c85e9d23b0b99a63cca2720ca5f71', 'eaducation,lawyer', 30, 40, NULL, NULL, 0, 7, 1484042682, 1485252282, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(66, 'New Project # 2', '3', 'Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail', '0000-00-00', 'India', 'tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,On the Job Training,Project Management', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,9c1330f0dda3f188a3813b9840d1143f', 'eaducation,Project management', 20, 30, NULL, NULL, 0, 7, 1484042804, 1485252404, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(67, 'Test Project#01', '2', 'Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Mentoring,On the Job Training,Webinar,Train the Trainer', '089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', 'eaducation', 30, 36, NULL, NULL, 0, 7, 1485760921, 1486970521, 8, '38a5b5754308132f1ea36533e4f2cf80', '0', '0', '0', 1485844196, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(68, 'Test Project#02', '3', 'Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', 'eaducation', 40, 45, NULL, NULL, 0, 7, 1485763465, 1486973065, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(69, 'Test Project#03', '3', 'Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail Describe the project in detail', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', 'eaducation', 30, 40, NULL, NULL, 0, 7, 1485763562, 1486973162, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(70, 'Test Project#04', '3', 'Do not put a domain/URL in your project name Do not put a domain/URL in your project name Do not put a domain/URL in your project name Do not put a domain/URL in your project name Do not put a domain/URL in your project name Do not put a domain/URL in your project name Do not put a domain/URL in your project name', '0000-00-00', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,Webinar,Train the Trainer,SAP,ERP,SCADA,OPC', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d,999bc6b18351bbe817d26f559ba408ae,5202bfaff162a71345cc0f3dde1940a4,8ebe43fc79c5288888cac7b7106b0045,ad9f5325bab7d34c910fc2c7bce6e65c', 'eaducation', 35, 40, NULL, NULL, 0, 7, 1485763661, 1486973261, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(140, 'asadas', '0', 'sdfsd', '0000-00-00', 'United States', '2323', 'sdfsdf', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 15, 40, 0, 0, 0, 7, 1488351537, 1489215537, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(135, 'asadas', '3', 'dfgfdg', '0000-00-00', 'United States', '23', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 10, 100, 0, 0, 0, 7, 1488349391, 1489386191, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(136, 'adasd', '0', 'Description', '0000-00-00', 'United States', 'AA', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488349609, 1489386409, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4,7', 0),
(137, 'asadas', '0', 'sdfdsf', '0000-00-00', 'United States', 'asdsad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 10, 100, 0, 0, 0, 7, 1488349902, 1489386702, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5,7', 0),
(138, 'NewProject#1', '3', 'Description', '0000-00-00', 'United States', 'aa', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488350196, 1489214196, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5,7', 0),
(139, 'NewProject#1', '0', 'Project', '0000-00-00', 'United States', 'AA', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 11, 15, 0, 0, 0, 7, 1488350836, 1489214836, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5,7', 0),
(134, 'NewProject#1', '3', 'Description', '0000-00-00', 'United States', '2', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 50, 100, 0, 0, 0, 7, 1488349188, 1489213188, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4,7', 0),
(141, 'sdfds', '0', 'sdfsdf', '0000-00-00', 'United States', 'dsd', '23', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 3, 4, 0, 0, 0, 7, 1488352081, 1488784081, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(142, 'dgdfg', '0', 'dfgdf', '0000-00-00', 'India', 'sdf', 'sdfds', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 10, 19, 0, 0, 0, 7, 1488353152, 1489217152, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(143, 'adasdas', '0', 'asdasds', '0000-00-00', 'United States', 'As', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 10, 100, 0, 0, 0, 7, 1488353453, 1489217453, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(144, 'NewProject#1', '0', 'adasd', '0000-00-00', 'United States', 'tt', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 8, 10, 0, 0, 0, 7, 1488354883, 1489218883, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(145, 'NewProject', '0', 'asdasd', '0000-00-00', 'United States', 'TM', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 50, 100, 0, 0, 0, 7, 1488355384, 1489392184, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(146, 'asdads', '0', 'asds', '0000-00-00', 'United States', 'TN', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 16, 0, 0, 0, 7, 1488355677, 1489392477, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(147, 'NewProject#1', '0', 'Dec', '0000-00-00', 'United States', 'AA', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 50, 100, 0, 0, 0, 7, 1488356285, 1489220285, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0);
INSERT INTO `jobs` (`id`, `job_name`, `job_status`, `description`, `due_date`, `country`, `state`, `city`, `milestone`, `mile_notify`, `job_categories`, `job_categories_encrypt`, `manual_job`, `budget_min`, `budget_max`, `is_feature`, `is_urgent`, `is_hide_bids`, `creator_id`, `created`, `enddate`, `employee_id`, `checkstamp`, `owner_rated`, `employee_rated`, `job_paid`, `job_award_date`, `notification_status`, `attachment_url`, `attachment_name`, `attachment_url1`, `attachment_name1`, `attachment_url2`, `attachment_name2`, `is_private`, `private_users`, `contact`, `salary`, `flag`, `salarytype`, `escrow_due`, `invite_suppliers`, `team_member_id`) VALUES
(148, 'dfsd', '0', 'fsfsfd', '0000-00-00', 'United States', 'asdsad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 15, 40, 0, 0, 0, 7, 1488356614, 1489220614, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(149, 'adadas', '0', 'asdasd', '0000-00-00', 'United States', 'TN', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 15, 40, 0, 0, 0, 7, 1488356817, 1489220817, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(150, 'asdas', '0', 'asdasd', '0000-00-00', 'United States', 'asds', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488357182, 1489221182, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(151, 'NewProject', '0', 'Description', '0000-00-00', 'United States', 'asdsad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 250, 300, 0, 0, 0, 7, 1488357885, 1489221885, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5,7', 0),
(152, 'NewProject#1', '0', 'Description', '0000-00-00', 'India', 'asdsad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 50, 150, 0, 0, 0, 7, 1488358063, 1489654063, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '7', 0),
(153, 'proj', '0', 'sdfds', '0000-00-00', 'United States', 'ads', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488358334, 1489222334, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(154, 'asadas', '0', 'sdfsdf', '0000-00-00', 'Iceland', 'asd', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488358533, 1489654533, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(155, 'dasdasd', '0', 'adasdas', '0000-00-00', 'United States', 'asdsad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488358911, 1489222911, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(156, 'asadas', '0', 'dec', '0000-00-00', 'United States', 'adad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488359191, 1489655191, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5,7', 0),
(157, 'asdas', '0', 'adad', '0000-00-00', 'United States', 'asds', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 25, 100, 0, 0, 0, 7, 1488359786, 1489223786, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(158, 'asadas', '0', 'sdfds', '0000-00-00', 'United States', 'asdsad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488360161, 1492680161, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4,7', 0),
(159, 'asadas', '0', 'sdfdsf', '0000-00-00', 'United States', 'DD', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 50, 100, 0, 0, 0, 7, 1488360402, 1489224402, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5,4', 0),
(160, 'asadas', '0', 'adas', '0000-00-00', 'United States', 'dad', 'Arkansas', '1', 0, 'Self Paced Training', '4372889b77c08a18e6c7678959dfae5f', '', 15, 25, 0, 0, 0, 7, 1488360621, 1489224621, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(161, 'sdf', '0', 'sfsfs', '0000-00-00', 'United States', 'asdsad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488362208, 1489399008, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(162, 'adasd', '0', 'adasd', '0000-00-00', 'United States', 'asdsa', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488363094, 1489399894, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(163, 'Project', '0', 'asdas', '0000-00-00', 'United States', 'asda', 'asasd', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 25, 55, 0, 0, 0, 7, 1488364136, 1489228136, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(164, 'asadas', '0', 'adad', '0000-00-00', 'United States', 'adas', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 100, 200, 0, 0, 0, 7, 1488364544, 1489228544, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(165, 'sdsf', '0', 'ddsfds', '0000-00-00', 'United States', 'd', 'adasas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 2, 2, 0, 0, 0, 7, 1488365163, 1488537963, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(166, 'fgdf', '0', 'fdgdgdgf', '0000-00-00', 'United States', 'fsdf', 'dsfsd', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 2, 2, 0, 0, 0, 7, 1488365554, 1488538354, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(167, 'sds', '0', 'sdfds', '0000-00-00', 'United States', 'fsdfd', 'sdsfds', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 4, 5, 0, 0, 0, 7, 1488366628, 1488712228, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(168, 'ryrt', '0', 'yrtyr', '0000-00-00', 'United States', 'dadad', 'das', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 40, 70, 0, 0, 0, 7, 1488367183, 1490959183, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(169, 'dff', '0', 'ssf', '0000-00-00', 'United States', 'sdfsf', 'fsf', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 44, 66, 0, 0, 0, 7, 1488367373, 1488626573, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(170, 'fsdf', '0', 'sfsf', '0000-00-00', 'United States', 'dadad', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 15, 40, 0, 0, 0, 7, 1488368180, 1489404980, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(171, 'sdfs', '0', 'fsdfdsf', '0000-00-00', 'United States', 'fdsfds', 'sdfds', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 6, 11, 0, 0, 0, 7, 1488368472, 1488627672, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(172, 'sdfsd', '0', 'fsfsd', '0000-00-00', 'United States', 'ada', 'ad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 2, 2, 0, 0, 0, 7, 1488368989, 1488541789, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(173, 'asdas', '0', 'adad', '0000-00-00', 'United States', 'dasd', 'da', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 2, 5, 0, 0, 0, 7, 1488369259, 1488714859, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(174, 'asdsa', '0', 'adas', '0000-00-00', 'United States', 'dfsdf', 'ds', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 20, 25, 0, 0, 0, 7, 1488369425, 1489665425, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(175, 'sdfsf', '0', 'sfsdf', '0000-00-00', 'United States', 'dasdsa', 'sadada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 2, 2, 0, 0, 0, 7, 1488370142, 1488542942, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(176, 'sdfs', '0', 'dfsdf', '0000-00-00', 'United States', 'adas', 'dad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 2, 4, 0, 0, 0, 7, 1488371023, 1488630223, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(177, 'sdfdsf', '0', 'sdfsdf', '0000-00-00', 'United States', 'sdsad', 'da', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 10, 100, 0, 0, 0, 7, 1488371228, 1489408028, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(178, 'asda', '0', 'sdada', '0000-00-00', 'United States', 'sdasd', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 4, 5, 0, 0, 0, 7, 1488372233, 1488545033, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(179, 'asdasd', '0', 'ad', '0000-00-00', 'United States', 'asdad', 'adad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 16, 123, 0, 0, 0, 7, 1488372425, 1489668425, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(180, 'ada', '0', 'adas', '0000-00-00', 'United States', 'asdsad', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 14, 18, 0, 0, 0, 7, 1488372592, 1489409392, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(181, 'sdf', '0', 'sdfs', '0000-00-00', 'United States', 'dada', 'asdas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 23, 23, 0, 0, 0, 7, 1488373029, 1488718629, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(182, 'asdad', '0', 'ada', '0000-00-00', 'United States', 'dada', 'asda', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 2, 4, 0, 0, 0, 7, 1488373142, 1489409942, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(183, 'asda', '0', 'asdas', '0000-00-00', 'United States', 'asdad', 'asdsa', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 14, 16, 0, 0, 0, 7, 1488374320, 1489411120, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(184, 'sdfds', '0', 'adas', '0000-00-00', 'United States', 'asdad', 'asdsa', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 43, 0, 0, 0, 7, 1488374509, 1489411309, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(185, 'aadas', '0', 'adasd', '0000-00-00', 'Antigua and Barbuda', 'asdas', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 3, 3, 0, 0, 0, 7, 1488423528, 1488682728, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(186, 'asdad', '0', 'aadsa', '0000-00-00', 'United States', 'aasda', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 2, 5, 0, 0, 0, 7, 1488423707, 1489460507, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(187, 'asdad', '0', 'asdasd', '0000-00-00', 'United States', 'adasd', 'asdsad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 4, 6, 0, 0, 0, 7, 1488424135, 1490238535, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(188, 'asdasd', '0', 'asdas', '0000-00-00', 'United States', '12', 'adad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 5, 7, 0, 0, 0, 7, 1488424402, 1490238802, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '7', 0),
(189, 'Project', '0', 'sfsdf', '0000-00-00', 'United States', 'ads', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 123, 13, 0, 0, 0, 7, 1488425147, 1489461947, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5,7', 0),
(190, 'asds', '0', 'asdas', '0000-00-00', 'United States', 'dadad', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 123, 123, 0, 0, 0, 7, 1488425481, 1489462281, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(191, 'asadas', '0', 'asdasd', '0000-00-00', 'United States', 'adad', 'adad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 12, 0, 0, 0, 7, 1488425658, 1489462458, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(192, 'sdfsf', '0', 'sfsdf', '0000-00-00', 'United States', 'dad', 'sadas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 33, 55, 0, 0, 0, 7, 1488425935, 1489462735, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(193, 'asda', '0', 'da', '0000-00-00', 'United States', 'adasd', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 34, 0, 0, 0, 7, 1488426168, 1489462968, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(194, 'ada', '0', 'dadadaa', '0000-00-00', 'United States', 'asdad', 'adad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 14, 0, 0, 0, 7, 1488426707, 1489463507, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(195, 'adada', '0', 'dadasdad', '0000-00-00', 'United States', 'dasdsad', 'adsa', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 22, 34, 0, 0, 0, 7, 1488426896, 1489463696, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5,7', 0),
(196, 'asdasd', '0', 'adasd', '0000-00-00', 'United States', 'dadas', 'asda', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 21, 0, 0, 0, 7, 1488427127, 1489463927, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(197, 'sdfs', '0', 'sfsfs', '0000-00-00', 'United States', 'dads', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 14, 0, 0, 0, 7, 1488427392, 1490241792, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(198, 'sdfs', '0', 'fsfs', '0000-00-00', 'United States', 'adsa', 'asdad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 15, 6, 0, 0, 0, 7, 1488427641, 1489464441, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(199, 'asdsad', '0', 'asdasd', '0000-00-00', 'United States', 'adad', 'adasd', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 21, 34, 0, 0, 0, 7, 1488427914, 1490242314, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(200, 'adsadasd', '0', 'adadad', '0000-00-00', 'United States', 'dada', 'asda', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 22, 0, 0, 0, 7, 1488428308, 1489465108, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(201, 'ada', '0', 'adsasd', '0000-00-00', 'United States', 'adad', 'asd', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 12, 0, 0, 0, 7, 1488428594, 1488601394, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(202, 'asda', '0', 'dadadad', '0000-00-00', 'United States', 'adasd', 'Arkansas', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 21, 123, 0, 0, 0, 7, 1488428797, 1490243197, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(203, 'ada', '0', 'adad', '0000-00-00', 'United States', 'adasd', 'adad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 16, 0, 0, 0, 7, 1488431325, 1489468125, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(204, 'ada', '0', 'dadada', '0000-00-00', 'United States', 'adas', 'adad', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 1, 4, 0, 0, 0, 7, 1488431459, 1489381859, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(205, 'Bid Testing Project', '0', 'Bid Testing Project Bid Testing Project\n Bid Testing Project\n Bid Testing Project\n Bid Testing Project\n Bid Testing Project\n Bid Testing Project\n\n ', '2017-03-30', 'United States', 'dads', 'ada', '1', 0, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 12, 15, 0, 0, 0, 7, 1488432032, 1497504881, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '4', 0),
(206, 'Project insert for demo - secound', '3', 'Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description ', '2017-03-30', 'United States', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 20, 40, 0, 0, 0, 7, 1488432674, 1491911735, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '5', 0),
(207, 'Project insert for demo', '3', 'Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description ', '2017-03-31', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'On the Job Training,University/Classroom', '45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1', '', 25, 50, 0, 0, 0, 7, 1488432674, 1491998125, 0, '', '0', '0', '0', 0, 1, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0),
(208, 'Project insert for place bid', '3', 'Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description Project Description ', '2017-04-15', 'India', 'Tamilnadu', 'Madurai', '1', 1, 'Self Paced Training,Mentoring,On the Job Training,University/Classroom,University/eLearning,Webinar,Train the Trainer', '4372889b77c08a18e6c7678959dfae5f,089011f59ea2749a842c1cb289c52c5d,45c1a51912d3278521105a38797197d6,4300cc3a3c73093817f2819998be78d1,ecc1096e75897a6a418aa54cc6309b95,50dd9fb6d93c81e15cec36ffc49cd0f8,8364a35733b4c01bb57ce49b93bfd34d', '', 20, 40, 0, 0, 0, 7, 1488432674, 1494241846, 0, '', '0', '0', '0', 0, 0, '', NULL, '', '', '', '', 0, NULL, '', '', 0, '', 0, '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `jobs_preview`
--

CREATE TABLE `jobs_preview` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `job_status` enum('0','1','2','3') NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `milestone` varchar(50) NOT NULL,
  `job_categories` text CHARACTER SET utf8 NOT NULL,
  `manual_job` text CHARACTER SET utf8 NOT NULL,
  `budget_min` int(11) UNSIGNED DEFAULT '0',
  `budget_max` int(11) UNSIGNED DEFAULT '0',
  `is_feature` int(1) DEFAULT NULL,
  `is_urgent` int(1) DEFAULT NULL,
  `is_hide_bids` int(1) DEFAULT NULL,
  `is_private` int(1) DEFAULT NULL,
  `creator_id` int(10) UNSIGNED NOT NULL,
  `created` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `open_days` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `job_award_date` int(11) DEFAULT NULL,
  `checkstamp` varchar(50) NOT NULL,
  `owner_rated` enum('0','1') NOT NULL,
  `employee_rated` enum('0','1') NOT NULL,
  `job_paid` enum('0','1') NOT NULL,
  `CONTACT` text NOT NULL,
  `SALARY` varchar(15) NOT NULL,
  `FLAG` int(1) NOT NULL,
  `SALARYTYPE` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `jobs_preview`
--

INSERT INTO `jobs_preview` (`id`, `job_name`, `job_status`, `description`, `country`, `state`, `city`, `milestone`, `job_categories`, `manual_job`, `budget_min`, `budget_max`, `is_feature`, `is_urgent`, `is_hide_bids`, `is_private`, `creator_id`, `created`, `enddate`, `open_days`, `employee_id`, `job_award_date`, `checkstamp`, `owner_rated`, `employee_rated`, `job_paid`, `CONTACT`, `SALARY`, `FLAG`, `SALARYTYPE`) VALUES
(1, 'maven test job', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br>', 'Azerbaijan', 'Sasas', 'addasdsad', '', 'Education', '', 12, 14, 1, 1, 0, 0, 3, 1419220957, 1420430557, 0, 0, 0, '', '0', '0', '0', '', '', 0, ''),
(2, 'SMED Workshops to reduce change over times', '', 'In our production we have 3 different machine types with 3 different stup types each. For all machines and all 4 shift crews a setup SMED workshop should be carried out including SMED optimization frontup.<br>', 'United States', 'SC', 'Charleston', '', 'Lean Management', '', 0, 5000, 0, 0, 0, 0, 4, 1419337935, 1420547535, 0, 0, 0, '', '0', '0', '0', '', '', 0, ''),
(3, 'Engineering', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br>', 'India', 'Tamil Nadu', 'chennai', '', 'Machine procurement,Machine Development,Technical Documentation', '', 15, 50, 1, 1, 0, NULL, 7, 1421738775, 1422948375, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(4, 'Environment Safety Health', '', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br>', 'India', 'Tamilnadu', 'Madurai', '', 'Energy Saving,Enviromental Protection,Environmental Certification,Safety', '', 1500, 2000, 0, 0, 0, NULL, 7, 1421745960, 1422955560, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(5, 'Draft Check', '', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf<br>', 'India', 'Tamilnadu', 'Madurai', '1', 'University/Classroom,University/eLearning,Webinar', 'skill1,skill2', 9, 10, 0, 0, 0, NULL, 7, 1427247892, 1428457492, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(6, 'Draft Check', '', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf<br>', 'India', 'Tamilnadu', 'Madurai', '1', 'University/Classroom,University/eLearning,Webinar', 'skill1,skill2', 9, 10, 0, 0, 0, NULL, 7, 1427247981, 1428457581, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(7, 'Draft Check', '', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf<br>', 'India', 'Tamilnadu', 'Madurai', '1', 'University/Classroom,University/eLearning,Webinar', 'skill1,skill2', 9, 10, 0, 0, 0, NULL, 7, 1427253112, 1428462712, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(8, 'Draft Check', '', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf<br>', 'India', 'Tamilnadu', 'Madurai', '2', 'University/Classroom,University/eLearning,Webinar', 'skill1,skill2', 9, 10, 0, 0, 0, NULL, 7, 1427256912, 1428466512, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(9, 'Draft Check', '', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf<br>', 'India', 'Tamilnadu', 'Madurai', '2', 'University/Classroom,University/eLearning,Webinar', 'skill1,skill2', 9, 10, 0, 0, 0, NULL, 7, 1427257449, 1428467049, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(10, 'Draft Check', '', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf', 'India', 'Tamilnadu', 'Madurai', '2', 'University/Classroom,University/eLearning,Webinar', 'skill1,skill2', 9, 10, 1, NULL, NULL, NULL, 7, 1487666326, 1488875926, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(11, 'Draft Check', '', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf', 'India', 'Tamilnadu', 'Madurai', '2', 'University/Classroom,University/eLearning,Webinar', 'skill1,skill2', 9, 10, 1, NULL, NULL, NULL, 7, 1487666704, 1488876304, 0, 0, NULL, '', '0', '0', '0', '', '', 0, ''),
(12, 'Draft Check', '', 'dsfsd dsf sdf sdf sdf sf sdf dss fdsf sdfsdf sdf sfdsf sdfdsf sdsf sfsdf', 'India', 'Tamilnadu', 'Madurai', '2', 'University/Classroom,University/eLearning,Webinar', '<div style=', 9, 10, 1, NULL, NULL, NULL, 7, 1487666714, 1488876314, 0, 0, NULL, '', '0', '0', '0', '', '', 0, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `job_cases`
--

CREATE TABLE `job_cases` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `case_type` varchar(100) CHARACTER SET utf8 NOT NULL,
  `case_reason` varchar(100) CHARACTER SET utf8 NOT NULL,
  `problem_description` varchar(256) CHARACTER SET utf8 NOT NULL,
  `problem_subject` varchar(250) NOT NULL,
  `private_comments` varchar(256) CHARACTER SET utf8 NOT NULL,
  `review_type` varchar(100) CHARACTER SET utf8 NOT NULL,
  `payment` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `updates` varchar(256) CHARACTER SET utf8 NOT NULL,
  `status` enum('open','closed') NOT NULL,
  `notification_status` tinyint(4) NOT NULL,
  `employee_delete` tinyint(4) NOT NULL COMMENT '0-active 1-inactive',
  `owner_delete` tinyint(4) NOT NULL COMMENT '0-active 1-inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `job_cases`
--

INSERT INTO `job_cases` (`id`, `job_id`, `user_id`, `admin_id`, `case_type`, `case_reason`, `problem_description`, `problem_subject`, `private_comments`, `review_type`, `payment`, `created`, `parent`, `updates`, `status`, `notification_status`, `employee_delete`, `owner_delete`) VALUES
(1, 56, 8, 0, 'Dispute', 'Dispute Over Quality of Service', 'Bad Quality', '', 'Bad Quality', 'Remove Review', 10, 1480585615, 0, '', 'open', 1, 0, 0),
(2, 56, 7, 0, '', '', 'you are wrong', '', '', '', 0, 1484129770, 1, 'Requesting to change dispute case', 'open', 1, 0, 0),
(3, 56, 8, 0, '', '', 'ok', '', '', '', 0, 1484129900, 1, 'Requesting staff intervention', 'open', 1, 0, 0),
(4, 63, 7, 0, 'Dispute', 'Dispute Over Quality of Service', 'Poor quality - owner', '', '', 'Remove Review', 12, 1484813366, 0, '', 'open', 1, 0, 0),
(5, 56, 8, 0, '', '', '', '', 'i will correct', '', 0, 1484904012, 1, 'Requesting staff intervention', 'open', 1, 1, 1),
(6, 56, 8, 0, '', '', '', '', 'ok fine', '', 0, 1484904702, 1, 'Requesting staff intervention', 'open', 1, 1, 1),
(7, 63, 8, 0, 'Cancel', 'Dispute Over Quality of Service', 'Quality issue', '', 'I\'m not satisfied', 'Remove Review', 30, 1484906734, 0, '', 'open', 1, 0, 0),
(8, 56, 7, 0, '', '', 'ok', '', '', '', 0, 1484914159, 1, 'Requesting staff intervention', 'open', 1, 1, 0),
(9, 56, 7, 0, '', '', 'Testing Dispute Description', 'Testing Dispute', '', '', 0, 1496134890, 1, '', 'open', 1, 0, 0),
(10, 56, 7, 0, '', '', 'Testing Dispute Description 1', 'Testing Dispute 1', '', '', 0, 1496204444, 1, '', 'open', 1, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `job_invitation`
--

CREATE TABLE `job_invitation` (
  `id` int(11) NOT NULL,
  `job_id` varchar(128) NOT NULL,
  `sender_id` varchar(128) NOT NULL,
  `receiver_id` varchar(128) NOT NULL,
  `invite_date` int(11) NOT NULL,
  `notification_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `job_invitation`
--

INSERT INTO `job_invitation` (`id`, `job_id`, `sender_id`, `receiver_id`, `invite_date`, `notification_status`) VALUES
(40, '14', '7', '8', 1422065911, 1),
(41, '15', '7', '8', 1422066644, 1),
(42, '26', '7', '8', 1423725918, 1),
(43, '30', '7', '8', 1425283439, 1),
(44, '46', '7', '8', 1429493940, 1),
(45, '47', '7', '17', 1429496141, 1),
(46, '49', '7', '8', 1429510365, 1),
(47, '49', '7', '17', 1429510365, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `created` int(11) NOT NULL,
  `notification_status` int(11) NOT NULL DEFAULT '0',
  `deluserid` longtext NOT NULL,
  `from_delete` tinyint(4) NOT NULL,
  `to_delete` tinyint(4) NOT NULL,
  `from_trash_delete` tinyint(4) NOT NULL,
  `to_trash_delete` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `messages`
--

INSERT INTO `messages` (`id`, `job_id`, `from_id`, `to_id`, `subject`, `message`, `created`, `notification_status`, `deluserid`, `from_delete`, `to_delete`, `from_trash_delete`, `to_trash_delete`) VALUES
(1, 8, 7, 7, '', 'nhx cnjvlxniugfsgfhglfhgf  fdgfsjd gfsdgfdhiarewEEDGDFCG FGHGFHGFHG', 1420437540, 1, ',7,7', 0, 1, 0, 0),
(2, 14, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>https://consult24online.com/index.php/project/view/14', 1422065911, 1, ',8,7', 1, 2, 0, 0),
(3, 15, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>https://consult24online.com/index.php/project/view/15', 1422066644, 1, ',8,7', 0, 0, 0, 0),
(4, 15, 8, 7, '', 'hiiiiiiiiii', 1422081839, 1, ',8', 1, 1, 0, 0),
(5, 26, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>https://consult24online.com/index.php/project/view/26', 1423725918, 1, '', 0, 0, 0, 0),
(6, 20, 8, 7, '', 'Hello..', 1423726745, 1, ',7', 1, 0, 0, 0),
(7, 30, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>https://consult24online.com/index.php/project/view/30', 1425283440, 0, ',8', 1, 0, 0, 0),
(8, 46, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>https://consult24online.com/index.php/project/view/46', 1429493940, 1, ',8', 1, 0, 0, 0),
(9, 47, 7, 17, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>https://consult24online.com/index.php/project/view/47', 1429496141, 0, '', 0, 0, 0, 0),
(10, 49, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>https://consult24online.com/index.php/project/view/49', 1429510365, 1, ',8', 0, 0, 0, 0),
(11, 49, 7, 17, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>https://consult24online.com/index.php/project/view/49', 1429510365, 0, '', 0, 0, 0, 0),
(12, 45, 7, 8, '', 'Test Message', 1429779635, 1, ',7', 0, 0, 0, 0),
(13, 39, 7, 2, '', 'Everyone Test', 1429781580, 0, '', 0, 0, 0, 0),
(14, 39, 7, 5, '', 'Everyone Test', 1429781580, 0, '', 0, 0, 0, 0),
(15, 39, 7, 8, '', 'Everyone Test', 1429781580, 0, ',8,8', 2, 0, 0, 0),
(16, 39, 7, 12, '', 'Everyone Test', 1429781580, 0, ',7', 0, 0, 0, 0),
(17, 39, 7, 14, '', 'Everyone Test', 1429781580, 0, ',7', 0, 0, 0, 0),
(18, 39, 7, 16, '', 'Everyone Test', 1429781580, 0, ',7', 0, 0, 0, 0),
(19, 39, 7, 17, '', 'Everyone Test', 1429781580, 0, '', 0, 0, 0, 0),
(20, 39, 7, 21, '', 'Everyone Test', 1429781580, 0, ',7', 0, 0, 0, 0),
(21, 39, 7, 23, '', 'Everyone Test', 1429781581, 0, '', 0, 0, 0, 0),
(22, 39, 7, 25, '', 'Everyone Test', 1429781581, 0, '', 0, 0, 0, 0),
(23, 22, 8, 7, '', 'sfsfsdfdsfds', 1479287183, 0, ',8,8', 1, 1, 0, 0),
(24, 74, 7, 5, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/74', 1488184760, 0, '', 0, 0, 0, 0),
(25, 74, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/74', 1488184765, 1, '', 0, 0, 0, 0),
(26, 75, 7, 5, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/75', 1488186414, 0, '', 0, 0, 0, 0),
(27, 75, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/75', 1488186419, 1, '', 0, 0, 0, 0),
(28, 76, 7, 5, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/76', 1488186994, 0, '', 0, 0, 0, 0),
(29, 76, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/76', 1488186999, 1, '', 0, 0, 0, 0),
(30, 77, 7, 5, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/77', 1488187157, 0, '', 0, 0, 0, 0),
(31, 77, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/77', 1488187162, 1, '', 0, 0, 0, 0),
(32, 78, 7, 5, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/78', 1488187299, 0, '', 0, 0, 0, 0),
(33, 78, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/78', 1488187304, 1, '', 0, 0, 0, 0),
(34, 79, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/79', 1488189915, 1, '', 0, 0, 0, 0),
(35, 79, 7, 14, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/79', 1488189920, 0, '', 0, 0, 0, 0),
(36, 80, 7, 5, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/80', 1488191360, 0, '', 0, 0, 0, 0),
(37, 80, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/80', 1488191365, 1, '', 0, 0, 0, 0),
(38, 81, 7, 5, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/81', 1488191700, 0, '', 0, 0, 0, 0),
(39, 81, 7, 8, '', 'Private Job Notification --> You are Invited for the private job<br/>Follow the link given below to view the job<br/>http://demo.maventricks.com/machinery_market/project/view/81', 1488191705, 1, '', 0, 0, 0, 0),
(40, 20, 7, 8, 'Test subject', 'Test Messages', 1496142260, 1, '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `milestone`
--

CREATE TABLE `milestone` (
  `id` int(64) NOT NULL,
  `emp_id` int(64) NOT NULL,
  `own_id` int(64) NOT NULL,
  `job_id` int(64) NOT NULL,
  `mile_money` varchar(128) NOT NULL,
  `mile_dates` date NOT NULL,
  `emp_req` int(11) NOT NULL,
  `own_release` int(11) NOT NULL,
  `created` varchar(128) NOT NULL,
  `accept_date` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `milestone`
--

INSERT INTO `milestone` (`id`, `emp_id`, `own_id`, `job_id`, `mile_money`, `mile_dates`, `emp_req`, `own_release`, `created`, `accept_date`) VALUES
(40, 8, 7, 19, '12', '2015-02-17', 2, 2, '1423104653', '1423125030'),
(41, 8, 7, 19, '14', '2015-02-20', 1, 2, '1423104653', '1423125030'),
(42, 8, 7, 19, '16', '2015-02-28', 0, 0, '1423104653', '1423125030'),
(43, 8, 7, 18, '12', '2015-02-17', 0, 0, '1423188085', '1423790764'),
(44, 8, 7, 18, '42', '2015-02-20', 0, 0, '1423188085', '1423790764'),
(45, 8, 7, 18, '78', '2015-02-28', 0, 0, '1423188085', '1423790764'),
(46, 8, 7, 21, '30', '1900-02-08', 2, 2, '1423280933', '1423282031'),
(47, 8, 7, 22, '5', '1900-02-10', 0, 0, '1423447935', '1460863509'),
(48, 8, 7, 23, '5', '2015-02-10', 2, 2, '1423448747', '1423448918'),
(49, 8, 7, 24, '5', '2015-02-15', 2, 2, '1423453993', '1423460046'),
(50, 8, 7, 24, '5', '2015-02-20', 2, 2, '1423453993', '1423460046'),
(51, 8, 7, 24, '5', '2015-02-25', 1, 0, '1423453993', '1423460046'),
(52, 8, 7, 24, '5', '2015-03-10', 0, 0, '1423453993', '1423460046'),
(53, 8, 7, 24, '5', '2015-02-20', 0, 0, '1423453993', '1423460046'),
(54, 8, 7, 25, '2', '2015-02-15', 2, 2, '1423558861', '1423559760'),
(55, 8, 7, 25, '3', '2015-02-20', 2, 2, '1423558861', '1423559760'),
(56, 8, 7, 31, '5', '2015-03-06', 0, 0, '1425291308', '1429771465'),
(57, 8, 7, 31, '5', '2015-03-12', 0, 0, '1425291308', '1429771465'),
(58, 8, 7, 31, '5', '2015-03-20', 0, 0, '1425291308', '1429771465'),
(121, 8, 7, 45, '1', '2015-03-28', 0, 0, '1427355801', '1429771333'),
(122, 8, 7, 45, '2', '2015-03-30', 0, 0, '1427355801', '1429771333'),
(123, 0, 7, 46, '5', '2015-04-25', 0, 0, '1429493940', ''),
(124, 0, 7, 46, '5', '2015-04-30', 0, 0, '1429493940', ''),
(125, 0, 7, 47, '', '0000-00-00', 0, 0, '1429496141', ''),
(126, 0, 7, 48, '', '0000-00-00', 0, 0, '1429509509', ''),
(127, 0, 7, 49, '', '0000-00-00', 0, 0, '1429510365', ''),
(128, 8, 7, 30, '5', '2015-04-28', 0, 0, '1429770756', '1429771472'),
(129, 8, 7, 30, '5', '2015-05-05', 0, 0, '1429770756', '1429771472'),
(130, 8, 7, 30, '5', '2015-05-10', 0, 0, '1429770756', '1429771472'),
(131, 8, 7, 50, '5', '2015-04-28', 1, 0, '1429771865', '1429772349'),
(132, 8, 7, 50, '5', '2015-05-05', 0, 0, '1429771865', '1429772349'),
(133, 0, 7, 51, '', '0000-00-00', 0, 0, '1471355018', ''),
(134, 0, 7, 52, '', '0000-00-00', 0, 0, '1477896120', ''),
(135, 0, 7, 53, '', '0000-00-00', 0, 0, '1477982491', ''),
(136, 0, 7, 54, '', '0000-00-00', 0, 0, '1477982564', ''),
(137, 0, 7, 55, '', '0000-00-00', 0, 0, '1477982645', ''),
(138, 8, 7, 56, '2', '2016-11-21', 0, 0, '1479729212', '1482476491'),
(139, 8, 7, 56, '2', '2016-11-24', 0, 0, '1479729212', '1482476491'),
(140, 8, 7, 56, '2', '2016-11-30', 0, 0, '1479729212', '1482476491'),
(141, 0, 7, 57, '10', '2016-11-21', 0, 0, '1479729319', ''),
(142, 0, 7, 57, '10', '2016-11-25', 0, 0, '1479729319', ''),
(143, 0, 7, 57, '10', '2016-11-29', 0, 0, '1479729319', ''),
(144, 0, 7, 58, '7', '2016-11-21', 0, 0, '1479729506', ''),
(145, 0, 7, 58, '7', '2016-11-24', 0, 0, '1479729506', ''),
(146, 0, 7, 58, '7', '2016-11-28', 0, 0, '1479729506', ''),
(147, 0, 7, 59, '5', '2016-11-21', 0, 0, '1479729864', ''),
(148, 0, 7, 59, '5', '2016-11-25', 0, 0, '1479729864', ''),
(149, 0, 7, 59, '5', '2016-11-28', 0, 0, '1479729864', ''),
(150, 0, 7, 60, '10', '2016-11-23', 0, 0, '1479883590', ''),
(151, 0, 7, 60, '20', '2016-11-27', 0, 0, '1479883590', ''),
(152, 0, 7, 61, '10', '2016-11-23', 0, 0, '1479886170', ''),
(153, 0, 7, 61, '15', '2016-11-28', 0, 0, '1479886170', ''),
(154, 0, 7, 62, '', '0000-00-00', 0, 0, '1480147111', ''),
(155, 8, 7, 63, '2', '2016-12-07', 0, 0, '1481607580', '1481610785'),
(156, 0, 7, 64, '5', '2016-12-14', 0, 0, '1482135213', ''),
(157, 0, 7, 64, '5', '2016-12-16', 0, 0, '1482135213', ''),
(158, 0, 7, 65, '10', '2017-01-19', 0, 0, '1484042682', ''),
(159, 0, 7, 65, '20', '2017-01-26', 0, 0, '1484042682', ''),
(160, 0, 7, 65, '30', '2017-01-30', 0, 0, '1484042682', ''),
(161, 0, 7, 66, '10', '2017-01-25', 0, 0, '1484042804', ''),
(162, 0, 7, 66, '20', '2017-01-31', 0, 0, '1484042804', ''),
(164, 0, 7, 68, '20', '2017-01-18', 0, 0, '1485763465', ''),
(165, 0, 7, 68, '20', '2017-01-26', 0, 0, '1485763465', ''),
(166, 0, 7, 69, '10', '2017-01-17', 0, 0, '1485763562', ''),
(167, 0, 7, 69, '20', '2017-01-26', 0, 0, '1485763562', ''),
(168, 0, 7, 70, '10', '2017-01-18', 0, 0, '1485763661', ''),
(169, 0, 7, 70, '25', '2017-01-26', 0, 0, '1485763661', ''),
(170, 8, 7, 67, '10', '2017-01-12', 2, 2, '1485844006', '1485844331'),
(171, 8, 7, 67, '20', '2017-01-19', 0, 0, '1485844006', '1485844331'),
(172, 8, 7, 67, '11', '2017-01-31', 0, 0, '1485844006', '1485844331');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `milestone_cost_description`
--

CREATE TABLE `milestone_cost_description` (
  `milestone_cost_description_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `cost_type` tinyint(4) NOT NULL COMMENT '1- labor 2- material 3- third party 4-travel cost ',
  `cost_description` varchar(1000) NOT NULL,
  `qty_amount` int(11) NOT NULL,
  `cost_per_unit` float NOT NULL,
  `unit` varchar(50) NOT NULL,
  `vat_percentage` float NOT NULL,
  `vat_amount` float NOT NULL,
  `cost_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `milestone_cost_description`
--

INSERT INTO `milestone_cost_description` (`milestone_cost_description_id`, `job_id`, `user_id`, `milestone_id`, `cost_type`, `cost_description`, `qty_amount`, `cost_per_unit`, `unit`, `vat_percentage`, `vat_amount`, `cost_total`) VALUES
(1, 206, 8, 13, 1, 'Labor Cost', 2, 50, 'hr', 10, 10, 110),
(2, 206, 8, 14, 1, 'Cost Description', 1, 1000, 'day', 25, 250, 1250),
(3, 206, 8, 15, 1, 'Cost Description', 3, 25, 'hr', 9, 6.75, 81.75),
(4, 206, 8, 13, 2, 'Material Cost', 2, 200, 'day', 20, 80, 480),
(5, 206, 8, 15, 3, 'Third party cost', 5, 100, 'hr', 10, 50, 550),
(6, 206, 8, 16, 4, 'Travel cost description', 1, 1000, 'day', 5, 50, 1050),
(7, 206, 8, 13, 4, 'Travel cost', 5, 1225, 'day', 10, 612.5, 6737.5),
(8, 206, 8, 13, 3, 'Third Party Cost', 1, 25, 'hr', 5, 1.25, 26.25),
(9, 208, 8, 86, 1, 'labour Cost des', 1, 10, 'hr', 2, 0.2, 10.2),
(10, 208, 8, 87, 4, 'Travel Cost Description', 1, 12, 'hr', 5, 0.6, 12.6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `owner_milestone`
--

CREATE TABLE `owner_milestone` (
  `owner_milestone_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `owner_milestone_name` varchar(250) NOT NULL,
  `owner_milestone_date` date NOT NULL,
  `owner_milestone_quote` double NOT NULL,
  `owner_milestone_description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `owner_milestone`
--

INSERT INTO `owner_milestone` (`owner_milestone_id`, `job_id`, `owner_milestone_name`, `owner_milestone_date`, `owner_milestone_quote`, `owner_milestone_description`) VALUES
(339, 208, 'Milestone#1', '2017-04-15', 10, 'Milestone#1 Description'),
(340, 208, 'Milestone#2', '2017-04-20', 20, 'Milestone#2 Descriptio'),
(343, 205, 'MilestoneBidTemplate#1', '2017-04-30', 5, 'MilestoneBidTemplate#1 Desc'),
(338, 206, 'Milestone#2', '2017-03-30', 20, 'Milestone#2 Description'),
(337, 206, 'Milestone#1', '2017-03-21', 10, 'Milestone#1 Description'),
(334, 207, 'Milestone#1', '2017-03-29', 10, 'Milestone#1 Description'),
(335, 207, 'Milestone#2', '2017-03-15', 20, 'Milestone#2 Description'),
(336, 207, 'Milestone#3', '2017-03-28', 30, 'Milestone#3 Description');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `owner_milestone_upload`
--

CREATE TABLE `owner_milestone_upload` (
  `owner_milestone_upload_id` int(11) NOT NULL,
  `owner_milestone_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `owner_milestone_upload_location` varchar(128) NOT NULL,
  `owner_milestone_upload_created` int(11) NOT NULL,
  `owner_milestone_upload_key` varchar(128) NOT NULL,
  `owner_milestone_upload_file_size` int(128) NOT NULL,
  `owner_milestone_upload_file_type` varchar(128) NOT NULL,
  `owner_milestone_upload_original_name` varchar(128) NOT NULL,
  `owner_milestone_upload_identify` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `owner_milestone_upload`
--

INSERT INTO `owner_milestone_upload` (`owner_milestone_upload_id`, `owner_milestone_id`, `job_id`, `owner_milestone_upload_location`, `owner_milestone_upload_created`, `owner_milestone_upload_key`, `owner_milestone_upload_file_size`, `owner_milestone_upload_file_type`, `owner_milestone_upload_original_name`, `owner_milestone_upload_identify`) VALUES
(196, 0, 206, '86aadb62b9f8e2eef78b5f9283c28700', 1488442048, '', 28, '.png', 'profile-icon-1.png', 1),
(197, 337, 206, '09155d1d3641443d3aa4cf714074903f', 1488442321, '', 28, '.png', 'profile-icon-1.png', 2),
(198, 338, 206, '7de7fbb0e66f1cacdc14205a694fc8b0', 1488442321, '', 14, '.png', 'transparent-green-checkmark-hi.png', 2),
(199, 338, 206, '24cc5c631a4060a185531705323e2258', 1488442321, '', 14, '.png', 'transparent-green-checkmark-hi.png', 2),
(200, 0, 207, '3cfe9045ff9e3fe2f41f12e052b167d3', 1488445865, '', 28, '.png', 'profile-icon-1.png', 1),
(201, 0, 207, '4c795de3fc1d48d37540a19610d187b1', 1488445866, '', 14, '.png', 'transparent-green-checkmark-hi.png', 1),
(202, 334, 207, '4544e98b19839de8565c1d59b4e241a1', 1488445868, '', 183, '.jpg', 'Lord-Shiva-Photos9.jpg11.jpg', 2),
(203, 334, 207, '6d30747acbd7fa0a8123c1a3af978b72', 1488446439, '', 28, '.png', 'profile-icon-1.png', 2),
(204, 335, 207, '4b483193f03aa6919b18077ca69ed81a', 1488446439, '', 14, '.png', 'transparent-green-checkmark-hi.png', 2),
(205, 335, 207, 'e4ef5cd4f16c946b2a1f71adc49b9c5b', 1488447080, '', 28, '.png', 'profile-icon-1.png', 2),
(206, 336, 207, 'd1c7040622ef92ad730e6aa64bc12b68', 1488447081, '', 14, '.png', 'transparent-green-checkmark-hi.png', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `isactive` tinyint(4) NOT NULL,
  `credits` int(11) NOT NULL,
  `total_days` int(11) NOT NULL,
  `created_date` int(11) NOT NULL,
  `updated_date` int(11) NOT NULL,
  `amount` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `description`, `isactive`, `credits`, `total_days`, `created_date`, `updated_date`, `amount`) VALUES
(1, 'package1', 'asdsad osiaduso aiudosai udosaiudosaiudosiad usoaid usaoid', 1, 17, 60, 1422089988, 1422089988, 20),
(2, 'test pack 2', 'fds dsfdsfdsdfsfds fds dsfdsfdsdfsfds fds dsfdsfdsdfsfds', 1, 12, 90, 1422691934, 1422691934, 30);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `page`
--

CREATE TABLE `page` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `url` varchar(64) CHARACTER SET utf8 NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `page_title` varchar(128) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `page`
--

INSERT INTO `page` (`id`, `url`, `name`, `page_title`, `content`, `is_active`, `created`) VALUES
(19, 'condition', 'Terms & Conditions', 'Terms & Conditions', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 1, 1247560783),
(21, 'privacy', 'Privacy Policy', 'Privacy Policy', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>', 1, 1247762486),
(22, 'about', 'About Consultant Marketplace', 'About', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>', 1, 1343119726),
(23, 'help', 'Help', 'help', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>', 1, 1343119748);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `payments`
--

CREATE TABLE `payments` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `title` varchar(32) NOT NULL,
  `deposit_description` text NOT NULL,
  `withdraw_description` text NOT NULL,
  `is_deposit_enabled` tinyint(4) NOT NULL DEFAULT '1',
  `is_withdraw_enabled` tinyint(4) NOT NULL DEFAULT '1',
  `deposit_minimum` tinyint(4) NOT NULL,
  `withdraw_minimum` tinyint(4) NOT NULL,
  `mail_id` varchar(128) NOT NULL,
  `url` varchar(255) NOT NULL,
  `commission` float NOT NULL,
  `is_enable` tinyint(1) NOT NULL,
  `url_status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `payments`
--

INSERT INTO `payments` (`id`, `title`, `deposit_description`, `withdraw_description`, `is_deposit_enabled`, `is_withdraw_enabled`, `deposit_minimum`, `withdraw_minimum`, `mail_id`, `url`, `commission`, `is_enable`, `url_status`) VALUES
(1, 'paypal', 'Make a deposit using online payment service PayPal accounts are accepted.', 'Make a withdrawal using online payment service PayPal.com.', 1, 1, 5, 2, 'simonemassei@fastwebnet.it', 'https://www.sandbox.paypal.com/cgi-bin/webscri', 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `popular_search`
--

CREATE TABLE `popular_search` (
  `id` int(11) NOT NULL,
  `keyword` varchar(256) CHARACTER SET utf8 NOT NULL,
  `type` enum('work','user','job') NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `popular_search`
--

INSERT INTO `popular_search` (`id`, `keyword`, `type`, `created`) VALUES
(1, 'test', '', 1423076222),
(2, 'consultant', 'user', 1423076239),
(3, 'consultant', 'user', 1423135158),
(4, 'consultant', 'user', 1423135431),
(5, 'consultant', 'user', 1423395711),
(6, 'consultant', 'user', 1423629523),
(7, 'consultant', 'user', 1423629531),
(8, 'consultant', 'user', 1423629538),
(9, 'consultant', 'user', 1423629870),
(10, 'overall testing', '', 1423729411),
(11, 'overall testing', '', 1423729423),
(12, 'overall testing', '', 1423729454),
(13, 'overall testing', '', 1423729474),
(14, 'employee', 'user', 1423729677),
(15, 'employee', 'user', 1423730318),
(16, 'employee', 'user', 1423730324),
(17, 'overall test', '', 1423733071),
(18, 'consultant', 'user', 1423760531),
(19, 'consultant', 'user', 1424052746),
(20, 'consultant', 'user', 1424065015),
(21, 'employee', 'user', 1424068369),
(22, 'consultant', 'user', 1424136949),
(23, 'consultant', 'user', 1424420468),
(24, 'employee', 'user', 1424420508),
(25, 'employee', 'user', 1424420525),
(26, 'consultant', 'user', 1424421499),
(27, 'employee', 'user', 1424422262),
(28, 'consultant', 'user', 1424429046),
(29, 'consultant', 'user', 1424658025),
(30, 'consultant', 'user', 1424670864),
(31, 'consultant', 'user', 1424806012),
(32, 'employee', 'user', 1424806023),
(33, 'consultant', 'user', 1424846946),
(34, 'employee', 'user', 1424846954),
(35, 'consultant', 'user', 1424869074),
(36, 'consultant', 'user', 1425239495),
(37, 'employee', 'user', 1425239537),
(38, 'overall testing', '', 1425282427),
(39, 'consultant', 'user', 1425327059),
(40, 'employee', 'user', 1425327059),
(41, 'consultant', 'user', 1425419530),
(42, 'consultant', 'user', 1425547282),
(43, 'employee', 'user', 1425554598),
(44, 'employee', 'user', 1425676233),
(45, 'employee', 'user', 1425779762),
(46, 'consultant', 'user', 1426003462),
(47, 'consultant', 'user', 1426291819),
(48, 'employee', 'user', 1426291819),
(49, 'consultant', 'user', 1426291830),
(50, 'consultant', 'user', 1426291835),
(51, 'employee', 'user', 1426291835),
(52, 'employee', 'user', 1426292001),
(53, 'consultant', 'user', 1426292029),
(54, 'employee', 'user', 1426292077),
(55, 'consultant', 'user', 1426489076),
(56, 'consultant', 'user', 1426512754),
(57, 'consultant', 'user', 1426562163),
(58, 'consultant', 'user', 1426574928),
(59, 'consultant', 'user', 1426663634),
(60, 'consultant', 'user', 1426667282),
(61, 'employee', 'user', 1427007291),
(62, 'employee', 'user', 1427007296),
(63, 'consultant', 'user', 1427007301),
(64, 'consultant', 'user', 1427007307),
(65, 'consultant', 'user', 1427018646),
(66, ' ', '', 1427173826),
(67, ' ', '', 1427174187),
(68, 'IT', '', 1427193743),
(69, 'IT', '', 1427194042),
(70, 'consultant', 'user', 1427281673),
(71, 'consultant', 'user', 1427285340),
(72, 'employee', 'user', 1428202745),
(73, 'employee', 'user', 1428202750),
(74, 'consultant', 'user', 1428202755),
(75, 'consultant', 'user', 1428202760),
(76, 'consultant', 'user', 1428297067),
(77, 'consultant', 'user', 1428624936),
(78, 'employee', 'user', 1428624939),
(79, 'consultant', 'user', 1428624945),
(80, 'employee', 'user', 1428624947),
(81, 'employee', 'user', 1428970756),
(82, 'consultant', 'user', 1428970757),
(83, 'consultant', 'user', 1428970768),
(84, 'consultant', 'user', 1428970776),
(85, 'employee', 'user', 1428970777),
(86, 'employee', 'user', 1428971015),
(87, 'consultant', 'user', 1428971152),
(88, 'employee', 'user', 1428971291),
(89, 'consultant', 'user', 1429001747),
(90, 'employee', 'user', 1429639465),
(91, 'employee', 'user', 1429639470),
(92, 'consultant', 'user', 1429639474),
(93, 'consultant', 'user', 1429639479),
(94, 'consultant', 'user', 1429776722),
(95, 'employee', 'user', 1429776733),
(96, 'consultant', 'user', 1429776864),
(97, 'employee', 'user', 1429776867),
(98, 'employee', 'user', 1430062127),
(99, 'consultant', 'user', 1430109733),
(100, 'consultant', 'user', 1430111165),
(101, 'consultant', 'user', 1430370247),
(102, 'consultant', 'user', 1430708744),
(103, 'employee', 'user', 1430708745),
(104, 'consultant', 'user', 1430708753),
(105, 'employee', 'user', 1430708759),
(106, 'employee', 'user', 1430736879),
(107, 'consultant', 'user', 1430785461),
(108, 'consultant', 'user', 1430826971),
(109, 'Project Documentation', '', 1430890747),
(110, 'Project Milestone Test1', '', 1430890877),
(111, 'consultant', 'user', 1430938926),
(112, 'employee', 'user', 1430955128),
(113, 'employee', 'user', 1430955133),
(114, 'consultant', 'user', 1430955138),
(115, 'consultant', 'user', 1430955143),
(116, 'consultant', 'user', 1431025594),
(117, 'consultant', 'user', 1431615449),
(118, 'employee', 'user', 1431615450),
(119, 'consultant', 'user', 1431615465),
(120, 'consultant', 'user', 1431615473),
(121, 'employee', 'user', 1431615474),
(122, 'employee', 'user', 1431615769),
(123, 'consultant', 'user', 1431615942),
(124, 'employee', 'user', 1431616174),
(125, 'employee', 'user', 1431740043),
(126, 'consultant', 'user', 1431804215),
(127, 'employee', 'user', 1431804232),
(128, 'employee', 'user', 1431806508),
(129, 'consultant', 'user', 1431806904),
(130, 'employee', 'user', 1431806914),
(131, 'consultant', 'user', 1431821923),
(132, 'employee', 'user', 1431821930),
(133, 'consultant', 'user', 1431872091),
(134, 'employee', 'user', 1431872093),
(135, 'consultant', 'user', 1432021388),
(136, 'employee', 'user', 1432021391),
(137, 'consultant', 'user', 1432054695),
(138, 'employee', 'user', 1432054697),
(139, 'consultant', 'user', 1432215057),
(140, 'employee', 'user', 1432215059),
(141, 'consultant', 'user', 1432237059),
(142, 'employee', 'user', 1432257458),
(143, 'consultant', 'user', 1432257834),
(144, 'consultant', 'user', 1432316602),
(145, 'employee', 'user', 1432328559),
(146, 'employee', 'user', 1432328564),
(147, 'consultant', 'user', 1432328569),
(148, 'consultant', 'user', 1432328574),
(149, 'employee', 'user', 1432429599),
(150, 'consultant', 'user', 1432429599),
(151, 'consultant', 'user', 1432429623),
(152, 'employee', 'user', 1432429623),
(153, 'consultant', 'user', 1432536718),
(154, 'consultant', 'user', 1432560772),
(155, 'employee', 'user', 1432560774),
(156, 'consultant', 'user', 1432739216),
(157, 'employee', 'user', 1432739220),
(158, 'consultant', 'user', 1432763115),
(159, 'consultant', 'user', 1433079070),
(160, 'consultant', 'user', 1433214858),
(161, 'consultant', 'user', 1433218657),
(162, 'consultant', 'user', 1433230715),
(163, 'consultant', 'user', 1433253274),
(164, 'consultant', 'user', 1433276732),
(165, 'consultant', 'user', 1433327073),
(166, 'consultant', 'user', 1433387517),
(167, 'consultant', 'user', 1433409025),
(168, 'consultant', 'user', 1433429753),
(169, 'consultant', 'user', 1433455252),
(170, 'consultant', 'user', 1433470525),
(171, 'consultant', 'user', 1433484984),
(172, 'consultant', 'user', 1433509811),
(173, 'consultant', 'user', 1433512053),
(174, 'employee', 'user', 1433512510),
(175, 'consultant', 'user', 1433523804),
(176, 'consultant', 'user', 1433533060),
(177, 'consultant', 'user', 1433546717),
(178, 'consultant', 'user', 1433561293),
(179, 'consultant', 'user', 1433579567),
(180, 'consultant', 'user', 1433596168),
(181, 'consultant', 'user', 1433622290),
(182, 'consultant', 'user', 1433639270),
(183, 'consultant', 'user', 1433657482),
(184, 'consultant', 'user', 1433674792),
(185, 'consultant', 'user', 1433691856),
(186, 'consultant', 'user', 1433710467),
(187, 'consultant', 'user', 1433733784),
(188, 'consultant', 'user', 1433751058),
(189, 'consultant', 'user', 1433765120),
(190, 'consultant', 'user', 1433798002),
(191, 'consultant', 'user', 1434178913),
(192, 'employee', 'user', 1434181819),
(193, 'employee', 'user', 1434268252),
(194, 'consultant', 'user', 1434268253),
(195, 'consultant', 'user', 1434268258),
(196, 'consultant', 'user', 1434268262),
(197, 'employee', 'user', 1434268262),
(198, 'employee', 'user', 1434268424),
(199, 'consultant', 'user', 1434268520),
(200, 'employee', 'user', 1434268648),
(201, 'employee', 'user', 1434274193),
(202, 'consultant', 'user', 1434274214),
(203, 'consultant', 'user', 1434383612),
(204, 'consultant', 'user', 1435544748),
(205, 'employee', 'user', 1435544749),
(206, 'consultant', 'user', 1435733339),
(207, 'employee', 'user', 1435733341),
(208, 'consultant', 'user', 1435789044),
(209, 'employee', 'user', 1435852819),
(210, 'consultant', 'user', 1436087856),
(211, 'consultant', 'user', 1436156582),
(212, 'employee', 'user', 1436160532),
(213, 'consultant', 'user', 1436324602),
(214, 'employee', 'user', 1436416688),
(215, 'employee', 'user', 1436416694),
(216, 'consultant', 'user', 1436416699),
(217, 'consultant', 'user', 1436416703),
(218, 'employee', 'user', 1436856444),
(219, 'consultant', 'user', 1436856445),
(220, 'consultant', 'user', 1436856452),
(221, 'consultant', 'user', 1436856457),
(222, 'employee', 'user', 1436856457),
(223, 'employee', 'user', 1436856583),
(224, 'consultant', 'user', 1436856661),
(225, 'employee', 'user', 1436856760),
(226, 'elance', '', 1437029435),
(227, 'employee', 'user', 1437124917),
(228, 'employee', 'user', 1437410178),
(229, 'consultant', 'user', 1437500124),
(230, 'employee', 'user', 1437524141),
(231, 'employee', 'user', 1437636443),
(232, 'employee', 'user', 1437685040),
(233, 'employee', 'user', 1437685045),
(234, 'consultant', 'user', 1437685050),
(235, 'consultant', 'user', 1437685055),
(236, 'employee', 'user', 1437805041),
(237, 'employee', 'user', 1437941214),
(238, 'consultant', 'user', 1438074058),
(239, 'consultant', 'user', 1438144516),
(240, 'employee', 'user', 1438236056),
(241, 'consultant', 'user', 1438270108),
(242, 'consultant', 'user', 1438411037),
(243, 'employee', 'user', 1438411044),
(244, 'employee', 'user', 1438451555),
(245, 'employee', 'user', 1438697543),
(246, 'employee', 'user', 1439052599),
(247, 'employee', 'user', 1439052604),
(248, 'consultant', 'user', 1439052609),
(249, 'consultant', 'user', 1439052614),
(250, 'employee', 'user', 1439222680),
(251, 'consultant', 'user', 1439390604),
(252, 'employee', 'user', 1439501791),
(253, 'consultant', 'user', 1439881892),
(254, 'employee', 'user', 1439881894),
(255, 'consultant', 'user', 1439932965),
(256, 'consultant', 'user', 1440266949),
(257, 'employee', 'user', 1440429360),
(258, 'employee', 'user', 1440429365),
(259, 'consultant', 'user', 1440429371),
(260, 'consultant', 'user', 1440429376),
(261, 'consultant', 'user', 1440669860),
(262, 'employee', 'user', 1440669868),
(263, 'consultant', 'user', 1440988999),
(264, 'consultant', 'user', 1441740669),
(265, 'employee', 'user', 1441746668),
(266, 'employee', 'user', 1441809999),
(267, 'employee', 'user', 1441810004),
(268, 'consultant', 'user', 1441810010),
(269, 'consultant', 'user', 1441810015),
(270, 'employee', 'user', 1441923281),
(271, 'consultant', 'user', 1442012768),
(272, 'employee', 'user', 1442053342),
(273, 'employee', 'user', 1442101060),
(274, 'consultant', 'user', 1442220078),
(275, 'consultant', 'user', 1442385420),
(276, 'consultant', 'user', 1442558959),
(277, 'consultant', 'user', 1442564936),
(278, 'employee', 'user', 1442720879),
(279, 'consultant', 'user', 1442881666),
(280, 'employee', 'user', 1442881669),
(281, 'consultant', 'user', 1442882177),
(282, 'employee', 'user', 1442882178),
(283, 'employee', 'user', 1443072009),
(284, 'employee', 'user', 1443216065),
(285, 'employee', 'user', 1443216070),
(286, 'consultant', 'user', 1443216075),
(287, 'consultant', 'user', 1443216080),
(288, 'consultant', 'user', 1443247976),
(289, 'consultant', 'user', 1443435095),
(290, 'consultant', 'user', 1443646775),
(291, 'employee', 'user', 1443667456),
(292, 'consultant', 'user', 1443841677),
(293, 'consultant', 'user', 1444047955),
(294, 'employee', 'user', 1444047992),
(295, 'consultant', 'user', 1444055204),
(296, 'employee', 'user', 1444055261),
(297, 'consultant', 'user', 1444057208),
(298, 'consultant', 'user', 1444219104),
(299, 'consultant', 'user', 1444407040),
(300, 'consultant', 'user', 1444433884),
(301, 'consultant', 'user', 1444591975),
(302, 'employee', 'user', 1444644786),
(303, 'consultant', 'user', 1444727519),
(304, 'consultant', 'user', 1444769365),
(305, 'employee', 'user', 1444848438),
(306, 'employee', 'user', 1444848444),
(307, 'consultant', 'user', 1444848449),
(308, 'consultant', 'user', 1444848453),
(309, 'consultant', 'user', 1444952344),
(310, 'consultant', 'user', 1445151448),
(311, 'consultant', 'user', 1445222268),
(312, 'employee', 'user', 1445222268),
(313, 'employee', 'user', 1445222279),
(314, 'consultant', 'user', 1445222279),
(315, 'consultant', 'user', 1445332317),
(316, 'consultant', 'user', 1445535803),
(317, 'consultant', 'user', 1445695684),
(318, 'employee', 'user', 1445695684),
(319, 'consultant', 'user', 1445740623),
(320, 'consultant', 'user', 1445776550),
(321, 'employee', 'user', 1445776560),
(322, 'consultant', 'user', 1445776948),
(323, 'employee', 'user', 1445776951),
(324, 'consultant', 'user', 1446005399),
(325, 'employee', 'user', 1446005402),
(326, 'consultant', 'user', 1446183311),
(327, 'employee', 'user', 1446183313),
(328, 'consultant', 'user', 1446192779),
(329, 'consultant', 'user', 1446192779),
(330, 'employee', 'user', 1446192780),
(331, 'employee', 'user', 1446192780),
(332, 'consultant', 'user', 1446429138),
(333, 'employee', 'user', 1446429140),
(334, 'consultant', 'user', 1446534971),
(335, 'consultant', 'user', 1446582957),
(336, 'employee', 'user', 1446582959),
(337, 'consultant', 'user', 1446714947),
(338, 'consultant', 'user', 1446783337),
(339, 'employee', 'user', 1446783339),
(340, 'employee', 'user', 1446817559),
(341, 'employee', 'user', 1446836646),
(342, 'employee', 'user', 1446853045),
(343, 'employee', 'user', 1446912741),
(344, 'consultant', 'user', 1446967636),
(345, 'employee', 'user', 1446967660),
(346, 'consultant', 'user', 1447142335),
(347, 'employee', 'user', 1447142338),
(348, 'consultant', 'user', 1447413112),
(349, 'employee', 'user', 1447413117),
(350, 'consultant', 'user', 1447503732),
(351, 'employee', 'user', 1447503732),
(352, 'employee', 'user', 1447517488),
(353, 'consultant', 'user', 1447518119),
(354, 'consultant', 'user', 1447677274),
(355, 'employee', 'user', 1447677274),
(356, 'consultant', 'user', 1447677274),
(357, 'employee', 'user', 1447677275),
(358, 'consultant', 'user', 1447724437),
(359, 'consultant', 'user', 1447793733),
(360, 'employee', 'user', 1447793734),
(361, 'consultant', 'user', 1448031946),
(362, 'employee', 'user', 1448031950),
(363, 'consultant', 'user', 1457353283),
(364, 'consultant', 'user', 1459617710),
(365, 'consultant', 'user', 1459617722),
(366, 'test', 'job', 1460807035),
(367, 'test', 'job', 1460807098),
(368, 'test', 'job', 1460807101),
(369, 'test', 'job', 1460807107),
(370, 'help', 'job', 1460807116),
(371, 'test', 'job', 1460807120),
(372, 'consultant', 'user', 1460808017),
(373, 'consultant', 'user', 1460808023),
(374, 'test', 'job', 1460823935),
(375, 'help', 'job', 1460823937),
(376, 'test', 'job', 1460824045),
(377, 'test', 'job', 1460824050),
(378, 'consultant', 'user', 1460870094),
(379, 'consultant', 'user', 1461179877),
(380, 'consultant', 'user', 1461179877),
(381, 'i', 'job', 1461180821),
(382, 'i', 'job', 1461180831),
(383, 'i', 'job', 1461180837),
(384, 'i', 'job', 1461180840),
(385, 'i', 'job', 1461180842),
(386, 'i', 'job', 1461180847),
(387, 'i', 'job', 1461180857),
(388, 'i', 'job', 1461969254),
(389, 'employee', 'user', 1461969265),
(390, 'help', 'job', 1463601765),
(391, 'test', 'job', 1469330693),
(392, 'test', 'job', 1469467877),
(393, 'ad', 'job', 1477294546),
(394, 'test', 'job', 1477294553),
(395, 'test', 'job', 1477294573),
(396, 'test', 'job', 1477294578),
(397, 'test', 'job', 1477294622),
(398, 'testing project', 'job', 1477399856),
(399, 'testing project', 'job', 1477547353),
(400, 'testing project', 'job', 1477547897),
(401, 'testing project', 'job', 1477547934),
(402, 'testing project', 'job', 1477547950),
(403, 'testing project', 'job', 1477548451),
(404, 'testing project', 'job', 1477548456),
(405, 'testing project', 'job', 1477549819),
(406, 'testcdeggh', 'job', 1477895265),
(407, 'testcdeggh', 'job', 1477895271),
(408, 'TEST for Syed', 'job', 1477895336),
(409, 'Market place', 'job', 1477896606),
(410, 'Market place', 'job', 1477896620),
(411, 'Search Job', 'job', 1477900539),
(412, 'Search Job', 'job', 1477900921),
(413, 'Search Job', 'job', 1477900968),
(414, 'Market place', 'job', 1477902618),
(415, 'Market place', 'job', 1477902627),
(416, 'Market place', 'job', 1477902637),
(417, 'test', 'job', 1477970187),
(418, 'TEST for Syed', 'job', 1477970225),
(419, 'TEST for Syed', 'job', 1477970232),
(420, 'Search Job', 'job', 1477982305),
(421, 'Search Job', 'job', 1477982788),
(422, 'employee', 'user', 1477982850),
(423, 'consultant', 'user', 1477982854),
(424, 'consultant', 'user', 1477982861),
(425, 'Search Job', 'job', 1477984020),
(426, 'Search Job', 'job', 1477984049),
(427, 'Search Job', 'job', 1477984060),
(428, 'Search Job', 'job', 1477984070),
(429, 'Search Job', 'job', 1477984106),
(430, 'Search Projects', 'job', 1477984169),
(431, 'Search Job', 'job', 1477984189),
(432, 'Search Job', 'job', 1477984433),
(433, 'Search Job', 'job', 1477984451),
(434, 'Search Job', 'job', 1477984468),
(435, 'Market place', 'job', 1478070002),
(436, 'consultant', 'user', 1478172863),
(437, 'engineering', 'job', 1494075092);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `payment_method` tinyint(4) NOT NULL COMMENT '0- fixed payment 1- hourly payment',
  `use_range` tinyint(4) NOT NULL COMMENT '0- not selected 1- seleted',
  `price` int(100) NOT NULL,
  `skill` int(11) NOT NULL,
  `header_img` int(11) NOT NULL,
  `thumbnail_img` int(11) NOT NULL,
  `machine_description` varchar(2500) NOT NULL,
  `characteristics` varchar(2000) NOT NULL,
  `value` varchar(2000) NOT NULL,
  `remarks` varchar(2000) NOT NULL,
  `categories` varchar(1000) NOT NULL,
  `main_img` varchar(200) NOT NULL,
  `attachment1` varchar(200) NOT NULL,
  `attachment2` varchar(200) NOT NULL,
  `attachment3` varchar(255) NOT NULL,
  `attachment4` varchar(255) NOT NULL,
  `attachment5` varchar(255) NOT NULL,
  `team_member_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `portfolio`
--

INSERT INTO `portfolio` (`id`, `user_id`, `title`, `payment_method`, `use_range`, `price`, `skill`, `header_img`, `thumbnail_img`, `machine_description`, `characteristics`, `value`, `remarks`, `categories`, `main_img`, `attachment1`, `attachment2`, `attachment3`, `attachment4`, `attachment5`, `team_member_id`) VALUES
(14, 25, 'portfolio', 0, 1, 999, 23, 118, 119, 'Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description Portfolio description', '', '', '', '118,121', '', '', '', '', '', '', 0),
(22, 8, 'Portfolio #7', 0, 0, 60, 0, 0, 0, 'Machine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine Description', 'Characteristics #7', 'value #7', 'Remarks #7', '177,31,32,33,34,35,36', '', '', '', '', '', '', 0),
(23, 8, 'Portfolio #8', 0, 0, 65, 0, 0, 0, 'Machine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description', 'Characteristics #8', 'value #8', 'remarks #8', '14,15,16,17,18,21,22', '', '', '', '', '', '', 0),
(19, 8, 'Portfolio #4', 1, 0, 25, 0, 0, 0, 'Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description', 'Characteristics #4', 'value #4', 'remarks #4', '37,38,41,42', '', '', '', '', '', '', 0),
(20, 8, 'Portfolio #5', 1, 0, 25, 0, 0, 0, 'Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description', 'Characteristics #4', 'value #4', 'remarks #4', '15,16,22,31', '', '', '', '', '', '', 0),
(21, 8, 'Portfolio #6', 0, 0, 55, 0, 0, 0, 'Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description', 'Characteristics #6', 'value #6', 'remarks #6', '41,42,43,44', '', '', '', '', '', '', 0),
(15, 8, 'Portfolio #1', 0, 0, 1000, 0, 0, 0, 'Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description', 'Input Characteristics', 'input Value', 'input Remarks', '14,15,16,22', '', '', '', '', '', '', 0),
(16, 8, 'Portfolio #2', 0, 0, 100, 0, 0, 0, 'Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description', 'Characteristics #2 ', 'Value #2', 'Remarks #2', '16,17,18,33,34', '', '', '', '', '', '', 0),
(17, 8, 'Portfolio #3', 0, 0, 75, 0, 0, 0, 'Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description', 'Characteristics #3', 'value #3', 'remarks #3', '39,41,42,43,44', '', '', '', '', '', '', 0),
(24, 8, 'Portfolio #9', 1, 0, 65, 0, 0, 0, 'Machine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine DescriptionMachine Description', 'Characteristics #9', 'value #9', 'remarks #9', '45,46,47,48,49,50', '', '', '', '', '', '', 0),
(25, 8, 'Portfolio#10', 0, 0, 100, 0, 0, 0, 'Machine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description', 'Characteristics #10', 'value #10', 'remarks #10', '14,15,16,17,18,21,22', '', '', '', '', '', '', 0),
(26, 8, 'Portfolio#11', 1, 0, 120, 0, 0, 0, 'Machine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description\r\nMachine Description', 'Characteristics #11', 'value#11', 'remarks#11', '177,31,32,33,34,35,36', '', '', '', '', '', '', 0),
(27, 8, 'Portfolio#12', 0, 0, 60, 0, 0, 0, 'Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description', 'Characteristics #12', 'value #12', 'remarks #12', '21,32,34,36', '', '', '', '', '', '', 40),
(28, 8, 'Portfolio#13', 1, 0, 40, 0, 0, 0, 'Machine Description  Machine Description  Machine Description  Machine Description  Machine Description  Machine Description  Machine Description  Machine Description  Machine Description  Machine Description', 'Characteristics #13', 'value #13', 'remarks #13', '14,15,16,17,18', '', '', '', '', '', '', 40),
(29, 8, 'Portfolio#14', 0, 0, 75, 0, 0, 0, 'Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description Machine Description', 'Characteristics #14', 'value #14', 'remarks #14', '15,177,31,32', '', '', '', '', '', '', 40);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `portfolio_uploads`
--

CREATE TABLE `portfolio_uploads` (
  `id` int(11) NOT NULL,
  `portfolio_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ori_name` varchar(255) NOT NULL,
  `date` int(12) NOT NULL,
  `ext` varchar(12) NOT NULL,
  `filesize` int(20) NOT NULL,
  `description` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `portfolio_uploads`
--

INSERT INTO `portfolio_uploads` (`id`, `portfolio_id`, `folder_id`, `user_id`, `name`, `ori_name`, `date`, `ext`, `filesize`, `description`) VALUES
(115, 13, 11, 8, '6cb9efc098b653653ddee8e8d1e8dab3', 'photo1.jpg', 1481780371, '.jpg', 3, 'Portfolio attachment 1'),
(116, 13, 13, 8, '1f9dd7789f81ba58949a0cb8c0ff2417', 'company.jpg', 1481853163, '.jpg', 17, 'Portfolio attachment 3'),
(118, 14, 0, 25, 'ca51abdd5b12730cf3f39e8a961eade1', 'email-send-ss-1920-800x450.jpg', 1483689052, '.jpg', 79, ''),
(119, 14, 0, 25, 'd995ea76ab27a3fc5c232efe597de9a6', 'company.jpg', 1483689073, '.jpg', 17, ''),
(132, 15, 0, 8, '94362922b60c3f792bb40ae6ebbd5257', 'portfolio1.gif', 1484327286, '.gif', 234, ''),
(133, 16, 0, 8, '21710c8d19c3348e479edcfcea5bbeb8', 'Portfolio2.jpg', 1484637361, '.jpg', 65, ''),
(134, 17, 0, 8, 'db77c2bffa173ce699bf9e016b0ff4f7', 'portfolio3.jpg', 1484637490, '.jpg', 55, ''),
(135, 20, 0, 8, '184f12b5b0e9c836c846a61c87bf171b', 'portfolio5.jpg', 1484637853, '.jpg', 59, ''),
(136, 19, 0, 8, 'ed4e41f0c62e3ec39cb058f02a38ce83', 'portfolio6.jpg', 1484638119, '.jpg', 95, ''),
(137, 21, 0, 8, '0bafc6d83b78b1b608a22ac580c02035', 'portfolio9.jpg', 1484638447, '.jpg', 65, ''),
(138, 22, 0, 8, 'c8089173d3213ea03f9843aea05b5ff9', 'portfolio11.jpg', 1484638623, '.jpg', 50, ''),
(139, 23, 0, 8, 'f964b004469728c0a925c7ffd446c769', 'portfolio1.gif', 1484638773, '.gif', 234, ''),
(140, 24, 0, 8, '2e8e0169e974eb19c87324e8c7e1a4f1', 'Portfolio2.jpg', 1484638966, '.jpg', 65, ''),
(141, 25, 0, 8, '92d0a71f6bafd18213c3e5bca28bb336', 'portfolio3.jpg', 1484639087, '.jpg', 55, ''),
(142, 26, 0, 8, 'f3a0c6f70e5ae7cbae7feab27ec14797', 'portfolio5.jpg', 1484639353, '.jpg', 59, ''),
(143, 22, 0, 8, '4af71fd26a9d6c42a3e00d506518396a', 'Portfolio2.jpg', 1484721861, '.jpg', 65, 'Portfolio testing'),
(144, 27, 0, 8, '4287af0b5d9e66d4dc79797ddfc2c626', 'transparent-green-checkmark-hi.png', 1485786411, '.png', 14, ''),
(145, 28, 0, 8, '387ce0067c5b58496f3c977d83df7ead', 'Tulips.jpg', 1485787239, '.jpg', 606, ''),
(146, 29, 0, 8, '028786432dcf2d8eff2cbfa040cfd256', 'Hydrangeas.jpg', 1485787504, '.jpg', 581, ''),
(147, 29, 0, 8, 'baf8f53d78e759a171fb0e10618df48b', '575707_143957712445339_1332912855_n.jpg', 1485932415, '.jpg', 49, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `project_bid_upload`
--

CREATE TABLE `project_bid_upload` (
  `project_bid_upload_id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `employee_milestone_id` int(11) NOT NULL,
  `project_bid_upload_location` varchar(128) NOT NULL,
  `project_bid_upload_created` int(11) NOT NULL,
  `project_bid_upload_key` varchar(128) NOT NULL,
  `project_bid_upload_file_size` int(128) NOT NULL,
  `project_bid_upload_file_type` varchar(128) NOT NULL,
  `project_bid_upload_original_name` varchar(128) NOT NULL,
  `project_bid_upload_identify` varchar(128) NOT NULL COMMENT '1- project upload 2- milestone upload'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `project_bid_upload`
--

INSERT INTO `project_bid_upload` (`project_bid_upload_id`, `bid_id`, `employee_milestone_id`, `project_bid_upload_location`, `project_bid_upload_created`, `project_bid_upload_key`, `project_bid_upload_file_size`, `project_bid_upload_file_type`, `project_bid_upload_original_name`, `project_bid_upload_identify`) VALUES
(8, 100, 0, 'f58fc6eedc4ea29a0a5b743b036a3f97', 1486199358, '', 248, '.docx', 'Doubts on Group Permissionn.docx', '1'),
(20, 0, 5, '2fd46e9d016c919ade28834cc4ff718c', 1486210966, '', 248, '.docx', 'Doubts on Group Permission.docx', '2'),
(18, 0, 6, '44baa9582a443b130545f8c3c116be31', 1486210941, '', 248, '.docx', 'Doubts on Group Permission.docx', '2'),
(19, 0, 6, '878f69887272d8f03b5688b3630e145b', 1486210941, '', 248, '.docx', 'Doubts on Group Permissionn.docx', '2'),
(21, 0, 13, 'cf45d530d92884f1787214cbc767491e', 1491392099, '', 248, '.docx', 'Doubts on Group Permissionn.docx', '2'),
(23, 0, 14, '2646add3306e429f8c7e8d5b7c0643c8', 1491558776, '', 536, '.docx', 'Barnet search explanation.docx', '2'),
(24, 0, 14, 'a09e7ad395055db8773fcc6f1ef6de72', 1491558818, '', 18, '.docx', 'Meta_Tags_movesavers.co.uk.docx', '2'),
(25, 0, 14, '21060d892b1977ec0123dcc9ccf3983b', 1491558818, '', 304, '.docx', 'Milestone workflow.docx', '2'),
(26, 0, 16, 'e2a5d67ddab011a14cff98da81690d25', 1491558860, '', 11, '.jpg', 'index.jpg', '2'),
(27, 0, 18, '6bde2997049e61a595ebe00d153051d2', 1491559083, '', 536, '.docx', 'Barnet search explanation.docx', '2'),
(28, 0, 18, 'b78ac0a05350a01e35da98c5d66f7212', 1491559083, '', 19, '.docx', 'childs hill.docx', '2'),
(29, 103, 0, '7c5fba979b03b3ac1db860bbee8e47b2', 1491640677, '', 248, '.docx', 'Doubts on Group Permission.docx', '1'),
(31, 103, 0, 'b60d4f27661e978acd33333fdfa3b5ac', 1491810312, '', 304, '.docx', 'Milestone workflow.docx', '1'),
(32, 0, 106, '9d9c51f3c858152a53aa0cba1d3d9d84', 1492862864, '', 18, '.docx', 'Meta_Tags_movesavers.co.uk.docx', '2'),
(33, 0, 87, '4cd7b53785f383136a527fb98dd366e8', 1492867039, '', 248, '.docx', 'Doubts on Group Permissionn.docx', '2'),
(34, 0, 107, '026b2f64d7e927d87985b386512d8840', 1492867188, '', 14, '.docx', 'New Microsoft Office Word Document.docx', '2'),
(35, 122, 0, 'ee2cc9a901b22baa9d0bc3eb63c32128', 1493046102, '', 19, '.docx', 'childs hill.docx', '1'),
(36, 0, 108, 'bba858d99e3191098ae100a9a5381043', 1493048719, '', 23, '.png', 'Default.png', '2'),
(37, 0, 108, '46fd25ba1217b5de1616809915c42712', 1493048719, '', 809, '.docx', 'Doubts in find mahinery.docx', '2'),
(38, 0, 109, '882cf75a76cfef25fbd79f7ddb870250', 1493048932, '', 19, '.docx', 'childs hill.docx', '2'),
(40, 0, 113, '026b2f64d7e927d87985b386512d8840', 1492867188, '', 14, '.docx', 'New Microsoft Office Word Document.docx', '2'),
(41, 0, 113, 'e5b51ff12acd28a30f6dd0830c11b825', 1493052670, '', 372, '.docx', 'RO.CA Changes V.4_12.03.16.docx', '2'),
(42, 0, 114, '5b733074e134f2a73d16e08f8df029b1', 1493202354, '', 18, '.docx', 'Meta_Tags_movesavers.co.uk.docx', '2'),
(43, 0, 114, '75b2a6a4cb57eabefa547b425779e9da', 1493202354, '', 304, '.docx', 'Milestone workflow.docx', '2'),
(44, 0, 115, '5b733074e134f2a73d16e08f8df029b1', 1493202354, '', 18, '.docx', 'Meta_Tags_movesavers.co.uk.docx', '2'),
(45, 0, 115, '75b2a6a4cb57eabefa547b425779e9da', 1493202354, '', 304, '.docx', 'Milestone workflow.docx', '2'),
(46, 0, 116, 'bba858d99e3191098ae100a9a5381043', 1493048719, '', 23, '.png', 'Default.png', '2'),
(47, 0, 116, '46fd25ba1217b5de1616809915c42712', 1493048719, '', 809, '.docx', 'Doubts in find mahinery.docx', '2'),
(48, 0, 116, '323987757cf45359654aefaf278c78a1', 1493223378, '', 14, '.docx', 'New Microsoft Office Word Document.docx', '2'),
(49, 0, 121, '4e098e732b00a11a4f195f386c757194', 1493485906, '', 304, '.docx', 'Milestone workflow.docx', '2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rating_hold`
--

CREATE TABLE `rating_hold` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `rating_hold`
--

INSERT INTO `rating_hold` (`id`, `user_id`, `rating`, `job_id`) VALUES
(7, 4, 10, 7),
(8, 7, 5, 25);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `report_violation`
--

CREATE TABLE `report_violation` (
  `id` int(11) NOT NULL,
  `job_id` varchar(128) NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `post_id` varchar(128) NOT NULL,
  `post_name` varchar(128) NOT NULL,
  `comment` text NOT NULL,
  `report_date` int(128) NOT NULL,
  `report_type` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `report_violation`
--

INSERT INTO `report_violation` (`id`, `job_id`, `job_name`, `post_id`, `post_name`, `comment`, `report_date`, `report_type`) VALUES
(13, '19', 'milesss1', '8', 'employee', 'Users who violate the Company terms, especially by posting contact information in an attempt to avoid our fees, negatively affect every other person who presently uses, and will use in the future, the services offered by Bidonn. We believe our fees are very fair for the service we offer our users. By preventing violations and banning users who do violate the terms, we can presently keep our fees low, lower those fees in the future, and generally provide a better service for everyone. Please help Bidonn by reporting any violations. Thank You!', 1423009617, 'Bid Report'),
(14, '19', 'milesss1', '8', 'employee', 'asdasd\nasdkas;kd\n;asdjlksjaj\nas;djlsajkdl\njklsajdlkj', 1423009668, 'Bid Report');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `comments` varchar(256) CHARACTER SET utf8 NOT NULL,
  `rating` int(11) NOT NULL,
  `review_time` int(11) NOT NULL,
  `review_type` enum('1','2') CHARACTER SET utf8 NOT NULL,
  `job_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `hold` enum('0','1') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `reviews`
--

INSERT INTO `reviews` (`id`, `comments`, `rating`, `review_time`, `review_type`, `job_id`, `owner_id`, `employee_id`, `hold`) VALUES
(1, '', 10, 1421017072, '1', 7, 4, 5, '0'),
(2, 'Very nice cooperation', 10, 1421017382, '2', 7, 4, 5, '0'),
(3, 'jhgjgjghjkh', 5, 1422087768, '2', 15, 7, 8, '0'),
(4, 'good work..', 5, 1423721537, '1', 25, 7, 8, '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(64) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'owner'),
(2, 'employee');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sales`
--

CREATE TABLE `sales` (
  `id` int(5) NOT NULL,
  `refid` varchar(20) NOT NULL DEFAULT '',
  `referral` varchar(128) NOT NULL,
  `account_type` smallint(6) NOT NULL,
  `created_date` date NOT NULL DEFAULT '0000-00-00',
  `signup_date` int(11) NOT NULL,
  `signup_date_format` varchar(50) NOT NULL,
  `created_time` time NOT NULL DEFAULT '00:00:00',
  `browser` varchar(100) NOT NULL DEFAULT '',
  `ipaddress` varchar(20) NOT NULL DEFAULT '',
  `payment` varchar(10) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

CREATE TABLE `settings` (
  `id` int(12) UNSIGNED NOT NULL,
  `code` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `setting_type` char(1) CHARACTER SET utf8 NOT NULL,
  `value_type` char(1) CHARACTER SET utf8 NOT NULL,
  `int_value` int(12) DEFAULT NULL,
  `string_value` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `text_value` text CHARACTER SET utf8,
  `created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `settings`
--

INSERT INTO `settings` (`id`, `code`, `name`, `setting_type`, `value_type`, `int_value`, `string_value`, `text_value`, `created`) VALUES
(1, 'SITE_TITLE', 'Site Title', 'S', 'S', 0, 'Consult24online', NULL, 1419123369),
(2, 'SITE_SLOGAN', 'Site Slogan', 'S', 'S', 0, 'The Consultant Guru Network for your Business', NULL, 1419123369),
(3, 'SITE_STATUS', 'Site status', 'S', 'I', 0, '', NULL, 2012),
(4, 'OFFLINE_MESSAGE', 'Offline Message', 'S', 'T', 0, '', 'This Site is under maintenance and will be back soon.', 2012),
(9, 'SITE_ADMIN_MAIL', 'Site Admin Mail', 'S', 'S', NULL, 'info@ralfkrone.de', NULL, 1419123369),
(10, 'PAYMENT_SETTINGS', 'minimum maintanace amount', 'S', 'I', 0, 'initial payment details', NULL, 2012),
(11, 'LANGUAGE_CODE', 'Language', 'S', 'S', NULL, 'english', NULL, 2012),
(12, 'FEATURED_PROJECTS_LIMIT', 'Featured project list', 'S', 'I', 15, NULL, NULL, 2012),
(13, 'URGENT_PROJECTS_LIMIT', 'Urgent Projects list', 'S', 'I', 10, NULL, NULL, 2012),
(14, 'LATEST_PROJECTS_LIMIT', 'Latest Projects list', 'S', 'I', 10, NULL, NULL, 2012),
(15, 'FEATURED_PROJECT_AMOUNT', 'featured project minimum amount', 'S', 'I', 25, NULL, NULL, 2012),
(16, 'URGENT_PROJECT_AMOUNT', 'urgent project minimum', 'S', 'I', 10, NULL, NULL, 2012),
(17, 'HIDE_PROJECT_AMOUNT', 'hide project minimum amount', 'S', 'I', 10, NULL, NULL, 2012),
(19, 'USER_FILE_LIMIT', 'File management', 'S', 'I', 10, NULL, NULL, 2012),
(18, 'PROVIDER_COMMISSION_AMOUNT', 'Provider commission', 'S', 'I', 2, NULL, NULL, 2012),
(20, 'ESCROW_PAGE_LIMIT', 'escrow pagination limit', 'S', 'I', 10, NULL, NULL, 2012),
(21, 'TRANSACTION_PAGE_LIMIT', 'transaction pagination limit', 'S', 'I', 10, NULL, NULL, 2012),
(22, 'MAIL_LIMIT', 'define the mail limit', 'S', 'I', 10, NULL, NULL, 2012),
(23, 'PROJECT_PERIOD', 'project period limit', 'S', 'I', 14, NULL, NULL, 2012),
(24, 'BASE_URL', 'site url', 'S', 'S', NULL, 'http://marketplace.oprocon.eu/', NULL, 1419123369),
(25, 'UPLOAD_LIMIT', 'Maximum Upload Limit', 'S', 'I', 10, NULL, NULL, 0),
(27, 'HOSTNAME', 'hostname', 'S', 'S', NULL, 'localhost', NULL, 0),
(51, 'PROVIDER_FREE_CREDITS', 'Employee free credits for 1 month from signup', 'S', 'I', 16, NULL, NULL, 5646544),
(32, 'PRIVATE_PROJECT_AMOUNT', 'private project amount', 'S', 'I', 25, NULL, NULL, 2012),
(35, 'FORCED_ESCROW', 'forced escrow', 'S', 'T', 1, NULL, '0', 0),
(42, 'FACEBOOK', 'facebook', 'S', 'S', NULL, 'https://www.facebook.com', NULL, 1342648800),
(43, 'TWITTER', 'twitter', 'S', 'S', NULL, 'https://www.twitter.com', NULL, 1342648800),
(44, 'RSS', 'rss', 'S', 'S', NULL, 'https://www.rss.com', NULL, 1342648800),
(45, 'LINKEDIN', 'linkedin', 'S', 'S', NULL, 'https://www.linkedin.com', NULL, 1342648800),
(46, 'CURRENCY_TYPE', 'currency_type', 'S', 'S', NULL, 'USD', NULL, 0),
(47, 'TIME_ZONE', 'time zone', 'S', 'S', NULL, 'UM5', NULL, 0),
(49, 'DAYLIGHT', 'daylight savings', 'S', 'S', NULL, 'TRUE', NULL, 56654);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `slider`
--

CREATE TABLE `slider` (
  `id` int(6) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `attachment_url` longtext NOT NULL,
  `attachment_name` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `slider`
--

INSERT INTO `slider` (`id`, `group_name`, `description`, `created`, `modified`, `attachment_url`, `attachment_name`) VALUES
(13, 'cube,circles', 'World Class Enterprise: the online commuity for enterprises, companies and consultants. Start to \nextend your worlwide network now!', 1421997877, 1421998137, '956723246128c526f8d1c6ff16bc4142.png', 'img1.png'),
(14, 'cubeRandom,circlesInside', 'World Class Business Blog: Read the latest news, discuss and comment the latest business related trends. Keep up to date and join now!', 1421998174, 1421998174, '477e0108b343ef565fd571ac131af411.png', 'img2.png'),
(15, 'block,circlesRotate', 'World Class Consultant Marketplace: Get connected to any kind of business service. Find skilled experts or extend your business worldwide. Sign up now!', 1421998296, 1421998296, '9990eae22d5f7bc6c11a6645a2f408d3.png', 'img3.png'),
(16, 'cube,circles', 'World Class Template Marketplace: Find your predesigned tools, presentations, training videos or software here for download. Search now!', 1421998324, 1421998324, 'da8568ec1401ba847742f12e2005c862.png', 'img4.png'),
(17, 'cubeRandom,circlesInside', 'World Class Lean Marketplace: You are not able to find the right lean tools you need for your business? Have a look to our Lean Marketplace, here are world wide suppliers with theis articles listed. Shop Now!', 1421998374, 1421998374, 'b738eb933a1785cde4337f0e9f27fbc6.png', 'img5.png'),
(18, 'block,circlesRotate', 'World Class Executive University: You have a need of high quality training or education for your company or enterprise. Here are world wide Universities and training centers listed with their programs. Train on or offline, worldwide and get certified. Check it out Now!', 1421998411, 1421998411, '69858527dc11b1c4e1e12c3507614af4.png', 'img6.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subscriptionuser`
--

CREATE TABLE `subscriptionuser` (
  `id` int(11) NOT NULL,
  `user_id` int(25) NOT NULL,
  `package_id` smallint(6) NOT NULL,
  `balance_credits` int(11) NOT NULL,
  `valid` int(15) NOT NULL,
  `amount` varchar(15) NOT NULL,
  `created` varchar(15) NOT NULL,
  `flag` smallint(6) NOT NULL,
  `updated_date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `subscriptionuser`
--

INSERT INTO `subscriptionuser` (`id`, `user_id`, `package_id`, `balance_credits`, `valid`, `amount`, `created`, `flag`, `updated_date`) VALUES
(8, 8, 1, -1, 30, '20', '1491033691', 1, 1493510400),
(9, 14, 0, 15, 30, '', '1422694641', 1, 1425286641),
(11, 17, 0, 11, 60, '20', '1490702448', 1, 1490702448),
(12, 23, 0, 16, 30, '', '1425703481', 1, 1428295481),
(13, 25, 0, 16, 30, '', '1429495986', 1, 1432087986),
(14, 27, 0, 16, 30, '', '1430118293', 1, 1432710293),
(15, 45, 0, 16, 30, '', '1495464332', 1, 1498056332),
(16, 46, 0, 16, 30, '', '1495549124', 1, 1498141124),
(17, 47, 0, 16, 30, '', '1495632357', 1, 1498224357),
(18, 48, 0, 16, 30, '', '1495632961', 1, 1498224961),
(19, 49, 0, 16, 30, '', '1495634300', 1, 1498226300),
(20, 50, 0, 16, 30, '', '1495768669', 1, 1498360669),
(21, 51, 0, 16, 30, '', '1495768934', 1, 1498360934),
(22, 52, 0, 16, 30, '', '1497842422', 1, 1500434422),
(23, 53, 0, 16, 30, '', '1497843974', 1, 1500435974),
(24, 54, 0, 16, 30, '', '1497868828', 1, 1500460828),
(25, 55, 0, 16, 30, '', '1497869107', 1, 1500461107),
(26, 56, 0, 16, 30, '', '1497872167', 1, 1500464167);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `support`
--

CREATE TABLE `support` (
  `id` int(11) NOT NULL,
  `callid` varchar(40) NOT NULL,
  `category` int(11) NOT NULL,
  `subject` text NOT NULL,
  `description` longtext NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `suspend`
--

CREATE TABLE `suspend` (
  `id` int(11) NOT NULL,
  `suspend_type` varchar(20) NOT NULL,
  `suspend_value` varchar(255) NOT NULL,
  `suspend_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `team_members`
--

CREATE TABLE `team_members` (
  `team_member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_permission_id` int(11) NOT NULL,
  `job_title` varchar(150) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `team_owner_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `team_members`
--

INSERT INTO `team_members` (`team_member_id`, `user_id`, `group_permission_id`, `job_title`, `email_address`, `telephone`, `password`, `team_owner_id`) VALUES
(2, 40, 1, 'Developer', 'guru_subramaniam@maventricks.com', '9345234343', '123456', 8),
(3, 41, 2, 'Developer', 'shanmugam@maventricks.com', '934523434399', '12345', 8),
(5, 40, 2, 'Developer', 'guru_subramaniam@maventricks.com', '9345234343', '12345', 8),
(7, 49, 14, 'dummy', 'ralf.krone@ralfkrone.de', '3865497549', '-,.msyndfgölahüplrj', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(64) CHARACTER SET utf8 NOT NULL,
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `employee_id` bigint(20) NOT NULL DEFAULT '0',
  `transaction_time` int(11) NOT NULL,
  `amount` float NOT NULL,
  `status` char(16) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `paypal_address` varchar(256) NOT NULL,
  `user_type` varchar(256) NOT NULL,
  `reciever_id` varchar(256) NOT NULL,
  `job_id` varchar(256) NOT NULL,
  `package_id` smallint(6) NOT NULL,
  `update_flag` tinyint(14) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `creator_id`, `owner_id`, `employee_id`, `transaction_time`, `amount`, `status`, `description`, `paypal_address`, `user_type`, `reciever_id`, `job_id`, `package_id`, `update_flag`) VALUES
(1, 'Deposit', 1, 1, 0, 1419185069, 1000, 'success', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(2, 'Deposit', 3, 3, 0, 1419338427, 5000, 'success', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(3, 'Deposit', 3, 3, 0, 1419371562, 10, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(4, 'Deposit', 5, 0, 5, 1419622849, 1000, 'Pending', 'Amount Deposited Through Paypal', '', 'employee', '', '', 0, 0),
(5, 'Deposit', 4, 4, 0, 1419623825, 4000, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(6, 'Deposit', 4, 4, 0, 1419626007, 4000, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(7, 'Deposit', 3, 3, 0, 1419669963, 100, 'success', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(8, 'Deposit', 4, 4, 0, 1419679626, 4000, 'success', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(9, 'Escrow Transfer', 4, 4, 5, 1419680021, 4000, 'Completed', 'Escrow Amount Tansfer for project -- ', '', '', '5', '7', 0, 0),
(10, 'Deposit', 4, 4, 0, 1419685042, 5000, 'success', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(11, 'Project Fee', 7, 7, 0, 1420434671, 10, 'Completed', 'UrgentProject Fee', '', '0', '', '', 0, 0),
(12, 'Escrow Transfer', 4, 4, 5, 1421016449, 5, 'Completed', 'Escrow Amount Tansfer for project -- ', '', '', '5', '7', 0, 0),
(13, 'Escrow Transfer', 4, 4, 5, 1421016551, 15, 'Completed', 'Escrow Amount Tansfer for project -- ', '', '', '5', '7', 0, 0),
(14, 'Project Fee', 7, 7, 0, 1421738862, 60, 'Completed', 'Featured+Urgent+PrivateProject Fee', '', '0', '', '', 0, 0),
(15, 'Deposit', 8, 0, 8, 1421741670, 20, 'success', 'Amount Deposited Through Paypal', '', 'employee', '', '', 0, 0),
(16, 'Project Fee', 7, 7, 0, 1421746659, 50, 'Completed', 'Featured+PrivateProject Fee', '', '0', '', '', 0, 0),
(17, 'Project Fee', 7, 7, 0, 1421817693, 10, 'Completed', 'UrgentProject Fee', '', '0', '', '', 0, 0),
(18, 'Project Fee', 7, 7, 0, 1422065911, 25, 'Completed', 'PrivateProject Fee', '', '0', '', '', 0, 0),
(19, 'Project Fee', 7, 7, 0, 1422066644, 25, 'Completed', 'PrivateProject Fee', '', '0', '', '', 0, 0),
(20, 'Deposit', 8, 0, 8, 1422083584, 5, 'success', 'Amount Deposited Through Paypal', '', 'employee', '', '', 0, 0),
(21, 'Deposit', 7, 7, 0, 1422412611, 5, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(22, 'Deposit', 7, 7, 0, 1422412711, 100, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(23, 'Transfer', 8, 0, 0, 1422413715, 100, 'Completed', 'Transfer Amount for', '', '', '7', '15', 0, 0),
(24, 'Deposit', 8, 0, 8, 1422424057, 50, 'Pending', 'Amount Deposited Through Paypal', '', 'employee', '', '', 0, 0),
(25, 'Deposit', 8, 0, 8, 1422424097, 10, 'Pending', 'Amount Deposited Through Paypal', '', 'employee', '', '', 0, 0),
(26, 'Project Fee', 7, 7, 0, 1422939631, 10, 'Completed', 'Hide BidsProject Fee', '', '0', '', '', 0, 0),
(27, 'Project Fee', 7, 7, 0, 1422943273, 25, 'Completed', 'FeaturedProject Fee', '', '0', '', '', 0, 0),
(28, 'Project Fee', 7, 7, 0, 1422950534, 25, 'Completed', 'FeaturedProject Fee', '', '0', '', '', 0, 0),
(29, 'Transfer', 7, 0, 0, 1423011798, 60, 'Completed', 'Transfer Amount for', '', '', '8', '19', 0, 0),
(30, 'Escrow Transfer', 7, 7, 8, 1423012545, 6, 'Completed', 'Escrow Amount Tansfer for project -- ', '', '', '8', '15', 0, 0),
(31, 'Deposit', 7, 7, 0, 1423704729, 6, 'success', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(32, 'Withdraw', 7, 7, 0, 1423706708, 5, 'Pending', 'Withdraw Amount From Paypal', 'sathick@maventricks.com', 'owner', '', '', 0, 0),
(33, 'Transfer', 7, 0, 0, 1423707022, 5, 'Completed', 'Transfer Amount for', '', '', '8', '25', 0, 0),
(34, 'Withdraw', 7, 7, 0, 1423707136, 5, 'Pending', 'Withdraw Amount From Paypal', 'sathick@maventricks.com', 'owner', '', '', 0, 0),
(35, 'Deposit', 8, 0, 8, 1423707359, 5, 'success', 'Amount Deposited Through Paypal', '', 'employee', '', '', 0, 0),
(36, 'Transfer', 8, 0, 0, 1423707694, 6, 'Completed', 'Transfer Amount for', '', '', '7', '25', 0, 0),
(37, 'Withdraw', 8, 0, 8, 1423707908, 5, 'Pending', 'Withdraw Amount From Paypal', 'defsdfdf@gmail.com', 'employee', '', '', 0, 0),
(38, 'Project Fee', 7, 7, 0, 1423725918, 45, 'Completed', 'Urgent+Hide Bids+PrivateProject Fee', '', '0', '', '', 0, 0),
(39, 'Deposit', 7, 7, 0, 1424059696, 12, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(40, 'Deposit', 7, 7, 0, 1424060954, 12, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(41, 'Deposit', 7, 7, 0, 1424061389, 12, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(42, 'Deposit', 7, 7, 0, 1424064279, 12, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(43, 'Project Fee', 4, 4, 0, 1425154995, 25, 'Completed', 'FeaturedProject Fee', '', '0', '', '', 0, 0),
(44, 'Project Fee', 7, 7, 0, 1425280111, 25, 'Completed', 'FeaturedProject Fee', '', '0', '', '', 0, 0),
(45, '0', 7, 7, 0, 1425283167, 35, 'Completed', '', '', '0', '', '', 0, 0),
(46, 'Project Fee', 7, 7, 0, 1425283439, 70, 'Completed', 'Featured+Urgent+Hide Bids+PrivateProject Fee', '', '0', '', '', 0, 0),
(47, 'Deposit', 7, 7, 0, 1425290430, 7, 'success', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(48, 'Deposit', 7, 7, 0, 1426729324, 5, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(49, '0', 4, 4, 0, 1427045957, 25, 'Completed', '', '', '0', '', '', 0, 0),
(50, 'Deposit', 7, 7, 0, 1427085865, 15, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(51, 'Deposit', 7, 7, 0, 1427085917, 15, 'Pending', 'Amount Deposited Through Paypal', '', 'owner', '', '', 0, 0),
(52, 'Deposit', 8, 0, 8, 1427678475, 10, 'Pending', 'Amount Deposited Through Paypal', '', 'employee', '', '', 0, 0),
(53, 'Project Fee', 7, 7, 0, 1429493940, 25, 'Completed', 'PrivateProject Fee', '', '0', '', '', 0, 0),
(54, 'Project Fee', 7, 7, 0, 1429496141, 25, 'Completed', 'PrivateProject Fee', '', '0', '', '', 0, 0),
(55, 'Project Fee', 7, 7, 0, 1429509509, 25, 'Completed', 'PrivateProject Fee', '', '0', '', '', 0, 0),
(56, 'Project Fee', 7, 7, 0, 1429510069, 25, 'Completed', 'PrivateProject Fee', '', '0', '', '', 0, 0),
(57, 'Project Fee', 7, 7, 0, 1429510365, 25, 'Completed', 'PrivateProject Fee', '', '0', '', '', 0, 0),
(58, 'Project Fee', 7, 7, 0, 1480147111, 35, 'Completed', 'Featured+UrgentProject Fee', '', '0', '', '', 0, 0),
(59, 'Escrow Transfer', 7, 7, 8, 1486623562, 4, 'Pending', 'Escrow Amount Tansfer for project -- ', '', '', '8', '63', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `refid` varchar(128) NOT NULL DEFAULT '0',
  `user_name` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `first_name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `company_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vat_id` varchar(128) CHARACTER SET utf8 NOT NULL,
  `role_id` smallint(6) NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(128) CHARACTER SET utf8 NOT NULL,
  `language` varchar(250) CHARACTER SET utf8 NOT NULL,
  `profile_desc` text CHARACTER SET utf8,
  `user_status` tinyint(4) NOT NULL DEFAULT '0',
  `activation_key` varchar(32) CHARACTER SET utf8 NOT NULL,
  `country_symbol` char(2) CHARACTER SET utf8 NOT NULL,
  `state` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `zip_code` varchar(64) CHARACTER SET utf8 NOT NULL,
  `job_notify` char(10) CHARACTER SET utf8 DEFAULT NULL,
  `bid_notify` char(10) CHARACTER SET utf8 DEFAULT NULL,
  `message_notify` char(10) CHARACTER SET utf8 NOT NULL,
  `rate` smallint(6) DEFAULT NULL,
  `logo` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `created` int(11) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `user_rating` smallint(2) NOT NULL,
  `num_reviews` int(11) NOT NULL,
  `rating_hold` int(11) NOT NULL,
  `tot_rating` int(11) NOT NULL,
  `suspend_status` enum('0','1') NOT NULL DEFAULT '0',
  `ban_status` enum('0','1') NOT NULL DEFAULT '0',
  `team_owner` int(11) NOT NULL,
  `online` enum('1','0') NOT NULL DEFAULT '1',
  `login_status` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `refid`, `user_name`, `first_name`, `last_name`, `name`, `company_address`, `vat_id`, `role_id`, `password`, `email`, `language`, `profile_desc`, `user_status`, `activation_key`, `country_symbol`, `state`, `city`, `zip_code`, `job_notify`, `bid_notify`, `message_notify`, `rate`, `logo`, `created`, `last_activity`, `user_rating`, `num_reviews`, `rating_hold`, `tot_rating`, `suspend_status`, `ban_status`, `team_owner`, `online`, `login_status`) VALUES
(1, '0', 'owner-test', '', '', 'owner1', '', '', 1, '454f8b9c99b299cb93014c03c70a29ca3bb93960becfcb15182f4e9423314b7850f74e943b47ced16674643f67de993e', 'privat@ralfkrone.de', '', NULL, 1, 'aec29fbe0c8e47558c3237922c2de0ae', 'US', '', '', '', NULL, '', '', NULL, NULL, 1419137559, 1420429793, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(2, '0', 'consult-test', '', '', 'Megamind', '', '', 2, 'c51dcc4e0deaee00fa5af30e29b6e1acbf32fcb3cea8c4b5cdeaecece8e248df439b2da1b834cb67bbafd2fa07d02f49', 'ralf@lifestyle-imaging.de', '', '', 1, '9ed2e65ba6c07b7d7b91e7bcf7863cc8', 'US', '', '', '', 'Instantly', NULL, 'Instantly', 150, NULL, 1419196743, 1485603322, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(3, '0', 'maven test', '', '', 'maven test company', '', '', 1, 'cd7b22e089a337ef2af0d8c476452a26c6fcab71ab0304d0dacca12c2db4d8c8923c2f5fadfb4e4f7bb8092016f01d4e', 'aruna.mark001@gmail.com', '', '', 1, '5eb9bf366a782fdbd674db04b71f366a', 'IN', '', '', '', 'Instantly', '', 'Hourly', NULL, NULL, 1419220574, 1424211440, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(4, '0', 'enterprise', '', '', 'RK Enterprises', '', '', 1, '96fd02f78758ae9d418feb871df005460fada2b6a0a83b731842fcf5ce717490413423a18e8806bfde10f132d153367b', 'msn@ralfkrone.de', '', '', 1, '16f5ceea2044675a344f33f9b0906e93', 'US', '', '', '', '', '', '', 0, '52e1db045225f533547ee1d8dfc2b83b.jpg', 1419221338, 1439411031, 10, 1, 0, 10, '0', '0', 0, '1', '0'),
(5, '0', 'consultant', '', '', 'Cloud 7', '', '', 2, '96fd02f78758ae9d418feb871df005460fada2b6a0a83b731842fcf5ce717490413423a18e8806bfde10f132d153367b', 'info@fotogalerie24.de', '', '', 1, 'dc3fa479fa07380886d6aff0b7573ff0', 'US', 'South Carolina', 'Columbia', '', '', '', '', 100, '801cbea455d705e12255704378840267.jpg', 1419339060, 1428083115, 10, 1, 0, 10, '0', '0', 0, '1', '0'),
(6, '0', 'aruna', '', '', 'Maventricks', '', '', 1, '0fa76955abfa9dafd83facca8343a92aa09497f98101086611b0bfa95dbc0dcc661d62e9568a5a032ba81960f3e55d4a', 'er.m.arunadevi@gmail.com', '', '', 1, '8f1adb8fb62128d5f5bce8919e0b22a3', 'US', '', '', '', '', '', '', NULL, '13db9b7ca46ca8ea1d61b9f7e59dfbe2.png', 1420422601, 1422500745, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(7, '0', 'owner', 'Mari-owner', 'Muthu', 'Demo Owner Company', 'Demo Owner Company address', '123456', 1, 'd6a2f9c9f0174a04cad704c3cc2b35b5cfb2bf937c16eed40980c1d0af0731449625ddebe4a337c300793630a6599344', 'marimuthu@maventricks.com', 'english', NULL, 1, '', 'IN', 'Tamilnadu', 'Madurai', '625010', '', NULL, '', NULL, 'eec4e167a96fe968c93ace8617b491ba.jpg', 1420429759, 1497357322, 5, 1, 0, 5, '0', '0', 0, '1', '1'),
(8, '0', 'employee', 'Mari-emp', 'Muthu', 'Demo Company', '31,kambar street', '9000', 2, 'c4f15f2fc4bd5a31b04cc7ffa66f401b75002f7647e0f017b1f1f851552800ec1e41b3e28137e30c372e2a00df00a7bb', 'lenin902@gmail.com', 'english', NULL, 1, '', 'IN', 'Tamilnadu', 'Madurai', '625010', '', NULL, '', 20, '635b5aab7bb336d8f7ee23a71dc22709.jpg', 1420429783, 1497078597, 5, 1, 0, 5, '0', '0', 0, '0', '1'),
(9, '0', NULL, '', '', '', '', '', 1, NULL, 'test@test.de', '', NULL, 0, '136a486f89580e516d00e1851db80282', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1421002619, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(10, '0', NULL, '', '', '', '', '', 1, NULL, 'test@me.com', '', NULL, 0, 'c87c7cccb3fd1abe5a6fdb9b7841fd7e', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1421006709, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(11, '0', NULL, '', '', '', '', '', 1, NULL, 'psrrfriendsforever@gmail.com', '', NULL, 0, 'f11b3e633f95734cf804d7df992d6c11', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1422425720, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(12, '0', NULL, '', '', '', '', '', 2, NULL, 'dffsdfsdfg@gmail.com', '', NULL, 0, 'bb624f2d2959564b6eaf95a790f1e245', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1422425920, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(26, '0', NULL, '', '', '', '', '', 1, NULL, 'nithya@maventricks.com', '', NULL, 0, 'f8d2bf491243cd0d25b5a99aebc595db', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1429766252, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(14, '0', 'mark lio', '', '', '', '', '', 2, '0fa76955abfa9dafd83facca8343a92aa09497f98101086611b0bfa95dbc0dcc661d62e9568a5a032ba81960f3e55d4a', 'psrrfriendsforever@gmail.com', '', '', 1, '3bdb741abe0b456cb66369c3317f648f', 'US', '', '', '', '', NULL, '', 12, NULL, 1422694532, 1423095438, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(15, '0', 'employee1', '', '', 'Demo Company', '', '', 1, '706866232fa5fc11486d8389c390b314a8df3c187365711033869bc2c44603fe384c3419163bcd927fb2d7b9a3ddca6a', 'lenin902@gmail.com', '', '', 1, 'dfffde05e888386a8447e06c749b8397', 'IN', '', '', '', '', '', '', NULL, NULL, 1423879574, 1494570261, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(16, '0', NULL, '', '', '', '', '', 2, NULL, 'marimuthu@maventricks.comm', '', NULL, 0, 'e0061cdff2c14f88b5306a67e221d1c7', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1423880706, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(17, '0', 'employee2', 'Employee', 'secound', 'Demo Company', 'Employee 2 company', '90000', 2, 'c03660d381697a1a5b5f0db02812d2cda377d74794fed12e5dc06795b9e03d08966c940a0cb9fba2578d28f0b2bc2bf9', 'marimuthu@maventricks.com', 'english', '', 1, 'aaa0c785a36a2c46e84308cebfb39207', 'IN', 'Tamilnadu', 'Madurai', '625010', NULL, NULL, '', 20, '92ea9d96b763436f55c16828686b86ca.jpg', 1423880956, 1495679903, 0, 0, 0, 0, '0', '0', 0, '1', '1'),
(18, '0', NULL, '', '', '', '', '', 1, NULL, 'newuser@mysite.com', '', NULL, 0, '2c8178f2ebc50b0a3310246ae13e578f', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1423916162, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(19, '0', NULL, '', '', '', '', '', 1, NULL, 'enterprise@consult24online.com', '', NULL, 0, 'ec5b1852393ac1122679cfedb4f8887f', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1423991222, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(20, '0', NULL, '', '', '', '', '', 1, NULL, 'rachelhou2013@gmail.com', '', NULL, 0, 'd21b4182662dacd54f20d6573ed874c5', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1424035851, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(21, '0', NULL, '', '', '', '', '', 2, NULL, 'yongqi26@sohu.com', '', NULL, 0, '39d6d8b582d002888e89be36cb67b823', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1424035901, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(22, '0', 'sam007', '', '', 'Webicules Technology', '', '', 1, '0a989ebc4a77b56a6e2bb7b19d995d185ce44090c13e2984b7ecc6d446d4b61ea9991b76a4c2f04b1b4d244841449454', 'sam@webicules.com', '', NULL, 1, '62fd809151b8fec570ec63a39202542f', 'US', '', '', '', NULL, '', '', NULL, NULL, 1425691789, 1426655918, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(23, '0', 'sam008', '', '', 'Webicules Technology', '', '', 2, '0a989ebc4a77b56a6e2bb7b19d995d185ce44090c13e2984b7ecc6d446d4b61ea9991b76a4c2f04b1b4d244841449454', 'sam@webicules.com', '', '', 1, '49e2f732d4f3ec0c8fa56ae0998742e8', 'US', '', '', '', '', NULL, '', 20, NULL, 1425703309, 1426657075, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(24, '0', 'mshaheen', '', '', 'Firefly Intelligent Technologies', '', '', 1, '26c64f75d03f8efcd3a931df064319829ab650bbf5538eceeb666613a4e2948967dcec4032600dee5b2ea71bae961b1d', 'm_shaheen1984@yahoo.com', '', NULL, 1, 'eb5123c567061f16ee63fdb0f0c9758e', 'DE', '', 'Munich', '', NULL, '', '', NULL, NULL, 1427193800, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(25, '0', 'employee3', '', '', 'Demo Company 3', '', '', 2, '8c58464c5763dec290835e4a2579c75f8900e622850197445c9324f49e7a576e81e565f9779c4c81d017fb2fe8285e74', 'balki@maventricks.com', '', '', 1, '1ecd066824ecc06c59649ce8a2abe7fb', 'US', 'California', 'los angeles', '', '', NULL, '', 15, 'f6558e37aa2d8d221bb0d17a88fd2580.jpg', 1429495762, 1483672387, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(27, '0', 'prabhu', '', '', '', '', '', 2, 'a347a63d19dffadf8e66687693f61ba65bb8d3f22dab02e5312267e4127c6978bfcd8538747a454e3383ebce0bc91d9b', 'prabhu@maventricks.com', '', '', 1, 'deaa86129d7cbd5cdac1d8702d30220c', 'US', '', '', '', '', NULL, '', 30, NULL, 1430117645, 1430177016, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(28, '0', 'prabhuv', '', '', '', '', '', 1, 'a347a63d19dffadf8e66687693f61ba65bb8d3f22dab02e5312267e4127c6978bfcd8538747a454e3383ebce0bc91d9b', 'prabhuthegrate@gmail.com', '', NULL, 1, '7092556256367c011055e313649b0899', 'US', '', '', '', NULL, '', '', NULL, NULL, 1430118483, 1430178934, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(29, '0', NULL, '', '', '', '', '', 1, NULL, 'wani.aftav23@gmail.com', '', NULL, 0, 'de093b710eb4f3d34b34c7b4abc62dec', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1459855034, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(30, '0', NULL, '', '', '', '', '', 1, NULL, 'info@ralfkrone.de', '', NULL, 0, '17f7bcaaceb05f88763972420429126d', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1460472087, 0, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(31, '0', '', '', '', '', '', '', 2, NULL, 'sustaining4905@hotmail.com', '', NULL, 0, 'b239313c9d23c4cf7f83d3110c4f509b', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1469200067, 1469200067, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(32, '0', '', '', '', '', '', '', 2, NULL, 'brust@test.com', '', NULL, 0, 'd225027de3f9106952dbf6016c4ba9c1', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1469250146, 1469250146, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(33, '0', '', '', '', '', '', '', 2, NULL, 'daniel_brust@outlook.com', '', NULL, 0, '6afb5058284b474c1ea23591b0c96cea', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1469250658, 1469250658, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(34, '0', '', '', '', '', '', '', 2, NULL, 'me@test.va', '', NULL, 0, '43769f771c07c66341925abc2ac13671', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1469461707, 1469461707, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(36, '0', '', '', '', '', '', '', 2, NULL, 'yogaraaj@maventricks.com', '', NULL, 0, 'c650fbdf03f60937af083079098467e5', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1480570823, 1480570823, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(40, '0', 'guru_employee', 'guru', 'subramaniam', 'Demo1 company', '32,kambar street', '10000', 2, 'c4f15f2fc4bd5a31b04cc7ffa66f401b75002f7647e0f017b1f1f851552800ec1e41b3e28137e30c372e2a00df00a7bb', 'guru_subramaniam@maventricks.com', 'english', 'Team Member', 1, '334484e0ff19bb966b3af96cd23fc955', 'IN', 'Tamilnadu', 'Madurai', '625010', NULL, NULL, '', 20, NULL, 1485143780, 1486618790, 0, 0, 0, 0, '0', '0', 8, '1', '0'),
(41, '0', 'shanmugam_employee', 'shan', 'mugam', 'Demo2 company', '32,kambar street', '10000', 2, 'c4f15f2fc4bd5a31b04cc7ffa66f401b75002f7647e0f017b1f1f851552800ec1e41b3e28137e30c372e2a00df00a7bb', 'shanmugam@maventricks.com', 'english', NULL, 1, 'b8eb6c2127b26117248f27a7085d3cdb', 'IN', 'Tamilnadu', 'Madurai', '625010', NULL, NULL, '', 50, NULL, 1485144299, 1485148679, 0, 0, 0, 0, '0', '0', 8, '1', '0'),
(42, '0', '', '', '', '', '', '', 2, NULL, 'info@ralfkrone.de', '', NULL, 0, '1f369209fa8592ad84b1ee03e8dd9b65', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1493890400, 1493890400, 0, 0, 0, 0, '0', '0', 7, '1', '0'),
(43, '0', '', '', '', '', '', '', 1, NULL, 'enterprise@yopmail.com', '', NULL, 0, '098ff40e637a5f8c15d9c522d1099821', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1495439524, 1495439524, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(44, '0', '', '', '', '', '', '', 2, NULL, 'consultant@yopmail.com', '', NULL, 0, '98593993b11af053a953f12ac2949aa9', '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, 1495439607, 1495439607, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(45, '', 'pandiaarajan', '', '', 'Pandian Company', '', '', 2, '22e09e0e02c9fce6eeeb1a2cd30732ae961342d30938ee9a5ef19ee823b8ea8799033f724f9e1a0a6b72601561326293', 'pandiarajan@maventricks.com', '', '', 1, 'a37760bd52bed06b8722f32cb9ed39e0', 'IN', 'Tamilnadu', 'Madurai', '', 'Instantly', NULL, 'Instantly', 50, '761b72622c7c9ffbe803b7725a9d7f35.jpg', 1495458299, 1495458299, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(46, '', 'testuser', 'Firstname', 'Lastname', 'Testcompany', '', '8765795806ß98', 2, '66a66ccc05778a84f0e67b5bae15748b95e0e228b06a37ff382aa39f34f0ac97277f8edf8cb6d0811f22550be982cea0', 'support@ralfkrone.de', 'english', '', 1, 'becdfd85efbe4fab1920256ae95bbc7a', 'US', 'FL', 'Miami', '20567', NULL, NULL, '', 10, '85da1815a25581f84b935a2a3f342e21.JPG', 1495458318, 1495458318, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(47, '', 'guru_m', 'guru_m', 'mavent', 'Test company', '', '', 2, '8a8ddd08b6b4c683dbe0a0baf7c914d2024efb7180e8786b0932c5d83e92dbbccf760346425d4ccead35ca4e2707b314', 'guru@maventricks.com', 'english', '', 1, '2bd01c601a8899c54ea613a660318796', 'IN', 'Tamilnadu', 'Madurai', '', 'Instantly', NULL, 'Instantly', 50, NULL, 1495630077, 1495630077, 0, 0, 0, 0, '0', '0', 8, '1', '0'),
(48, '', 'team_member#1', 'teamm', 'member#1', 'Test company', '', '', 2, 'ea769acb0e5ddd1f18463a85d76d1f89bab79deb64c1c6ec5ecac67b9a983c82e9f9b3e06a33ee239c0389820b25c4ef', 'team_member1@team.com', 'english', '', 1, '5b55c68425db8eea1c4465cb7478b74b', 'IN', 'Tamilnadu', 'Madurai', '', 'Instantly', NULL, 'Instantly', 50, NULL, 1495632779, 1495632779, 0, 0, 0, 0, '0', '0', 7, '1', '0'),
(49, '', 'Testteammember', 'testteammember', 'member', 'Highfly Corp.', '', '', 2, '44accf4a6221d01de386da6d2c48b0fae47930c80d2371cd669bff5235c6c1a5ce47f863a1379829f8602822f96410c2', 'ralf.krone@ralfkrone.de', 'english', 'optional profile this os a text to fill 25 character for the minimum requirement.', 1, '79709e96b5c3ad0078e617a5bdae3f97', 'CN', '', '', '', '', NULL, '', 5, NULL, 1495633547, 1495633547, 0, 0, 0, 0, '0', '0', 46, '1', '0'),
(50, '', 'mm-coach', 'test1212', 'test1212', 'sadsad', '', '', 2, '25421d7c7e6fd6aa71f707353cc3408fa1fb316e698136553b0e03eea875a7808670e168300482228307a09504d7fdd4', 'mm-coach@yopmail.com', 'english', '11sadasdasddsadsassssssssssssssssssssssssssssssssssssssssssssssssssss', 1, '2f2f33d3c728d79380909280dabb4a4a', 'DZ', '1121', '1212', '', '', NULL, '', 11, NULL, 1495768600, 1495768600, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(51, '', 'mm-enterprise', 'hjkhkhkhk', 'kjhkhkhkh', 'mm-enterprise', '', '', 1, '2a4adb946101376c946865d89937b4bbb6164b07c339d44780c23fd7872b58237f6690ed898fb230aa847355421ad8d5', 'mm-enterprise@yopmail.com', 'english', '2322cvdffffffffffffffffffffffffffffffffffffffffffffffffff', 1, '703d44326ea1739c901d0be7d5964b52', 'US', 'sadsad', 'sdsa', '', '', NULL, '', 12, NULL, 1495768839, 1495768839, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(52, '', 'lgjsdlfkgjsfdlk', 'dgh;skldjgskldf', 'fdkjghsdkfjh', '', '', '', 2, '6075f704e9a442677a0289ff3b641b116b49db08a5ef5cd29081b0ca0c01da5e0bf410a41a9ef749492becb6224fecf7', 'lgjsdlfkgjsfdlk@mailinator.com', 'english', '', 1, 'b26cd95c3aad4e7192d1ee3645085e02', 'US', '', '', '', '', NULL, '', 20, NULL, 1497842130, 1497842130, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(53, '', 'Oprotest', 'Oprocon', 'Testing', 'Oprocon', '', '', 2, '79d657f31e075699e603308f929d59f50f8829e7a628c2073bd2133f53249a82b98d347a196bf491cce4af60d04b2483', 'ralf@fotogalerie24.de', 'english', '', 1, '4948502e2496c1a57df31626b6ecbf5d', 'US', '', '', '', '', NULL, '', 10, NULL, 1497842707, 1497842707, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(54, '', 'demo_user', 'Alexey', 'Nekrasov', 'Demo Company', '', '', 1, '1ab60e110d41a9aac5e30d086c490819bfe3461b38c76b9602fe9686aa0aa3d28c63c96a1019e3788c40a14f4292e50f', 'alexey.nekrasov1@gmail.com', 'english', '', 1, 'cead2a1fb255ecc3e452270378b38f39', 'UA', '', '', '', '', NULL, '', 10, NULL, 1497868681, 1497869496, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(55, '', 'Maksym', 'Maksym', 'Kalin', '', '', '', 2, 'ad92e44b8836ae628ff9c56f285d7a2978a8f7421b547b4d31f527cf7ff685bf82b3586cfe403b77972adec6cfda5e23', 'kalin.mv@gmail.com', 'english', '', 1, '4a4e4cec4fc297abdd60d7993da4a36b', 'US', '', '', '', '', NULL, '', 22, NULL, 1497868937, 1497868937, 0, 0, 0, 0, '0', '0', 0, '1', '0'),
(56, '', 'demo_user_supplier', 'Alexey', 'Nekrasov', 'Demo Company', '', '', 2, '1ab60e110d41a9aac5e30d086c490819bfe3461b38c76b9602fe9686aa0aa3d28c63c96a1019e3788c40a14f4292e50f', 'alexey.nekrasov1@gmail.com', 'english', '', 1, '3aedb6b7573dd99dab2e436753b9cb93', 'US', '', '', '', '', NULL, '', 10, NULL, 1497872121, 1497872121, 0, 0, 0, 0, '0', '0', 0, '1', '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_balance`
--

CREATE TABLE `user_balance` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_balance`
--

INSERT INTO `user_balance` (`id`, `user_id`, `amount`) VALUES
(1, 1, 5220),
(2, 2, 0),
(3, 3, 250),
(4, 4, 4930),
(5, 5, 3940),
(6, 6, 100),
(7, 7, 4971),
(8, 8, 5872.38),
(9, 9, 0),
(10, 10, 0),
(11, 11, 0),
(12, 12, 0),
(13, 13, 0),
(14, 14, 0),
(15, 15, 0),
(16, 16, 0),
(17, 17, 5872.38),
(18, 18, 0),
(19, 19, 0),
(20, 20, 0),
(21, 21, 0),
(22, 22, 0),
(23, 23, 0),
(24, 24, 0),
(25, 25, 0),
(26, 26, 0),
(27, 27, 0),
(28, 28, 0),
(29, 29, 0),
(30, 30, 0),
(31, 31, 0),
(32, 32, 0),
(33, 33, 0),
(34, 34, 0),
(35, 37, 0),
(36, 38, 0),
(37, 39, 0),
(38, 40, 0),
(39, 41, 0),
(40, 42, 0),
(41, 43, 0),
(42, 44, 0),
(43, 45, 0),
(44, 46, 0),
(45, 47, 0),
(46, 48, 0),
(47, 49, 0),
(48, 50, 0),
(49, 51, 0),
(50, 52, 0),
(51, 53, 0),
(52, 54, 0),
(53, 55, 0),
(54, 56, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_categories`
--

CREATE TABLE `user_categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_categories` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_categories`
--

INSERT INTO `user_categories` (`id`, `user_id`, `user_categories`) VALUES
(1, 2, '12'),
(2, 5, '15,16,17,18'),
(3, 14, '32,33,50,58'),
(4, 8, '14,15,16,18,31,70,73,153'),
(5, 17, '14,16,17,33,117,153'),
(6, 23, '16,133'),
(7, 25, '14,15,16,17,18,21,22,115,116,138,139'),
(8, 27, '14,15,16,17,18,21,22,177,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,59,60,61,62,63,65,66,67,68,69,70,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,26,27,28,29,30,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,169,170,172,145,146,147,148,149,150,151'),
(9, 40, '14,15,16,17,18,21,22'),
(10, 45, '14,15,16,17'),
(11, 45, '14,15,16,17,18,21'),
(12, 46, '51,52,53,54'),
(13, 47, '14,15,16,17,18,21'),
(14, 48, '14,15,16,17,18,21'),
(15, 49, '127'),
(16, 50, '41,42,70,73'),
(17, 51, '14,15,16,17,18,21,22,177,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,59,60,61,62,63,65,66,67,68,69,70,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,26,27,28,29,30,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,169,170,172,145,146,147,148,149,150,151'),
(18, 52, '81,127'),
(19, 53, '14,15,16,17,18,21,22,177,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,59,60,61,62,63,65,66,67,68,69,70,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,26,27,28,29,30,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,169,170,172,145,146,147,148,149,150,151'),
(20, 54, '14'),
(21, 55, '14,15,16,17,18,21,22,177,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,59,60,61,62,63,65,66,67,68,69,70,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,26,27,28,29,30,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,169,170,172,145,146,147,148,149,150,151'),
(22, 56, '14,15,16,17,18,21,22,177,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,59,60,61,62,63,65,66,67,68,69,70,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,26,27,28,29,30,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,169,170,172,145,146,147,148,149,150,151');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_contacts`
--

CREATE TABLE `user_contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `msn` varchar(100) CHARACTER SET utf8 NOT NULL,
  `gtalk` varchar(100) CHARACTER SET utf8 NOT NULL,
  `yahoo` varchar(100) CHARACTER SET utf8 NOT NULL,
  `skype` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_contacts`
--

INSERT INTO `user_contacts` (`id`, `user_id`, `msn`, `gtalk`, `yahoo`, `skype`) VALUES
(1, 1, '', '', '', ''),
(2, 2, '', '', '', ''),
(3, 3, '', '', '', ''),
(4, 4, '', '', '', ''),
(5, 5, '', '', '', ''),
(6, 6, '', '', '', ''),
(7, 14, '', '', '', ''),
(8, 8, '', '', '', ''),
(9, 15, '', '', '', ''),
(10, 17, '', '', '', ''),
(11, 7, '', '', '', ''),
(12, 22, '', '', '', ''),
(13, 23, '', '', '', ''),
(14, 24, '', '', 'm_shaheen1984', 'mshaheen1984'),
(15, 25, '', '', '', ''),
(16, 27, '', '', '', ''),
(17, 28, '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_files`
--

CREATE TABLE `user_files` (
  `user_file_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `portfolio_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_list`
--

CREATE TABLE `user_list` (
  `id` int(11) NOT NULL,
  `creator_id` varchar(256) NOT NULL,
  `user_id` varchar(256) NOT NULL,
  `user_name` varchar(256) NOT NULL,
  `user_role` varchar(256) NOT NULL,
  `blocked_status` tinyint(4) NOT NULL COMMENT '0- active 1-blocked'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_list`
--

INSERT INTO `user_list` (`id`, `creator_id`, `user_id`, `user_name`, `user_role`, `blocked_status`) VALUES
(1, '5', '6', 'aruna', '1', 0),
(2, '6', '2', 'consult-test', '1', 0),
(3, '4', '14', 'mark lio', '1', 0),
(4, '4', '2', 'consult-test', '1', 0),
(5, '8', '7', 'owner', '1', 0),
(6, '7', '2', 'consult-test', '2', 1),
(7, '7', '5', 'consultant', '1', 0),
(8, '7', '23', 'sam008', '1', 0),
(9, '7', '27', 'prabhu', '1', 0),
(16, '8', '1', 'owner-test', '2', 1),
(11, '8', '15', 'employee1', '1', 0),
(12, '8', '4', 'enterprise', '1', 0),
(17, '8', '1', 'owner-test', '2', 1),
(14, '8', '17', 'employee2', '1', 0),
(15, '8', '25', 'employee3', '1', 0),
(21, '8', '27', 'prabhu', '2', 1),
(24, '8', '24', 'mshaheen', '1', 0),
(25, '8', '15', 'employee1', '1', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `chat_last_seen`
--
ALTER TABLE `chat_last_seen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `clickthroughs`
--
ALTER TABLE `clickthroughs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `dispute_agree`
--
ALTER TABLE `dispute_agree`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `draftjobs`
--
ALTER TABLE `draftjobs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `employee_milestone`
--
ALTER TABLE `employee_milestone`
  ADD PRIMARY KEY (`employee_milestone_id`);

--
-- Indizes für die Tabelle `escrow_release_request`
--
ALTER TABLE `escrow_release_request`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indizes für die Tabelle `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`folder_id`);

--
-- Indizes für die Tabelle `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `group_permission`
--
ALTER TABLE `group_permission`
  ADD PRIMARY KEY (`group_permission_id`);

--
-- Indizes für die Tabelle `invite_suppliers`
--
ALTER TABLE `invite_suppliers`
  ADD PRIMARY KEY (`invite_suppliers_id`);

--
-- Indizes für die Tabelle `ipn_return`
--
ALTER TABLE `ipn_return`
  ADD PRIMARY KEY (`invoice`);

--
-- Indizes für die Tabelle `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `jobs_preview`
--
ALTER TABLE `jobs_preview`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `job_cases`
--
ALTER TABLE `job_cases`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `job_invitation`
--
ALTER TABLE `job_invitation`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `milestone`
--
ALTER TABLE `milestone`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `milestone_cost_description`
--
ALTER TABLE `milestone_cost_description`
  ADD PRIMARY KEY (`milestone_cost_description_id`);

--
-- Indizes für die Tabelle `owner_milestone`
--
ALTER TABLE `owner_milestone`
  ADD PRIMARY KEY (`owner_milestone_id`);

--
-- Indizes für die Tabelle `owner_milestone_upload`
--
ALTER TABLE `owner_milestone_upload`
  ADD PRIMARY KEY (`owner_milestone_upload_id`);

--
-- Indizes für die Tabelle `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `popular_search`
--
ALTER TABLE `popular_search`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `portfolio_uploads`
--
ALTER TABLE `portfolio_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `project_bid_upload`
--
ALTER TABLE `project_bid_upload`
  ADD PRIMARY KEY (`project_bid_upload_id`);

--
-- Indizes für die Tabelle `rating_hold`
--
ALTER TABLE `rating_hold`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `report_violation`
--
ALTER TABLE `report_violation`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indizes für die Tabelle `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `subscriptionuser`
--
ALTER TABLE `subscriptionuser`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `suspend`
--
ALTER TABLE `suspend`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suspend_value` (`suspend_value`);

--
-- Indizes für die Tabelle `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`team_member_id`);

--
-- Indizes für die Tabelle `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_balance`
--
ALTER TABLE `user_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_categories`
--
ALTER TABLE `user_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_contacts`
--
ALTER TABLE `user_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_files`
--
ALTER TABLE `user_files`
  ADD PRIMARY KEY (`user_file_id`);

--
-- Indizes für die Tabelle `user_list`
--
ALTER TABLE `user_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `admins`
--
ALTER TABLE `admins`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT für Tabelle `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT für Tabelle `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;
--
-- AUTO_INCREMENT für Tabelle `chat_last_seen`
--
ALTER TABLE `chat_last_seen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT für Tabelle `clickthroughs`
--
ALTER TABLE `clickthroughs`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT für Tabelle `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `country`
--
ALTER TABLE `country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;
--
-- AUTO_INCREMENT für Tabelle `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT für Tabelle `dispute_agree`
--
ALTER TABLE `dispute_agree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `draftjobs`
--
ALTER TABLE `draftjobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT für Tabelle `employee_milestone`
--
ALTER TABLE `employee_milestone`
  MODIFY `employee_milestone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
--
-- AUTO_INCREMENT für Tabelle `escrow_release_request`
--
ALTER TABLE `escrow_release_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT für Tabelle `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT für Tabelle `files`
--
ALTER TABLE `files`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT für Tabelle `folders`
--
ALTER TABLE `folders`
  MODIFY `folder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT für Tabelle `groups`
--
ALTER TABLE `groups`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT für Tabelle `group_permission`
--
ALTER TABLE `group_permission`
  MODIFY `group_permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT für Tabelle `invite_suppliers`
--
ALTER TABLE `invite_suppliers`
  MODIFY `invite_suppliers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;
--
-- AUTO_INCREMENT für Tabelle `jobs_preview`
--
ALTER TABLE `jobs_preview`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT für Tabelle `job_cases`
--
ALTER TABLE `job_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT für Tabelle `job_invitation`
--
ALTER TABLE `job_invitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT für Tabelle `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT für Tabelle `milestone`
--
ALTER TABLE `milestone`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT für Tabelle `milestone_cost_description`
--
ALTER TABLE `milestone_cost_description`
  MODIFY `milestone_cost_description_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT für Tabelle `owner_milestone`
--
ALTER TABLE `owner_milestone`
  MODIFY `owner_milestone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=344;
--
-- AUTO_INCREMENT für Tabelle `owner_milestone_upload`
--
ALTER TABLE `owner_milestone_upload`
  MODIFY `owner_milestone_upload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;
--
-- AUTO_INCREMENT für Tabelle `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `page`
--
ALTER TABLE `page`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT für Tabelle `payments`
--
ALTER TABLE `payments`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `popular_search`
--
ALTER TABLE `popular_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=438;
--
-- AUTO_INCREMENT für Tabelle `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT für Tabelle `portfolio_uploads`
--
ALTER TABLE `portfolio_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT für Tabelle `project_bid_upload`
--
ALTER TABLE `project_bid_upload`
  MODIFY `project_bid_upload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT für Tabelle `rating_hold`
--
ALTER TABLE `rating_hold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle `report_violation`
--
ALTER TABLE `report_violation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT für Tabelle `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT für Tabelle `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT für Tabelle `subscriptionuser`
--
ALTER TABLE `subscriptionuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT für Tabelle `support`
--
ALTER TABLE `support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `suspend`
--
ALTER TABLE `suspend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `team_members`
--
ALTER TABLE `team_members`
  MODIFY `team_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT für Tabelle `user_balance`
--
ALTER TABLE `user_balance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT für Tabelle `user_categories`
--
ALTER TABLE `user_categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `user_contacts`
--
ALTER TABLE `user_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT für Tabelle `user_files`
--
ALTER TABLE `user_files`
  MODIFY `user_file_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `user_list`
--
ALTER TABLE `user_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
