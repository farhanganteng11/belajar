<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika berhasil, simpan session dan arahkan ke index.php
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            // Jika password salah, atur notifikasi 'danger'
            $_SESSION['notif'] = ['pesan' => 'Username atau password yang Anda masukkan salah!', 'tipe' => 'danger'];
            header("Location: login.php");
            exit();
        }
    } else {
        // Jika username tidak ditemukan, atur notifikasi 'danger'
        $_SESSION['notif'] = ['pesan' => 'Username atau password yang Anda masukkan salah!', 'tipe' => 'danger'];
        header("Location: login.php");
        exit();
    }
} else {
    // Jika file diakses langsung tanpa metode POST, kembalikan ke halaman login
    header("Location: login.php");
exit();
}
?>