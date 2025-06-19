<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Mengambil data input lama jika ada (untuk sticky form saat error)
$form_input = $_SESSION['form_input'] ?? [];
unset($_SESSION['form_input']);

// Proses Simpan Transaksi
if (isset($_POST['simpan'])) {
  $user_id = $_SESSION['user_id'];
  $type = mysqli_real_escape_string($conn, $_POST['jenis']);
  $amount = (int)$_POST['nominal'];
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
  $tanggal = $_POST['tanggal'];

  if ($amount <= 0) {
    $_SESSION['notif'] = [
        'pesan' => 'Nominal harus angka positif dan tidak boleh nol.',
        'tipe' => 'danger'
    ];
    // Simpan input pengguna untuk mengisi kembali form
    $_SESSION['form_input'] = $_POST;
    header("Location: tambah_transaksi.php");
    exit();
  }

  $query = "INSERT INTO transactions (user_id, type, amount, kategori, tanggal)
            VALUES ('$user_id', '$type', '$amount', '$kategori', '$tanggal')";

  if (mysqli_query($conn, $query)) {
    $_SESSION['notif'] = [
        'pesan' => 'Transaksi berhasil disimpan',
        'tipe'  => 'success'
    ];
    header("Location: daftar_transaksi.php");
    exit();
  } else {
    $_SESSION['notif'] = [
        'pesan' => 'Gagal menyimpan data ke database.',
        'tipe'  => 'danger'
    ];
    $_SESSION['form_input'] = $_POST;
    header("Location: tambah_transaksi.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Transaksi - Money Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <div class="container">
    <h3 class="mb-4">Tambah Transaksi</h3>

    <?php
    // Blok untuk menampilkan notifikasi dari session
    if (isset($_SESSION['notif'])) {
        $notif = $_SESSION['notif'];
        echo "<div class='alert alert-{$notif['tipe']} alert-dismissible fade show' role='alert'>
                {$notif['pesan']}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        unset($_SESSION['notif']);
    }
    ?>

    <form method="POST" class="card p-4 shadow-sm bg-white">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="jenis" class="form-label">Jenis Transaksi</label>
          <select name="jenis" id="jenis" class="form-select" required>
            <option value="Pemasukan" <?= ($form_input['jenis'] ?? '') == 'Pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
            <option value="Pengeluaran" <?= ($form_input['jenis'] ?? '') == 'Pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label for="nominal" class="form-label">Nominal</label>
          <input type="number" name="nominal" id="nominal" class="form-control" min="1" value="<?= htmlspecialchars($form_input['nominal'] ?? '') ?>" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="kategori" class="form-label">Kategori</label>
          <input type="text" name="kategori" id="kategori" class="form-control" value="<?= htmlspecialchars($form_input['kategori'] ?? '') ?>" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="tanggal" class="form-label">Tanggal</label>
          <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= htmlspecialchars($form_input['tanggal'] ?? '') ?>" required>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-3 gap-2">
        <a href="index.php" class="btn btn-secondary">
          <i class="mdi mdi-arrow-left"></i>
        </a>
        <button type="submit" name="simpan" class="btn btn-primary">
          <i class="mdi mdi-content-save"></i>
        </button>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>