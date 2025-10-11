-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2013 at 08:55 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `newsalary`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'windscreen', 'adeniji');

-- --------------------------------------------------------

--
-- Table structure for table `admin_outbox`
--

CREATE TABLE IF NOT EXISTS `admin_outbox` (
  `ao_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(100) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `msg_subject` text NOT NULL,
  `msg_msg` text NOT NULL,
  `sent_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ao_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `register_staff`
--

CREATE TABLE IF NOT EXISTS `register_staff` (
  `staff_id` int(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `department` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `years` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `register_staff`
--

INSERT INTO `register_staff` (`staff_id`, `fname`, `sex`, `birthday`, `department`, `position`, `grade`, `years`, `username`, `password`, `date_registered`) VALUES
(1, 'Adeniji Charles Ayo', 'Male', '1989-06-06', 'I.T.', 'GMD/CEO', '18', '18', 'adeniji', 'charles', '2013-06-29 20:44:29'),
(2, 'Mathew Senami Tosin', 'Female', '1988-12-16', 'Human Resources', 'Manager', '12', '15', 'senami', '12345678', '2013-06-29 20:54:48'),
(3, 'Adesiyan Kemi Jelilat', 'Female', '1988-11-26', 'I.T.', 'Manager', '6', '13', 'adesiyan', 'adesiyan', '2013-06-29 20:56:07'),
(4, 'Adeniji Titilayo Mary', 'Female', '1990-07-21', 'Accounting', 'As. Director', '6', '15', 'adeniji', 'teetee1', '2013-06-30 01:12:55'),
(6, 'Adeomi Oluwafemi Alade', 'Male', '1980-12-31', 'Administration', 'Manager', '7', '16', 'adeomi', 'adeomi1', '2013-06-30 01:14:43'),
(7, 'Ogundipe Kemi Eunice', 'Female', '1987-11-08', 'Administration', 'As.Manager', '9', '14', 'ogundipe', 'eunice1', '2013-06-30 01:15:43'),
(8, 'Adewole Seyi', 'Female', '1990-12-31', 'Marketing', 'As.Manager', '13', '16', 'adewole', 'adewole', '2013-06-30 17:22:47'),
(9, 'Adeniji Temilayo', 'Male', '1997-04-28', 'Production', 'Director', '13', '16', 'temilayo', 'temilayo', '2013-06-30 17:35:07'),
(10, 'Christina Aguilera', 'Female', '1970-03-11', 'Human Resources', 'Supervisor', '18', '16', 'christina', 'christina', '2013-06-30 17:50:43'),
(11, 'Katy Perry', 'Female', '1967-09-23', 'Accounting', 'Head', '9', '12', 'katyperry', 'katyperry', '2013-06-30 17:51:50'),
(12, 'Anazodo Charles', 'Male', '1950-07-17', 'Marketing', 'Ass. Head', '20', '20', 'anazodo', 'anazodo', '2013-06-30 17:53:18'),
(13, 'Odesola Banji', 'Male', '1998-03-01', 'Research', 'Head', '12', '16', 'odesola', 'odesola', '2013-06-30 20:09:42'),
(14, 'David Beckham', 'Male', '1977-06-26', 'Marketing', 'Clerk', '5', '12', 'david', 'beckham', '2013-07-01 20:21:50'),
(15, 'Jeffery John', 'Male', '2010-07-12', 'Accounting', 'Director', '25', '10', 'jeffery', 'jeffery', '2013-07-26 17:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `salary_id` int(50) NOT NULL AUTO_INCREMENT,
  `staff_id` int(50) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `years` varchar(50) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `basic` varchar(50) NOT NULL,
  `meal` varchar(50) NOT NULL,
  `housing` varchar(50) NOT NULL,
  `transport` varchar(50) NOT NULL,
  `entertainment` varchar(50) NOT NULL,
  `long_service` int(11) NOT NULL,
  `tax` varchar(50) NOT NULL,
  `totall` int(60) NOT NULL,
  `date_s` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`salary_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `staff_id`, `fname`, `department`, `position`, `years`, `grade`, `basic`, `meal`, `housing`, `transport`, `entertainment`, `long_service`, `tax`, `totall`, `date_s`) VALUES
(1, 1, 'Adeniji Charles Ayo', 'I.T.', 'MD/CEO', '18', '18', '17237612', '263738', '2585641.8', '1379008.96', '344752.24', 301658, '1551385.08', 20561026, '2013-06-30 00:08:17'),
(2, 2, 'Mathew Senami Tosin', 'Human Resources', 'Manager', '15', '12', '1998837', '637721', '299825.55', '159906.96', '39976.74', 34980, '179895.33', 2991352, '2013-06-30 00:09:05'),
(3, 3, 'Adesiyan Kemi Jelilat', 'I.T.', 'Manager', '13', '6', '7827627', '162783', '1174144.05', '626210.16', '0', 0, '704486.43', 9086278, '2013-06-30 00:09:28'),
(4, 4, 'Adeniji Titilayo Mary', 'Accounting', 'As. Director', '15', '6', '500000', '50000', '75000', '40000', '0', 8750, '45000', 628750, '2013-06-30 17:20:05'),
(6, 6, 'Adeomi Oluwafemi Alade', 'Administration', 'Manager', '16', '7', '400000', '120000', '60000', '32000', '0', 7000, '36000', 583000, '2013-06-30 17:20:50'),
(7, 7, 'Ogundipe Kemi Eunice', 'Administration', 'As.Manager', '14', '9', '820000', '50000', '123000', '65600', '16400', 0, '73800', 1001200, '2013-06-30 17:21:14'),
(9, 8, 'Adewole Seyi', 'Marketing', 'As.Manager', '16', '13', '465344', '124434', '69801.6', '37227.52', '9306.88', 8144, '41880.96', 672377, '2013-06-30 17:32:12'),
(10, 9, 'Adeniji Temilayo', 'Production', 'Director', '16', '13', '700000', '245856', '105000', '56000', '14000', 12250, '63000', 1070106, '2013-06-30 17:35:38'),
(11, 10, 'Christina Aguilera', 'Human Resources', 'Supervisor', '16', '18', '890000', '234676', '133500', '71200', '17800', 15575, '80100', 1282651, '2013-06-30 20:13:48'),
(16, 11, 'Katy Perry', 'Accounting', 'Head', '12', '9', '100000', '100000', '15000', '8000', '2000', 0, '9000', 216000, '2013-06-30 20:18:14'),
(17, 12, 'Anazodo Charles', 'Marketing', 'Ass. Head', '20', '20', '200000', '10000', '30000', '16000', '4000', 3500, '18000', 245500, '2013-06-30 20:18:35'),
(18, 13, 'Odesola Banji', 'Research', 'Head', '16', '12', '500000', '200000', '75000', '40000', '10000', 8750, '45000', 788750, '2013-06-30 20:18:48'),
(20, 1, 'Adeniji Charles Ayo', 'I.T.', 'MD/CEO', '18', '18', '17237612', '1000000', '2585641.8', '1379008.96', '344752.24', 301658, '1551385.08', 21297288, '2013-07-01 07:08:07'),
(21, 2, 'Mathew Senami Tosin', 'Human Resources', 'Manager', '15', '12', '2000000', '32424', '300000', '160000', '40000', 35000, '180000', 2387424, '2013-07-01 07:08:58'),
(25, 3, 'Adesiyan Kemi Jelilat', 'I.T.', 'Manager', '13', '6', '1000000', '1000000', '150000', '80000', '0', 0, '90000', 2140000, '2013-07-02 10:03:45'),
(26, 4, 'Adeniji Titilayo Mary', 'Accounting', 'As. Director', '15', '6', '2004898', '1873783', '300734.7', '160391.84', '0', 35086, '180440.82', 4194452, '2013-07-02 10:04:24'),
(27, 6, 'Adeomi Oluwafemi Alade', 'Administration', 'Manager', '16', '7', '500000', '500000', '75000', '40000', '0', 8750, '45000', 1078750, '2013-07-02 10:04:37'),
(28, 7, 'Ogundipe Kemi Eunice', 'Administration', 'As.Manager', '14', '9', '545766', '128473', '81864.9', '43661.28', '10915.32', 0, '49118.94', 761562, '2013-07-02 10:05:46'),
(30, 8, 'Adewole Seyi', 'Marketing', 'As.Manager', '16', '13', '721538', '252713', '108230.7', '57723.04', '14430.76', 12627, '64938.42', 1102324, '2013-07-02 10:08:52'),
(31, 9, 'Adeniji Temilayo', 'Production', 'Director', '16', '13', '8739928', '183732', '1310989.2', '699194.24', '174798.56', 152949, '786593.52', 10474997, '2013-07-02 10:18:01'),
(32, 10, 'Christina Aguilera', 'Human Resources', 'Supervisor', '16', '18', '83671', '777229', '12550.65', '6693.68', '1673.42', 1464, '7530.39', 875752, '2013-07-02 10:18:34'),
(33, 11, 'Katy Perry', 'Accounting', 'Head', '12', '9', '23232', '131311', '3484.8', '1858.56', '464.64', 0, '2090.88', 158260, '2013-07-02 10:18:51'),
(34, 12, 'Anazodo Charles', 'Marketing', 'Ass. Head', '20', '20', '773883', '363633', '116082.45', '61910.64', '15477.66', 13543, '69649.47', 1274880, '2013-07-02 10:19:17'),
(35, 15, 'Jeffery John', 'Accounting', 'Director', '10', '25', '1000000', '100000', '150000', '80000', '20000', 0, '90000', 1260000, '2013-07-26 17:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `staff_inbox`
--

CREATE TABLE IF NOT EXISTS `staff_inbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(50) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `msg_subject` text NOT NULL,
  `msg_msg` text NOT NULL,
  `received_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `staff_inbox`
--

INSERT INTO `staff_inbox` (`id`, `staff_id`, `sender`, `receiver`, `msg_subject`, `msg_msg`, `received_date`) VALUES
(1, '1', '2', 'Adeniji Charles Ayo', 'Hi', 'This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:', '2013-08-12 20:36:17'),
(2, '', '1', 'Mathew Senami Tosin', '', 'This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:\r\n\r\n\r\nThis is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:', '2013-08-12 20:37:55'),
(3, '2', '1', 'Mathew Senami Tosin', 'Hi', 'This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:', '2013-08-12 20:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `staff_outbox`
--

CREATE TABLE IF NOT EXISTS `staff_outbox` (
  `so_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(50) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `msg_subject` text NOT NULL,
  `msg_msg` text NOT NULL,
  `date_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`so_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `staff_outbox`
--

INSERT INTO `staff_outbox` (`so_id`, `staff_id`, `sender`, `receiver`, `msg_subject`, `msg_msg`, `date_sent`) VALUES
(1, 1, '2', 'Adeniji Charles Ayo', 'Hi', 'This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:', '2013-08-12 20:36:17'),
(3, 2, '1', 'Mathew Senami Tosin', 'Hi', 'This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:This is the abstract of the project/business feasibility for the donor.  It is the first thing that the donor will read.  It should be direct, clear and concise.  The content of the summary should include who you are, the scope of your project and cost. Your Executive Summary should be able to arrest the attention of the reviewing officer.  For example, the Executive Summary of NOIC proposal for collaboration with Local Governments in Lagos State (November 2001) is as follows:', '2013-08-12 20:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `variables`
--

CREATE TABLE IF NOT EXISTS `variables` (
  `housing` float NOT NULL,
  `transport` float NOT NULL,
  `tax` float NOT NULL,
  `entertainment` float NOT NULL,
  `long_service` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `variables`
--

INSERT INTO `variables` (`housing`, `transport`, `tax`, `entertainment`, `long_service`) VALUES
(0.15, 0.08, 0.09, 0.02, 0.0175);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
