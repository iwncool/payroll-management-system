-- ============================================
-- PAYROLL MANAGEMENT SYSTEM DATABASE
-- ============================================
-- Database: payroll_db
-- Version: 1.0
-- Created: 2026-09-26

CREATE DATABASE IF NOT EXISTS `payroll_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `payroll_db`;

-- ============================================
-- TABLE: users
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: employees
-- ============================================
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_bergabung` date NOT NULL,
  `departemen` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tunjangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fasilitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji` decimal(15,2) DEFAULT '0.00',
  `is_processed` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `nip_index` (`nip`),
  KEY `departemen_index` (`departemen`),
  KEY `is_processed_index` (`is_processed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATA DEFAULT
-- ============================================
INSERT INTO `users` (`username`, `password_hash`) VALUES
('admin', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/KFm')
ON DUPLICATE KEY UPDATE `password_hash` = VALUES(`password_hash`);

INSERT INTO `employees` (`nip`, `nama`, `tanggal_bergabung`, `departemen`, `jabatan`, `tunjangan`, `fasilitas`, `gaji`, `is_processed`) VALUES
('EMP001', 'Budi Santoso', '2024-01-15', 'IT', 'Senior Developer', 'Tunjangan Kesehatan, Tunjangan Makan', 'Laptop, Monitor', 8500000.00, 1),
('EMP002', 'Siti Nurhaliza', '2024-02-20', 'Finance', 'Finance Manager', 'Tunjangan Kesehatan, Tunjangan Transportasi', 'Mobil Dinas', 7500000.00, 1),
('EMP003', 'Ahmad Wijaya', '2024-03-10', 'HR', 'HR Specialist', 'Tunjangan Kesehatan', 'Laptop', 5000000.00, 1),
('EMP004', 'Dewi Lestari', '2024-04-05', 'IT', 'Junior Developer', 'Tunjangan Kesehatan, Tunjangan Makan', 'Laptop', 4500000.00, 0),
('EMP005', 'Roni Hermawan', '2024-05-12', 'Operations', 'Operations Manager', 'Tunjangan Kesehatan, Tunjangan Makan', 'Mobil Dinas', 6500000.00, 0)
ON DUPLICATE KEY UPDATE
  `nama` = VALUES(`nama`),
  `tanggal_bergabung` = VALUES(`tanggal_bergabung`),
  `departemen` = VALUES(`departemen`),
  `jabatan` = VALUES(`jabatan`),
  `tunjangan` = VALUES(`tunjangan`),
  `fasilitas` = VALUES(`fasilitas`),
  `gaji` = VALUES(`gaji`),
  `is_processed` = VALUES(`is_processed`);

-- ============================================
-- END
-- ============================================
