<?php
include "../assets/conn/config.php";

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'ubah') {
        // Mengambil data dari form
        $id_alternatif = $conn->real_escape_string($_POST['id_alternatif']);
        $nama_alternatif = $conn->real_escape_string($_POST['nama_alternatif']);
        $jenis_hama = $conn->real_escape_string($_POST['jenis_hama']);
        $bentuk_pestisida = $conn->real_escape_string($_POST['bentuk_pestisida']);
        $warna_pestisida = $conn->real_escape_string($_POST['warna_pestisida']);

        // Query untuk update data
        $sql = "UPDATE tbl_alternatif 
                SET 
                    nama_alternatif = '$nama_alternatif', 
                    jenis_hama = '$jenis_hama', 
                    bentuk_pestisida = '$bentuk_pestisida', 
                    warna_pestisida = '$warna_pestisida'
                WHERE id_alternatif = '$id_alternatif'";

        if ($conn->query($sql) === TRUE) {
            // Redirect jika berhasil
            header("Location: alternatif.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

include "header.php"; 
?>

<h2 class="mb-4">Ubah Data</h2>
<hr>

<?php
// Mendapatkan data berdasarkan ID
$id_alternatif = $conn->real_escape_string($_GET['id_alternatif']);
$sql = "SELECT * FROM tbl_alternatif WHERE id_alternatif='$id_alternatif'";
$stm = $conn->query($sql);
$a = $stm->fetch_assoc();
?>

<form action="alternatif-ubah.php?aksi=ubah" method="post">
    <input type="hidden" name="id_alternatif" value="<?= htmlspecialchars($a['id_alternatif']) ?>">
    <div class="form-group">
        <label>Nama Alternatif</label>
        <input type="text" name="nama_alternatif" class="form-control" value="<?= htmlspecialchars($a['nama_alternatif']) ?>" required>
    </div>
    <div class="form-group">
        <label>Jenis Hama</label>
        <input type="text" name="jenis_hama" class="form-control" value="<?= htmlspecialchars($a['jenis_hama']) ?>" required>
    </div>
    <div class="form-group">
        <label>Bentuk Pestisida</label>
        <input type="text" name="bentuk_pestisida" class="form-control" value="<?= htmlspecialchars($a['bentuk_pestisida']) ?>" required>
    </div>
    <div class="form-group">
        <label>Warna Pestisida</label>
        <input type="text" name="warna_pestisida" class="form-control" value="<?= htmlspecialchars($a['warna_pestisida']) ?>" required>
    </div>
    <hr>
    <input type="submit" value="Ubah" class="btn btn-primary">
    <a href="alternatif.php" class="btn btn-secondary">Batal</a>
</form>
</div>
</div>