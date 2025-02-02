<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'ubah') {
        $id_subkriteria = $_POST['id_subkriteria'];
        $id_kriteria = $_POST['id_kriteria'];
        $nama_subkriteria = $_POST['nama_subkriteria'];
        $nilai_subkriteria = $_POST['nilai_subkriteria'];
        $sql = "UPDATE tbl_subkriteria SET id_kriteria='$id_kriteria', nama_subkriteria='$nama_subkriteria', nilai_subkriteria='$nilai_subkriteria' WHERE id_subkriteria='$id_subkriteria'";
        $row = $conn->query($sql);
        header("location:subkriteria.php?id_kriteria=$id_kriteria");
    }
}
include "header.php"; ?>
<h2 class="mb-4">Ubah Data</h2>
<hr>
<?php
$sql = "SELECT * FROM tbl_subkriteria WHERE id_subkriteria='$_GET[id_subkriteria]'";
$stm = $conn->query($sql);
$a = $stm->fetch_assoc(); ?>
<form action="subkriteria-ubah.php?aksi=ubah" method="post">
    <input type="hidden" name="id_subkriteria" value="<?= $a['id_subkriteria'] ?>">
    <input type="hidden" name="id_kriteria" value="<?= $_GET['id_kriteria'] ?>">
    <div class="form-group">
        <label>Nama Subkriteria</label>
        <input type="text" name="nama_subkriteria" class="form-control" value="<?= $a['nama_subkriteria'] ?>">
    </div>

    <div class="form-group">
        <label>Nilai Subkriteria</label>
        <input type="number" name="nilai_subkriteria" class="form-control" value="<?= $a['nilai_subkriteria'] ?>">
    </div>
    <hr>
    <input type="submit" value="Ubah" class="btn btn-primary">
    <a href="subkriteria.php?id_kriteria=<?= $_GET['id_kriteria'] ?>" class="btn badge-secondary">Batal</a>
</form>
</div>
</div>