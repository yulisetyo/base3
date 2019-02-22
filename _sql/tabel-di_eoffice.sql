-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.30-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table pbn_user.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table pbn_user.migrations: ~2 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(2, '2014_10_12_100000_create_password_resets_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table pbn_user.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table pbn_user.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table pbn_user.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `username` varchar(18) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kdunit` varchar(20) NOT NULL,
  `eselon` varchar(2) NOT NULL,
  `kdlevel` varchar(2) NOT NULL,
  `aktif` enum('y','n') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nip_unique` (`nip`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table pbn_user.users: ~21 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Yuli Setyo Budi', '198307032002121006', 'yuli', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080104', '99', '30', 'y', NULL, '2019-02-08 09:57:30', '2019-02-08 09:57:30');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(2, 'Eko Firmansyah', '198607012006021003', 'eko', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080104', '77', '30', 'y', NULL, '2019-02-08 09:57:54', '2019-02-08 09:57:54');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(3, 'Siswanto', '197005121990121001', 'siswanto', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '112110150500801', '31', '30', 'y', NULL, '2019-02-13 09:50:03', '2019-02-13 09:50:03');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(4, 'Alwi', '196405061985031004', 'alwi', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080104', '41', '30', 'y', NULL, '2019-02-13 09:50:47', '2019-02-13 09:50:47');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(5, 'Sudarto', '196904091989121001', 'sudarto', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '1121101505008', '21', '30', 'y', NULL, '2019-02-13 09:51:22', '2019-02-13 09:51:22');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(6, 'Surtinah', '196010201982032001', 'surtinah', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '112110150500801', '99', '20', 'y', NULL, '2019-02-13 09:52:07', '2019-02-13 09:52:07');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(7, 'Novie Shol Abdillah', '198311102003121002', 'novie', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '1121101505008', '99', '20', 'y', NULL, '2019-02-13 09:52:56', '2019-02-13 09:52:56');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(8, 'Tri Septiarini', '198909032010122001', 'oyin', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '1121101505008', '99', '20', 'y', NULL, '2019-02-13 09:53:30', '2019-02-13 09:53:30');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(9, 'Andy Haholongan', '198304222004121001', 'ahong', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080104', '99', '30', 'y', NULL, '2019-02-13 09:54:31', '2019-02-13 09:54:31');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(10, 'Hendi Hendaris', '198308202002121002', 'bendot', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080105', '99', '30', 'y', NULL, '2019-02-13 09:56:04', '2019-02-13 09:56:04');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(11, 'Agastya Vitadhani', '198508142007101001', 'agas', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080102', '77', '30', 'y', NULL, '2019-02-13 09:56:51', '2019-02-13 09:56:51');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(12, 'Yohanes Probo Satrio', '197901122002121001', 'rio', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080105', '41', '30', 'y', NULL, '2019-02-13 09:57:58', '2019-02-13 09:57:58');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(13, 'Hanafi Firdaus', '198311032004121002', 'hanafi', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080102', '41', '30', 'y', NULL, '2019-02-13 09:59:06', '2019-02-13 09:59:06');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(14, 'Umar Jati', '198004092001121001', 'uje', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080102', '77', '30', 'y', NULL, '2019-02-13 10:01:42', '2019-02-13 10:01:42');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(15, 'M. Syaifuddin Lutfi', '197503211995021001', 'lutfi', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080103', '41', '30', 'y', NULL, '2019-02-13 10:02:33', '2019-02-13 10:02:33');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(16, 'Vina Eriyandi', '198505312006021002', 'vina', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080103', '77', '30', 'y', NULL, '2019-02-13 10:23:56', '2019-02-13 10:23:56');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(17, 'Ghitha Afifah Hurin', '199301262014112001', 'ghitha', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080103', '99', '30', 'y', NULL, '2019-02-13 10:25:08', '2019-02-13 10:25:08');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(18, 'Johan Muslim', '198208302001121002', 'johan', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080103', '77', '30', 'y', NULL, '2019-02-13 10:26:00', '2019-02-13 10:26:00');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(19, 'Muhammad Husni Thamrin', '198310132002121004', 'thamrin', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080104', '77', '30', 'y', NULL, '2019-02-13 10:27:01', '2019-02-13 10:27:01');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(20, 'Jananto Sigit Widodo', '198201152002121001', 'sigit', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080104', '99', '30', 'y', NULL, '2019-02-13 10:27:31', '2019-02-13 10:27:31');
INSERT INTO `users` (`id`, `name`, `nip`, `username`, `password`, `kdunit`, `eselon`, `kdlevel`, `aktif`, `remember_token`, `created_at`, `updated_at`) VALUES
	(21, 'Rifan Abdul Rachman', '198109252002121003', 'rifan', '$2y$10$lXCOmDXnYl0UPYhS9cg78eAcCLs1UHgCL1IqrgFfNhtGd13BGzR7u', '11211015050080105', '77', '30', 'y', NULL, '2019-02-13 10:35:31', '2019-02-13 10:35:31');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table pbn_user.user_menus
DROP TABLE IF EXISTS `user_menus`;
CREATE TABLE IF NOT EXISTS `user_menus` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `link_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category` tinyint(1) unsigned NOT NULL,
  `have_child` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `parent_id` smallint(3) unsigned NOT NULL,
  `sequence` tinyint(2) NOT NULL DEFAULT '1',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `granted_role` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '+00+',
  `icon_fa` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table pbn_user.user_menus: ~8 rows (approximately)
DELETE FROM `user_menus`;
/*!40000 ALTER TABLE `user_menus` DISABLE KEYS */;
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(1, 'Beranda', 'home', 1, 0, 0, 1, 0, '+00+', 'glyphichon glyphicon-dashboard', '2019-02-12 14:10:24', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(2, 'Dokumen', '#', 1, 1, 0, 2, 1, '+00+', 'glyphicon glyphicon-folder-open', '2019-02-12 14:49:28', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(3, 'Surat Masuk', '#', 2, 1, 2, 1, 1, '+00+', 'glyphicon glyphicon-record', '2019-02-12 14:37:03', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(4, 'Semua Surat', 'surat-masuk', 3, 0, 3, 1, 1, '+00+', 'glyphicon glyphicon-asterisk', '2019-02-14 14:54:01', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(5, 'Non Undangan', '#', 3, 0, 3, 2, 1, '+00+', 'glyphicon glyphicon-asterisk', '2019-02-15 09:38:12', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(6, 'Undangan', '#', 3, 0, 3, 3, 1, '+00+', 'glyphicon glyphicon-asterisk', '2019-02-15 09:38:08', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(7, 'Agenda Rapat', '#', 3, 0, 3, 4, 1, '+00+', 'glyphicon glyphicon-asterisk', '2019-02-15 09:38:11', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(8, 'Referensi', '#', 1, 1, 0, 99, 1, '+00+', 'glyphicon glyphicon-book', '2019-02-13 15:54:30', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(9, 'User', 'ref/user', 2, 0, 8, 1, 1, '+00+', 'glyphicon glyphicon-record', '2019-02-15 09:16:43', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(10, 'Unit', 'ref/unit', 2, 0, 8, 2, 1, '+00+', 'glyphicon glyphicon-record', '2019-02-15 09:16:46', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(11, 'Sekretaris', 'ref/sekre', 2, 0, 8, 3, 1, '+00+', 'glyphicon glyphicon-record', '2019-02-15 09:16:49', '0000-00-00 00:00:00');
INSERT INTO `user_menus` (`id`, `title`, `link_url`, `category`, `have_child`, `parent_id`, `sequence`, `active`, `granted_role`, `icon_fa`, `created_at`, `updated_at`) VALUES
	(12, 'Plt./Plh.', 'ref/plt', 2, 0, 8, 4, 1, '+00+', 'glyphicon glyphicon-record', '2019-02-15 09:16:53', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user_menus` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
