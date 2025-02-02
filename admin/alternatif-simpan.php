<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'simpan') {
        $nama_alternatif = $_POST['nama_alternatif'];
        $jenis_hama = $_POST['jenis_hama'];
        $bentuk_pestisida = $_POST['bentuk_pestisida'];
        $warna_pestisida = $_POST['warna_pestisida'];

        $sql = "INSERT INTO tbl_alternatif 
                (nama_alternatif, jenis_hama, bentuk_pestisida, warna_pestisida)
                VALUES 
                ('$nama_alternatif', '$jenis_hama', '$bentuk_pestisida', '$warna_pestisida')";
        $row = $conn->query($sql);
        header("location:alternatif.php");
    }
}
include "header.php"; 
?>

<h2 class="mb-4">Tambah Data</h2>
<hr>

<form action="alternatif-simpan.php?aksi=simpan" method="post">
    <div class="form-group">
        <label>Nama Alternatif</label>
        <input type="text" name="nama_alternatif" class="form-control">
    </div>
    <div class="form-group">
        <label>Jenis Hama</label>
        <input type="text" name="jenis_hama" class="form-control">
    </div>
    <div class="form-group">
        <label>Bentuk Pestisida</label>
        <input type="text" name="bentuk_pestisida" class="form-control">
    </div>
    <div class="form-group">
        <label>Warna Pestisida</label>
        <input type="text" name="warna_pestisida" class="form-control">
    </div>
    <hr>
    <input type="submit" value="Simpan" class="btn btn-primary">
    <a href="alternatif.php" class="btn badge-secondary">Batal</a>
</form>
</div>
</div>
