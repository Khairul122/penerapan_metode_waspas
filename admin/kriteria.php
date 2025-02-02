<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $sql = "DELETE FROM tbl_kriteria WHERE id_kriteria='$_GET[id_kriteria]'";
        $stm = $conn->query($sql);
        header("location:kriteria.php");
    }
}
include "header.php";
?>

<h2 class="mb-4">Kriteria</h2>
<hr>
<a href="kriteria-simpan.php" class="btn btn-primary mb-4"><i class='bx bx-plus mr-3'></i> Tambah Data</a>

<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Nama Kriteria</th>
        <th class="text-center">Bobot</th>
        <th class="text-center">Tipe</th>
        <th class="text-center">Subkriteria</th>
        <th class="text-center">Aksi</th>
    </tr>
    <?php
    $sql = "SELECT * FROM tbl_kriteria ORDER BY id_kriteria";
    $stm = $conn->query($sql);
    $no = 1;
    while ($a = $stm->fetch_assoc()) {
    ?>
    <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td class="text-center"><?= $a['nama_kriteria'] ?></td>
        <td class="text-center"><?= $a['bobot_kriteria'] ?></td>
        <td class="text-center"><?= $a['tipe_kriteria'] ?></td>
        <td class=" text-center">
            <a href="subkriteria.php?id_kriteria=<?= $a['id_kriteria'] ?>" class="btn btn-secondary"><i
                    class='bx bx-plus'></i></a>
        </td>
        <td class=" text-center">
            <a href="kriteria-ubah.php?id_kriteria=<?= $a['id_kriteria'] ?>" class="btn btn-success"><i
                    class='bx bx-edit-alt'></i></a>
            <a href="kriteria.php?id_kriteria=<?= $a['id_kriteria'] ?>&aksi=hapus" class="btn btn-danger"><i
                    class='bx bx-trash'></i></a>
        </td>
    </tr>

    <?php } ?>
</table>
</div>
</div>