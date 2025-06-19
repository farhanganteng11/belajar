<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
header("Location: login.php");
exit();
}

$user_id = $_SESSION['user_id'];
$transaksi_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error_message = '';
$transaksi_to_display = [];

// Ambil data asli dari database terlebih dahulu
if ($transaksi_id > 0) {
$query_select = "SELECT * FROM transactions WHERE id = $transaksi_id AND user_id = $user_id";
$result = mysqli_query($conn, $query_select);
if (mysqli_num_rows($result) == 1) {
    $transaksi_to_display = mysqli_fetch_assoc($result);
} else {
    $_SESSION['notif'] = ['pesan' => 'Transaksi tidak ditemukan', 'tipe' => 'warning'];
    header("Location: daftar_transaksi.php");
    exit();
}
} else {
    header("Location: daftar_transaksi.php");
    exit();
}

// Proses form jika disubmit (method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
$type = mysqli_real_escape_string($conn, $_POST['jenis']);
$amount = (int)$_POST['nominal'];
$kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
$tanggal = $_POST['tanggal'];

if ($amount <= 0) {
    $error_message = 'Nominal harus angka positif dan tidak boleh nol.';
    $transaksi_to_display = $_POST;
    $transaksi_to_display['type'] = $_POST['jenis']; 
} else {
    $query_update = "UPDATE transactions 
                    SET type = '$type', amount = '$amount', kategori = '$kategori', tanggal = '$tanggal'
                    WHERE id = $transaksi_id AND user_id = $user_id";

    if (mysqli_query($conn, $query_update)) {
    $_SESSION['notif'] = ['pesan' => 'Transaksi berhasil diperbarui', 'tipe' => 'success'];
    header("Location: daftar_transaksi.php");
    exit();
    } else {
    $error_message = 'Gagal memperbarui data ke database.';
    $transaksi_to_display = $_POST;
    $transaksi_to_display['type'] = $_POST['jenis'];
    }
}
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Transaksi - Money Tracker</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
<div class="container">
    <h3 class="mb-4">Edit Transaksi</h3>

    <?php
    if (!empty($error_message)) {
        echo "<div class='alert alert-danger'>{$error_message}</div>";
    }
    ?>

    <form method="POST" action="edit_transaksi.php?id=<?= $transaksi_id; ?>" class="card p-4 shadow-sm bg-white">
    <div class="row">
        <div class="col-md-6 mb-3">
        <label for="jenis" class="form-label">Jenis Transaksi</label>
        <select name="jenis" id="jenis" class="form-select" required>
            <option value="Pemasukan" <?= ($transaksi_to_display['type'] == 'Pemasukan') ? 'selected' : ''; ?>>Pemasukan</option>
            <option value="Pengeluaran" <?= ($transaksi_to_display['type'] == 'Pengeluaran') ? 'selected' : ''; ?>>Pengeluaran</option>
        </select>
        </div>

        <div class="col-md-6 mb-3">
        <label for="nominal" class="form-label">Nominal</label>
        <input type="number" name="nominal" id="nominal" class="form-control" min="1" value="<?= htmlspecialchars($transaksi_to_display['amount'] ?? $transaksi_to_display['nominal']); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <input type="text" name="kategori" id="kategori" class="form-control" value="<?= htmlspecialchars($transaksi_to_display['kategori']); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= htmlspecialchars($transaksi_to_display['tanggal']); ?>" required>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3 gap-2">
        <a href="daftar_transaksi.php" class="btn btn-secondary">Batal</a>
        <button type="submit" name="update" class="btn btn-primary">
        Simpan Perubahan
        </button>
    </div>
    </form>
</div>
</div>

</body>
</html>