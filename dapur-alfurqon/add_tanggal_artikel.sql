-- Migration: Menambahkan kolom tanggal ke tabel artikel
-- Jalankan query ini di database untuk menambahkan kolom tanggal

-- Tambah kolom tanggal
ALTER TABLE `artikel` 
ADD COLUMN `tanggal` DATE DEFAULT NULL AFTER `status`;

-- Update artikel yang sudah ada dengan tanggal dari created_at
UPDATE `artikel` SET `tanggal` = DATE(`created_at`) WHERE `tanggal` IS NULL;

-- Verifikasi perubahan
-- SELECT id_artikel, judul, tanggal, created_at FROM artikel;
