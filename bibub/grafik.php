<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT MONTH(tanggal) as bulan, SUM(CASE WHEN type='Pemasukan' THEN amount ELSE 0 END) as pemasukan,
                  SUM(CASE WHEN type='Pengeluaran' THEN amount ELSE 0 END) as pengeluaran
            FROM transactions
            WHERE user_id = $user_id
            GROUP BY MONTH(tanggal)
            ORDER BY bulan";

$result = mysqli_query($conn, $query);

$bulan = [];
$pemasukan = [];
$pengeluaran = [];

while ($row = mysqli_fetch_assoc($result)) {
  $bulan[] = date('F', mktime(0, 0, 0, $row['bulan'], 10));
  $pemasukan[] = $row['pemasukan'];
  $pengeluaran[] = $row['pengeluaran'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Grafik - Simple Money Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h3>Grafik Pemasukan vs Pengeluaran</h3>
  <canvas id="grafikTransaksi" height="120"></canvas>
</div>
<script>
const ctx = document.getElementById('grafikTransaksi').getContext('2d');
const chart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?php echo json_encode($bulan); ?>,
    datasets: [
      {
        label: 'Pemasukan',
        data: <?php echo json_encode($pemasukan); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.7)'
      },
      {
        label: 'Pengeluaran',
        data: <?php echo json_encode($pengeluaran); ?>,
        backgroundColor: 'rgba(255, 99, 132, 0.7)'
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'top' },
      title: {
        display: true,
        text: 'Ringkasan Bulanan'
      }
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
</script>
</body>
</html>