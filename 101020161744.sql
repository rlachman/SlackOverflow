-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2016 at 09:43 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `answer` varchar(5000) NOT NULL,
  `responder_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `num_upvotes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `answer`, `responder_id`, `question_id`, `num_upvotes`) VALUES
(23, 'You could use the addslashes() method to escape apostrophes and quotation marks like this: don\'t or "quote".', 5, 28, NULL),
(24, '...', 5, 28, NULL),
(25, 'aasdfasdf', 5, 28, NULL),
(26, 'TEST', 5, 28, NULL),
(27, 'Read some tutorials.', 5, 22, NULL),
(28, 'Bob', 2, 30, NULL),
(29, 'Posted from mobile', 12, 28, NULL),
(30, 'It\'s a secret.', 13, 18, NULL),
(31, 'Test', 5, 27, NULL),
(32, '5th answer', 5, 28, NULL);

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
(18, 'How to redirect after submitting form using PHP?', 'How to redirect after submitting form using PHP?', 5, NULL, NULL),
(22, 'How can I use CSS to make my web app look better?', 'How can I use CSS to make my web app look better?', 5, NULL, NULL),
(23, 'Can I post here from a phone??', 'Can I post here from a phone??', 5, NULL, NULL),
(24, 'How do I set my upstream branch?', 'How do I reset set my upstream branch?', 5, NULL, NULL),
(25, 'Who sells the best laptop?', 'I am looking to buy a new laptop and I am wondering who will give me the best and for my buck performance wise? ', 8, NULL, 1),
(26, 'test', 'test', 9, NULL, NULL),
(27, 'Hi', 'Hi', 5, NULL, NULL),
(28, 'What can I use to sanitize a string before inserting into SQL DB?', 'Read above.', 5, NULL, NULL),
(29, 'asdf', 'asdf', 2, NULL, NULL),
(30, 'What is my name?', 'What is my name???', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pass`) VALUES
(1, 'harrison', 'email@email.com', '$2y$10$8NnIKUShKJaYPaJD7CGvteJR4Ob4ZrRkMvoRtSYijUeSwG7YFNwjO'),
(2, 'bob', 'bob@bob.com', '$2y$10$lQnGeg0V65uMomPxddu3luSE8AEa1k6yGI4tj/2W1qHAkURKLDBd.'),
(3, 'john', 'john@john.com', '$2y$10$FouKLN5PmmYkYUi1cRS4j.Cke230BddZx3CpFCJK8eGZ1Bj1OGvXe'),
(4, 'stevieWonder', 'email@emails.com', '$2y$10$JAn7B.AHoOtPy57f79yFi.mjOaaNcbVzBRZDpC0daHIXUvnZYQRua'),
(5, 'JohnWayne', 'jw@jw.com', '$2y$10$FuZc7.iHZfSo/2YMIW5WOehOagQBJu7HEyzTIQ5ZYuzqj7Xyu9zBG'),
(6, 'RayCharles', 'rc@email.com', '$2y$10$uXI53uGpoT0hEnsP84S89uVZsq.i4PRJmwpCwCuwBY4jQ.RWfnDc6'),
(7, 'DarthVader', 'jw@email.com', '$2y$10$DSnn44sNqq1UCujVxp4tAOZEch5yxP.pMAHVOmJlh161zdtu3t7gO'),
(8, 'kitten', 'kitten@kitten.com', '$2y$10$SjUTi2ZBNFtOFZalPoHfy.dabSJqg/aFyustI1OIjc3gTTw5PwjnW'),
(9, 'steve', 'steve@steve.com', '$2y$10$ZTPijWz/rD3c.hMvlBq4Y.kWAdpC3EIayoReNQ0LEbqiuKIBfvvVy'),
(12, 'BillGates', 'Bg@email.com', '$2y$10$4/3rIs0o6w2ftARi4eEl0eegsBtWaoxCptau3Zs4q8WsiU5TgeWha'),
(13, 'Joe', 'joe@email.com', '$2y$10$8wXWQEeEyurTJAFVT4uj.OL5IbqrFXKwPBhVANbl.eigsIGgCYvse');

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
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
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
