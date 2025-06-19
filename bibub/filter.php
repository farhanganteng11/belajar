<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
include 'koneksi.php';

$user_id = $_SESSION['user_id'];
$filtered = false;
$filter_result = [];

if (isset($_POST['filter'])) {
  $bulan = $_POST['bulan'];
  $tahun = $_POST['tahun'];

  $query = "SELECT * FROM transactions 
            WHERE user_id = $user_id 
            AND MONTH(tanggal) = $bulan 
            AND YEAR(tanggal) = $tahun 
            ORDER BY tanggal DESC";
  $result = mysqli_query($conn, $query);
  $filter_result = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $filtered = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Filter Transaksi - Simple Money Tracker</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h3>Filter Transaksi Berdasarkan Bulan & Tahun</h3>
  
  <form method="POST" class="row g-3 mt-3 mb-4">
    <div class="col-md-3">
      <label for="bulan" class="form-label">Bulan</label>
      <select name="bulan" id="bulan" class="form-select" required>
        <option value="">Pilih Bulan</option>
        <?php
        for ($i = 1; $i <= 12; $i++) {
          $selected = (isset($bulan) && $bulan == $i) ? 'selected' : '';
          echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
        }
        ?>
      </select>
    </div>
    <div class="col-md-3">
      <label for="tahun" class="form-label">Tahun</label>
      <input type="number" name="tahun" id="tahun" class="form-control" min="2000" max="2100" value="<?= $tahun ?? date('Y') ?>" required>
    </div>
    <div class="col-md-2 align-self-end">
      <button type="submit" name="filter" class="btn btn-primary">Tampilkan</button>
    </div>
  </form>

  <?php if ($filtered): ?>
    <h5>Hasil Filter: <?= date('F', mktime(0, 0, 0, $bulan, 10)) . " $tahun" ?></h5>
    <table class="table table-bordered table-striped mt-3">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Jenis</th>
          <th>Nominal</th>
          <th>Kategori</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (count($filter_result) > 0) {
          $no = 1;
          foreach ($filter_result as $row) {
            echo "<tr>
                    <td>$no</td>
                    <td>{$row['type']}</td>
                    <td>Rp " . number_format($row['amount'], 0, ',', '.') . "</td>
                    <td>{$row['kategori']}</td>
                    <td>{$row['tanggal']}</td>
                  </tr>";
            $no++;
          }
        } else {
          echo "<tr><td colspan='5' class='text-center'>Tidak ada transaksi di bulan ini</td></tr>";
        }
        ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
