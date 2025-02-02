<?php
include '../assets/conn/config.php'; 

// Pastikan tabel 'tbl_kepala' ada di database Anda
$sql = "SELECT * FROM tbl_kepala WHERE id_kepala = 1"; // Pastikan nama tabel sesuai
$result = $conn->query($sql);

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $kepaladinas = $result->fetch_assoc();
} else {
    die("Data kepala dinas tidak ditemukan.");
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_kepala = $_POST['nama_kepala'];
    $jabatan = $_POST['jabatan'];
    $nip = $_POST['nip'];
    
    // Query untuk update data kepala dinas
    $sql_update = "UPDATE tbl_kepala 
                   SET nama_kepala = ?, jabatan = ?, nip = ?
                   WHERE id_kepala = 1"; // Pastikan id_kepala sesuai dengan data yang Anda ubah
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sss", $nama_kepala, $jabatan, $nip); // Perbaikan pada bind_param

    if ($stmt->execute()) {
        echo "<p>Data berhasil diperbarui.</p>";
    } else {
        echo "<p>Terjadi kesalahan: " . $conn->error . "</p>";
    }

    // Reload data setelah update
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

include 'header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nama Kepala Dinas</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Ganti dengan path CSS Bootstrap -->
</head>
<body>
<div class="container">
    <h2>Edit Nama Kepala Dinas</h2>
    <form method="POST">
        <div class="form-group">
            <label for="nama_lengkap">Nama Kepala</label>
            <input type="text" id="nama_kepala" name="nama_kepala" class="form-control" value="<?= htmlspecialchars($kepaladinas['nama_kepala']) ?>" required>
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" id="jabatan" name="jabatan" class="form-control" value="<?= htmlspecialchars($kepaladinas['jabatan']) ?>" required>
        </div>
        <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" id="nip" name="nip" class="form-control" value="<?= htmlspecialchars($kepaladinas['nip']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>