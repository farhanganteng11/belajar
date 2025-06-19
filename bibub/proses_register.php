<?php
session_start();
include "koneksi.php";

// Pastikan request berasal dari metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

// Validasi dasar
if (empty($username) || empty($password)) {
    $_SESSION['notif'] = ['pesan' => 'Username dan password tidak boleh kosong.', 'tipe' => 'danger'];
    header("Location: register.php");
    exit();
}

// Cek apakah username sudah ada
$check_query = "SELECT id FROM users WHERE username='$username'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    $_SESSION['notif'] = ['pesan' => 'Username sudah digunakan! Silakan pilih yang lain.', 'tipe' => 'danger'];
    header("Location: register.php");
    exit();
} else {
    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert pengguna baru ke database
    $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    if (mysqli_query($conn, $insert_query)) {
    // Jika berhasil, kirim notifikasi ke halaman login
    $_SESSION['notif'] = ['pesan' => 'Registrasi berhasil! Silakan login dengan akun baru Anda.', 'tipe' => 'success'];
    header("Location: login.php");
    exit();
    } else {
    $_SESSION['notif'] = ['pesan' => 'Terjadi kesalahan pada server. Registrasi gagal!', 'tipe' => 'danger'];
    header("Location: register.php");
    exit();
    }
}
} else {
// Jika file diakses langsung, redirect ke halaman registrasi
header("Location: register.php");
exit();
}
?>