-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2021 at 09:28 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adminity-ci-bgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `id` varchar(5) NOT NULL,
  `name` varchar(25) NOT NULL,
  `code_name` varchar(4) NOT NULL,
  `profit_center` varchar(10) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_branch`
--

INSERT INTO `tbl_branch` (`id`, `name`, `code_name`, `profit_center`, `alamat`, `telp`, `fax`, `email`) VALUES
('1000', 'Kantor Pusat', 'KP', 'KP01000', 'Jalan Kali Besar Timur No. 5-7 Jakarta', '+62.21.6916666', '+62.21.6903162', 'info@bgrindonesia.co.id'),
('1001', 'Medan', 'MDN', 'RG11001', 'Jl. Titi Pahlawan Medan Marelan, Medan - Sumatera Utara', '+62 61 6850555', '+62 61 6850444', 'ridhopahlawantobing@gmail.com'),
('1002', 'Dumai', 'DMI', 'RG11002', 'Jl. Anggur No. 2, Rimba Sekampung, Dumai, Riau', '+62 765 38828, 38878', '+62 765 38006', 'bgr_riau@yahoo.co.id'),
('1003', 'Padang', 'PDG', 'RG11003', 'Jl. Raya By Pass Km 6, Papak Kaluwek RT 02/03 Kelurahan Pisang - Kecamatan Pauh, Padang - Sumatera Barat', '+62 751 775977', '+62 751 775945', 'wulandari.ekasri@yahoo.co.id'),
('1004', 'Palembang', 'PLB', 'RG21004', 'Jl. R.E. Martadinata Sei Buah, Palembang – Sumatera Selatan', '+62 711 713794', '+62 711 713883', 'finance.plb@bgrlogistics.id'),
('1005', 'Bangka Belitung', 'BBL', 'RG21005', 'Jl. Ketapang Raya No. 77 RT.01 RW.01 Kelurahan Temberan, Kecamatan Bukit Intan, Kota Pangkalpinang 331147', '+62 717 9100716', '+62 717 9100716', 'deby.pratiwi@bgrlogistics.id'),
('1006', 'Lampung', 'LPG', 'RG31006', 'Jl. Soekarno Hatta Km 11, Srengsem, Panjang-Bandar Lampung', '+62 721 252064', '+62 721 266666', 'suwarno@bgrlogistics.id'),
('1007', 'DKI Jakarta', 'DKI', 'RG41007', 'Jl. Boulevard BGR No. 1, Perintis Kemerdekaan Kelapa Gading Barat – Jakarta Utara', '+62 21 452 5555, 4584808 – 30', '+62 21 45848036', 'finance.dki@bgrindonesia.co.id'),
('1008', 'Bandung', 'BDG', 'BR11008', 'Jl. Soekarno Hatta No. 503B Bandung – Jawa Barat', '+62 22 731 5878, 731 5595', '+62 22 7315580', 'bgrbdg.atkeu@gmail.com'),
('1009', 'Semarang', 'SMG', 'RG51009', 'Jl. Dr. Wahidin No. 85, Semarang 50253', '+62 24 8444183', '+62 24 8316901', 'oliviarzbgrsmg@gmail.com'),
('1010', 'Surabaya', 'SBY', 'RG61010', 'Jl. Teluk Kumai Barat 104, Surabaya – Jawa Timur', '+62 31 329 3714, 329 3869', '+62 31 329 4070', 'kikikholik24@gmail.com'),
('1011', 'Denpasar', 'DPS', 'RG71011', 'Jl. By Pass I Gusti Ngurah Rai Br. Kelan Tuban, Kuta Denpasar - Bali', '+62 361 705 421', '+62 361 701 482', 'bachtiar.firdaus@bgrlogistics.id'),
('1012', 'Kupang', 'KPG', 'RG71012', 'Jl. Sam Ratulangi No. 35 B, Kel. Oesapa, Kec. Kelapa Lima, Kota Kupang, Nusa Tenggara Timur, Kode Pos 85228', '+62 380 832241', '+62 380 824545', 'ranibgrkpg17@gmail.com'),
('1013', 'Mataram', 'MTR', 'RG71013', 'Jl. Panjitilar No. 116 Mataram - Nusa Tenggara Barat', '+62 370 623781', '+62 370 637390', 'ulik.farisca@bgrlogistics.id'),
('1014', 'Makassar', 'MKS', 'RG81014', 'Jl. Hertasning Komp. Palm Mas No. 7 Makassar – Sulawesi Selatan', '+62 411 435 221', '+62 411 447 582', 'maghfur.adiyanto@bgrlogistics.id'),
('1015', 'Palu', 'PL', 'RG81015', 'Jl. Dr. Suharso No. 38 Palu - Sulawesi Tengah', '+62 451 423032', '+62 451 455043', 'maghfura@gmail.com'),
('1016', 'Bitung', 'BTG', 'RG81016', 'Jl. S.H. Sarundajang, Kel. Girian Weru II, Kota Bitung - Sulawesi Utara', '+62 438 2230393', '+62 438 2230393', 'meidy.kairupan@bgrlogistics.id'),
('1017', 'Pontianak', 'PTN', 'BR21017', 'Jl. Tanjung Raya II No. AA2, Pontianak - Kalimantan Barat', '+62 561 575961', '+62 561 575961', 'sudirdja@bgrlogistics.id'),
('1018', 'Balikpapan', 'BLP', 'BR31018', 'Jl.MT. Haryono Komp. Ruko Balikpapan Baru Block A2/2, Balikpapan - Kalimantan Timur', '+62 542 877422', '+62 542 872645', 'dewi.purnama@bgrlogistics.id'),
('1019', 'Banjarmasin', 'BJM', 'BR41019', 'Jl. Pembangunan I No. 3 Banjarmasin - Kalimantan Selatan', '+62 5114424535', '+62 5114424535', 'junisa.adilia@bgrlogistics.id'),
('1020', 'Sorong', 'SRG', 'RG81020', 'Komp. Harapan Indah, Jl. Flamboyan Gg. Flamboyan 2 RT 02/09 Kel. Klowuyuk Km. 10.5 Sorong - West Papua', '+62 951 326089', '+62 951 329944', 'bgrsorong@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log_login`
--

CREATE TABLE `tbl_log_login` (
  `id` int(11) NOT NULL,
  `captcha` varchar(6) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `company_id` varchar(30) NOT NULL,
  `login_at` datetime NOT NULL,
  `logout_at` datetime NOT NULL,
  `browser` varchar(30) NOT NULL,
  `platform` varchar(30) NOT NULL,
  `ip` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_log_login`
--

INSERT INTO `tbl_log_login` (`id`, `captcha`, `user_id`, `company_id`, `login_at`, `logout_at`, `browser`, `platform`, `ip`) VALUES
(1, 'LXTZV', '90009000', '', '2021-05-10 14:22:18', '0000-00-00 00:00:00', 'Chrome 90.0.4430.93', 'Windows 10', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

CREATE TABLE `tbl_menus` (
  `id_menu` int(11) NOT NULL,
  `label` varchar(200) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(100) NOT NULL DEFAULT 'feather icon-list',
  `have_crud` tinyint(1) NOT NULL DEFAULT 0,
  `parent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_head_section` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_menus`
--

INSERT INTO `tbl_menus` (`id_menu`, `label`, `link`, `icon`, `have_crud`, `parent`, `is_head_section`, `sort`, `created_at`) VALUES
(105, 'Navigation', '', 'feather icon-list', 0, 0, 1, 1, '2019-01-25 22:48:56'),
(106, 'Dashboard', 'dashboard', 'feather icon-home', 0, 105, 0, 2, '2019-01-25 22:49:13'),
(107, 'System', '', 'feather icon-list', 0, 0, 1, 4, '2019-01-25 22:49:56'),
(108, 'Menu', 'menu', 'feather icon-list', 1, 107, 0, 5, '2019-01-25 22:50:50'),
(109, 'User', '', 'feather icon-users', 0, 0, 1, 8, '2019-01-25 22:51:11'),
(110, 'User Data', 'user', 'feather icon-users', 1, 109, 0, 11, '2019-01-25 22:51:38'),
(111, 'User Role', 'user_role', 'feather icon-clipboard', 0, 109, 0, 9, '2019-01-25 22:52:26'),
(112, 'User Status', 'user_status', 'feather icon-check-circle', 1, 109, 0, 10, '2019-01-25 22:52:47'),
(139, 'Notifikasi', 'notifikasi', 'feather icon-bell', 0, 105, 0, 3, '2019-09-10 14:01:12'),
(154, 'Divre', '', 'fa fa-university', 0, 107, 0, 6, '2019-09-18 09:29:42'),
(155, 'Divre', 'divre', 'feather icon-list', 1, 154, 127, 7, '2019-09-18 09:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_privileges`
--

CREATE TABLE `tbl_menu_privileges` (
  `id` int(11) NOT NULL,
  `id_usr_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `act_create` tinyint(1) NOT NULL DEFAULT 0,
  `act_update` tinyint(1) NOT NULL DEFAULT 0,
  `act_delete` tinyint(1) NOT NULL DEFAULT 0,
  `act_hard_delete` tinyint(1) NOT NULL DEFAULT 0,
  `act_detail` tinyint(1) NOT NULL DEFAULT 0,
  `filter_by_area` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_menu_privileges`
--

INSERT INTO `tbl_menu_privileges` (`id`, `id_usr_role`, `id_menu`, `act_create`, `act_update`, `act_delete`, `act_hard_delete`, `act_detail`, `filter_by_area`, `created_at`, `updated_at`) VALUES
(3183, 2, 105, 0, 0, 0, 0, 0, 0, '2020-01-13 08:37:24', '0000-00-00 00:00:00'),
(3188, 2, 106, 0, 0, 0, 0, 0, 0, '2020-01-13 08:37:24', '0000-00-00 00:00:00'),
(3189, 2, 139, 0, 0, 0, 0, 0, 0, '2020-01-13 08:37:24', '0000-00-00 00:00:00'),
(5965, 5, 105, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:18', '0000-00-00 00:00:00'),
(5976, 5, 106, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:18', '0000-00-00 00:00:00'),
(5977, 5, 139, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:18', '0000-00-00 00:00:00'),
(6003, 7, 105, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:40', '0000-00-00 00:00:00'),
(6014, 7, 106, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:40', '0000-00-00 00:00:00'),
(6015, 7, 139, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:40', '0000-00-00 00:00:00'),
(6025, 8, 105, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:50', '0000-00-00 00:00:00'),
(6032, 8, 106, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:50', '0000-00-00 00:00:00'),
(6033, 8, 139, 0, 0, 0, 0, 0, 0, '2020-07-13 07:32:50', '0000-00-00 00:00:00'),
(6110, 11, 105, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:19', '0000-00-00 00:00:00'),
(6119, 11, 106, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:19', '0000-00-00 00:00:00'),
(6120, 11, 139, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:19', '0000-00-00 00:00:00'),
(6129, 12, 105, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:31', '0000-00-00 00:00:00'),
(6138, 12, 106, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:31', '0000-00-00 00:00:00'),
(6139, 12, 139, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:31', '0000-00-00 00:00:00'),
(6148, 13, 105, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:45', '0000-00-00 00:00:00'),
(6155, 13, 106, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:45', '0000-00-00 00:00:00'),
(6156, 13, 139, 0, 0, 0, 0, 0, 0, '2020-07-13 07:33:45', '0000-00-00 00:00:00'),
(6179, 15, 105, 0, 0, 0, 0, 0, 0, '2020-07-13 07:34:00', '0000-00-00 00:00:00'),
(6182, 15, 106, 0, 0, 0, 0, 0, 0, '2020-07-13 07:34:00', '0000-00-00 00:00:00'),
(6183, 15, 139, 0, 0, 0, 0, 0, 0, '2020-07-13 07:34:00', '0000-00-00 00:00:00'),
(6213, 18, 105, 0, 0, 0, 0, 0, 0, '2020-07-13 07:34:23', '0000-00-00 00:00:00'),
(6217, 18, 106, 0, 0, 0, 0, 0, 0, '2020-07-13 07:34:23', '0000-00-00 00:00:00'),
(6218, 18, 139, 0, 0, 0, 0, 0, 0, '2020-07-13 07:34:23', '0000-00-00 00:00:00'),
(6719, 14, 105, 0, 0, 0, 0, 0, 0, '2020-08-14 02:31:35', '0000-00-00 00:00:00'),
(6722, 14, 106, 0, 0, 0, 0, 0, 0, '2020-08-14 02:31:35', '0000-00-00 00:00:00'),
(6723, 14, 139, 0, 0, 0, 0, 0, 0, '2020-08-14 02:31:35', '0000-00-00 00:00:00'),
(6743, 23, 105, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:00', '0000-00-00 00:00:00'),
(6747, 23, 106, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:00', '0000-00-00 00:00:00'),
(6748, 23, 139, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:00', '0000-00-00 00:00:00'),
(6761, 22, 105, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:15', '0000-00-00 00:00:00'),
(6768, 22, 106, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:15', '0000-00-00 00:00:00'),
(6769, 22, 139, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:15', '0000-00-00 00:00:00'),
(6779, 24, 105, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:53', '0000-00-00 00:00:00'),
(6780, 24, 106, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:53', '0000-00-00 00:00:00'),
(6782, 24, 139, 0, 0, 0, 0, 0, 0, '2020-08-14 16:34:53', '0000-00-00 00:00:00'),
(6797, 25, 105, 0, 0, 0, 0, 0, 0, '2020-08-14 16:35:54', '0000-00-00 00:00:00'),
(6798, 25, 106, 0, 0, 0, 0, 0, 0, '2020-08-14 16:35:54', '0000-00-00 00:00:00'),
(6799, 25, 139, 0, 0, 0, 0, 0, 0, '2020-08-14 16:35:54', '0000-00-00 00:00:00'),
(6890, 16, 105, 0, 0, 0, 0, 0, 0, '2020-10-02 08:17:36', '0000-00-00 00:00:00'),
(6897, 16, 106, 0, 0, 0, 0, 0, 0, '2020-10-02 08:17:36', '0000-00-00 00:00:00'),
(6898, 16, 139, 0, 0, 0, 0, 0, 0, '2020-10-02 08:17:36', '0000-00-00 00:00:00'),
(7294, 27, 105, 0, 0, 0, 0, 0, 0, '2020-12-19 18:20:53', '0000-00-00 00:00:00'),
(7295, 27, 106, 0, 0, 0, 0, 0, 0, '2020-12-19 18:20:53', '0000-00-00 00:00:00'),
(7296, 27, 109, 0, 0, 0, 0, 0, 0, '2020-12-19 18:20:53', '0000-00-00 00:00:00'),
(7297, 27, 110, 0, 0, 0, 0, 0, 0, '2020-12-19 18:20:53', '0000-00-00 00:00:00'),
(7304, 27, 139, 0, 0, 0, 0, 0, 0, '2020-12-19 18:20:53', '0000-00-00 00:00:00'),
(7542, 26, 105, 0, 0, 0, 0, 0, 0, '2021-02-08 03:31:44', '0000-00-00 00:00:00'),
(7546, 26, 106, 0, 0, 0, 0, 0, 0, '2021-02-08 03:31:44', '0000-00-00 00:00:00'),
(7547, 26, 139, 0, 0, 0, 0, 0, 0, '2021-02-08 03:31:44', '0000-00-00 00:00:00'),
(7588, 21, 105, 0, 0, 0, 0, 0, 0, '2021-02-09 02:35:03', '0000-00-00 00:00:00'),
(7603, 21, 106, 0, 0, 0, 0, 0, 0, '2021-02-09 02:35:03', '0000-00-00 00:00:00'),
(7604, 21, 139, 0, 0, 0, 0, 0, 0, '2021-02-09 02:35:03', '0000-00-00 00:00:00'),
(7620, 29, 105, 0, 0, 0, 0, 0, 0, '2021-02-11 02:28:43', '0000-00-00 00:00:00'),
(7621, 29, 106, 0, 0, 0, 0, 0, 0, '2021-02-11 02:28:43', '0000-00-00 00:00:00'),
(7622, 29, 139, 0, 0, 0, 0, 0, 0, '2021-02-11 02:28:43', '0000-00-00 00:00:00'),
(7650, 28, 105, 0, 0, 0, 0, 0, 0, '2021-02-11 04:14:29', '0000-00-00 00:00:00'),
(7651, 28, 106, 0, 0, 0, 0, 0, 0, '2021-02-11 04:14:29', '0000-00-00 00:00:00'),
(7652, 28, 139, 0, 0, 0, 0, 0, 0, '2021-02-11 04:14:29', '0000-00-00 00:00:00'),
(7867, 10, 105, 0, 0, 0, 0, 0, 0, '2021-02-25 16:20:46', '0000-00-00 00:00:00'),
(7885, 10, 106, 0, 0, 0, 0, 0, 0, '2021-02-25 16:20:46', '0000-00-00 00:00:00'),
(7886, 10, 139, 0, 0, 0, 0, 0, 0, '2021-02-25 16:20:46', '0000-00-00 00:00:00'),
(7934, 20, 105, 0, 0, 0, 0, 0, 0, '2021-02-25 16:21:53', '0000-00-00 00:00:00'),
(7945, 20, 106, 0, 0, 0, 0, 0, 0, '2021-02-25 16:21:53', '0000-00-00 00:00:00'),
(7946, 20, 139, 0, 0, 0, 0, 0, 0, '2021-02-25 16:21:53', '0000-00-00 00:00:00'),
(7959, 17, 105, 0, 0, 0, 0, 0, 0, '2021-02-28 15:00:32', '0000-00-00 00:00:00'),
(7974, 17, 106, 0, 0, 0, 0, 0, 0, '2021-02-28 15:00:32', '0000-00-00 00:00:00'),
(7975, 17, 139, 0, 0, 0, 0, 0, 0, '2021-02-28 15:00:32', '0000-00-00 00:00:00'),
(7988, 6, 105, 0, 0, 0, 0, 0, 0, '2021-03-01 06:44:51', '0000-00-00 00:00:00'),
(7995, 6, 106, 0, 0, 0, 0, 0, 0, '2021-03-01 06:44:51', '0000-00-00 00:00:00'),
(7996, 6, 139, 0, 0, 0, 0, 0, 0, '2021-03-01 06:44:51', '0000-00-00 00:00:00'),
(8017, 1, 105, 0, 0, 0, 0, 0, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8063, 1, 106, 0, 0, 0, 0, 0, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8064, 1, 139, 0, 0, 0, 0, 0, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8072, 1, 107, 0, 0, 0, 0, 0, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8073, 1, 155, 1, 1, 1, 0, 0, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8074, 1, 108, 1, 1, 1, 0, 1, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8075, 1, 154, 0, 0, 0, 0, 0, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8076, 1, 109, 0, 0, 0, 0, 0, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8077, 1, 111, 0, 0, 0, 0, 0, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8078, 1, 112, 1, 1, 1, 0, 1, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8079, 1, 110, 1, 1, 1, 0, 1, 0, '2021-03-08 02:54:57', '0000-00-00 00:00:00'),
(8087, 3, 105, 0, 0, 0, 0, 0, 0, '2021-03-08 02:55:18', '0000-00-00 00:00:00'),
(8116, 3, 106, 0, 0, 0, 0, 0, 0, '2021-03-08 02:55:18', '0000-00-00 00:00:00'),
(8117, 3, 139, 0, 0, 0, 0, 0, 0, '2021-03-08 02:55:18', '0000-00-00 00:00:00'),
(8130, 4, 105, 0, 0, 0, 0, 0, 0, '2021-03-08 02:58:56', '0000-00-00 00:00:00'),
(8156, 4, 106, 0, 0, 0, 0, 0, 0, '2021-03-08 02:58:56', '0000-00-00 00:00:00'),
(8157, 4, 139, 0, 0, 0, 0, 0, 0, '2021-03-08 02:58:56', '0000-00-00 00:00:00'),
(8170, 9, 105, 0, 0, 0, 0, 0, 0, '2021-03-08 02:59:24', '0000-00-00 00:00:00'),
(8192, 9, 106, 0, 0, 0, 0, 0, 0, '2021-03-08 02:59:24', '0000-00-00 00:00:00'),
(8193, 9, 139, 0, 0, 0, 0, 0, 0, '2021-03-08 02:59:24', '0000-00-00 00:00:00'),
(8208, 19, 105, 0, 0, 0, 0, 0, 0, '2021-03-08 03:00:06', '0000-00-00 00:00:00'),
(8230, 19, 106, 0, 0, 0, 0, 0, 0, '2021-03-08 03:00:06', '0000-00-00 00:00:00'),
(8231, 19, 139, 0, 0, 0, 0, 0, 0, '2021-03-08 03:00:06', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifikasi`
--

CREATE TABLE `tbl_notifikasi` (
  `id` int(11) NOT NULL,
  `nik` varchar(225) NOT NULL,
  `title` varchar(500) NOT NULL,
  `detail` text NOT NULL,
  `link` varchar(1000) NOT NULL,
  `link_type` tinyint(4) NOT NULL COMMENT '1; internal; 2: exsternal',
  `tipe_proposal` int(1) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL COMMENT '0; belum dibaca; 1. sudah dibaca',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `key_setting` varchar(255) NOT NULL,
  `val_setting` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `id_usr_status` int(11) NOT NULL,
  `id_usr_role` int(11) NOT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `user_pass` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_area` int(11) NOT NULL,
  `forgot_pass_token` varchar(255) DEFAULT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `user_limit` tinyint(4) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `grand_segment` varchar(255) DEFAULT NULL,
  `telegram_chat_id` varchar(50) DEFAULT NULL,
  `telegram_username` varchar(255) DEFAULT NULL,
  `telegram_name` varchar(255) DEFAULT NULL,
  `telegram_date` datetime DEFAULT NULL,
  `telegram_status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `id_usr_status`, `id_usr_role`, `nik`, `user_pass`, `full_name`, `email`, `user_area`, `forgot_pass_token`, `verify_token`, `user_limit`, `foto`, `grand_segment`, `telegram_chat_id`, `telegram_username`, `telegram_name`, `telegram_date`, `telegram_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1328, 2, 1, '90009000', '$2y$07$an5h/jL5sGcOV..RoD.vkOS6P1iT9t6x.2D1MwNEgCAQHtD8PgL72', 'Super Admin', '', 1000, '1df4001c1061a4b3e5a55f06fac25559', NULL, 0, NULL, NULL, '603322043', 'ray_novello', 'Muhammad Rayhan Novelo ', '2021-03-01 14:35:41', 1, '2020-02-22 14:38:48', '2021-05-10 14:10:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usr_roles`
--

CREATE TABLE `tbl_usr_roles` (
  `id_usr_role` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_desc` text DEFAULT NULL,
  `can_finish` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_usr_roles`
--

INSERT INTO `tbl_usr_roles` (`id_usr_role`, `role_name`, `role_desc`, `can_finish`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', '', NULL, '2018-12-14 02:50:13', '2019-01-24 11:01:21', NULL),
(2, 'Marketing Cabang', '', NULL, '2019-10-23 09:38:53', '2021-05-10 14:12:19', '2021-05-10 14:12:19'),
(3, 'Operasional Cabang', '', NULL, '2019-10-23 09:39:03', '2021-05-10 14:12:24', '2021-05-10 14:12:24'),
(4, 'Kepala Cabang', '', NULL, '2019-10-23 09:39:14', '2021-05-10 14:12:27', '2021-05-10 14:12:27'),
(5, 'Operasional Pusat', '', NULL, '2019-10-23 09:39:32', '2021-05-10 14:12:30', '2021-05-10 14:12:30'),
(6, 'Manager Operasional Pusat', '', NULL, '2019-10-23 09:39:41', '2021-05-10 14:12:41', '2021-05-10 14:12:41'),
(7, 'Vp Operasional', '', 1, '2019-10-23 09:39:56', '2021-05-10 14:12:35', '2021-05-10 14:12:35'),
(8, 'Direksi Ops', '', 1, '2019-10-23 09:40:02', '2021-05-10 14:12:38', '2021-05-10 14:12:38'),
(9, 'Keuangan Pusat', NULL, 1, '2019-11-21 09:19:42', '2021-05-10 14:12:43', '2021-05-10 14:12:43'),
(10, 'Project Management Office (PMO)', '-', NULL, '2020-01-13 08:34:39', '2021-05-10 14:12:46', '2021-05-10 14:12:46'),
(11, 'Marketing Pusat', NULL, NULL, '2020-01-22 08:01:04', '2021-05-10 14:12:49', '2021-05-10 14:12:49'),
(12, 'GM Marketing', NULL, NULL, '2020-01-22 08:49:39', '2021-05-10 14:12:52', '2021-05-10 14:12:52'),
(13, 'General Manager Operasional Pusat', NULL, 1, '2020-02-11 07:46:53', '2021-05-10 14:12:53', '2021-05-10 14:12:53'),
(14, 'Guest', 'View IO', NULL, '2020-03-03 01:50:12', '2021-05-10 14:12:55', '2021-05-10 14:12:55'),
(15, 'Guest 2', 'View PS', NULL, '2020-03-04 01:47:55', '2021-05-10 14:12:56', '2021-05-10 14:12:56'),
(16, 'Direktur Utama', NULL, 1, '2020-03-12 08:11:22', '2021-05-10 14:12:58', '2021-05-10 14:12:58'),
(17, 'Guest 3', 'View IO dan PS', NULL, '2020-03-25 16:07:07', '2021-05-10 14:13:00', '2021-05-10 14:13:00'),
(18, 'Sekretaris DU', 'Notifikasi', NULL, '2020-03-26 04:37:16', '2021-05-10 14:13:01', '2021-05-10 14:13:01'),
(19, 'Keuangan Cabang', 'Approval invoice, view list', NULL, '2020-04-21 08:04:16', '2021-05-10 14:13:03', '2021-05-10 14:13:03'),
(20, 'Manajer Keuangan Cabang', 'Approval invoice, view list', NULL, '2020-04-21 08:04:36', '2021-05-10 14:13:04', '2021-05-10 14:13:04'),
(21, 'VP Keuangan', 'Approve invoice, list invoice ps', NULL, '2020-05-03 13:20:29', '2021-05-10 14:13:05', '2021-05-10 14:13:05'),
(22, 'D1', 'Approval Proposal', 1, '2020-06-22 08:41:56', '2021-05-10 14:13:07', '2021-05-10 14:13:07'),
(23, 'D2', 'Approval Proposal', 0, '2020-08-14 16:31:27', '2021-05-10 14:13:08', '2021-05-10 14:13:08'),
(24, 'D3', 'Approval Proposal', 0, '2020-08-14 16:31:33', '2021-05-10 14:13:10', '2021-05-10 14:13:10'),
(25, 'Deputy Cabang', 'Approval Invoice', NULL, '2020-08-14 16:31:53', '2021-05-10 14:13:11', '2021-05-10 14:13:11'),
(26, 'KAP', 'E-Bupot', NULL, '2020-12-10 06:49:38', '2021-05-10 14:13:12', '2021-05-10 14:13:12'),
(27, 'Command Center', 'Manajemen User - Reset Password', NULL, '2020-12-19 18:09:45', '2021-05-10 14:13:14', '2021-05-10 14:13:14'),
(28, 'General Affair (GA)', 'View IO & PS', NULL, '2021-02-10 07:00:19', '2021-05-10 14:13:16', '2021-05-10 14:13:16'),
(29, 'Manajer PMO', 'Approval PS', NULL, '2021-02-11 02:27:43', '2021-05-10 14:13:18', '2021-05-10 14:13:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usr_sessions`
--

CREATE TABLE `tbl_usr_sessions` (
  `id_usr_session` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `usr_login_ip` varchar(16) DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL,
  `usr_logout_ip` varchar(16) DEFAULT NULL,
  `is_logged` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usr_status`
--

CREATE TABLE `tbl_usr_status` (
  `id_usr_status` int(11) NOT NULL,
  `status_name` varchar(150) NOT NULL,
  `status_desc` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_usr_status`
--

INSERT INTO `tbl_usr_status` (`id_usr_status`, `status_name`, `status_desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Verifying', 'User has been registered, but still can\'t use account till verifying it using email.', '2018-12-21 07:10:23', '2018-12-21 14:10:23', NULL),
(2, 'Masih Bekerja', 'Account can be use as well as their role.', '2019-09-05 06:26:21', '2019-09-05 13:26:21', NULL),
(3, 'Akun Telblokir', 'Suspending user from login and make any change to system.', '2019-09-05 06:26:40', '2019-09-05 13:26:40', NULL),
(4, 'Tidak Aktif Bekerja', 'Account deleted.', '2020-09-01 07:19:07', '2020-09-01 14:19:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_log_login`
--
ALTER TABLE `tbl_log_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `tbl_menu_privileges`
--
ALTER TABLE `tbl_menu_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_usr_role`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `tbl_notifikasi`
--
ALTER TABLE `tbl_notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_status` (`id_usr_status`),
  ADD KEY `id_role` (`id_usr_role`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `tbl_usr_roles`
--
ALTER TABLE `tbl_usr_roles`
  ADD PRIMARY KEY (`id_usr_role`);

--
-- Indexes for table `tbl_usr_sessions`
--
ALTER TABLE `tbl_usr_sessions`
  ADD PRIMARY KEY (`id_usr_session`);

--
-- Indexes for table `tbl_usr_status`
--
ALTER TABLE `tbl_usr_status`
  ADD PRIMARY KEY (`id_usr_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_log_login`
--
ALTER TABLE `tbl_log_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `tbl_menu_privileges`
--
ALTER TABLE `tbl_menu_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8244;

--
-- AUTO_INCREMENT for table `tbl_notifikasi`
--
ALTER TABLE `tbl_notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1561;

--
-- AUTO_INCREMENT for table `tbl_usr_roles`
--
ALTER TABLE `tbl_usr_roles`
  MODIFY `id_usr_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_usr_sessions`
--
ALTER TABLE `tbl_usr_sessions`
  MODIFY `id_usr_session` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_usr_status`
--
ALTER TABLE `tbl_usr_status`
  MODIFY `id_usr_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `CONS_STAT` FOREIGN KEY (`id_usr_status`) REFERENCES `tbl_usr_status` (`id_usr_status`),
  ADD CONSTRAINT `CONS_USR_ROLE` FOREIGN KEY (`id_usr_role`) REFERENCES `tbl_usr_roles` (`id_usr_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
