-- Buat database
CREATE DATABASE IF NOT EXISTS catatan_keuangan_db;
USE catatan_keuangan_db;

-- Tabel users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

-- Tabel transactions
CREATE TABLE IF NOT EXISTS transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  type ENUM('Pemasukan', 'Pengeluaran') NOT NULL,
  amount INT NOT NULL,
  kategori VARCHAR(100) NOT NULL,
  tanggal DATE NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Data contoh user
-- Username: farhan
-- Password: 123456 (sudah di-hash dengan password_hash())
INSERT INTO users (username, password) VALUES
('farhan', '$2y$10$6uEGF2RY2sZPj/PkTZ3gfu9Aw7GCRUDEvmU2E0/4W9Vph6DNVBA/y');
