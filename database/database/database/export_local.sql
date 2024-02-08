-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 172.16.8.8
-- Creato il: Gen 24, 2024 alle 09:43
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `failed_jobs`
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
-- Struttura della tabella `migrations`
--

CREATE TABLE `migrations` (
                              `id` int(10) UNSIGNED NOT NULL,
                              `migration` varchar(255) NOT NULL,
                              `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
                                                          (1, '2014_10_12_000000_create_users_table', 1),
                                                          (2, '2014_10_12_100000_create_password_resets_table', 1),
                                                          (3, '2019_08_19_000000_create_failed_jobs_table', 1),
                                                          (4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
                                                          (5, '2024_01_23_091611_nome_migrazione', 1),
                                                          (6, '2024_01_23_091630_prima_migrazione', 1),
                                                          (7, '2024_01_23_091721_v1.0.0', 1),
                                                          (8, '2024_01_23_091943_aggiunta_entity_roles', 2),
                                                          (9, '2024_01_23_092136_nome_migrazione', 3),
                                                          (10, '2024_01_23_092204_migrazione_2_creazione_entity_necessarie', 3),
                                                          (11, '2024_01_23_093815_create_products_table', 4),
                                                          (12, '2024_01_23_094633_creata_tabella_attribute_product', 5),
                                                          (13, '2024_01_23_094857_creata_tabella_attribute_product', 6),
                                                          (14, '2024_01_23_095252_edit_1_product_attributes', 7),
                                                          (15, '2024_01_23_095743_edit_1_table_products', 8),
                                                          (16, '2024_01_23_100059_edit_2_table_products', 9),
                                                          (17, '2024_01_23_100550_edit_2_table_product_attributes', 10),
                                                          (18, '2024_01_23_104017_edit_3_table_products', 11),
                                                          (19, '2024_01_23_135815_add_settings_table', 12),
                                                          (20, '2024_01_23_140632_add_columns_to_settings_table', 13),
                                                          (21, '2024_01_23_141130_bugfix_table_settings_not_found', 14),
                                                          (22, '2024_01_23_143449_add_relationships_btw_user_unities_v2', 15),
                                                          (23, '2024_01_23_143900_add_relationships_btw_user_unities_v3', 16),
                                                          (24, '2014_10_12_200000_add_two_factor_columns_to_users_table', 17),
                                                          (25, '2024_01_23_144638_create_sessions_table', 17),
                                                          (26, '2024_01_23_150856_create_sessions_table', 18);

-- --------------------------------------------------------

--
-- Struttura della tabella `password_resets`
--

CREATE TABLE `password_resets` (
                                   `email` varchar(255) NOT NULL,
                                   `token` varchar(255) NOT NULL,
                                   `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `personal_access_tokens`
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
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
                            `id` bigint(20) UNSIGNED NOT NULL,
                            `product_num_ceap` bigint(20) UNSIGNED DEFAULT NULL,
                            `product_num_intern` varchar(255) NOT NULL,
                            `product_name` longtext NOT NULL,
                            `product_image` longtext DEFAULT NULL,
                            `product_start` datetime NOT NULL DEFAULT '2024-01-23 10:41:20',
                            `product_end` datetime DEFAULT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `product_num_ceap`, `product_num_intern`, `product_name`, `product_image`, `product_start`, `product_end`, `created_at`, `updated_at`) VALUES
                                                                                                                                                                         (2, 100000057, 'B4', 'Bloc-notes A4', NULL, '2022-01-23 00:00:00', '2024-01-23 13:05:31', '2024-01-23 09:58:56', '2024-01-23 09:58:56'),
                                                                                                                                                                         (3, 100000120, 'B10', 'Bucatrici Leitz 5008', NULL, '2022-01-23 00:00:00', NULL, '2024-01-23 09:59:57', '2024-01-23 09:59:57');

-- --------------------------------------------------------

--
-- Struttura della tabella `product_attributes`
--

CREATE TABLE `product_attributes` (
                                      `id` bigint(20) UNSIGNED NOT NULL,
                                      `attribute_code` varchar(255) NOT NULL,
                                      `attribute_name` text DEFAULT NULL,
                                      `attribute_value` varchar(255) NOT NULL,
                                      `attribute_hidden` tinyint(1) NOT NULL,
                                      `attribute_date_start` datetime NOT NULL,
                                      `attribute_date_end` datetime NOT NULL,
                                      `product_ref_id` int(11) NOT NULL,
                                      `created_at` timestamp NULL DEFAULT NULL,
                                      `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `attribute_code`, `attribute_name`, `attribute_value`, `attribute_hidden`, `attribute_date_start`, `attribute_date_end`, `product_ref_id`, `created_at`, `updated_at`) VALUES
    (1, 'QTA', 'Quantità', '10', 0, '2024-01-23 11:07:20', '2024-01-23 11:07:20', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `sessions`
--

CREATE TABLE `sessions` (
                            `id` varchar(255) NOT NULL,
                            `user_id` bigint(20) UNSIGNED DEFAULT NULL,
                            `ip_address` varchar(45) DEFAULT NULL,
                            `user_agent` text DEFAULT NULL,
                            `payload` longtext NOT NULL,
                            `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
                                                                                                     ('6vZeECcFHsvQLujRqafkiFfQkB9m7OXgISDi5qlq', NULL, '172.16.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiemVqNklLTXVocUx2SnByTENvT3NlenB6VWpTQkg3TUF0czJLZVR4dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1706078006),
                                                                                                     ('Ew9TtrfyINcBtJL3rRqZa5FbfWVzBbULSVEC4lm8', NULL, '172.16.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSG1SNDllVHpTZlVTNFIxZ3l6c0dza1RIU1VIalhrRWMwRnhhemREQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1706030211),
                                                                                                     ('hxe2qgQjXyBygO2gDkGWEZWserIIdOnrjd8qzjVw', NULL, '172.16.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzgyTmloUXdVa0NwTG5uMENqTFdETnhoRXhGbUUzQTA2TFY3djR4WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1706081599),
                                                                                                     ('Jo7rHyeWsn2dfVe5VfAYQXskxb2KG9VbWdkKp3sO', NULL, '172.16.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFRHNHJaTE51STg1akY4R0hlYnVaWUgxYUJtWWJlQkZuT0d3MUVqMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1706025018),
                                                                                                     ('lZEpJZnvd1VNbFel41Z3Vn5jf7ZuotwYYWPbThfq', NULL, '172.16.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUFrVk1RSkRmM2NPa0psTXppbG5uRUJ6MGlybWpYdE1jaDB4VnhzZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0cyI7fX0=', 1706025022),
                                                                                                     ('Q9G3jyrCrJJaJwVIIutaekVaUQjqRh3TukZKwAR3', NULL, '172.16.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamlHbHRSTlExdlhWZ0FteXg5MjJvdWhBakZmSG95cjNVRVdGSnc0dSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1706022631);

-- --------------------------------------------------------

--
-- Struttura della tabella `settings`
--

CREATE TABLE `settings` (
                            `id` bigint(20) UNSIGNED NOT NULL,
                            `key` varchar(255) NOT NULL,
                            `value` varchar(255) NOT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
                                                                              (1, 'path_logo', 'https://www.spailocarno.ch/site/wp-content/uploads/2017/02/logo_cptl_ti.png', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
                                                                              (2, 'path_logo', 'https://www.spailocarno.ch/site/wp-content/uploads/2017/02/logo_cptl_ti.png', '2024-01-23 14:12:48', '2024-01-23 14:12:48');

-- --------------------------------------------------------

--
-- Struttura della tabella `unities`
--

CREATE TABLE `unities` (
                           `id` bigint(20) UNSIGNED NOT NULL,
                           `unity_code` varchar(255) NOT NULL,
                           `unity_name` varchar(255) NOT NULL,
                           `unity_ref_id` bigint(20) UNSIGNED DEFAULT NULL,
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `unities`
--

INSERT INTO `unities` (`id`, `unity_code`, `unity_name`, `unity_ref_id`, `created_at`, `updated_at`) VALUES
                                                                                                         (1, 'ROOT', 'Root - Amm. IT', NULL, NULL, NULL),
                                                                                                         (2, 'CPTL', 'CPT Locarno', NULL, NULL, NULL),
                                                                                                         (3, 'SPAI', 'Scuola Professionale ...', 2, NULL, NULL),
                                                                                                         (4, 'SSSMT', 'Scuola Superiore Specializzata ...', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
                         `id` bigint(20) UNSIGNED NOT NULL,
                         `first_name` varchar(255) NOT NULL,
                         `last_name` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `username` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `two_factor_secret` text DEFAULT NULL,
                         `two_factor_recovery_codes` text DEFAULT NULL,
                         `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
                         `unity_id` bigint(20) UNSIGNED NOT NULL,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `unity_id`, `created_at`, `updated_at`) VALUES
    (1, 'Angelo', 'Rigoni', 'angelo.rigoni05@gmail.com', 'angy', 'Abc123!', NULL, NULL, NULL, 1, NULL, NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indici per le tabelle `migrations`
--
ALTER TABLE `migrations`
    ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `password_resets`
--
ALTER TABLE `password_resets`
    ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `product_attributes`
--
ALTER TABLE `product_attributes`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_attributes_attribute_code_unique` (`attribute_code`);

--
-- Indici per le tabelle `sessions`
--
ALTER TABLE `sessions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indici per le tabelle `settings`
--
ALTER TABLE `settings`
    ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `unities`
--
ALTER TABLE `unities`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unities_unity_code_unique` (`unity_code`),
  ADD KEY `unities_unity_ref_id_foreign` (`unity_ref_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_unity_id_foreign` (`unity_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `failed_jobs`
--
ALTER TABLE `failed_jobs`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `migrations`
--
ALTER TABLE `migrations`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `product_attributes`
--
ALTER TABLE `product_attributes`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `settings`
--
ALTER TABLE `settings`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `unities`
--
ALTER TABLE `unities`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `unities`
--
ALTER TABLE `unities`
    ADD CONSTRAINT `unities_unity_ref_id_foreign` FOREIGN KEY (`unity_ref_id`) REFERENCES `unities` (`id`);

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
    ADD CONSTRAINT `users_unity_id_foreign` FOREIGN KEY (`unity_id`) REFERENCES `unities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
