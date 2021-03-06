-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql.cms.gre.ac.uk:3306
-- Generation Time: Feb 28, 2020 at 01:54 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1-log
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mdb_st2645h`
--
CREATE DATABASE IF NOT EXISTS `mdb_st2645h` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mdb_st2645h`;

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`CategoryID`, `Name`, `Description`, `Removed`) VALUES
(1, 'Educational', NULL, 1),
(2, 'Health and Safety', NULL, 0),
(3, 'Medical', 'For medical problems or health issues', 0),
(4, 'Electrical', 'Any computing related concerns', 0),
(5, 'Danger', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE `Comment` (
  `CommentID` int(11) NOT NULL,
  `IdeaID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CommentText` text NOT NULL,
  `Anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `DatePosted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Comment`
--

INSERT INTO `Comment` (`CommentID`, `IdeaID`, `UserID`, `CommentText`, `Anonymous`, `DatePosted`, `Removed`) VALUES
(1, 2, 10, 'What!  Your dead body doesn\'t have the courtesy to remove it\'s self', 0, '2020-02-02 21:27:00', 0),
(2, 1, 6, 'Excellent idea', 0, '2020-02-13 16:22:31', 0),
(3, 1, 18, 'I would like that', 1, '2020-02-13 16:23:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Department`
--

CREATE TABLE `Department` (
  `DepartmentID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Department`
--

INSERT INTO `Department` (`DepartmentID`, `Name`, `Description`, `Removed`) VALUES
(1, 'Computing', NULL, 0),
(2, 'Science', NULL, 0),
(3, 'Sports', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Document`
--

CREATE TABLE `Document` (
  `DocumentID` int(11) NOT NULL,
  `IdeaID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Document` longblob NOT NULL,
  `Size` int(11) NOT NULL,
  `Removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Forum`
--

CREATE TABLE `Forum` (
  `ForumID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Closure` datetime NOT NULL,
  `FinalClosure` datetime NOT NULL,
  `Removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Forum`
--

INSERT INTO `Forum` (`ForumID`, `Name`, `Description`, `Closure`, `FinalClosure`, `Removed`) VALUES
(1, 'Improvements', NULL, '2020-02-29 12:00:00', '2020-03-29 12:00:00', 0),
(2, 'Computing', 'Computers and Stuff', '2020-03-03 10:30:00', '2020-04-02 10:30:00', 0),
(3, 'Food', NULL, '2020-02-18 00:00:00', '2020-02-27 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Idea`
--

CREATE TABLE `Idea` (
  `IdeaID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ForumID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `IdeaText` text NOT NULL,
  `Anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `DatePosted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ViewCounter` int(11) NOT NULL DEFAULT '0',
  `Removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Idea`
--

INSERT INTO `Idea` (`IdeaID`, `UserID`, `ForumID`, `Title`, `IdeaText`, `Anonymous`, `DatePosted`, `ViewCounter`, `Removed`) VALUES
(1, 3, 1, 'Pool Table', 'Install a pool table', 0, '2020-02-01 12:00:00', 53, 0),
(2, 7, 1, 'Unwanted Item', 'Best place to dispose of unwanted remains', 1, '2020-02-02 21:20:00', 6, 0),
(3, 21, 1, 'Advanced resting locations', 'We need more places to slack off to', 0, '2020-02-13 02:51:53', 18, 0),
(4, 17, 1, 'No more sharp corners', 'Also foam on all edges would be nice', 0, '2020-02-13 02:54:32', 5, 0),
(5, 2, 1, 'It is the end of the world', 'AHHHHHHH', 1, '2020-02-13 02:54:49', 2, 1),
(6, 3, 3, 'Better Canteen Food', 'The food is awful, I want better options', 0, '2020-02-19 18:45:48', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `IdeaCategory`
--

CREATE TABLE `IdeaCategory` (
  `IdeaCategory` int(11) NOT NULL,
  `IdeaID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IdeaCategory`
--

INSERT INTO `IdeaCategory` (`IdeaCategory`, `IdeaID`, `CategoryID`) VALUES
(1, 1, 3),
(2, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Rate`
--

CREATE TABLE `Rate` (
  `RateID` int(11) NOT NULL,
  `IdeaID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ThumbUp` tinyint(1) NOT NULL DEFAULT '0',
  `ThumbDown` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Rate`
--

INSERT INTO `Rate` (`RateID`, `IdeaID`, `UserID`, `ThumbUp`, `ThumbDown`) VALUES
(1, 1, 5, 1, 0),
(2, 2, 7, 1, 0),
(3, 1, 4, 1, 0),
(4, 1, 6, 1, 0),
(5, 1, 7, 0, 1),
(6, 3, 21, 0, 0),
(7, 4, 7, 0, 1),
(8, 4, 17, 0, 0),
(9, 2, 9, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE `Role` (
  `RoleID` int(11) NOT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `NoDepartment` tinyint(1) NOT NULL DEFAULT '0',
  `Removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`RoleID`, `Name`, `Type`, `Description`, `NoDepartment`, `Removed`) VALUES
(1, 'Quality Assurance Manager', 'Manager', NULL, 1, 0),
(2, 'Quality Assurance Coordinator', 'Coordinator', NULL, 0, 0),
(3, 'Academic', 'Staff', NULL, 0, 0),
(4, 'Support', 'Staff', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Test`
--

CREATE TABLE `Test` (
  `ID` int(11) NOT NULL,
  `Number` int(11) DEFAULT NULL,
  `String` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Test`
--

INSERT INTO `Test` (`ID`, `Number`, `String`) VALUES
(3, NULL, 'Jesus'),
(4, 0, 'Me'),
(5, 1, 'FrankSpencer'),
(6, 1, 'Improvements'),
(7, 1, 'Pool Table'),
(8, 1, 'Computing'),
(9, 4, 'John');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserID` int(11) NOT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `RoleID` int(11) NOT NULL,
  `UserName` varchar(20) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  `Banned` tinyint(1) NOT NULL DEFAULT '0',
  `Removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `DepartmentID`, `RoleID`, `UserName`, `Password`, `Email`, `Admin`, `Banned`, `Removed`) VALUES
(1, NULL, 1, 'NumberOne', 'password', 'myEmail@mail.com', 1, 0, 0),
(2, 1, 2, 'ChickenLittle', 'NotPassword', 'ChickenLittle@mail.com', 0, 0, 0),
(3, 1, 3, 'Mr_Pinky', 'potato', 'PepperPigLover@mail.com', 0, 0, 0),
(4, 1, 4, 'Brony4Life', 'MyLittlePony', 'BronyMan@mail.com', 0, 0, 0),
(5, 2, 2, 'FrankSpencer', 'FrankSpencer', 'FrankSpencer@mail.com', 0, 0, 0),
(6, 2, 3, 'Pikachu', 'Pikachu', 'PokemonMaster@mail.com', 0, 0, 0),
(7, 2, 4, 'Satou Kazuma', 'Steal', 'KazumaDesu@mail.com', 0, 0, 0),
(8, 3, 4, 'sabhdjfds', 'The Witcher 2', 'ahhh@mail.com', 0, 0, 0),
(9, 3, 3, 'Arnie', 'ILoveMuscles', 'MuscleLover@mail.com', 0, 0, 0),
(10, 3, 4, 'Jesus', 'Jesus', 'Jesus@mail.com', 1, 0, 0),
(12, 1, 3, 'aaasf', 'The Witcher 2', 'b', 0, 0, 1),
(13, 2, 3, 'aaasf', 'Password', 'c@gree.com', 0, 0, 0),
(16, 3, 4, 'Yepa', 'Password', 'adsf@gre.acc', 0, 0, 0),
(17, 1, 4, 'Mr Bump', 'Oww', 'mrBump@mail.com', 0, 0, 0),
(18, 1, 4, 'Frank', 'Skinner', 'ItsComingHome@mail.com', 0, 0, 0),
(19, 2, 3, 'IronSide', 'ironside', 'Transformers@mail.com', 0, 0, 1),
(20, 3, 2, 'B Man', 'I can fly', 'bumbles@mail.com', 0, 0, 0),
(21, 1, 4, 'Hasebe', 'Jaa ne Lucy', 'OnABreak@mail.com', 0, 0, 0),
(22, 1, 4, 'asdf', 'The Witcher 2', 'asdf@gmail.com', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `IdeaID` (`IdeaID`),
  ADD KEY `StaffID` (`UserID`);

--
-- Indexes for table `Department`
--
ALTER TABLE `Department`
  ADD PRIMARY KEY (`DepartmentID`);

--
-- Indexes for table `Document`
--
ALTER TABLE `Document`
  ADD PRIMARY KEY (`DocumentID`),
  ADD KEY `IdeaID` (`IdeaID`);

--
-- Indexes for table `Forum`
--
ALTER TABLE `Forum`
  ADD PRIMARY KEY (`ForumID`);

--
-- Indexes for table `Idea`
--
ALTER TABLE `Idea`
  ADD PRIMARY KEY (`IdeaID`),
  ADD KEY `StaffID` (`UserID`),
  ADD KEY `ForumID` (`ForumID`);

--
-- Indexes for table `IdeaCategory`
--
ALTER TABLE `IdeaCategory`
  ADD PRIMARY KEY (`IdeaCategory`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `IdeaID` (`IdeaID`);

--
-- Indexes for table `Rate`
--
ALTER TABLE `Rate`
  ADD PRIMARY KEY (`RateID`),
  ADD KEY `StaffID` (`UserID`),
  ADD KEY `IdeaID` (`IdeaID`);

--
-- Indexes for table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `Test`
--
ALTER TABLE `Test`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `DepartmentID` (`DepartmentID`),
  ADD KEY `RoleID` (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Comment`
--
ALTER TABLE `Comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Department`
--
ALTER TABLE `Department`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Document`
--
ALTER TABLE `Document`
  MODIFY `DocumentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Forum`
--
ALTER TABLE `Forum`
  MODIFY `ForumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Idea`
--
ALTER TABLE `Idea`
  MODIFY `IdeaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `IdeaCategory`
--
ALTER TABLE `IdeaCategory`
  MODIFY `IdeaCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Rate`
--
ALTER TABLE `Rate`
  MODIFY `RateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Role`
--
ALTER TABLE `Role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Test`
--
ALTER TABLE `Test`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`IdeaID`) REFERENCES `Idea` (`IdeaID`),
  ADD CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`);

--
-- Constraints for table `Document`
--
ALTER TABLE `Document`
  ADD CONSTRAINT `Document_ibfk_1` FOREIGN KEY (`IdeaID`) REFERENCES `Idea` (`IdeaID`);

--
-- Constraints for table `Idea`
--
ALTER TABLE `Idea`
  ADD CONSTRAINT `Idea_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`),
  ADD CONSTRAINT `Idea_ibfk_2` FOREIGN KEY (`ForumID`) REFERENCES `Forum` (`ForumID`);

--
-- Constraints for table `IdeaCategory`
--
ALTER TABLE `IdeaCategory`
  ADD CONSTRAINT `IdeaCategory_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `Category` (`CategoryID`),
  ADD CONSTRAINT `IdeaCategory_ibfk_2` FOREIGN KEY (`IdeaID`) REFERENCES `Idea` (`IdeaID`);

--
-- Constraints for table `Rate`
--
ALTER TABLE `Rate`
  ADD CONSTRAINT `Rate_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`),
  ADD CONSTRAINT `Rate_ibfk_2` FOREIGN KEY (`IdeaID`) REFERENCES `Idea` (`IdeaID`);

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `Department` (`DepartmentID`),
  ADD CONSTRAINT `User_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `Role` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
