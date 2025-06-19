<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $user_id = $_SESSION['user_id'];

  // Hanya hapus transaksi milik user yang sedang login
  $query = "DELETE FROM transactions WHERE id = $id AND user_id = $user_id";
  if (mysqli_query($conn, $query)) {
    header("Location: daftar_transaksi.php");
    exit();
  } else {
    echo "Gagal menghapus transaksi: " . mysqli_error($conn);
  }
} else {
  header("Location: daftar_transaksi.php");
  exit();
}
