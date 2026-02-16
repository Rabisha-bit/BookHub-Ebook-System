-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2026 at 11:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebook_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bestselling_books`
--

CREATE TABLE `bestselling_books` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `ranking` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bestselling_books`
--

INSERT INTO `bestselling_books` (`id`, `book_id`, `ranking`, `is_active`, `added_at`) VALUES
(1, 10, 1, 1, '2025-12-06 14:11:03'),
(3, 9, 2, 1, '2025-12-06 14:46:47'),
(4, 13, 3, 1, '2025-12-06 14:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_author` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `full_description` text NOT NULL,
  `book_cover` varchar(255) NOT NULL,
  `pdf_file` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `pdf_type` enum('free','paid') NOT NULL DEFAULT 'free',
  `pdf_price` int(11) NOT NULL DEFAULT 0,
  `hardcopy_price` int(11) DEFAULT 0,
  `cd_price` int(11) DEFAULT 0,
  `format_pdf` tinyint(1) DEFAULT 1,
  `format_hardcopy` tinyint(1) DEFAULT 0,
  `format_cd` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `book_title`, `book_author`, `short_description`, `full_description`, `book_cover`, `pdf_file`, `category_id`, `pdf_type`, `pdf_price`, `hardcopy_price`, `cd_price`, `format_pdf`, `format_hardcopy`, `format_cd`, `created_at`, `updated_at`) VALUES
(2, 'The Shadow Collector', 'Ayesha Rahman', 'A thrilling story of a young girl who discovers she can collect shadows and uncover hidden truths.', 'Lara, a quiet teenager, learns she has a strange ability to detach and read the shadows of people.\r\nWhen her city is shaken by mysterious disappearances, she realizes the shadows hold the truth behind every lie.\r\nAs she digs deeper, she uncovers a dark secret linked to her own family.\r\nA gripping fantasy-mystery that keeps the reader hooked until the final chapter.', 'The Shadow Collector.jpg', 'book.pdf', 1, 'paid', 399, 1999, 999, 1, 1, 1, '2025-11-25 17:55:15', '2025-11-27 07:16:35'),
(4, 'Namal', 'Nimrah Ahmed', 'A gripping Urdu novel blending mystery, crime, and emotions, following Faris Ghazi as he uncovers dark secrets', 'Namal is a fast-paced Urdu fiction that follows Faris Ghazi, a former intelligence officer wrongfully trapped in a murder case.\r\nAs the story unfolds, secrets, conspiracies, and unexpected connections between the characters begin to surface.\r\nThe novel explores family bonds, revenge, justice, and faith with powerful twists.\r\nIt is an emotional roller-coaster filled with suspense, love, and moral lessons', 'namal.jpg', 'book.pdf', 1, 'free', 0, 1800, 1700, 1, 1, 0, '2025-11-26 06:22:48', '2025-11-28 17:59:44'),
(5, 'Ishq-e-Aatish', 'Sadia Rajpoot', 'A powerful romantic fiction about a love so intense that it burns through pride, pain, and destiny.\r\n', '“Ishq-e-Aatish” is an intense romantic drama that follows the turbulent journey of two opposites whose lives become intertwined by fate. The story explores themes of emotional struggle, societal pressure, and unconditional love. As their bond deepens, both must confront the secrets and fears that threaten to destroy everything they hold dear.', 'ishq-e-atish.jpg', 'book.pdf', 1, 'paid', 250, 1400, 550, 1, 1, 1, '2025-11-26 06:35:38', '2025-11-27 07:17:24'),
(6, 'The Happy Prince & Other Tales', 'Oscar Wilde', 'A collection of heartwarming stories with meaningful morals. ', 'This collection includes stories like \"The Happy Prince\" and \"The Selfish Giant\" that teach kindness, compassion, and selflessness. Each story carries a moral lesson while being enchanting and memorable. Ideal for readers of all ages.', 'gk1.jpg', 'book.pdf', 4, 'paid', 399, 1999, 699, 1, 1, 1, '2025-11-26 17:33:03', '2025-11-27 07:17:40'),
(7, 'Pedagogy of the Oppressed', 'Paulo Freire', 'A classic book on education and social change.', 'Paulo Freire explores how education can be a tool for liberation and social transformation. He emphasizes dialogue, critical thinking, and student-centered learning. This book is foundational for educators interested in transformative teaching methods.', 'Pedagogy of the Oppressed.jpg', 'book.pdf', 3, 'paid', 699, 899, 600, 1, 1, 1, '2025-11-26 17:36:21', '2025-11-27 07:17:57'),
(8, 'How Children Learn', 'John Holt', 'Insights into natural learning processes of children.\r\nEmphasizes curiosity and self-directed learning in classrooms.', 'John Holt examines how children naturally acquire knowledge and skills, arguing that education should nurture curiosity and independence. The book provides practical advice for parents and teachers to support genuine learning.', 'How Children Learn.jpg', 'book.pdf', 3, 'free', 0, 699, 399, 1, 1, 1, '2025-11-26 17:44:24', '2025-11-27 07:18:09'),
(9, 'The Little Bookroom', 'Eleanor Farjeon', 'Magical collection of charming fairy tales and stories.\r\nInspires imagination and teaches gentle moral lessons.', 'This collection features whimsical stories filled with imagination, wonder, and moral lessons. Each tale transports readers into a world of fantasy while providing gentle guidance and inspiration. Suitable for children and adults alike.', 'The_Little_Bookroom.jpg', 'book.pdf', 4, 'free', 0, 799, 500, 1, 1, 1, '2025-11-26 17:50:32', '2025-11-27 07:18:23'),
(10, 'Bakht (بخت)', 'Mehrunnisa Shahmeer', 'Romantic, Emotional, Social Issues, Fate & Destiny, Love & Sacrifice, sometimes elements of thriller/crime & social‑drama.', '\"Bakht\" follows the journey of its protagonist as she faces love, betrayal, and societal expectations. Through trials and hardships, she discovers her inner strength and learns to navigate the complexities of life. Mehrunnisa Shahmeer weaves a story full of emotional depth, suspense, and life lessons, making it a must-read for Urdu fiction lovers.', 'bakht.jpg', 'book.pdf', 1, 'paid', 399, 1699, 600, 1, 1, 1, '2025-11-26 17:55:50', '2025-11-27 07:18:36'),
(11, 'Teach Like a Champion', 'Doug Lemov', 'Practical strategies for effective classroom teaching.\r\nFocused on techniques to improve student engagement and results.', 'Doug Lemov provides over 60 teaching techniques used by highly effective educators. The book covers classroom management, student engagement, and instructional methods with clear examples and actionable advice.', 'Teach Like a Champion.jpg', 'book.pdf', 3, 'free', 0, 799, 499, 1, 1, 1, '2025-11-27 07:28:05', '2025-11-27 07:28:19'),
(12, 'The Little Bookroom', 'Eleanor Farjeon', 'Magical collection of charming fairy tales and stories.\r\nInspires imagination and teaches gentle moral lessons.', 'This collection features whimsical stories filled with imagination, wonder, and moral lessons. Each tale transports readers into a world of fantasy while providing gentle guidance and inspiration. Suitable for children and adults alike.', 'TheLittleBookroom.jpg', 'book.pdf', 4, 'paid', 499, 899, 499, 1, 1, 1, '2025-11-27 07:32:43', '2025-11-27 07:32:43'),
(13, 'The Witches', 'Roald Dahl', 'A thrilling story about witches plotting against children.\r\nAdventure and bravery unfold as a young boy faces danger.', 'A young boy encounters real witches plotting against children. With courage and cleverness, he navigates dangerous adventures. Roald Dahl’s signature dark humor and fantasy style make this story unforgettable.', 'TheWitches.jpg', 'book.pdf', 4, 'paid', 399, 950, 550, 1, 1, 1, '2025-11-27 07:38:09', '2025-11-27 07:38:09'),
(14, 'Jannat k Patty', 'Nimrah Ahmed', 'GOOD BOOK', 'good book', 'book1.jpg', 'book (1).pdf', 1, 'free', 0, 999, 699, 1, 1, 1, '2025-12-08 13:39:17', '2025-12-08 13:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `bookcategory`
--

CREATE TABLE `bookcategory` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookcategory`
--

INSERT INTO `bookcategory` (`category_id`, `category_name`) VALUES
(3, 'Education'),
(1, 'Fictional'),
(2, 'GK Books'),
(4, 'Stories');

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE `competitions` (
  `comp_id` int(11) NOT NULL,
  `comp_title` varchar(255) NOT NULL,
  `comp_description` text DEFAULT NULL,
  `comp_type` enum('essay','story') NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `prize_details` varchar(255) DEFAULT NULL,
  `status` enum('upcoming','active','completed') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`comp_id`, `comp_title`, `comp_description`, `comp_type`, `start_date`, `end_date`, `prize_details`, `status`, `created_at`) VALUES
(1, 'Essay on Environment', 'Write an essay about protecting nature.', 'essay', '2025-12-01 00:00:00', '2025-12-11 00:00:00', 'Rs 5000 + Certificate', 'upcoming', '2025-11-27 14:04:36'),
(2, 'Smart Essay Challenge – 2025', 'This is a timed online essay competition for students. Topic will be shown after starting the attempt. Participants will get 3 hours to complete and submit their essay. Late submissions will be locked.', 'essay', '2025-12-10 00:00:00', '2025-12-15 00:00:00', '2000 + Essay Writing Guide + Certificate', 'upcoming', '2025-11-30 12:14:18'),
(4, 'Junior Creative Story Challenge – 2024', 'A storytelling competition jisme students ne apni best creative short story submit ki. Entries online collect ki gayi aur top stories ko publish kiya gaya.', 'story', '2024-05-01 00:00:00', '2024-05-10 00:00:00', 'Story Books + Achievement Certificate.', 'completed', '2025-11-30 12:24:23'),
(5, 'National  Essay Marathon – 2024', 'Timed essay writing competition jisme participants ko 3 hours ka slot mila. Essays judges ne evaluate kiye aur winners announce kiye gaye.', 'essay', '2024-08-15 00:00:00', '2024-08-25 00:00:00', 'Rs 5000 + Certificate', 'completed', '2025-11-30 12:26:14'),
(7, 'Literary Star Story Contest – 2023', 'Story lovers ke liye ek online poetry contest. Participants ne apni poems upload ki, aur best poems website par publish ki gayi.', 'story', '2023-12-01 00:00:00', '2023-12-30 00:00:00', 'Story Books + Achievement Certificate.', 'completed', '2025-11-30 12:31:33'),
(8, 'Kids Creative Essay Showdown – 2025', 'Students ke liye ek on-the-go, time-boxed essay challenge. Jaise hi participant topic page access karta hai, system automatic timer fire kar deta hai — 3 ghante ka runway milta hai essay deliver karne ke liye. Deadline miss hui? System hard-lock activate kar deta hai. Pure legacy discipline + modern workflow vibes.', 'essay', '2025-11-29 00:00:00', '2025-12-20 00:00:00', 'Rs 5000 + Certificate', 'active', '2025-11-30 12:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `competition_submissions`
--

CREATE TABLE `competition_submissions` (
  `submission_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `essay_text` text DEFAULT NULL,
  `submission_type` enum('file','text') NOT NULL,
  `timer_start` datetime DEFAULT NULL,
  `timer_end` datetime DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('submitted','under_review','approved','rejected') NOT NULL DEFAULT 'submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `competition_winners`
--

CREATE TABLE `competition_winners` (
  `id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `position` enum('first','second','third') NOT NULL,
  `announced_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Rabisha Nadeem', 'rabisha2698@gmail.com', 'Book Update', 'Book update available', '2025-12-01 15:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `kids_books_calendar`
--

CREATE TABLE `kids_books_calendar` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `release_date` date NOT NULL,
  `book_icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kids_books_calendar`
--

INSERT INTO `kids_books_calendar` (`id`, `title`, `description`, `release_date`, `book_icon`, `created_at`) VALUES
(1, 'The Magical Forest', 'A fantasy tale packed with fairies, talking trees & adventure.', '2026-02-14', 'A fantasy tale.png', '2025-12-04 11:36:41'),
(2, 'Space Explorer Mia', 'A fun science story about Mia’s journey across planets.', '2026-02-22', 'Space Explorer Mia.png', '2025-12-04 11:38:08'),
(3, 'Benny’s Brave Day', 'A heartwarming story about being brave & kind.', '2026-03-15', 'Benny’s Brave Day.png', '2025-12-04 11:39:22');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_number` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `province` varchar(100) NOT NULL,
  `order_notes` text DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `delivery_charges` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_status` enum('pending','approved','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `postal_code`, `province`, `order_notes`, `payment_method`, `subtotal`, `delivery_charges`, `total`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 22, 'ORD202602162867', 'Rabisha', 'Nadeem', 'rabisha2698@gmail.com', '+923303860361', 'FS 22/4 Near Sun Rise Children Academy Jinnah Square Malir', 'Karachi', '0000', 'Sindh', '', 'cod', 1800.00, 200.00, 2000.00, 'delivered', '2026-02-16 09:58:54', '2026-02-16 10:02:43'),
(2, 22, 'ORD202602163661', 'Rabisha', 'Nadeem', 'rabisha2698@gmail.com', '+923303860361', 'FS 22/4 Near Sun Rise Children Academy Jinnah Square Malir', 'Karachi', '0000', 'Sindh', '', 'cod', 1200.00, 200.00, 1400.00, 'delivered', '2026-02-16 10:06:06', '2026-02-16 10:07:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `format` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `title`, `author`, `format`, `price`, `quantity`, `total`, `created_at`) VALUES
(1, 1, 0, 'Namal', 'Nimrah Ahmed', 'hardcopy', 1800.00, 1, 1800.00, '2026-02-16 09:58:54'),
(2, 2, 0, 'Bakht (بخت)', 'Mehrunnisa Shahmeer', 'cd', 600.00, 2, 1200.00, '2026-02-16 10:06:06');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_password`, `role_id`, `created_at`, `updated_at`) VALUES
(22, 'Rabisha Nadeem', 'rabisha2698@gmail.com', 'rabisha2698@gmail.com.jpeg', '$2y$10$EN0BXegUQsE9VSWfBJZVMubc0zLDXC0.XhkX.xU6Ypmc7Bs8wE4Dm', 2, '2026-02-16 09:04:18', '2026-02-16 09:04:18'),
(27, 'Admin', 'adminn@gamil.com', 'adminn@gamil.com.', '$2y$10$YAGKTfuYmn3BT7bick17vezI6Ep.c1.emKHnJqTSkTN5JGJCIQEi2', 1, '2026-02-16 09:32:47', '2026-02-16 09:33:13'),
(28, 'Admin Rabisha', 'adminrabisha@gmail.com', 'adminrabisha@gmail.com.', '$2y$10$Hb0gMnI71/nWgr0d6y.bCO7IvtK5QIViwWvd4wpKHrhaw/FM3bJs.', 1, '2026-02-16 09:36:36', '2026-02-16 09:36:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bestselling_books`
--
ALTER TABLE `bestselling_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `bookcategory`
--
ALTER TABLE `bookcategory`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`comp_id`);

--
-- Indexes for table `competition_submissions`
--
ALTER TABLE `competition_submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `comp_id` (`comp_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `competition_winners`
--
ALTER TABLE `competition_winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competition_id` (`competition_id`),
  ADD KEY `submission_id` (`submission_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kids_books_calendar`
--
ALTER TABLE `kids_books_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bestselling_books`
--
ALTER TABLE `bestselling_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bookcategory`
--
ALTER TABLE `bookcategory`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `competition_submissions`
--
ALTER TABLE `competition_submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `competition_winners`
--
ALTER TABLE `competition_winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kids_books_calendar`
--
ALTER TABLE `kids_books_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bestselling_books`
--
ALTER TABLE `bestselling_books`
  ADD CONSTRAINT `bestselling_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `bookcategory` (`category_id`);

--
-- Constraints for table `competition_submissions`
--
ALTER TABLE `competition_submissions`
  ADD CONSTRAINT `competition_submissions_ibfk_1` FOREIGN KEY (`comp_id`) REFERENCES `competitions` (`comp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `competition_submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `competition_winners`
--
ALTER TABLE `competition_winners`
  ADD CONSTRAINT `competition_winners_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`comp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `competition_winners_ibfk_2` FOREIGN KEY (`submission_id`) REFERENCES `competition_submissions` (`submission_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
