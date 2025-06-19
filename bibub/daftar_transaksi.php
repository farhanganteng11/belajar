<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
include 'koneksi.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM transactions WHERE user_id = $user_id ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Transaksi - Simple Money Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <div class="container">
    <h3 class="mb-4">Daftar Transaksi</h3>

    <?php
    if (isset($_SESSION['notif'])) {
        $notif = $_SESSION['notif'];
        echo "<div class='alert alert-{$notif['tipe']} alert-dismissible fade show' role='alert'>
                {$notif['pesan']}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        unset($_SESSION['notif']);
    }
    ?>

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Nominal</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['type']}</td>
                    <td>Rp " . number_format($row['amount'], 0, ',', '.') . "</td>
                    <td>" . htmlspecialchars($row['kategori']) . "</td>
                    <td>{$row['tanggal']}</td>
                    <td class='d-flex gap-2'>
                      <a href='edit_transaksi.php?id={$row['id']}' 
                          class='btn btn-sm btn-warning'>
                          <i class='mdi mdi-pencil'></i>
                      </a>
                      <a href='hapus_transaksi.php?id={$row['id']}' 
                          class='btn btn-sm btn-danger' 
                          onclick=\"return confirm('Yakin ingin menghapus transaksi ini?')\">
                          <i class='mdi mdi-delete'></i>
                      </a>
                    </td>
                  </tr>";
            $no++;
          }

          if (mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='6' class='text-center'>Belum ada transaksi</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>