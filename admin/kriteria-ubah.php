<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'ubah') {
        $id_kriteria = $_POST['id_kriteria'];
        $nama_kriteria = $_POST['nama_kriteria'];
        $bobot_kriteria = $_POST['bobot_kriteria'];
        $tipe_kriteria = $_POST['tipe_kriteria'];
        $sql = "UPDATE tbl_kriteria SET nama_kriteria='$nama_kriteria', bobot_kriteria='$bobot_kriteria', tipe_kriteria='$tipe_kriteria' WHERE id_kriteria='$id_kriteria'";
        $row = $conn->query($sql);
        header("location:kriteria.php");
    }
}
include "header.php"; ?>
<h2 class="mb-4">Ubah Data</h2>
<hr>
<?php
$sql = "SELECT * FROM tbl_kriteria WHERE id_kriteria='$_GET[id_kriteria]'";
$stm = $conn->query($sql);
$a = $stm->fetch_assoc(); ?>
<form action="kriteria-ubah.php?aksi=ubah" method="post">
    <input type="hidden" name="id_kriteria" value="<?= $a['id_kriteria'] ?>">
    <div class="form-group">
        <label>Nama Kriteria</label>
        <input type="text" name="nama_kriteria" class="form-control" value="<?= $a['nama_kriteria'] ?>">
    </div>

    <div class="form-group">
        <label>Bobot Kriteria</label>
        <input type="number" name="bobot_kriteria" class="form-control" value="<?= $a['bobot_kriteria'] ?>">
    </div>

    <div class="form-group">
        <label>Tipe Kriteria</label>
        <select name="tipe_kriteria" class="form-control">
            <option selected><?= $a['tipe_kriteria'] ?></option>
            <option>Benefit</option>
            <option>Cost</option>
        </select>
    </div>
    <hr>
    <input type="submit" value="Ubah" class="btn btn-primary">
    <a href="kriteria.php" class="btn badge-secondary">Batal</a>
</form>
</div>
</div>