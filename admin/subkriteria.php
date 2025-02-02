<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $sql = "DELETE FROM tbl_subkriteria WHERE id_subkriteria='$_GET[id_subkriteria]'";
        $stm = $conn->query($sql);
        header("location:subkriteria.php?id_kriteria=$_GET[id_kriteria]");
    }
}
include "header.php";

$query = "SELECT * FROM tbl_kriteria WHERE id_kriteria='$_GET[id_kriteria]'";
$st = $conn->query($query);
$data = $st->fetch_assoc();
?>

<h2 class="mb-4">Subkriteria /
    <a href="kriteria.php"><?= $data['nama_kriteria'] ?></a>
</h2>
<hr>
<a href="subkriteria-simpan.php?id_kriteria=<?= $_GET['id_kriteria'] ?>" class="btn btn-primary mb-4"><i
        class='bx bx-plus mr-3'></i> Tambah Data</a>

<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Nama Subkriteria</th>
        <th class="text-center">Nilai Subkriteria</th>
        <th class="text-center">Aksi</th>
    </tr>
    <?php
    $sql = "SELECT * FROM tbl_subkriteria WHERE id_kriteria='$_GET[id_kriteria]' ORDER BY id_subkriteria";
    $stm = $conn->query($sql);
    $no = 1;
    while ($a = $stm->fetch_assoc()) {
    ?>
    <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td class="text-center"><?= $a['nama_subkriteria'] ?></td>
        <td class="text-center"><?= $a['nilai_subkriteria'] ?></td>

        <td class=" text-center">
            <a href="subkriteria-ubah.php?id_kriteria=<?= $a['id_kriteria'] ?>&id_subkriteria=<?= $a['id_subkriteria'] ?>"
                class="btn btn-success"><i class='bx bx-edit-alt'></i></a>
            <a href="subkriteria.php?id_kriteria=<?= $a['id_kriteria'] ?>&id_subkriteria=<?= $a['id_subkriteria'] ?>&aksi=hapus"
                class="btn btn-danger"><i class='bx bx-trash'></i></a>
        </td>
    </tr>

    <?php } ?>
</table>
</div>
</div>