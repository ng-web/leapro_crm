-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2016 at 02:43 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `leapro_crm`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `recur_job_orders`(IN `id` INT, IN `diff` INT, IN `type` INT)
BEGIN
        DECLARE _cnt INT;
        DECLARE es_count INT;
        DECLARE i INT;
        DECLARE _id INT;
        DECLARE _idp INT;
        DECLARE p_id INT;
        Declare ea int;
       
        SET _cnt = 1;
        WHILE _cnt <= diff DO

            IF type = 1 THEN BEGIN
               INSERT into estimates(`campaign_id`,`expiry_date`, `status_id`, `received_date`, `confirmed_date`, `schedule_date_time`,`tax`, `discount`, `factor`, `schedule_end_date`, `recurring_value`)
               select `campaign_id`, `expiry_date`, `status_id`,  `received_date`, `confirmed_date`, `schedule_date_time`+ INTERVAL _cnt WEEK, `tax`, `discount`, `factor`, `schedule_end_date` + INTERVAL _cnt WEEK,
               null from estimates WHERE estimate_id = id;
             END; END IF;

            IF type = 2 THEN BEGIN
               INSERT into estimates(`campaign_id`, `expiry_date`, `status_id`, `received_date`, `confirmed_date`, `schedule_date_time`,`tax`, `discount`, `factor`, `schedule_end_date`, `recurring_value`)
               select `campaign_id`, `expiry_date`, `status_id`, `received_date`, `confirmed_date`, `schedule_date_time`+ INTERVAL _cnt MONTH, `tax`, `discount`, `factor`, `schedule_end_date` + INTERVAL _cnt WEEK,
               null from estimat
               es WHERE estimate_id = id;
             END; END IF;
             
             set _id = (select LAST_INSERT_ID()); 

             insert into estimated_areas(estimate_id,area_id)
             select _id, `area_id` from estimated_areas
             where estimate_id = id;
             
             select count(*) AS count into es_count from  estimated_areas where estimate_id = _id;
             
             set i = 0;
             WHILE i < es_count DO
               
               select  `estimated_area_id` into p_id from estimated_areas where estimate_id = id limit i,1;
               select  `estimated_area_id` into _idp from estimated_areas where estimate_id = _id limit i,1;

               insert into products_used_per_area(`estimated_area_id`, `product_id`, `quantity`, `product_cost_at_time`)
               select _idp, `product_id`, `quantity`,  `product_cost_at_time` from 
               estimated_areas inner join products_used_per_area 
               on
               products_used_per_area.estimated_area_id = estimated_areas.estimated_area_id
               where estimated_areas.estimate_id = id and estimated_areas.estimated_area_id = p_id; 
               
               SET i = i + 1;

             END WHILE;

             SET _cnt = _cnt + 1;
        END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `address_province` varchar(128) NOT NULL,
  `address_zip` int(11) DEFAULT NULL,
  `address_type` tinyint(1) DEFAULT NULL,
  `address_status` tinyint(1) DEFAULT NULL,
  `address_details` text,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `address_line1`, `address_line2`, `address_province`, `address_zip`, `address_type`, `address_status`, `address_details`) VALUES
(1, 'Bryce District', 'Christiana P.O.', 'Manchester', NULL, 0, NULL, NULL),
(2, 'Bryce District', 'Christiana P.O.', 'Manchester', NULL, 0, NULL, NULL),
(3, 'Bryce District', 'Christiana P.O.', 'Manchester', NULL, NULL, NULL, NULL),
(21, 'Job Lane', 'Chrisitiana', 'Manchester', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `advertising_campaign`
--

CREATE TABLE IF NOT EXISTS `advertising_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `advertising_campaign`
--

INSERT INTO `advertising_campaign` (`id`, `name`, `description`) VALUES
(1, 'facebook', NULL),
(2, 'Phone call', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_location_id` int(11) DEFAULT NULL,
  `area_name` varchar(30) NOT NULL,
  `area_description` text,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`area_id`),
  KEY `company_location_id` (`company_location_id`),
  KEY `cutomer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `company_location_id`, `area_name`, `area_description`, `customer_id`) VALUES
(1, 1, 'Bathroom 7', 'Roach infection under bed', NULL),
(3, NULL, 'Master Bedroom', '', 6),
(11, 1, 'Kitchen', 'rodent infestaion', NULL),
(12, 1, 'BedRoom', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `area_units`
--

CREATE TABLE IF NOT EXISTS `area_units` (
  `area_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `value` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`area_unit_id`),
  KEY `areas_fk` (`area_id`),
  KEY `units_fk` (`unit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `area_units`
--

INSERT INTO `area_units` (`area_unit_id`, `area_id`, `unit_id`, `value`) VALUES
(28, 11, 1, 78),
(29, 1, 1, 290),
(30, 1, 2, 400),
(31, 1, 3, 400),
(32, 1, 4, 80),
(33, 12, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
  `assignment_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `estimate_id` int(11) NOT NULL,
  PRIMARY KEY (`assignment_id`),
  KEY `emp_id` (`emp_id`,`estimate_id`),
  KEY `estimate_id` (`estimate_id`),
  KEY `emp_id_2` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bsr_activity`
--

CREATE TABLE IF NOT EXISTS `bsr_activity` (
  `bs_id` int(11) NOT NULL AUTO_INCREMENT,
  `bs_status` tinyint(1) NOT NULL,
  `bs_qty` int(11) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `number_seen` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `bs_condition` int(11) NOT NULL,
  `bs_comments` text,
  `equipment_id` int(11) NOT NULL,
  `bsr_id` int(11) NOT NULL,
  PRIMARY KEY (`bs_id`),
  KEY `employee_id` (`employee_id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `bsr_id` (`bsr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bsr_header`
--

CREATE TABLE IF NOT EXISTS `bsr_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bsr_docnum` varchar(32) NOT NULL,
  `bsr_approvedby` varchar(70) NOT NULL,
  `bsr_verifiedby` varchar(70) NOT NULL,
  `bsr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emp_id` int(11) NOT NULL,
  `estimated_area_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`),
  KEY `estimate_area_id` (`estimated_area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(128) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`company_id`),
  KEY `customer_id` (`customer_id`),
  KEY `customer_id_2` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `customer_id`) VALUES
(1, 'Xtreme ', 1),
(4, 'lumbers', 5),
(5, 'Z-treme', 1),
(27, 'Best Dressed', 28),
(28, 'hhhh', 29),
(29, 'KamKay Cook Shop', 30),
(30, 'Strip-Tees', 31);

-- --------------------------------------------------------

--
-- Table structure for table `company_locations`
--

CREATE TABLE IF NOT EXISTS `company_locations` (
  `company_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `branch_name` varchar(120) NOT NULL,
  `contact_person` varchar(60) NOT NULL,
  `contact_email` text,
  `contact_tel` varchar(20) NOT NULL,
  `contact_fax` varchar(20) DEFAULT NULL,
  `company_notes` text,
  PRIMARY KEY (`company_location_id`),
  KEY `company_id` (`company_id`,`address_id`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `company_locations`
--

INSERT INTO `company_locations` (`company_location_id`, `company_id`, `address_id`, `branch_name`, `contact_person`, `contact_email`, `contact_tel`, `contact_fax`, `company_notes`) VALUES
(1, 1, 1, 'Xtreme (Mandeville)', 'Yanik Blake', 'yanikblake@extreme.com', '234-678', NULL, NULL),
(2, 4, 1, 'Lumbers (Ocho Rios)', '', NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_firstname` varchar(60) NOT NULL,
  `customer_lastname` varchar(60) NOT NULL,
  `customer_midname` varchar(60) DEFAULT NULL,
  `customer_details` text,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address_id` int(11) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `customer_type` enum('Residential','Commercial') NOT NULL,
  `customer_telephone` varchar(30) NOT NULL,
  `customer_cell` varchar(30) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_email` (`customer_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_firstname`, `customer_lastname`, `customer_midname`, `customer_details`, `date_registered`, `address_id`, `gender`, `customer_type`, `customer_telephone`, `customer_cell`, `customer_email`, `status`) VALUES
(1, 'Yanik', 'Blake', 'T', 'Owns an entertainment Lounge', '2016-06-29 02:56:23', 1, 'male', 'Commercial', '527-7128', '527-7128', 'yanikblake@gmail.com', 'active'),
(5, 'mathew', 'lee', '', 'owns lumber company', '2016-07-05 18:09:00', 1, 'male', 'Commercial', '987-654-3210', '987-654-3211', 'mattlee@gmail.com', 'active'),
(6, 'Jowayne', 'Brown', 'J', 'Owns a restaurant', '2016-08-01 18:38:15', 1, 'male', 'Residential', '876-543-2345', '876-432-1345', 'jowayneBrown@gmail.com', 'active'),
(28, 'Rajon', 'Mullings', 'J.', 'Owns best dress chickens', '2016-09-30 15:15:13', 1, 'male', 'Commercial', '876-364-2442', '876-244-2522', 'rajon_mullings@gmail.com', 'active'),
(29, 'kkk', 'Mullings', 'J.', 'Owns best dress chickens', '2016-09-30 15:16:42', 1, 'male', 'Commercial', '987-545-3218', '987-654-3215', 'jjkk@gmail.com', 'active'),
(30, 'Kamile', 'Madden', '', 'Owns a cook shop', '2016-10-06 15:15:12', 1, 'female', 'Commercial', '876-453-1232', '987-123-2312', 'kamile_madden@yahoo.com', 'active'),
(31, 'Rasheed', 'Russell', '', 'Own a strip club', '2016-10-11 18:39:34', 1, 'male', 'Commercial', '876-125-2532', '876-232-3232', 'russell@gmail.com', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `dept_no` char(4) NOT NULL,
  `dept_name` varchar(40) NOT NULL,
  PRIMARY KEY (`dept_no`),
  UNIQUE KEY `dept_name` (`dept_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deployments`
--

CREATE TABLE IF NOT EXISTS `deployments` (
  `deploy_id` int(11) NOT NULL AUTO_INCREMENT,
  `estimated_area_id` int(11) DEFAULT NULL,
  `equipment_id` int(11) NOT NULL,
  `deploy_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deploy_notes` text,
  PRIMARY KEY (`deploy_id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `estimated_area_id` (`estimated_area_id`),
  KEY `estimated_area_id_2` (`estimated_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `deployments`
--

INSERT INTO `deployments` (`deploy_id`, `estimated_area_id`, `equipment_id`, `deploy_date`, `deploy_notes`) VALUES
(2, 11, 2, '2016-10-21 07:00:24', ''),
(3, 15, 1, '2016-10-25 18:43:23', '');

-- --------------------------------------------------------

--
-- Table structure for table `dept_emp`
--

CREATE TABLE IF NOT EXISTS `dept_emp` (
  `emp_no` int(11) NOT NULL,
  `dept_no` char(4) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  PRIMARY KEY (`emp_no`,`dept_no`),
  KEY `emp_no` (`emp_no`),
  KEY `dept_no` (`dept_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dept_manager`
--

CREATE TABLE IF NOT EXISTS `dept_manager` (
  `dept_no` char(4) NOT NULL,
  `emp_no` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  PRIMARY KEY (`emp_no`,`dept_no`),
  KEY `emp_no` (`emp_no`),
  KEY `dept_no` (`dept_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `emp_no` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `first_name` varchar(14) NOT NULL,
  `last_name` varchar(16) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `hire_date` date NOT NULL,
  `emp_pic` text NOT NULL,
  `emp_license_number` varchar(20) DEFAULT NULL,
  `emp_type` enum('Technician','Admin') NOT NULL,
  PRIMARY KEY (`emp_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_no`, `birth_date`, `first_name`, `last_name`, `gender`, `hire_date`, `emp_pic`, `emp_license_number`, `emp_type`) VALUES
(0, '1993-09-09', 'Joe', 'Barret', 'M', '2016-04-06', '', NULL, 'Technician'),
(1, '1985-07-04', 'Larry', 'Steel', 'M', '2016-08-01', '', NULL, 'Technician');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `equipment_id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_name` varchar(30) NOT NULL,
  `equipment_barcode` varchar(50) DEFAULT NULL,
  `equipment_description` text,
  `service_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`equipment_id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equipment_name`, `equipment_barcode`, `equipment_description`, `service_id`) VALUES
(1, 'Rat Bait #030', '#030', 'Rat bait', NULL),
(2, 'Rat Bait #031', '#031', 'Rat Bait', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estimated_areas`
--

CREATE TABLE IF NOT EXISTS `estimated_areas` (
  `estimated_area_id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  PRIMARY KEY (`estimated_area_id`),
  KEY `area_id` (`area_id`),
  KEY `estimate_id` (`estimate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `estimated_areas`
--

INSERT INTO `estimated_areas` (`estimated_area_id`, `estimate_id`, `area_id`) VALUES
(3, 5, 1),
(11, 7, 1),
(12, 8, 3),
(13, 9, 1),
(14, 10, 1),
(15, 12, 1),
(16, 13, 1),
(17, 13, 11),
(18, 14, 1),
(37, 15, 1),
(38, 15, 11),
(39, 16, 1),
(40, 17, 1),
(41, 18, 1),
(42, 19, 1),
(43, 20, 1),
(44, 21, 1),
(45, 22, 1),
(46, 23, 1),
(47, 24, 1);

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE IF NOT EXISTS `estimates` (
  `estimate_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `received_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_date` date DEFAULT NULL,
  `schedule_date_time` datetime DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `tax` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `factor` double NOT NULL DEFAULT '0',
  `schedule_end_date` datetime DEFAULT NULL,
  `recurring_value` enum('W','M') DEFAULT NULL,
  PRIMARY KEY (`estimate_id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `estimates`
--

INSERT INTO `estimates` (`estimate_id`, `campaign_id`, `status_id`, `received_date`, `confirmed_date`, `schedule_date_time`, `expiry_date`, `tax`, `discount`, `factor`, `schedule_end_date`, `recurring_value`) VALUES
(5, 1, 2, '2016-07-09 22:19:19', NULL, NULL, '2016-08-20', 0, 0, 0, NULL, NULL),
(7, 2, 3, '2016-07-09 22:49:16', NULL, '2016-10-25 09:00:00', '2016-08-25', 15, 0, 0, '2016-10-25 10:00:00', NULL),
(8, 2, 3, '2016-08-04 06:07:57', NULL, '2016-09-05 06:30:00', '0000-00-00', 5, 0, 0, '2016-09-05 09:00:00', NULL),
(9, 1, 2, '2016-08-04 20:22:15', NULL, NULL, '0000-00-00', 20, 0, 0, NULL, NULL),
(10, 2, 2, '2016-08-04 20:29:41', NULL, NULL, '0000-00-00', 5, 0, 0, NULL, NULL),
(12, 1, 3, '2016-08-16 17:46:00', NULL, '2016-10-26 07:00:00', '0000-00-00', 5, 0, 0, '2016-10-26 08:00:00', NULL),
(13, 1, 2, '2016-08-19 03:06:19', NULL, NULL, '2016-08-25', 5, 0, 0, NULL, NULL),
(14, 1, 2, '2016-08-19 03:28:48', NULL, NULL, '2016-08-26', 5, 9, 0, NULL, NULL),
(15, 1, 3, '2016-08-19 03:35:37', NULL, '2016-09-28 06:00:00', '2016-08-26', 5, 6, 0, '2016-09-28 07:00:00', NULL),
(16, 1, 3, '2016-08-16 17:46:00', NULL, '2016-11-01 08:30:00', '0000-00-00', 5, 0, 0, '2016-11-01 09:30:00', NULL),
(17, 1, 3, '2016-08-16 17:46:00', NULL, '2016-11-08 08:30:00', '0000-00-00', 5, 0, 0, '2016-11-08 09:30:00', NULL),
(18, 1, 3, '2016-08-16 17:46:00', NULL, '2016-11-15 08:30:00', '0000-00-00', 5, 0, 0, '2016-11-15 09:30:00', NULL),
(19, 1, 3, '2016-08-16 17:46:00', NULL, '2016-11-22 08:30:00', '0000-00-00', 5, 0, 0, '2016-11-22 09:30:00', NULL),
(20, 1, 3, '2016-08-16 17:46:00', NULL, '2016-11-29 08:30:00', '0000-00-00', 5, 0, 0, '2016-11-29 09:30:00', NULL),
(21, 1, 3, '2016-08-16 17:46:00', NULL, '2016-12-06 08:30:00', '0000-00-00', 5, 0, 0, '2016-12-06 09:30:00', NULL),
(22, 1, 3, '2016-08-16 17:46:00', NULL, '2016-12-13 08:30:00', '0000-00-00', 5, 0, 0, '2016-12-13 09:30:00', NULL),
(23, 1, 3, '2016-08-16 17:46:00', NULL, '2016-12-20 08:30:00', '0000-00-00', 5, 0, 0, '2016-12-20 09:30:00', NULL),
(24, 1, 3, '2016-08-16 17:46:00', NULL, '2016-12-27 08:30:00', '0000-00-00', 5, 0, 0, '2016-12-27 09:30:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estimate_status`
--

CREATE TABLE IF NOT EXISTS `estimate_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(60) NOT NULL,
  `status_description` text,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `estimate_status`
--

INSERT INTO `estimate_status` (`status_id`, `status`, `status_description`) VALUES
(1, 'Potential Work', NULL),
(2, 'Declined', NULL),
(3, 'Open', NULL),
(4, 'Invoice', NULL),
(5, 'Close', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inspection_codes`
--

CREATE TABLE IF NOT EXISTS `inspection_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `priority` varchar(30) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jnd`
--

CREATE TABLE IF NOT EXISTS `jnd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` text,
  `estimate_area_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estimate_area_id` (`estimate_area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1473428441),
('m140209_132017_init', 1473428596),
('m140403_174025_create_account_table', 1473428597),
('m140504_113157_update_tables', 1473428598),
('m140504_130429_create_token_table', 1473428599),
('m140830_171933_fix_ip_field', 1473428599),
('m140830_172703_change_account_table_name', 1473428599),
('m141222_110026_update_ip_field', 1473428600),
('m141222_135246_alter_username_length', 1473428600),
('m150614_103145_update_social_account_table', 1473428601),
('m150623_212711_fix_username_notnull', 1473428601),
('m151218_234654_add_timezone_to_profile', 1473428601);

-- --------------------------------------------------------

--
-- Table structure for table `pest`
--

CREATE TABLE IF NOT EXISTS `pest` (
  `pest_id` int(11) NOT NULL AUTO_INCREMENT,
  `pest_name` varchar(64) DEFAULT NULL,
  `pest_description` text,
  PRIMARY KEY (`pest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `pest`
--

INSERT INTO `pest` (`pest_id`, `pest_name`, `pest_description`) VALUES
(1, 'Other Pest', ''),
(2, 'Bugs', ''),
(3, 'Flies', ''),
(4, 'Ants', ''),
(5, 'Termites', ''),
(6, 'Wasps', ''),
(7, 'Lizards', ''),
(8, 'Duck Ants', ''),
(9, 'Mice', ''),
(10, 'Birds', ''),
(11, 'Rodent', ''),
(12, 'Fleas', ''),
(13, 'Roaches', '');

-- --------------------------------------------------------

--
-- Table structure for table `pest_services`
--

CREATE TABLE IF NOT EXISTS `pest_services` (
  `pest_services_id` int(11) NOT NULL,
  `pest_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`pest_services_id`),
  KEY `pest_id` (`pest_id`,`service_id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pmi_activity`
--

CREATE TABLE IF NOT EXISTS `pmi_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pest_id` int(11) DEFAULT NULL,
  `activity_type` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `comments` text,
  `action` int(11) DEFAULT NULL,
  `estimated_area_id` int(11) DEFAULT NULL,
  `pmi_id` int(11) DEFAULT NULL,
  `pmi_docnum` varchar(32) NOT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `verified_by` varchar(255) DEFAULT NULL,
  `pmi_date` date NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `employee_id_2` (`employee_id`),
  KEY `estimated_area_id` (`estimated_area_id`),
  KEY `pest_id` (`pest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(128) NOT NULL,
  `product_description` text,
  `product_cost` double DEFAULT '0',
  `product_quantity` double DEFAULT '0',
  `ingredients` text,
  `dilution` double DEFAULT NULL,
  `application` varchar(60) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_cost`, `product_quantity`, `ingredients`, `dilution`, `application`, `service_id`) VALUES
(1, 'Chemical X', 'Kills any rodent', 300, 10, '', 0, '', 1),
(2, 'jkuygtb', 'ikjuhyg', 2, 3, '', 0, '', 1),
(3, 'Dust Pro 2000', 'Used to get rid of dust', 800, 90, '', 0, '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products_used_per_area`
--

CREATE TABLE IF NOT EXISTS `products_used_per_area` (
  `products_used_per_area_id` int(11) NOT NULL AUTO_INCREMENT,
  `estimated_area_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `product_cost_at_time` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`products_used_per_area_id`),
  KEY `product_id` (`product_id`),
  KEY `estimated_area_id` (`estimated_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `products_used_per_area`
--

INSERT INTO `products_used_per_area` (`products_used_per_area_id`, `estimated_area_id`, `product_id`, `quantity`, `product_cost_at_time`) VALUES
(3, 3, 1, 0, 0),
(12, 11, 1, 0, 0),
(13, 12, 1, 40, 300),
(14, 13, 1, 10, 300),
(15, 14, 1, 30, 300),
(16, 15, 1, 20, 500),
(17, 16, 1, 7, 300),
(18, 17, 1, 5, 300),
(19, 18, 1, 0, 300),
(27, 37, 2, 0, 2),
(28, 38, 1, 0, 300),
(29, 39, 1, 20, 500),
(30, 40, 1, 20, 500),
(31, 41, 1, 20, 500),
(32, 42, 1, 20, 500),
(33, 43, 1, 20, 500),
(34, 44, 1, 20, 500),
(35, 45, 1, 20, 500),
(36, 46, 1, 20, 500),
(37, 47, 1, 20, 500);

-- --------------------------------------------------------

--
-- Table structure for table `product_services`
--

CREATE TABLE IF NOT EXISTS `product_services` (
  `service_estimate_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`service_estimate_id`),
  KEY `service_id` (`service_id`),
  KEY `product_id` (`product_id`),
  KEY `service_id_2` (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product_services`
--

INSERT INTO `product_services` (`service_estimate_id`, `service_id`, `product_id`) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`, `timezone`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE IF NOT EXISTS `salaries` (
  `emp_no` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  PRIMARY KEY (`emp_no`,`from_date`),
  KEY `emp_no` (`emp_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(60) NOT NULL,
  `service_cost` double NOT NULL,
  `service_description` text NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_cost`, `service_description`) VALUES
(1, 'Misting', 200, 'Get rid of mosquitoes.'),
(2, 'Dusting', 400, '');

-- --------------------------------------------------------

--
-- Table structure for table `social_account`
--

CREATE TABLE IF NOT EXISTS `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_areas`
--

CREATE TABLE IF NOT EXISTS `sub_areas` (
  `sub_area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) NOT NULL,
  `sub_area` int(11) NOT NULL,
  PRIMARY KEY (`sub_area_id`),
  KEY `area_id` (`area_id`,`sub_area`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE IF NOT EXISTS `titles` (
  `emp_no` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date DEFAULT NULL,
  PRIMARY KEY (`emp_no`,`title`,`from_date`),
  KEY `emp_no` (`emp_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`user_id`, `code`, `created_at`, `type`) VALUES
(1, '6GSpzVTdvuw5yGjy7aVb5J8xXxweTXXz', 1473433505, 0);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(30) NOT NULL,
  `abbreviation` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `abbreviation`) VALUES
(1, 'Length', 'L'),
(2, 'Width', 'W'),
(3, 'Height', 'H'),
(4, 'Depth', 'D'),
(5, 'Volume', 'V'),
(6, 'Area', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_email` (`email`),
  UNIQUE KEY `user_unique_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`) VALUES
(1, 'sysadmin', 'likeslocalja@gmail.com', '$2y$12$lwl78pVMNHr2urca9.QHbeKbiW/j/o64xbOxOvb27JS2eAUMzx4Ou', 'D3gfu43HyxET7hylOFHdjaw9EEWHFpsV', NULL, NULL, NULL, '::1', 1473433505, 1473433505, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_old`
--

CREATE TABLE IF NOT EXISTS `user_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_old`
--

INSERT INTO `user_old` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'msberry', '9mQrqUeCXDLl9tdygDhNvLMmx4LmvkFb', '$2y$13$YpfR5k2jIG.E1EAYiwbmf.hSCq/CH/vlL9eyJa9BhpxjTZOcgyL4q', NULL, 'euletteberry1968@gmail.com', 10, 1460401762, 1460401762),
(2, 'admin', 'Pf3y_hL-9IYQBKEsZbNwLWVKtxNrmzKu', '$2y$13$cHKmWNmcqOPeqyLWnS/.SO2rCsKgUK0Rfb0KHXBC6c5rm0HC3OsN.', NULL, 'likeslocalja@gmail.com', 10, 1460595445, 1460595445);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `company_area_fk` FOREIGN KEY (`company_location_id`) REFERENCES `company_locations` (`company_location_id`),
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `area_units`
--
ALTER TABLE `area_units`
  ADD CONSTRAINT `areas_fk` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `units_fk` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`);

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bsr_activity`
--
ALTER TABLE `bsr_activity`
  ADD CONSTRAINT `bsr_activity_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`emp_no`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `bsr_activity_ibfk_3` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bsr_activity_ibfk_4` FOREIGN KEY (`bsr_id`) REFERENCES `bsr_header` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bsr_header`
--
ALTER TABLE `bsr_header`
  ADD CONSTRAINT `bsr_header_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_no`),
  ADD CONSTRAINT `bsr_header_ibfk_2` FOREIGN KEY (`estimated_area_id`) REFERENCES `estimated_areas` (`estimated_area_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `cust_company_fk` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company_locations`
--
ALTER TABLE `company_locations`
  ADD CONSTRAINT `company_loc_add_fk` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`),
  ADD CONSTRAINT `company_loc_com_fk` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deployments`
--
ALTER TABLE `deployments`
  ADD CONSTRAINT `deploy_ibfk_1` FOREIGN KEY (`estimated_area_id`) REFERENCES `estimated_areas` (`estimated_area_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deploy_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dept_emp`
--
ALTER TABLE `dept_emp`
  ADD CONSTRAINT `dept_emp_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `employees` (`emp_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `dept_emp_ibfk_2` FOREIGN KEY (`dept_no`) REFERENCES `departments` (`dept_no`) ON DELETE CASCADE;

--
-- Constraints for table `dept_manager`
--
ALTER TABLE `dept_manager`
  ADD CONSTRAINT `dept_manager_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `employees` (`emp_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `dept_manager_ibfk_2` FOREIGN KEY (`dept_no`) REFERENCES `departments` (`dept_no`) ON DELETE CASCADE;

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `estimated_areas`
--
ALTER TABLE `estimated_areas`
  ADD CONSTRAINT `est_area_fk` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `est_estimate_fk` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`estimate_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `estimates`
--
ALTER TABLE `estimates`
  ADD CONSTRAINT `advertising_est_fk` FOREIGN KEY (`campaign_id`) REFERENCES `advertising_campaign` (`id`),
  ADD CONSTRAINT `est_status_fk` FOREIGN KEY (`status_id`) REFERENCES `estimate_status` (`status_id`);

--
-- Constraints for table `jnd`
--
ALTER TABLE `jnd`
  ADD CONSTRAINT `jnd_ibfk_1` FOREIGN KEY (`estimate_area_id`) REFERENCES `estimated_areas` (`estimated_area_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pest_services`
--
ALTER TABLE `pest_services`
  ADD CONSTRAINT `pest_services_ibfk_1` FOREIGN KEY (`pest_id`) REFERENCES `pest` (`pest_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pest_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pmi_activity`
--
ALTER TABLE `pmi_activity`
  ADD CONSTRAINT `pmi_activity_ibfk_1` FOREIGN KEY (`pest_id`) REFERENCES `pest` (`pest_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pmi_activity_ibfk_2` FOREIGN KEY (`estimated_area_id`) REFERENCES `estimated_areas` (`estimated_area_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pmi_activity_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`emp_no`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `products_used_per_area`
--
ALTER TABLE `products_used_per_area`
  ADD CONSTRAINT `pro_estarea_fk` FOREIGN KEY (`estimated_area_id`) REFERENCES `estimated_areas` (`estimated_area_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `product_services`
--
ALTER TABLE `product_services`
  ADD CONSTRAINT `product_services_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_estimates_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `employees` (`emp_no`) ON DELETE CASCADE;

--
-- Constraints for table `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `titles`
--
ALTER TABLE `titles`
  ADD CONSTRAINT `titles_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `employees` (`emp_no`) ON DELETE CASCADE;

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
