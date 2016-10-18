-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 18, 2016 at 06:33 AM
-- Server version: 5.7.15-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slackoverflow`
--
CREATE DATABASE slackoverflow;
USE slackoverflow;
-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `answer` varchar(5000) NOT NULL,
  `responder_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `is_best` tinyint(1) DEFAULT '0',
  `num_upvotes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `answer`, `responder_id`, `question_id`, `is_best`, `num_upvotes`) VALUES
(62, 'The answer is 2.', 12, 42, 1, NULL),
(63, 'John Wayne.', 12, 43, 1, NULL),
(64, 'lkajsdfo;iaudopf9adusfo;kajsdlkfjasdflas;dfkjasdf', 6, 43, 0, NULL),
(65, 'kalskdjfa9sd0f809238490jlkjkfasdfadf', 6, 42, 0, NULL),
(66, 'John Wayne.', 5, 43, 0, NULL),
(67, '42', 5, 44, 1, NULL),
(68, '16', 5, 44, 0, NULL),
(69, 'I have them.', 7, 45, 1, NULL),
(70, 'Don\'t know.', 12, 45, 0, NULL),
(72, '123', 5, 42, 0, NULL),
(73, 'cvgn', 8, 42, 0, NULL),
(74, 'Resp1', 5, 47, 1, NULL),
(75, 'Some guy.', 5, 48, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_title` varchar(100) NOT NULL,
  `question` varchar(5000) NOT NULL,
  `asker_id` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `is_solved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_title`, `question`, `asker_id`, `answer_id`, `is_solved`) VALUES
(42, 'How do I add this?', '1+1', 5, NULL, 1),
(43, 'What is my name?', 'What is my first and last name?', 5, NULL, 1),
(44, 'How many movies have I starred in?', '', 5, NULL, 1),
(45, 'Where are my glasses?', '', 6, NULL, 1),
(46, 'TEST', 'TEST', 5, NULL, NULL),
(47, 'Test', '???', 5, NULL, 1),
(48, 'Who is slimer?', 'Who is slimer?Who is slimer?Who is slimer?', 21, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `is_guest` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pass`, `is_guest`) VALUES
(1, 'harrison', 'email@email.com', '$2y$10$8NnIKUShKJaYPaJD7CGvteJR4Ob4ZrRkMvoRtSYijUeSwG7YFNwjO', 0),
(2, 'bob', 'bob@bob.com', '$2y$10$lQnGeg0V65uMomPxddu3luSE8AEa1k6yGI4tj/2W1qHAkURKLDBd.', 0),
(3, 'john', 'john@john.com', '$2y$10$FouKLN5PmmYkYUi1cRS4j.Cke230BddZx3CpFCJK8eGZ1Bj1OGvXe', 0),
(4, 'stevieWonder', 'email@emails.com', '$2y$10$JAn7B.AHoOtPy57f79yFi.mjOaaNcbVzBRZDpC0daHIXUvnZYQRua', 0),
(5, 'JohnWayne', 'jw@jw.com', '$2y$10$FuZc7.iHZfSo/2YMIW5WOehOagQBJu7HEyzTIQ5ZYuzqj7Xyu9zBG', 0),
(6, 'RayCharles', 'rc@email.com', '$2y$10$uXI53uGpoT0hEnsP84S89uVZsq.i4PRJmwpCwCuwBY4jQ.RWfnDc6', 0),
(7, 'DarthVader', 'jw@email.com', '$2y$10$DSnn44sNqq1UCujVxp4tAOZEch5yxP.pMAHVOmJlh161zdtu3t7gO', 0),
(8, 'kitten', 'kitten@kitten.com', '$2y$10$SjUTi2ZBNFtOFZalPoHfy.dabSJqg/aFyustI1OIjc3gTTw5PwjnW', 0),
(9, 'steve', 'steve@steve.com', '$2y$10$ZTPijWz/rD3c.hMvlBq4Y.kWAdpC3EIayoReNQ0LEbqiuKIBfvvVy', 0),
(12, 'BillGates', 'Bg@email.com', '$2y$10$4/3rIs0o6w2ftARi4eEl0eegsBtWaoxCptau3Zs4q8WsiU5TgeWha', 0),
(13, 'Joe', 'joe@email.com', '$2y$10$8wXWQEeEyurTJAFVT4uj.OL5IbqrFXKwPBhVANbl.eigsIGgCYvse', 0),
(14, 'guest', 'guest@guest.com', '$2y$10$FuZc7.iHZfSo/2YMIW5WOehOagQBJu7HEyzTIQ5ZYuzqj7Xyu9zBG', 1),
(15, 'moe', 'moe@email.com', '$2y$10$1Cd3nMHaz9gaF8oyfuUn8ucTSBh2zVOKzCib6ny8O3og9Zysywthe', 0),
(16, '123', '123@email.com', '$2y$10$bKl6UV6JxEj5z9dQcusZoe682EJGUsfy/RvcNe3A/6MZNl5mhM9se', 0),
(17, '1234', '1234@email.com', '$2y$10$L0bsruJe6d.Vn3M4pfqdkuIzBEZUnyacwE8mEbCa7o4oijSg3fegq', 0),
(18, 'abc', 'abc@email.com', '$2y$10$fMHC6W9.GwusMb.SFcKAheqbCnIVGJJ1UbpuVjPQGK0iPfGFz3ulO', 0),
(19, 'rstantz', 'rstantz@email.com', '$2y$10$m0QO81Hdx/JEQ9LlMOc1GeYJUZ9RVgIz5UJkF11etZYQfH1l5fEzK', 0),
(20, 'jbrunelle', 'jbrunelle@email.com', '$2y$10$7u3kaxoXuTe2azFEyg2tyOJCy5AYo1Coh60.FZc7f7Rxu0GVQHJHS', 0),
(21, 'slimer', 'slimer@email.com', '$2y$10$PeymSvdwnTkpqJFxZR7G4uFv35kjVst7kGVmWFqqHkSPfU.MxUt6O', 0),
(22, '123123', '123123@email.com', 'adminadmin', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `responder_id` (`responder_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `asker_id` (`asker_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`responder_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`asker_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`answer_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
