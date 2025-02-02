<?php
include "../assets/conn/config.php";

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $sql = "DELETE FROM tbl_nilai WHERE id_alternatif='$_GET[id_alternatif]'";
    $conn->query($sql);
    header("location:nilai.php");
}

include "header.php";
?>

<?php
setlocale(LC_TIME, 'id_ID.utf8', 'Indonesian_indonesia');
$tanggalSekarang = date('d F Y');
?>

<b>Pasaman, <?php echo $tanggalSekarang; ?></b>

<h2 class="mb-4">Nilai</h2>
<hr>

<a href="nilai-simpan.php" class="btn btn-primary mb-4"><i class='bx bx-plus mr-3'></i> Tambah Data</a>

<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">ID Alternatif</th> 
        <th class="text-center">Nama Alternatif</th>

        <?php
        // Ambil daftar kriteria
        $kriteriaList = [];
        $satuanList = [
            "Rp",        // Harga
            "ml/gr",     // Volume Racun/Ha
            "liter/kg",  // Ukuran Kemasan
            "tahun",     // Masa Kadaluarsa
            "m2"         // Luas Cakupan
        ];

        $kriteriaQuery = "SELECT id_kriteria, nama_kriteria FROM tbl_kriteria ORDER BY id_kriteria";
        $kriteriaResult = $conn->query($kriteriaQuery);
        $i = 0;
        while ($row = $kriteriaResult->fetch_assoc()) {
            $nama_kriteria = $row['nama_kriteria'];
            echo "<th class='text-center'>{$nama_kriteria}</th>";
            $kriteriaList[$row['id_kriteria']] = isset($satuanList[$i]) ? $satuanList[$i] : "";
            $i++;
        }
        ?>

        <th class="text-center">Tanggal</th>
        <th class="text-center">Aksi</th>
    </tr>

    <?php
    // Ambil semua alternatif
    $sql = "SELECT * FROM tbl_alternatif ORDER BY id_alternatif";
    $stm = $conn->query($sql);
    $no = 1;

    while ($a = $stm->fetch_assoc()) {
        $id_alternatif = $a['id_alternatif'];
        $nm_alternatif = $a['nama_alternatif'];
    ?>

    <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td class="text-center">A<?= $id_alternatif ?></td> 
        <td class="text-center"><?= $nm_alternatif ?></td>

        <?php
        // Ambil nilai dari tbl_nilai untuk alternatif ini
        $nilaiQuery = "SELECT id_kriteria, nilai_alternatif, tanggal 
                       FROM tbl_nilai 
                       WHERE id_alternatif = '$id_alternatif'";
        $nilaiResult = $conn->query($nilaiQuery);
        
        // Simpan nilai dalam array
        $nilaiData = [];
        while ($nilaiRow = $nilaiResult->fetch_assoc()) {
            $nilaiData[$nilaiRow['id_kriteria']] = $nilaiRow['nilai_alternatif'];
            $tanggal = $nilaiRow['tanggal'];
        }

        // Tampilkan nilai untuk setiap kriteria
        $i = 0;
        foreach ($kriteriaList as $id_kriteria => $satuan) {
            $nilai = isset($nilaiData[$id_kriteria]) ? $nilaiData[$id_kriteria] : "-";
            if ($nilai !== "-") {
                if ($satuan == "Rp") {
                    $nilaiFormatted = "Rp " . number_format($nilai, 0, ',', '.');
                } else {
                    $nilaiFormatted = number_format($nilai, 0, ',', '.') . " " . $satuan;
                }
            } else {
                $nilaiFormatted = "-";
            }
            echo "<td class='text-center'>$nilaiFormatted</td>";
            $i++;
        }

        echo "<td class='text-center'>$tanggal</td>";
        ?>

        <td class="text-center">
            <a href="nilai-ubah.php?id_alternatif=<?= $id_alternatif ?>" class="btn btn-success"><i class='bx bx-edit-alt'></i></a>
            <a href="nilai.php?id_alternatif=<?= $id_alternatif ?>&aksi=hapus" class="btn btn-danger"><i class='bx bx-trash'></i></a>
        </td>
    </tr>

    <?php } // End while ?>
</table>

</div>
</div>
