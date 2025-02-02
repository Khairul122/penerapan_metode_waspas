<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi']) && $_GET['aksi'] == 'simpan') {
    $id_alternatif = $_POST['id_alternatif'];

    $dkr = "SELECT * FROM tbl_kriteria ORDER BY id_kriteria";
    $k = $conn->query($dkr);
    while ($dk = $k->fetch_assoc()) {
        $idK = $dk['id_kriteria'];
        $nilai_alternatif = intval($_POST[$idK]); // Pastikan nilai dalam bentuk integer
        $nilai_subkriteria = intval($_POST['nilai_kriteria_' . $idK]);

        // Cari id_subkriteria berdasarkan nilai subkriteria
        $query_subkriteria = "SELECT id_subkriteria FROM tbl_subkriteria 
                              WHERE id_kriteria = '$idK' AND nilai_subkriteria = '$nilai_subkriteria'
                              LIMIT 1";
        $result_subkriteria = $conn->query($query_subkriteria);
        $row_subkriteria = $result_subkriteria->fetch_assoc();
        $id_subkriteria = $row_subkriteria ? $row_subkriteria['id_subkriteria'] : null;

        if ($id_subkriteria) {
            $sql = "INSERT INTO tbl_nilai (id_alternatif, id_kriteria, id_subkriteria, nilai_alternatif, nilai_subkriteria) 
                    VALUES ('$id_alternatif', '$idK', '$id_subkriteria', '$nilai_alternatif', '$nilai_subkriteria')";
            $conn->query($sql);
        }
    }

    header("location:nilai.php");
}

include "header.php"; ?>
<h2 class="mb-4">Tambah Data</h2>
<?php
setlocale(LC_TIME, 'id_ID.utf8', 'Indonesian_indonesia'); // Mengatur lokal ke bahasa Indonesia
echo "<b>Pasaman, " . strftime('%d %B %Y') . "</b>";
?>

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
        ],
        9: [
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


<hr>

<form action="nilai-simpan.php?aksi=simpan" method="post">
    <div class="form-group">
        <label>Nama Alternatif</label>
        <select name="id_alternatif" class="form-control">
            <option selected disabled>Pilih</option>
            <?php
            $data = "SELECT * FROM tbl_alternatif ORDER BY id_alternatif";
            $a = $conn->query($data);
            $no = 1;
            while ($dt = $a->fetch_assoc()) {
                echo "<option value='$dt[id_alternatif]'>$no - $dt[nama_alternatif]</option>";
                $no++;
            } ?>
        </select>
    </div>

    <?php
    $dkr = "SELECT * FROM tbl_kriteria ORDER BY id_kriteria";
    $b = $conn->query($dkr);
    while ($k = $b->fetch_assoc()) {
        $idK = $k['id_kriteria'];
        $nmK = $k['nama_kriteria'];
        
        echo "
        <div class='form-group'>
            <label>$nmK</label>
            <input type='number' class='form-control mb-3' id='input_$idK' name='$idK' oninput='updateNilaiKriteria($idK)'>
        
            <label>Nilai Kriteria</label>
            <input type='number' class='form-control mb-3' id='nilai_$idK' name='nilai_kriteria_$idK' readonly>
        </div>";
    }
    ?>
    
    <hr>
    <input type="submit" value="Simpan" class="btn btn-primary">
    <a href="nilai.php" class="btn badge-secondary">Batal</a>
</form>

</div>
</div>