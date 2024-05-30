-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 10:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ninja`
--

-- --------------------------------------------------------

--
-- Table structure for table `kamui`
--

CREATE TABLE `kamui` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `kutipan` text NOT NULL,
  `isi` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kamui`
--

INSERT INTO `kamui` (`id`, `judul`, `kategori`, `kutipan`, `isi`, `file_path`, `file_type`, `created_at`) VALUES
(1, 'KTP Muhammad Rizky Kurniawan', 'Sosial', '', 'KTP Untuk MSIB', 'uploads/Ktp.pdf', 'pdf', '2024-05-28 07:29:51'),
(2, 'Hasil Kuesioner Terhadap Umpan Balik Para Pengguna Aplikasi Dana di Universitas Prabumulih', 'Teknologi', '', 'Hasil Kuesioner', 'uploads/KUESIONERVALEN.csv', 'csv', '2024-05-28 07:34:46'),
(3, 'Tugas 9 Matkul Sistem Informasi', 'Teknologi', '', 'Lampiran Tugas dari Andra Vieri Goeslisainah', 'uploads/Andra Vieri Goeslisainnah_5MIC_Tugas 9_Sistem Informasi Industri.pdf', 'pdf', '2024-05-29 06:17:29'),
(4, 'Populasi Ternak Menurut Kecamatan dan Jenis Ternak di Kota Prabumulih Pada Tahun 2022', 'Peternakan', '', 'Data dari Dinas Pertanian Kota Prabumulih', 'uploads/1-3.jpg', 'jpg', '2024-05-29 06:28:14'),
(5, 'Populasi Unggas Menurut Kecamatan dan Jenis Unggas di Kota Prabumulih Pada Tahun 2022', 'Peternakan', '', 'Data dari Dinas Pertanian Kota Prabumulih', 'uploads/2-4.jpg', 'jpg', '2024-05-29 06:33:53'),
(6, 'Curah Hujan Di PT Dizamatra', 'Teknologi', '', 'Data Curah Hujan per April 2024 ', 'uploads/d36bb686-6cca-4a29-82b0-f9be8bf83f1c.xlsx', 'xlsx', '2024-05-29 06:44:14'),
(7, 'Gunfire on School Grounds in the United States', 'Pendidikan', '', 'Data jumlah penembakan yang terjadi di Sekolah Amerika Serikat', 'uploads/everytownresearch-gunfire-on-school-grounds.csv', 'csv', '2024-05-29 08:08:29'),
(8, 'Jumlah Kasus Covid di Tiap Provinsi ', 'Kesehatan', '', 'Data Kasus Covid 19 di Provinsi Indonesia', 'uploads/case-by-provinces-idn-covid19-1.csv', 'csv', '2024-05-29 08:18:22'),
(9, 'Epic 7 New Limited Support Unit', 'Teknologi', '', 'Luluca Summer BREEZE', 'uploads/luluca.jpg', 'jpg', '2024-05-30 07:10:45'),
(10, 'Data Covid di Indonesia', 'Kesehatan', '', 'Data COVID 19 di Indonesia', 'uploads/daily-update-idn-covid19-2.csv', 'csv', '2024-05-30 07:24:40'),
(11, 'Tugas Materi Destructor', 'Teknologi', '', 'Muhammmad Rizky Kurniawan', 'uploads/Destructor_3MIC_M Rizky Kurniawan.pdf', 'pdf', '2024-05-30 07:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$rOSluZ0265N9Y26e2.XLMOvUALkl1QonoXaNKH.OXQ7S.s4gYtGeu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kamui`
--
ALTER TABLE `kamui`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kamui`
--
ALTER TABLE `kamui`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
