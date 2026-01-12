-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2025 at 09:09 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_alfurqon`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id_artikel` int NOT NULL,
  `judul` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `konten` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori` enum('berita','tips','resep','promo') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'berita',
  `status` enum('draft','published') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id_artikel`, `judul`, `slug`, `konten`, `gambar`, `kategori`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tes Artikel', 'tes-artikel', 'Isi konten', 'artikel_69456b09c7b4d.jpg', 'tips', 'published', '2025-12-19 22:06:00', '2025-12-19 22:11:05');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id_gallery` int NOT NULL,
  `judul` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('aktif','nonaktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'aktif',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('aktif','nonaktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int NOT NULL,
  `nama_menu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` enum('makanan','minuman','aneka jajanan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'makanan',
  `harga` int NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_terjual` int NOT NULL DEFAULT '0',
  `status` enum('tersedia','habis') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `kategori`, `harga`, `deskripsi`, `gambar`, `jumlah_terjual`, `status`) VALUES
(7, 'Soto Ayam', 'makanan', 15000, 'Soto ayam mantul', '6945716f175db.jpg', 0, 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int NOT NULL,
  `nomor_pesanan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pelanggan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_telepon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'Catatan khusus untuk pesanan',
  `tanggal_order` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_harga` int NOT NULL,
  `status_order` enum('diproses','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id_detail` int NOT NULL,
  `id_order` int NOT NULL,
  `id_menu` int NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id_payment` int NOT NULL,
  `id_order` int NOT NULL,
  `metode` enum('tunai','qris') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_bayar` enum('belum','lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'belum',
  `qris_string` text COLLATE utf8mb4_general_ci,
  `qris_expired` datetime DEFAULT NULL,
  `pakasir_fee` int DEFAULT NULL,
  `pakasir_total` int DEFAULT NULL,
  `waktu_bayar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_pengaturan` int NOT NULL,
  `key_pengaturan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value_pengaturan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id_pengaturan`, `key_pengaturan`, `value_pengaturan`, `deskripsi`, `updated_at`) VALUES
(1, 'sejarah', 'Dapur Al-Furqon didirikan dengan semangat untuk menyajikan hidangan berkualitas dengan cita rasa otentik yang memanjakan lidah. Berawal dari dapur kecil pada tahun 2020, kami terus berkembang berkat dukungan pelanggan setia.\r\n\r\nNama \"Al-Furqon\" yang berarti \"pembeda\" menjadi filosofi kami dalam menyajikan makanan yang berbeda dari yang lain - dengan bahan pilihan, resep istimewa, dan pelayanan sepenuh hati.\r\n\r\nKini, Dapur Al-Furqon telah menjadi destinasi kuliner favorit bagi keluarga dan komunitas yang mengutamakan kualitas dan kebersihan dalam setiap hidangan.', 'Sejarah perusahaan', '2025-12-19 22:27:01'),
(2, 'visi', 'Menjadi rumah makan terdepan yang menyajikan hidangan berkualitas tinggi dengan sentuhan tradisional dan modern, serta menjadi pilihan utama masyarakat dalam memenuhi kebutuhan kuliner.', 'Visi perusahaan', '2025-12-19 22:22:44'),
(3, 'misi', 'Menyajikan makanan dengan bahan-bahan segar dan berkualitas\r\nMenjaga standar kebersihan dan kehigienisan tertinggi\r\nMemberikan pelayanan terbaik dengan keramahan\r\nTerus berinovasi dalam menu dan rasa\r\nMenciptakan suasana yang nyaman untuk pelanggan', 'Misi perusahaan (pisahkan dengan enter)', '2025-12-19 22:27:01'),
(4, 'jam_senin_jumat', '08:00 - 21:00', 'Jam operasional Senin-Jumat', '2025-12-19 22:22:44'),
(5, 'jam_sabtu', '09:00 - 22:00', 'Jam operasional Sabtu', '2025-12-19 22:22:44'),
(6, 'jam_minggu', '10:00 - 20:00', 'Jam operasional Minggu', '2025-12-19 22:22:44'),
(7, 'alamat', 'Jl. Contoh Alamat No. 123\r\nKota, Provinsi 12345', 'Alamat lengkap perusahaan', '2025-12-19 22:27:01'),
(8, 'telepon', '+62 812-3456-7890', 'Nomor telepon', '2025-12-19 22:22:44'),
(9, 'email', 'info@dapuralfurqon.com', 'Email perusahaan', '2025-12-19 22:22:44'),
(10, 'whatsapp', '6281234567890', 'Nomor WhatsApp (format internasional tanpa +)', '2025-12-19 22:22:44'),
(11, 'whatsapp_display', '+62 812-3456-7890', 'Nomor WhatsApp untuk ditampilkan', '2025-12-19 22:22:44'),
(12, 'pakasir_project', 'dapur-al-furqon', NULL, '2025-12-20 04:05:08'),
(13, 'pakasir_api_key', 'mQt6jshUwiQUEQAanUb9u21ByTb3nGCG', NULL, '2025-12-20 04:06:52');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE `testimoni` (
  `id_testimoni` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rating` tinyint NOT NULL DEFAULT '5' COMMENT '1-5 stars',
  `pesan` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `tanggal_kirim` datetime DEFAULT CURRENT_TIMESTAMP,
  `tanggal_review` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`id_testimoni`, `nama`, `email`, `rating`, `pesan`, `status`, `tanggal_kirim`, `tanggal_review`) VALUES
(1, 'Ahmad Fauzi', 'ahmad@email.com', 5, 'Makanannya enak banget! Pelayanan juga ramah. Pasti balik lagi!', 'approved', '2025-12-15 03:53:18', NULL),
(2, 'Siti Nurhaliza', 'siti@email.com', 5, 'Tempatnya nyaman, harga terjangkau, dan rasanya mantap. Recommended!', 'approved', '2025-12-17 03:53:18', NULL),
(3, 'Budi Santoso', 'budi@email.com', 4, 'Menu variatif dan porsinya pas. Cuma parkir agak susah.', 'approved', '2025-12-18 03:53:18', NULL),
(4, 'Dewi Lestari', NULL, 5, 'Sudah langganan dari dulu. Kualitas selalu terjaga!', 'approved', '2025-12-19 03:53:18', NULL),
(5, 'Rudi Hermawan', 'rudi@email.com', 4, 'Enak sih, tapi antrinya agak lama pas weekend.', 'rejected', '2025-12-20 03:53:18', '2025-12-20 04:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', '$2y$10$Qgx.w3jy.07lKGBR/WHFee2pKIno6aH1XGSmABB5XqfNxor6lvxGC', 'Administrator', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id_artikel`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id_gallery`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `idx_nomor_pesanan` (`nomor_pesanan`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id_payment`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `idx_status_bayar` (`status_bayar`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`),
  ADD UNIQUE KEY `key_pengaturan` (`key_pengaturan`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id_testimoni`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_tanggal` (`tanggal_kirim`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id_artikel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id_gallery` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id_payment` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id_pengaturan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id_testimoni` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
