-- Backup SQL untuk tabel-tabel yang dibuat
-- Generated on: 2024-01-15

-- Struktur tabel detail_jenis_kegiatan
CREATE TABLE IF NOT EXISTS `detail_jenis_kegiatan` (
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

-- Struktur tabel dokumentasi_kegiatan
CREATE TABLE IF NOT EXISTS `dokumentasi_kegiatan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `detail_jenis_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `ukuran_file` int(11) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dokumentasi_kegiatan_detail_jenis_kegiatan_id_foreign` (`detail_jenis_kegiatan_id`),
  CONSTRAINT `dokumentasi_kegiatan_detail_jenis_kegiatan_id_foreign` FOREIGN KEY (`detail_jenis_kegiatan_id`) REFERENCES `detail_jenis_kegiatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur tabel tanda_tangan
CREATE TABLE IF NOT EXISTS `tanda_tangan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `detail_jenis_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_penandatangan` enum('petugas','ka_unit') NOT NULL,
  `nip_penandatangan` varchar(20) NOT NULL,
  `nama_penandatangan` varchar(255) NOT NULL,
  `signature_data` text NOT NULL,
  `tanggal_tanda_tangan` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tanda_tangan_detail_jenis_kegiatan_id_foreign` (`detail_jenis_kegiatan_id`),
  KEY `tanda_tangan_nip_penandatangan_foreign` (`nip_penandatangan`),
  CONSTRAINT `tanda_tangan_detail_jenis_kegiatan_id_foreign` FOREIGN KEY (`detail_jenis_kegiatan_id`) REFERENCES `detail_jenis_kegiatan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tanda_tangan_nip_penandatangan_foreign` FOREIGN KEY (`nip_penandatangan`) REFERENCES `users` (`nip`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;