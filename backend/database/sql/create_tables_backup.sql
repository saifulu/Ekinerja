-- Backup SQL untuk semua tabel yang akan dibuat
-- Generated on: 2024-01-15

-- Tabel detail_jenis_kegiatan
CREATE TABLE `detail_jenis_kegiatan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) NOT NULL,
  `jenis_kegiatan` varchar(255) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `tanggal_dibuat` datetime NOT NULL,
  `hasil_temuan` text,
  `status` enum('draft','submitted','approved','rejected') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_jenis_kegiatan_nip_index` (`nip`),
  CONSTRAINT `detail_jenis_kegiatan_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `users` (`nip`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel dokumentasi_kegiatan
CREATE TABLE `dokumentasi_kegiatan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `detail_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `ukuran_file` bigint(20) NOT NULL,
  `jenis_upload` enum('camera','file') NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dokumentasi_kegiatan_detail_kegiatan_id_foreign` (`detail_kegiatan_id`),
  CONSTRAINT `dokumentasi_kegiatan_detail_kegiatan_id_foreign` FOREIGN KEY (`detail_kegiatan_id`) REFERENCES `detail_jenis_kegiatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel tanda_tangan
CREATE TABLE `tanda_tangan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `detail_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_ttd` enum('petugas','ka_unit') NOT NULL,
  `signature_data` text NOT NULL,
  `nama_penandatangan` varchar(255) NOT NULL,
  `tanggal_ttd` datetime NOT NULL,
  `ip_address` varchar(45),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tanda_tangan_detail_kegiatan_id_jenis_ttd_unique` (`detail_kegiatan_id`,`jenis_ttd`),
  CONSTRAINT `tanda_tangan_detail_kegiatan_id_foreign` FOREIGN KEY (`detail_kegiatan_id`) REFERENCES `detail_jenis_kegiatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;