<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'simpan') {
        $nama_kriteria = $_POST['nama_kriteria'];
        $bobot_kriteria = $_POST['bobot_kriteria'];
        $tipe_kriteria = $_POST['tipe_kriteria'];
        $sql = "INSERT INTO tbl_kriteria (nama_kriteria,bobot_kriteria,tipe_kriteria)VALUES('$nama_kriteria','$bobot_kriteria','$tipe_kriteria')";
        $row = $conn->query($sql);
        header("location:kriteria.php");
    }
}
include "header.php"; ?>
<h2 class="mb-4">Tambah Data</h2>
<hr>

<form action="kriteria-simpan.php?aksi=simpan" method="post">
    <div class="form-group">
        <label>Nama Kriteria</label>
        <input type="text" name="nama_kriteria" class="form-control">
    </div>

    <div class="form-group">
        <label>Bobot Kriteria</label>
        <input type="number" name="bobot_kriteria" class="form-control">
    </div>

    <div class="form-group">
        <label>Tipe Kriteria</label>
        <select name="tipe_kriteria" class="form-control">
            <option>Benefit</option>
            <option>Cost</option>
        </select>
    </div>
    <hr>
    <input type="submit" value="Simpan" class="btn btn-primary">
    <a href="kriteria.php" class="btn badge-secondary">Batal</a>
</form>
</div>
</div>