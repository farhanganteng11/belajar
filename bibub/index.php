<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

include 'koneksi.php';

// Ambil total pemasukan, pengeluaran, dan saldo
$user_id = $_SESSION['user_id'];

$query_in = "SELECT SUM(amount) as pemasukan FROM transactions WHERE user_id = $user_id AND type = 'Pemasukan'";
$query_out = "SELECT SUM(amount) as pengeluaran FROM transactions WHERE user_id = $user_id AND type = 'Pengeluaran'";

$result_in = mysqli_query($conn, $query_in);
$result_out = mysqli_query($conn, $query_out);

$total_in = mysqli_fetch_assoc($result_in)['pemasukan'] ?? 0;
$total_out = mysqli_fetch_assoc($result_out)['pengeluaran'] ?? 0;
$saldo = $total_in - $total_out;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Simple Money Tracker</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>
<?php
include 'sidebar.php';
?>

  <div class="main-content">
    <h2>Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</h2>
    <p>Berikut ringkasan keuangan pribadi kamu:</p>

    <div class="row mt-4">
      <div class="col-md-4 mb-3">
        <div class="card card-summary bg-light border-success">
          <div class="card-body">
            <h5>Total Pemasukan</h5>
            <h3 class="text-success">Rp <?= number_format($total_in, 0, ',', '.') ?></h3>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="card card-summary bg-light border-danger">
          <div class="card-body">
            <h5>Total Pengeluaran</h5>
            <h3 class="text-danger">Rp <?= number_format($total_out, 0, ',', '.') ?></h3>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="card card-summary bg-light border-primary">
          <div class="card-body">
            <h5>Saldo Saat Ini</h5>
            <h3 class="text-primary">Rp <?= number_format($saldo, 0, ',', '.') ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>