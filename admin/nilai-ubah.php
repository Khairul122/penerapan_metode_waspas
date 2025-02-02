<?php
include "../assets/conn/config.php";

$id_alternatif = "";
$nilaiAlternatif = [];

// Pastikan ada parameter 'id_alternatif' untuk mode edit
if (isset($_GET['id_alternatif'])) {
    $id_alternatif = $_GET['id_alternatif'];

    // Ambil nilai alternatif yang ada di database
    $queryNilai = "SELECT id_kriteria, nilai_alternatif FROM tbl_nilai WHERE id_alternatif='$id_alternatif'";
    $resultNilai = $conn->query($queryNilai);

    while ($row = $resultNilai->fetch_assoc()) {
        $nilaiAlternatif[$row['id_kriteria']] = $row['nilai_alternatif'];
    }
}

include "header.php";
?>

<h2 class="mb-4">Edit Data</h2>

<form action="proses-ubah-nilai.php?aksi=ubah" method="post">
    <input type="hidden" name="id_alternatif" value="<?= $id_alternatif ?>">

    <div class="form-group">
        <label>Nama Alternatif</label>
        <select name="id_alternatif" class="form-control" required>
            <option selected disabled>Pilih</option>
            <?php
            $data = "SELECT * FROM tbl_alternatif ORDER BY id_alternatif";
            $a = $conn->query($data);
            while ($dt = $a->fetch_assoc()) {
                $selected = ($dt['id_alternatif'] == $id_alternatif) ? "selected" : "";
                echo "<option value='$dt[id_alternatif]' $selected>$dt[nama_alternatif]</option>";
            } ?>
        </select>
    </div>

    <?php
    // Ambil daftar kriteria
    $dkr = "SELECT * FROM tbl_kriteria ORDER BY id_kriteria";
    $b = $conn->query($dkr);
    
    while ($k = $b->fetch_assoc()) {
        $idK = $k['id_kriteria'];
        $nmK = $k['nama_kriteria'];
        $nilai = isset($nilaiAlternatif[$idK]) ? $nilaiAlternatif[$idK] : ""; // Ambil nilai dari database jika ada
        
        echo "
        <div class='form-group'>
            <label>$nmK</label>
            <input type='number' class='form-control mb-3' id='input_$idK' name='$idK' value='$nilai' oninput='updateNilaiKriteria($idK)'>
        
            <label>Nilai Kriteria</label>
            <input type='number' class='form-control mb-3' id='nilai_$idK' name='nilai_kriteria_$idK' readonly>
        </div>";
    }
    ?>

    <hr>
    <input type="submit" value="Simpan Perubahan" class="btn btn-primary">
    <a href="nilai.php" class="btn btn-secondary">Batal</a>
</form>

<script>
    // Data subkriteria dalam format JavaScript
    const subkriteriaData = {
        1: [
            { min: 30000, max: 50000, nilai: 1 },
            { min: 50000, max: 100000, nilai: 2 },
            { min: 100000, max: 149000, nilai: 3 },
            { min: 150000, max: Infinity, nilai: 4 }
        ],
        2: [
            { min: 500, max: 1000, nilai: 1 },
            { min: 250, max: 449, nilai: 2 },
            { min: 100, max: 249, nilai: 3 }
        ],
        3: [
            { min: 6, max: 11, nilai: 1 },
            { min: 2, max: 5, nilai: 2 },
            { min: 0.5, max: 1, nilai: 3 }
        ],
        4: [
            { min: 5, max: 5, nilai: 1 },
            { min: 4, max: 4, nilai: 2 },
            { min: 3, max: 3, nilai: 3 },
            { min: 2, max: 2, nilai: 4 }
        ],
        5: [
            { min: 10000, max: 10000, nilai: 1 },
            { min: 5000, max: 5000, nilai: 2 }
        ]
    };

    function updateNilaiKriteria(idKriteria) {
        let inputValue = parseFloat(document.getElementById(`input_${idKriteria}`).value) || 0;
        let nilaiField = document.getElementById(`nilai_${idKriteria}`);
        nilaiField.value = ""; // Kosongkan nilai sebelum pengecekan

        if (subkriteriaData[idKriteria]) {
            for (let sub of subkriteriaData[idKriteria]) {
                if (inputValue >= sub.min && inputValue <= sub.max) {
                    nilaiField.value = sub.nilai; // Set nilai yang sesuai
                    break;
                }
            }
        }
    }
</script>

