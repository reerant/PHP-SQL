-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06.05.2019 klo 21:47
-- Palvelimen versio: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

--
-- Vedos taulusta `task`
--

INSERT INTO `task` (`taskID`, `description`, `date`, `priority`, `completed`, `userID`) VALUES
(111, 'test task', '2019-06-02', 'High', 0, 28),
(112, 'test task 2', '2019-05-19', 'Medium', 0, 28),
(113, 'test task 3', '2019-09-14', 'Low', 0, 28);

--
-- Vedos taulusta `user`
--

INSERT INTO `user` (`userID`, `fname`, `lname`, `email`, `password`) VALUES
(28, 'Jon', 'Snow', 'jon@test.com', '$2y$10$TsJdKYldy6R.aD4aGGAKIO9IZrvYWX/Zw93EZ0xTnjl2ecXzyev5u');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
