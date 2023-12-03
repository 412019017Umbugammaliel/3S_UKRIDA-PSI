-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2023 at 07:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3s_ukrida`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_category` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `point` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `id_category`, `id_user`, `point`, `created_at`, `updated_at`) VALUES
(4, 6, 5, 5, '2023-12-02 13:04:19', '2023-12-02 13:04:19'),
(5, 6, 5, 6, '2023-12-02 13:04:39', '2023-12-02 13:04:39'),
(6, 6, 5, 6, '2023-12-02 13:14:39', '2023-12-02 13:14:39'),
(7, 6, 3, 6, '2023-12-02 13:18:36', '2023-12-02 13:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_category` bigint(20) UNSIGNED NOT NULL,
  `name_category` varchar(255) NOT NULL,
  `image_category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_category`, `name_category`, `image_category`, `created_at`, `updated_at`) VALUES
(1, 'Realistic', '1700593045.jpg', '2023-11-20 10:37:42', '2023-11-21 11:57:25'),
(2, 'Investigative', '1700501897.png', '2023-11-20 10:38:17', '2023-11-20 10:38:17'),
(3, 'Artistic', '1700501928.jpg', '2023-11-20 10:38:48', '2023-11-20 10:38:48'),
(4, 'Social', '1700501968.jpg', '2023-11-20 10:39:28', '2023-11-23 05:43:44'),
(5, 'Enterprising', '1700501999.jpg', '2023-11-20 10:39:59', '2023-11-20 10:39:59'),
(6, 'Conventional', '1700502041.jpg', '2023-11-20 10:40:41', '2023-11-20 10:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `classifications`
--

CREATE TABLE `classifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_category` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classifications`
--

INSERT INTO `classifications` (`id`, `id_category`, `title`, `description`, `created_at`, `updated_at`) VALUES
(5, 1, 'Results Realistic', 'Orang yang menyukai karier Realistic seperti mekanik mobil, surveyor, tukang kayu, ahli elektro, koki, dan petani. Tipe R biasanya memiliki kemampuan mekanik dan atletik. Tipe R suka bekerja diluar ruangan dan suka bekerja dengan alat-alat dan mesin Tipe R umumnya lebih menyukai bekerja dengan benda dibanding dengan manusia. Oran biasanya mendeskripsikan Tipe R sebagai orang yang bersungguh-sungguh, bijaksana, praktis, alami, hemat, sederhana, gigih dan jujur.', '2023-11-26 22:44:49', '2023-11-26 22:50:40'),
(6, 2, 'Results Investigative', 'Orang yang menyukai karier seperti Ahli Biologi, Ahli Geologi, ahli Kimia, Antropolog, asisten laboratorium, pengawasan produk (product inspector), dan ahli medis.Tipe I biasanya memiliki kemampuan matematika dan sains. Tipe I senang untuk bekerja sendirian dan suka untuk memecahkan masalah. Tipe I umumnya suka untuk bekerja dengan hipotesis/ ide daripada dengan manusia atau alat benda. Orang-orang mendeskripsikan Tipe I sebagai orang yang logis memiliki rasa ingin tahu, teliti, terpelajar, independen, pendiam dan sederhana', '2023-11-26 22:45:32', '2023-11-26 22:50:21'),
(7, 3, 'Results Artistic', 'Orang yang menyukai karier seperti komposer, pemusik, penari, penyanyi, interior decorator, aktor, penulis, dan juru lelang. Tipe A biasanya memiliki keahlian artistik, suka menciptakan pekerjaan yang original, dan memiliki imajinasi yang baik. Tipe A umumnya lebih suka bekerja dengan ide baru daripada dengan manusia atau alat benda. Orang-orang mendeskripsikan Tipe A sebagai orang yang terbuka, kreatif, independen, emosional, impulsif, dan original', '2023-11-26 22:55:34', '2023-11-26 22:55:34'),
(8, 4, 'Results Social', 'Orang yang menyukai karier sebagai guru, terapis wicara, pekerja keagamaan, konselor, dan perawat. Tipe S biasanya senang berada disekitar orang banyak. Tipe ini tertarik dengan keberadaan orang-orang di sekitarnya dan membantu orang-orang yang mempunyai masalah. Tipe S umumnya lebih suka bekerja bersama tim/ orang lain daripada dengan alat benda. Orang mendeskripsikan Tipe S sebagai orang yang suka menolong dan pengertian, hangat, bertanggung jawab, mampu bekerja sama, bersahabat, baik hati dermawan, dan sabar.', '2023-11-26 22:56:31', '2023-11-26 22:56:31'),
(9, 5, 'Results Enterprising', 'Orang yang menyukai karier seperti eksekutif bisnis, produser televisi, sales, pramusaji, agen travel, supervisor, dan manager toko. Tipe E biasanya memiliki kemampuan memimpin dan public speaking. Tipe E tertarik dengan uang dan politik dan suka memengaruhi orang lain. Tipe E umumnya lebih suka untuk bekerja dengan orang lain dan ide daripada dengan alat benda. Orang mendeskripsikan Tipe E sebagai orang yang ramah, berpetualang, energik, optimis, senang bergaul, percaya diri, dan ambisius', '2023-11-26 22:57:27', '2023-11-26 22:57:27'),
(10, 6, 'Results Conventional', 'Orang yang menyukai karier sebagai analis finansial, banker, ahli pajak, pekerja pembukuan, sekretaris, pegawai kantor, dan penyiar radio. Tipe C memiliki kemampuan klerikal dan matematika. Tipe C senang bekerja di luar ruangan dan mengorganisir sesuatu. Tipe C umumnya senang bekerja dengan kertas dan angka daripada dengan manusia. Orang mendeskripsikan Tipe C sebagai orang yang praktis, hari-hati, cemas, efisien, patuh, dan keras hati.', '2023-11-26 22:58:16', '2023-11-26 22:58:16');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'SEMINAR, KONSELING, DAN TES MINAT PROGRAM PENGABDIAN MASYARAKAT', 'Pemilihan karier merupakan salah satu tugas perkembangan yang harus dilalui oleh remaja, khususnya remaja yang berada di Sekolah Menengah Pertama (SMP) maupun Atas (SMA). Siswa SMP kelas 9 mulai dihadapkan dengan perencanaan karier di masa depan dan perlu mengambil pilihan jurusan di SMA. Sementara siswa SMA perlu memilih jurusan atau perguruan tinggi yang diinginkan.', 'UKRIDA_3.png', '2023-11-20 10:29:57', '2023-11-22 13:03:06'),
(2, '3S SUKSES SETELAH SEKOLAH INFORMASI & KETENTUAN', 'Penyelenggaraan seminar dan tes ini merupakan bagian dari program pengabdian masyarakat Fakultas Psikologi Ukrida, oleh karena itu dalam pelaksanaannya tidak memungut biaya, tetapi terbuka menerima donasi yang ditujukan kepada Clement Suleeman Scholarship Fund (CSSF).', 'UKRIDA_1.png', '2023-11-20 10:31:23', '2023-11-22 13:02:36');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event_date` date NOT NULL,
  `session_type` enum('3S in House','3S Goes To School/Church') NOT NULL,
  `availability` enum('Open','Close') NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `created_at`, `updated_at`, `event_date`, `session_type`, `availability`, `image_path`, `description`) VALUES
(1, '2023-11-20 10:32:42', '2023-11-22 13:26:00', '2023-11-14', '3S in House', 'Open', '1700684760.png', 'Agar mencapai hasil yang lebih efektif, kami mengusulkan agar program ini dilaksanakan sesuai jenjang sekolah, misalnya untuk kelas 10 saja, kelas 11 saja atau komunitas seusia agar penyampaianya bisa tepat sesuai kebutuhan. Dalam tahun pelayanan 2022, program ini berlaku mulai 1 Oktober 2022 sesuai dengan kapasitas dan ketersediaan waktu dari team pengabdian masyarakat yang terdiri atas dosen dan mahasiswa Ukrida.');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_category` bigint(20) UNSIGNED NOT NULL,
  `final_point` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `id_user`, `id_category`, `final_point`, `created_at`, `updated_at`) VALUES
(2, 5, 6, 17, '2023-12-02 13:04:19', '2023-12-02 13:14:39'),
(3, 3, 6, 6, '2023-12-02 13:18:36', '2023-12-02 13:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_10_17_110001_create_users_table', 1),
(6, '2023_10_25_175936_create_contents_table', 1),
(7, '2023_10_30_174826_create_events_table', 1),
(8, '2023_11_09_173200_create_categories_table', 1),
(10, '2023_11_15_180412_create_answers_table', 1),
(11, '2023_11_18_143147_create_classifications_table', 1),
(19, '2023_11_20_183131_create_classifications_table', 2),
(20, '2023_11_25_130317_create_answers_table', 3),
(25, '2023_11_25_164828_create_point_table', 6),
(26, '2023_11_13_180343_create_questions_table', 7),
(35, '2023_11_25_130311_create_answers_table', 8),
(36, '2023_11_30_161032_create_histories_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('gammalielumbu@gmail.com', '$2y$10$FAZ6Iesv0FCamn9TsOUhMuLpPgdvbug1lB6AjT3dRc4tnyQh3QM4O', '2023-11-22 12:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `point`
--

CREATE TABLE `point` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `poin_name` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id_question` bigint(20) UNSIGNED NOT NULL,
  `id_category` bigint(20) UNSIGNED NOT NULL,
  `questions` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id_question`, `id_category`, `questions`, `title`, `created_at`, `updated_at`) VALUES
(1, 1, 'Apakah Anda Manusia?', 'Realistic-1', '2023-11-30 10:23:10', '2023-11-30 10:23:10'),
(2, 1, 'Apakah hidup itu indah?', 'Realistic-2', '2023-11-30 10:24:48', '2023-11-30 12:11:09'),
(3, 2, 'Bagaimana menjalani hidup?', 'Investigative-1', '2023-11-30 12:11:33', '2023-11-30 12:11:33'),
(4, 6, 'apakah hidup berat?', 'Investigative-2', '2023-11-30 12:11:56', '2023-11-30 15:48:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `class` varchar(255) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'User',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `class`, `school_name`, `password`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'umbu', 'umbu@gmail.com', NULL, '9', 'UKRIDA', '$2y$10$7ekkzlRmTpuH/3L88CkDtONlJe7zYzCh9Z.3Tw52Xx/HJQt7PnWKC', 'Admin', NULL, '2023-11-20 10:25:27', '2023-11-22 14:35:57'),
(2, 'counselor', 'counselor@gmail.com', NULL, '10', 'SMA katolik', '$2y$10$wcb/QO2fawgkEqoG3Veu5uae.iN7vn0B021b3pjRBkRao4P9kEAXy', 'Counselor', NULL, '2023-11-20 10:35:14', '2023-11-22 09:41:23'),
(3, 'user', 'user@gmail.com', NULL, '10', 'SMP N 1 user', '$2y$10$D9rOHJE2lGjUkG6wEOVIleB7gVfPMjWTmrRStI/4eGJ4vpK/bM1fO', 'User', NULL, '2023-11-20 10:36:35', '2023-11-30 10:40:54'),
(5, 'hallo', 'hallo@gmail.com', NULL, '10', 'hallohallo', '$2y$10$O6dnHebtbksIdmiNbH35Oe/op25fuyKSxo0J8xWdr6Sk3fmq5Gr9u', 'User', NULL, '2023-11-30 12:39:00', '2023-11-30 12:39:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_id_category_foreign` (`id_category`),
  ADD KEY `answers_id_user_foreign` (`id_user`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `classifications`
--
ALTER TABLE `classifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classifications_id_category_foreign` (`id_category`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `histories_id_user_foreign` (`id_user`),
  ADD KEY `histories_id_category_foreign` (`id_category`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `point`
--
ALTER TABLE `point`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `questions_id_category_foreign` (`id_category`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `classifications`
--
ALTER TABLE `classifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `point`
--
ALTER TABLE `point`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id_question` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`),
  ADD CONSTRAINT `answers_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `classifications`
--
ALTER TABLE `classifications`
  ADD CONSTRAINT `classifications_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`);

--
-- Constraints for table `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`),
  ADD CONSTRAINT `histories_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
