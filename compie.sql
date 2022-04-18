-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: אפריל 18, 2022 בזמן 04:26 PM
-- גרסת שרת: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `compie`
--

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `tictactoe`
--

CREATE TABLE `tictactoe` (
  `session_id` varchar(45) NOT NULL,
  `player1` varchar(20) NOT NULL,
  `player2` varchar(20) NOT NULL,
  `winner` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- הוצאת מידע עבור טבלה `tictactoe`
--

INSERT INTO `tictactoe` (`session_id`, `player1`, `player2`, `winner`) VALUES
('50bduh71ns305ugdbq0qdrgj1v', 'ee', 'cmp', 'cmp'),
('9qs4tmkk2tdfqguru2hi820k3h', 'eliran', 'cmp', 'cmp'),
('aj9bq9siqaitofmnlc491bqclc', 'eliran', 'lita', 'cmp');

--
-- Indexes for dumped tables
--

--
-- אינדקסים לטבלה `tictactoe`
--
ALTER TABLE `tictactoe`
  ADD PRIMARY KEY (`session_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
