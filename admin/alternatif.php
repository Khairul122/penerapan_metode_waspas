<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $sql = "DELETE FROM tbl_alternatif WHERE id_alternatif='$_GET[id_alternatif]'";
        $stm = $conn->query($sql);
        header("location:alternatif.php");
    }
}
include "header.php";
?>
<b>
    Pasaman, 30 Januari 2025
</b>
<h2 class="mb-4">Alternatif</h2>
<hr>
<a href="alternatif-simpan.php" class="btn btn-primary mb-4"><i class='bx bx-plus mr-3'></i> Tambah Data</a>

<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">ID Alternatif</th> <!-- Menambahkan kolom ID Alternatif -->
        <th class="text-center">Nama Alternatif</th>
        <th class="text-center">Jenis Hama</th>
        <th class="text-center">Bentuk Pestisida</th>
        <th class="text-center">Warna Pestisida</th>
        <th class="text-center">Aksi</th>
    </tr>
    <?php
    $sql = "SELECT * FROM tbl_alternatif ORDER BY id_alternatif";
    $stm = $conn->query($sql);
    $no = 1;
    while ($a = $stm->fetch_assoc()) {
    ?>
    <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td class="text-center">A<?= $a['id_alternatif'] ?></td> 
        <td class="text-center"><?= $a['nama_alternatif'] ?></td>
        <td class="text-center"><?= $a['jenis_hama'] ?></td>
        <td class="text-center"><?= $a['bentuk_pestisida'] ?></td>
        <td class="text-center"><?= $a['warna_pestisida'] ?></td>
        <td class="text-center">
            <a href="alternatif-ubah.php?id_alternatif=<?= $a['id_alternatif'] ?>" class="btn btn-success">
                <i class='bx bx-edit-alt'></i> Edit
            </a>
            <a href="alternatif.php?id_alternatif=<?= $a['id_alternatif'] ?>&aksi=hapus" class="btn btn-danger">
                <i class='bx bx-trash'></i> Hapus
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
</div>
</div>
