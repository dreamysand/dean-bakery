-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for kasir
CREATE DATABASE IF NOT EXISTS `kasir` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kasir`;

-- Dumping structure for table kasir.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gambar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Nonaktif',
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.admin: ~2 rows (approximately)
INSERT INTO `admin` (`id`, `email`, `username`, `password`, `gambar`, `status`, `last_login`) VALUES
	(13, 'gustav@gmail.com', 'gustav', '75f599ae37b1dc7df7d5bdfb4b6a07e5df38a49806f879e4', 'http://localhost\\dean-bakery\\admin\\assets\\admins\\680199c29afe8.jpg', 'Nonaktif', '2025-04-30 05:20:20'),
	(14, 'tenkaryo@gmail.com', 'Sut', '9ba5470c769ac22698b13e98120aa7778811318cfc84c13f', 'http://localhost\\dean-bakery\\admin\\assets\\admins\\68019ca2ab02a.jpg', 'Nonaktif', '2025-04-25 06:31:04');

-- Dumping structure for table kasir.detail_produk
CREATE TABLE IF NOT EXISTS `detail_produk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fid_produk` int NOT NULL,
  `varian` varchar(255) NOT NULL,
  `tanggal_expired` date NOT NULL,
  `stok` int NOT NULL,
  `terjual` int DEFAULT '0',
  `modal` int NOT NULL,
  `harga_jual` int NOT NULL,
  `keuntungan_per_produk` int NOT NULL,
  `gambar` longtext NOT NULL,
  `kode_bar` varchar(8) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK_detail_produk_produk` (`fid_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.detail_produk: ~6 rows (approximately)
INSERT INTO `detail_produk` (`id`, `fid_produk`, `varian`, `tanggal_expired`, `stok`, `terjual`, `modal`, `harga_jual`, `keuntungan_per_produk`, `gambar`, `kode_bar`) VALUES
	(1, 1, 'Original', '2025-04-24', 11, 1, 100000, 13000, 3000, 'http://localhost\\dean-bakery\\admin\\assets\\produk\\67d5a5779fc3e.jpg', '53811323'),
	(2, 1, 'Pandan', '2025-04-23', 10, 0, 100000, 13500, 3500, 'http://localhost\\dean-bakery\\admin\\assets\\produk\\6808f7fe32223.webp', '25557493'),
	(3, 5, 'Original', '2025-03-13', 10, 0, 180000, 20000, 2000, 'http://localhost\\dean-bakery\\admin\\assets\\produk\\67d301c9ce936.jpg', '24192101'),
	(4, 7, 'Coklat', '2025-05-01', 4, 13, 100000, 12000, 2000, 'http://localhost\\dean-bakery\\admin\\assets\\produk\\680b7d948cf1f.jpg', '67772831'),
	(5, 8, 'Ada', '2025-04-26', 20, 0, 100000, 12000, 7000, 'http://localhost\\dean-bakery\\admin\\assets\\produk\\680b7d4156cc3.jpg', '87410818'),
	(6, 9, 'Keju', '2025-04-26', 30, 0, 100000, 12000, 7000, 'http://localhost\\dean-bakery\\admin\\assets\\produk\\680b8241cd8ee.jpg', '27045732');

-- Dumping structure for table kasir.detail_transaksi
CREATE TABLE IF NOT EXISTS `detail_transaksi` (
  `id_detail_transaksi` int NOT NULL AUTO_INCREMENT,
  `fid_transaksi` int NOT NULL,
  `fid_detail_produk` int NOT NULL,
  `fid_member` int DEFAULT NULL,
  `total_produk` int NOT NULL,
  `subtotal` int NOT NULL,
  PRIMARY KEY (`id_detail_transaksi`),
  KEY `FK 3` (`fid_member`),
  KEY `FK 5` (`fid_transaksi`),
  KEY `FK 4` (`fid_detail_produk`) USING BTREE,
  CONSTRAINT `FK_detail_transaksi_detail_produk` FOREIGN KEY (`fid_detail_produk`) REFERENCES `detail_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_detail_transaksi_member` FOREIGN KEY (`fid_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_detail_transaksi_transaksi` FOREIGN KEY (`fid_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.detail_transaksi: ~31 rows (approximately)
INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `fid_transaksi`, `fid_detail_produk`, `fid_member`, `total_produk`, `subtotal`) VALUES
	(18, 13, 2, 1, 10, 120000),
	(19, 14, 3, 1, 1, 20000),
	(20, 15, 2, 1, 1, 12000),
	(21, 16, 2, 1, 2, 24000),
	(22, 17, 2, 1, 1, 12000),
	(23, 18, 3, 1, 3, 60000),
	(24, 19, 1, 1, 5, 60000),
	(25, 20, 1, 1, 2, 24000),
	(26, 20, 2, 1, 1, 12000),
	(27, 21, 1, 1, 2, 24000),
	(28, 21, 2, 1, 1, 12000),
	(30, 30, 2, 1, 2, 24000),
	(31, 31, 2, 1, 1, 12000),
	(32, 32, 2, 1, 1, 12000),
	(33, 33, 2, 1, 1, 12000),
	(34, 36, 2, NULL, 1, 12000),
	(35, 37, 4, NULL, 10, 60000),
	(36, 38, 4, NULL, 10, 60000),
	(37, 39, 4, NULL, 5, 30000),
	(38, 40, 4, NULL, 1, 6000),
	(39, 41, 4, NULL, 1, 6000),
	(40, 42, 4, NULL, 1, 6000),
	(41, 43, 4, NULL, 1, 6000),
	(42, 44, 4, NULL, 1, 6000),
	(43, 45, 4, NULL, 1, 6000),
	(44, 46, 4, NULL, 1, 6000),
	(50, 52, 4, 1, 1, 12000),
	(51, 53, 4, 1, 1, 12000),
	(52, 54, 4, 1, 1, 12000),
	(53, 55, 4, 4, 1, 12000),
	(54, 56, 4, 1, 1, 12000),
	(55, 57, 4, 1, 1, 12000);

-- Dumping structure for table kasir.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) NOT NULL,
  `gambar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_kategori`),
  UNIQUE KEY `kategori` (`kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.kategori: ~2 rows (approximately)
INSERT INTO `kategori` (`id_kategori`, `kategori`, `gambar`) VALUES
	(1, 'Roti Tawar', 'http://localhost\\dean-bakery\\admin\\assets\\kategori\\67c5ca5ac9f3c.jpg'),
	(6, 'Roti Manise', 'http://localhost\\dean-bakery\\admin\\assets\\kategori\\680b81973ad6d.jpeg');

-- Dumping structure for table kasir.laporan
CREATE TABLE IF NOT EXISTS `laporan` (
  `id_laporan` int NOT NULL,
  `total_penjualan` int NOT NULL,
  `total_modal` int NOT NULL,
  `total_keuntungan` int NOT NULL,
  `tanggal_laporan` date NOT NULL,
  PRIMARY KEY (`id_laporan`),
  UNIQUE KEY `tanggal_laporan` (`tanggal_laporan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.laporan: ~0 rows (approximately)

-- Dumping structure for table kasir.member
CREATE TABLE IF NOT EXISTS `member` (
  `id_member` int NOT NULL AUTO_INCREMENT,
  `nama_member` varchar(255) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `point` int NOT NULL DEFAULT '0',
  `status` enum('aktif','tidak aktif') NOT NULL DEFAULT 'tidak aktif',
  `last_transaction` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_member`),
  UNIQUE KEY `no_telp` (`no_telp`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.member: ~2 rows (approximately)
INSERT INTO `member` (`id_member`, `nama_member`, `no_telp`, `point`, `status`, `last_transaction`) VALUES
	(1, 'Budin', '08889037652', 33, 'aktif', '2025-04-30 05:22:24'),
	(4, 'Rudi', '0812456718', 1, 'aktif', '2025-04-28 22:36:02');

-- Dumping structure for table kasir.metode_pembayaran
CREATE TABLE IF NOT EXISTS `metode_pembayaran` (
  `id_metode_pembayaran` int NOT NULL AUTO_INCREMENT,
  `metode_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_metode_pembayaran`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.metode_pembayaran: ~1 rows (approximately)
INSERT INTO `metode_pembayaran` (`id_metode_pembayaran`, `metode_pembayaran`) VALUES
	(1, 'Tunai');

-- Dumping structure for table kasir.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) NOT NULL,
  `fid_kategori` int NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  PRIMARY KEY (`id_produk`),
  UNIQUE KEY `nama_produk` (`nama_produk`),
  KEY `FK 1` (`fid_kategori`),
  CONSTRAINT `FK_produk_kategori` FOREIGN KEY (`fid_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.produk: ~5 rows (approximately)
INSERT INTO `produk` (`id_produk`, `nama_produk`, `fid_kategori`, `deskripsi`) VALUES
	(1, 'Roti Tawar', 1, 'Roti tawar terenak di dunia'),
	(5, 'Roti Tawar L', 1, 'Roti tawar biasa dengan ukuran lebih besar.'),
	(7, 'Roti Coklat', 6, 'Coklat'),
	(8, 'Roti Ajalah', 6, 'Aja'),
	(9, 'Roti Keju', 6, 'Keju');

-- Dumping structure for table kasir.tokens
CREATE TABLE IF NOT EXISTS `tokens` (
  `id_token` int NOT NULL,
  `id_admin` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expired` datetime NOT NULL,
  PRIMARY KEY (`id_token`),
  KEY `FK_tokens_admin` (`id_admin`),
  CONSTRAINT `FK_tokens_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.tokens: ~0 rows (approximately)

-- Dumping structure for table kasir.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `kode_unik` varchar(50) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_harga` int NOT NULL,
  `fid_admin` int NOT NULL,
  `total_diskon` int NOT NULL DEFAULT '0',
  `total_bayar` int NOT NULL,
  `fid_metode_pembayaran` int NOT NULL,
  `total_kembalian` int NOT NULL,
  `total_keuntungan` int NOT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `FK 2` (`fid_admin`),
  KEY `FK 6` (`fid_metode_pembayaran`),
  CONSTRAINT `FK_transaksi_admin` FOREIGN KEY (`fid_admin`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_transaksi_metode_pembayaran` FOREIGN KEY (`fid_metode_pembayaran`) REFERENCES `metode_pembayaran` (`id_metode_pembayaran`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kasir.transaksi: ~27 rows (approximately)
INSERT INTO `transaksi` (`id_transaksi`, `kode_unik`, `tanggal_pembelian`, `total_harga`, `fid_admin`, `total_diskon`, `total_bayar`, `fid_metode_pembayaran`, `total_kembalian`, `total_keuntungan`) VALUES
	(13, '0b92e6da5b', '2025-04-18', 120000, 13, 0, 130000, 1, 10000, 20000),
	(14, '8900633f1d', '2025-04-18', 20000, 13, 0, 20000, 1, 0, 2000),
	(15, '1b8c25c0f2', '2025-04-18', 12000, 13, 0, 90000, 1, 78000, 2000),
	(16, '9a1d91b37b', '2025-04-18', 24000, 13, 0, 80000, 1, 56000, 4000),
	(17, 'ec71138bd2', '2025-04-18', 12000, 13, 0, 78900, 1, 66900, 2000),
	(18, 'f67866c2ac', '2025-04-18', 60000, 13, 0, 80000, 1, 20000, 6000),
	(19, '59178b5555', '2025-04-18', 60000, 13, 0, 90000, 1, 30000, 10000),
	(20, 'd7673172fe', '2025-04-19', 36000, 13, 0, 40000, 1, 4000, 6000),
	(21, 'b6ad87f571', '2025-04-19', 36000, 13, 0, 40000, 1, 4000, 6000),
	(30, '86b252ed6c', '2025-04-19', 23000, 13, 0, 25000, 1, 2000, 4000),
	(31, '82f5e0313f', '2025-04-19', 11000, 13, 0, 12000, 1, 1000, 2000),
	(32, '54ac616eb4', '2025-04-19', 11000, 13, 0, 18000, 1, 7000, 2000),
	(33, '088e894da1', '2025-04-19', 6000, 13, 0, 10000, 1, 4000, 2000),
	(34, '9de2dc90d5', '2025-04-23', 12000, 13, 0, 20000, 1, 8000, 2000),
	(35, '520373b2fa', '2025-04-23', 12000, 13, 0, 12000, 1, 0, 2000),
	(36, 'c4dbc0e9c3', '2025-04-23', 12000, 13, 0, 12000, 1, 0, 2000),
	(37, 'e073bdd62d', '2025-04-25', 60000, 13, 0, 90000, 1, 30000, 10000),
	(38, '30e6a59140', '2025-04-25', 60000, 13, 0, 90000, 1, 30000, 10000),
	(39, '17b87b0f33', '2025-04-25', 30000, 13, 0, 90000, 1, 60000, 5000),
	(40, 'c954838054', '2025-04-25', 6000, 13, 0, 7000, 1, 1000, 1000),
	(41, '1c54543570', '2025-04-25', 6000, 13, 0, 6000, 1, 0, 1000),
	(42, '4da47c92f5', '2025-04-25', 6000, 13, 0, 7000, 1, 1000, 1000),
	(43, '7f62223294', '2025-04-25', 6000, 13, 0, 9000, 1, 3000, 1000),
	(44, '972544e98d', '2025-04-25', 6000, 13, 0, 9000, 1, 3000, 1000),
	(45, 'df877a90f3', '2025-04-25', 6000, 13, 0, 9000, 1, 3000, 1000),
	(46, '69c6da4f41', '2025-04-25', 6000, 13, 0, 9000, 1, 3000, 1000),
	(47, '41afafaa62', '2025-04-25', 6000, 13, 0, 8000, 1, 2000, 1000),
	(48, 'dfccbd83e9', '2025-04-25', 6000, 13, 0, 8000, 1, 2000, 1000),
	(49, 'c5a2a8574d', '2025-04-25', 6000, 13, 0, 70000, 1, 64000, 1000),
	(50, 'c0620b977d', '2025-04-25', 13000, 13, 0, 14000, 1, 1000, 3000),
	(51, '3fa79b09f3', '2025-04-25', 11000, 13, 1000, 11000, 1, 0, 2000),
	(52, 'dad348e002', '2025-04-28', 12000, 13, 0, 90000, 1, 78000, 2000),
	(53, '2744d6f0e1', '2025-04-29', 9000, 13, 3000, 9000, 1, 0, 2000),
	(54, 'd2942125a2', '2025-04-29', 9000, 13, 3000, 9000, 1, 0, 2000),
	(55, '492233876d', '2025-04-29', 12000, 13, 0, 12000, 1, 0, 2000),
	(56, '297b42805b', '2025-04-29', 12000, 13, 0, 12000, 1, 0, 2000),
	(57, 'f39d7b7c1f', '2025-04-30', 12000, 13, 0, 12000, 1, 0, 2000);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
