<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'simpan') {
        $id_kriteria = $_POST['id_kriteria'];
        $nama_subkriteria = $_POST['nama_subkriteria'];
        $nilai_subkriteria = $_POST['nilai_subkriteria'];
        $sql = "INSERT INTO tbl_subkriteria (id_kriteria,nama_subkriteria,nilai_subkriteria)VALUES('$id_kriteria','$nama_subkriteria','$nilai_subkriteria')";
        $row = $conn->query($sql);
        header("location:subkriteria.php?id_kriteria=$id_kriteria");
    }
}
include "header.php"; ?>
<h2 class="mb-4">Tambah Data</h2>
<hr>

<form action="subkriteria-simpan.php?aksi=simpan" method="post">
    <input type="hidden" name="id_kriteria" value="<?= $_GET['id_kriteria'] ?>">
    <div class="form-group">
        <label>Nama Subkriteria</label>
        <input type="text" name="nama_subkriteria" class="form-control">
    </div>

    <div class="form-group">
        <label>Nilai Subkriteria</label>
        <input type="number" name="nilai_subkriteria" class="form-control">
    </div>
    <hr>
    <input type="submit" value="Simpan" class="btn btn-primary">
    <a href="subkriteria.php?id_kriteria=<?= $_GET['id_kriteria'] ?>" class="btn badge-secondary">Batal</a>
</form>
</div>
</div>