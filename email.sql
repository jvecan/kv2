CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `email` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verified` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;