-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 02:56 PM
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
-- Database: `raya_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `nama`, `metode`, `created_at`, `status`) VALUES
(2, 1, 2, 'oreli', 'qris', '2026-04-15 06:42:46', 'paid'),
(3, 1, 1, 'lia', 'qris', '2026-04-15 06:49:24', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `category` enum('digital','course','setup') DEFAULT NULL,
  `icon` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category`, `icon`, `created_at`) VALUES
(1, 'Live Streaming Basic', 'Pelajari dasar-dasar live streaming dari nol hingga siap tayang dengan kualitas profesional. Course ini dirancang khusus untuk pemula yang ingin memulai karier sebagai streamer tanpa ribet. Kamu akan dibimbing langkah demi langkah mulai dari setup software, pengaturan audio & video, hingga cara melakukan live streaming ke berbagai platform seperti YouTube dan Twitch.', 40000, 'course', '📚', '2026-04-12 13:44:23'),
(2, 'Streaming Production', 'Kelas ini ditujukan untuk meningkatkan kualitas live streaming ke level profesional. Pelajari teknik lanjutan seperti pengaturan multi-scene, optimalisasi audio & video, serta penggunaan software streaming. Cocok untuk streamer yang ingin tampil lebih profesional dan meningkatkan kualitas konten.', 50000, 'course', '🖥️', '2026-04-12 13:59:59'),
(3, 'All-in-One Canva Template', 'Paket template lengkap untuk kebutuhan konten kreator dan streamer dalam satu produk. Berisi template thumbnail YouTube, post & story Instagram, hingga banner channel yang mudah diedit di Canva.', 70000, 'digital', '💫', '2026-04-14 18:48:50'),
(4, 'Streaming Overlay Pack', 'Paket overlay siap pakai untuk meningkatkan tampilan live streaming kamu. Berisi frame webcam, starting soon, ending screen, dan elemen visual lainnya yang mudah digunakan di software streaming.', 75000, 'digital', '🎛', '2026-04-14 18:51:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('customer','mitra') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'aurelia', 'aurel@gmail.com', 'aurel123', 'customer', '2026-04-12 09:01:08'),
(2, 'cavindra', 'cavindra@gmail.com', 'cavindra123', 'mitra', '2026-04-12 10:35:16'),
(3, 'aurelia', 'aurelia@gmail.com', 'aurelia123', 'customer', '2026-04-13 08:26:32'),
(4, 'andre', 'andre@gmail.com', 'andre123', 'mitra', '2026-04-14 08:49:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
