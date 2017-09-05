-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 25, 2014 at 06:22 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `davaowebgate`
--
CREATE DATABASE IF NOT EXISTS `davaowebgate` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `davaowebgate`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_businesslist`
--

CREATE TABLE IF NOT EXISTS `tbl_businesslist` (
  `businessID` int(11) NOT NULL AUTO_INCREMENT,
  `businessName` varchar(50) NOT NULL,
  `businessCategory` varchar(20) NOT NULL,
  `businessType` varchar(30) NOT NULL,
  `businessAddress` varchar(100) NOT NULL,
  `businessLocation` varchar(50) NOT NULL,
  `businessPhone` varchar(50) NOT NULL,
  `businessFax` varchar(30) NOT NULL,
  `businessEmail` varchar(50) NOT NULL,
  `businessWebsite` varchar(50) NOT NULL,
  `businessDescription` text NOT NULL,
  `businessTags` varchar(150) NOT NULL,
  `businessFeatured` varchar(10) NOT NULL,
  `businessPostDate` varchar(15) NOT NULL,
  `businessUpDate` varchar(15) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`businessID`),
  FULLTEXT KEY `businessName` (`businessName`,`businessType`,`businessAddress`,`businessLocation`,`businessDescription`,`businessTags`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_businesstype`
--

CREATE TABLE IF NOT EXISTS `tbl_businesstype` (
  `businesstypeID` int(11) NOT NULL AUTO_INCREMENT,
  `businessCategory` varchar(20) NOT NULL,
  `businessType` varchar(40) NOT NULL,
  PRIMARY KEY (`businesstypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=134 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemcomments`
--

CREATE TABLE IF NOT EXISTS `tbl_itemcomments` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(200) NOT NULL,
  `commentPostDate` varchar(15) NOT NULL,
  `itemID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemviewcounter`
--

CREATE TABLE IF NOT EXISTS `tbl_itemviewcounter` (
  `counterID` int(11) NOT NULL AUTO_INCREMENT,
  `IPAddress` varchar(15) NOT NULL,
  `itemID` int(11) NOT NULL,
  PRIMARY KEY (`counterID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobpost`
--

CREATE TABLE IF NOT EXISTS `tbl_jobpost` (
  `jobID` int(11) NOT NULL,
  `jobTitle` varchar(50) NOT NULL,
  `jobCategory` varchar(20) NOT NULL,
  `jobDescription` varchar(250) NOT NULL,
  `jobQualification` varchar(250) NOT NULL,
  `jobRequirement` varchar(250) NOT NULL,
  `jobCompanyInfo` varchar(250) NOT NULL,
  `jobTags` varchar(150) NOT NULL,
  `jobPostDate` varchar(15) NOT NULL,
  `jobUpDate` varchar(15) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`jobID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_marketplace`
--

CREATE TABLE IF NOT EXISTS `tbl_marketplace` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `itemTitle` varchar(150) NOT NULL,
  `itemCategory` varchar(20) NOT NULL,
  `itemPrice` varchar(15) NOT NULL,
  `itemContactInfo` varchar(100) NOT NULL,
  `itemDescription` varchar(500) NOT NULL,
  `itemTags` varchar(150) NOT NULL,
  `itemFeatured` varchar(10) NOT NULL,
  `itemPostDate` varchar(15) NOT NULL,
  `itemUpDate` varchar(15) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`itemID`),
  FULLTEXT KEY `itemDescription` (`itemDescription`),
  FULLTEXT KEY `itemTitle` (`itemTitle`,`itemDescription`,`itemTags`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_privatemessage`
--

CREATE TABLE IF NOT EXISTS `tbl_privatemessage` (
  `privateMessageID` int(11) NOT NULL AUTO_INCREMENT,
  `messageSubject` varchar(40) NOT NULL,
  `privateMessage` varchar(300) NOT NULL,
  `privateMessagePostDate` varchar(15) NOT NULL,
  `itemID` int(11) NOT NULL,
  `fromUserID` int(11) NOT NULL,
  `toUserID` int(11) NOT NULL,
  `fromUserMail` varchar(30) NOT NULL,
  PRIMARY KEY (`privateMessageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userdetail`
--

CREATE TABLE IF NOT EXISTS `tbl_userdetail` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `userPhone` varchar(50) NOT NULL,
  `userFax` varchar(50) NOT NULL,
  `userMail` varchar(50) NOT NULL,
  `userPassword` varchar(30) NOT NULL,
  `hashedPassword` varchar(65) NOT NULL,
  `registerDate` varchar(15) NOT NULL,
  `registerUpDate` varchar(15) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
