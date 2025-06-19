<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar - Simple Money Tracker</title>
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
    .register-card {
      background: #ffffff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
    }
    .register-card .form-control {
      border-radius: 8px;
    }
    .register-card .btn-success {
      border-radius: 8px;
      font-weight: 500;
    }
    .logo-icon {
      font-size: 40px;
      color: #28a745;
    }
  </style>
</head>
<body>

<div class="register-card">
  <div class="text-center mb-4">
    <i class="bi bi-person-plus-fill logo-icon"></i>
    <h4 class="mt-2">Daftar ke <strong>Money Tracker</strong></h4>
  </div>

  <?php
    // Blok untuk menampilkan notifikasi dari session
    if (isset($_SESSION['notif'])) {
        $notif = $_SESSION['notif'];
        echo "<div class='alert alert-{$notif['tipe']}'>{$notif['pesan']}</div>";
        unset($_SESSION['notif']);
    }
  ?>

  <form action="proses_register.php" method="POST">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" placeholder="Buat username unik" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
    </div>
    <button class="btn btn-success w-100" type="submit">Daftar</button>
  </form>

  <p class="mt-4 text-center">Sudah punya akun? <a href="login.php">Login</a></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>