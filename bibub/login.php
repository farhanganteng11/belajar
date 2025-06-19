<?php
session_start();
// Jika sudah login, redirect ke index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Simple Money Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      background: #ffffff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
    }
    .login-card .form-control {
      border-radius: 8px;
    }
    .login-card .btn-primary {
      border-radius: 8px;
      font-weight: 500;
    }
    .logo-icon {
      font-size: 40px;
      color: #0d6efd;
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="text-center mb-4">
    <i class="bi bi-box-arrow-in-right logo-icon"></i>
    <h4 class="mt-2">Login ke <strong>Money Tracker</strong></h4>
  </div>

  <?php
    // Blok untuk menampilkan notifikasi dari session (dari registrasi atau login gagal)
    if (isset($_SESSION['notif'])) {
      $notif = $_SESSION['notif'];
      echo "<div class='alert alert-{$notif['tipe']} alert-dismissible fade show' role='alert'>
              {$notif['pesan']}
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
      unset($_SESSION['notif']);
  }  
  ?>

  <form action="proses_login.php" method="POST">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
    </div>
    <button class="btn btn-primary w-100" type="submit">Login</button>
  </form>

  <p class="mt-4 text-center">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>