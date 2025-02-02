<?php include "header.php"; ?>

<h2 class="mb-4">Metode</h2>
<hr>
<br>
<h5>Data Kriteria</h5>
<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Nama Kriteria</th>
        <th class="text-center">Bobot</th>
        <th class="text-center">Normalisasi</th>
    </tr>
    <?php
    //normalisasi bobot
    $n_WJ = array();
    $sql = "SELECT * FROM tbl_kriteria ORDER BY id_kriteria";
    $stm = $conn->query($sql);
    $no = 1;
    while ($a = $stm->fetch_assoc()) {

        $dsum = "SELECT SUM(bobot_kriteria) as nBobot FROM tbl_kriteria";
        $s = $conn->query($dsum);
        $ns = $s->fetch_assoc();
        //normalisasi bobot
        $nWj = $a['bobot_kriteria'] / $ns['nBobot'];
        $n_WJ[] = array(
            'nilai_wj' => $nWj
        );
    ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center"><?= $a['nama_kriteria'] ?> - (<?= $a['tipe_kriteria'] ?>)</td>
            <td class="text-center"><?= $a['bobot_kriteria'] ?></td>
            <td class="text-center"><?= $a['bobot_kriteria'] ?> / <?= $ns['nBobot'] ?> = <?= $nWj ?></td>
        </tr>

    <?php } ?>
</table>
<br>

<h5>Matriks Keputusan</h5>
<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">ID Alternatif</th>
        <th class="text-center">Nama Alternatif</th>
        <?php
        $kriteria = [];
        $satuan = [
            "Rp", 
            "ml/gr", 
            "liter/kg", 
            "tahun", 
            "m2" 
        ];
        
        $resultKriteria = $conn->query("SELECT id_kriteria, nama_kriteria FROM tbl_kriteria ORDER BY id_kriteria");
        $i = 0;
        while ($row = $resultKriteria->fetch_assoc()) {
            echo "<th class='text-center'>{$row['nama_kriteria']}</th>";
            $kriteria[] = $row['id_kriteria'];
            $i++;
        }
        ?>
    </tr>

    <?php
    $sql = "SELECT a.id_alternatif, a.nama_alternatif, n.id_kriteria, n.nilai_alternatif
            FROM tbl_alternatif a
            LEFT JOIN tbl_nilai n ON a.id_alternatif = n.id_alternatif
            ORDER BY a.id_alternatif, n.id_kriteria";

    $result = $conn->query($sql);

    $alternatifData = [];
    while ($row = $result->fetch_assoc()) {
        $id_alternatif = $row['id_alternatif'];
        if (!isset($alternatifData[$id_alternatif])) {
            $alternatifData[$id_alternatif] = [
                'nama' => $row['nama_alternatif'],
                'nilai' => []
            ];
        }
        $alternatifData[$id_alternatif]['nilai'][$row['id_kriteria']] = $row['nilai_alternatif'];
    }

    $no = 1;
    foreach ($alternatifData as $id_alternatif => $data) {
        echo "<tr>";
        echo "<td class='text-center'>{$no}</td>";
        echo "<td class='text-center'>A{$id_alternatif}</td>";
        echo "<td class='text-center'>{$data['nama']}</td>";

        $i = 0;
        foreach ($kriteria as $id_kriteria) {
            $nilai = isset($data['nilai'][$id_kriteria]) ? $data['nilai'][$id_kriteria] : "-";

            if ($nilai !== "-") {
                if ($i == 0) {
                    $nilaiFormatted = "Rp " . number_format($nilai, 0, ',', '.');
                } else {
                    $nilaiFormatted = number_format($nilai, 0, ',', '.') . " " . $satuan[$i];
                }
            } else {
                $nilaiFormatted = "-";
            }

            echo "<td class='text-center'>{$nilaiFormatted}</td>";
            $i++;
        }

        echo "</tr>";
        $no++;
    }
    ?>
</table>


<br>


<h5>Konversi Matriks Keputusan</h5>
<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">ID Alternatif</th>
        <th class="text-center">Nama Alternatif</th>
        <?php
        $kriteria = [];
        $resultKriteria = $conn->query("SELECT id_kriteria, nama_kriteria FROM tbl_kriteria ORDER BY id_kriteria");
        while ($row = $resultKriteria->fetch_assoc()) {
            echo "<th class='text-center'>{$row['nama_kriteria']}</th>";
            $kriteria[] = $row['id_kriteria'];
        }
        ?>
    </tr>

    <?php
    $query = "SELECT a.id_alternatif, a.nama_alternatif, n.id_kriteria, s.nilai_subkriteria AS n_sub 
              FROM tbl_alternatif a
              LEFT JOIN tbl_nilai n ON a.id_alternatif = n.id_alternatif
              LEFT JOIN tbl_subkriteria s ON n.id_subkriteria = s.id_subkriteria
              ORDER BY a.id_alternatif, n.id_kriteria";

    $result = $conn->query($query);

    $alternatifData = [];
    while ($row = $result->fetch_assoc()) {
        $id_alternatif = $row['id_alternatif'];
        if (!isset($alternatifData[$id_alternatif])) {
            $alternatifData[$id_alternatif] = [
                'nama' => $row['nama_alternatif'],
                'nilai' => []
            ];
        }
        $alternatifData[$id_alternatif]['nilai'][$row['id_kriteria']] = $row['n_sub'];
    }

    $no = 1;
    foreach ($alternatifData as $id_alternatif => $data) {
        echo "<tr>";
        echo "<td class='text-center'>{$no}</td>";
        echo "<td class='text-center'>A{$id_alternatif}</td>";
        echo "<td class='text-center'>{$data['nama']}</td>";

        foreach ($kriteria as $id_kriteria) {
            $nilai = isset($data['nilai'][$id_kriteria]) ? $data['nilai'][$id_kriteria] : "-";
            echo "<td class='text-center'>{$nilai}</td>";
        }

        echo "</tr>";
        $no++;
    }
    ?>

    <tr>
        <td colspan="3"><b>Maksimal</b></td>
        <?php
        $nilaiMax = [];
        $nilaiMin = [];

        $queryMaxMin = "SELECT n.id_kriteria, 
                               MAX(s.nilai_subkriteria) AS n_max, 
                               MIN(s.nilai_subkriteria) AS n_min
                        FROM tbl_nilai n
                        JOIN tbl_subkriteria s ON n.id_subkriteria = s.id_subkriteria
                        GROUP BY n.id_kriteria";

        $resultMaxMin = $conn->query($queryMaxMin);

        if ($resultMaxMin->num_rows > 0) {
            while ($row = $resultMaxMin->fetch_assoc()) {
                $nilaiMax[$row['id_kriteria']] = $row['n_max'];
                $nilaiMin[$row['id_kriteria']] = $row['n_min'];
            }
        }

        foreach ($kriteria as $id_kriteria) {
            $maxValue = isset($nilaiMax[$id_kriteria]) ? $nilaiMax[$id_kriteria] : "-";
            echo "<td class='text-center'><b>{$maxValue}</b></td>";
        }
        ?>
    </tr>

    <tr>
        <td colspan="3"><b>Minimal</b></td>
        <?php
        foreach ($kriteria as $id_kriteria) {
            $minValue = isset($nilaiMin[$id_kriteria]) ? $nilaiMin[$id_kriteria] : "-";
            echo "<td class='text-center'><b>{$minValue}</b></td>";
        }
        ?>
    </tr>

    <tr>
        <td colspan="3"><b>Wj</b></td>
        <?php
        foreach ($n_WJ as $nwj) {
            echo "<td class='text-center'><b>{$nwj['nilai_wj']}</b></td>";
        }
        ?>
    </tr>
</table>

<br>


<h5>Normalisasi Matriks</h5>
<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">ID Alternatif</th>
        <th class="text-center">Nama Alternatif</th>
        <?php
        $kriteria = [];
        $resultKriteria = $conn->query("SELECT id_kriteria, nama_kriteria, tipe_kriteria FROM tbl_kriteria ORDER BY id_kriteria");
        while ($row = $resultKriteria->fetch_assoc()) {
            echo "<th class='text-center'>{$row['nama_kriteria']} - ({$row['tipe_kriteria']})</th>";
            $kriteria[$row['id_kriteria']] = $row['tipe_kriteria'];
        }
        ?>
    </tr>

    <?php
    $nilaiMax = [];
    $nilaiMin = [];

    $queryMaxMin = "SELECT n.id_kriteria, 
                           MAX(s.nilai_subkriteria) AS n_max, 
                           MIN(s.nilai_subkriteria) AS n_min
                    FROM tbl_nilai n
                    JOIN tbl_subkriteria s ON n.id_subkriteria = s.id_subkriteria
                    GROUP BY n.id_kriteria";

    $resultMaxMin = $conn->query($queryMaxMin);
    while ($row = $resultMaxMin->fetch_assoc()) {
        $nilaiMax[$row['id_kriteria']] = $row['n_max'];
        $nilaiMin[$row['id_kriteria']] = $row['n_min'];
    }

    $query = "SELECT a.id_alternatif, a.nama_alternatif, n.id_kriteria, s.nilai_subkriteria AS n_sub
              FROM tbl_alternatif a
              LEFT JOIN tbl_nilai n ON a.id_alternatif = n.id_alternatif
              LEFT JOIN tbl_subkriteria s ON n.id_subkriteria = s.id_subkriteria
              ORDER BY a.id_alternatif, n.id_kriteria";

    $result = $conn->query($query);

    $alternatifData = [];
    while ($row = $result->fetch_assoc()) {
        $id_alternatif = $row['id_alternatif'];
        if (!isset($alternatifData[$id_alternatif])) {
            $alternatifData[$id_alternatif] = [
                'nama' => $row['nama_alternatif'],
                'nilai' => []
            ];
        }
        $alternatifData[$id_alternatif]['nilai'][$row['id_kriteria']] = $row['n_sub'];
    }

    $no = 1;
    foreach ($alternatifData as $id_alternatif => $data) {
        echo "<tr>";
        echo "<td class='text-center'>{$no}</td>";
        echo "<td class='text-center'>A{$id_alternatif}</td>";
        echo "<td class='text-center'>{$data['nama']}</td>";

        foreach ($kriteria as $id_kriteria => $tipe_kriteria) {
            $nilai_sub = isset($data['nilai'][$id_kriteria]) ? $data['nilai'][$id_kriteria] : "-";

            if ($nilai_sub != "-" && isset($nilaiMax[$id_kriteria]) && isset($nilaiMin[$id_kriteria])) {
                if ($tipe_kriteria == 'Benefit') {
                    $n_nm = $nilai_sub / $nilaiMax[$id_kriteria];
                } else {
                    $n_nm = $nilaiMin[$id_kriteria] / $nilai_sub;
                }
                echo "<td class='text-center'>" . number_format($n_nm, 2) . "</td>";
            } else {
                echo "<td class='text-center'>-</td>";
            }
        }

        echo "</tr>";
        $no++;
    }
    ?>
</table>


<br>


<h5>Pembentukan Nilai Qa</h5>
<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">ID Alternatif</th>
        <th class="text-center">Nama Alternatif</th>
        <?php
        $kriteria = [];
        $bobotKriteria = [];
        $totalBobot = 0;

        $resultKriteria = $conn->query("SELECT id_kriteria, nama_kriteria, tipe_kriteria, bobot_kriteria FROM tbl_kriteria ORDER BY id_kriteria");
        while ($row = $resultKriteria->fetch_assoc()) {
            echo "<th class='text-center'>{$row['nama_kriteria']} - ({$row['tipe_kriteria']})</th>";
            $kriteria[$row['id_kriteria']] = $row['tipe_kriteria'];
            $bobotKriteria[$row['id_kriteria']] = $row['bobot_kriteria'];
            $totalBobot += $row['bobot_kriteria'];
        }
        ?>
        <th class="text-center">Qa</th>
    </tr>

    <?php
    $nilaiMax = [];
    $nilaiMin = [];

    $queryMaxMin = "SELECT n.id_kriteria, 
                           MAX(s.nilai_subkriteria) AS n_max, 
                           MIN(s.nilai_subkriteria) AS n_min
                    FROM tbl_nilai n
                    JOIN tbl_subkriteria s ON n.id_subkriteria = s.id_subkriteria
                    GROUP BY n.id_kriteria";

    $resultMaxMin = $conn->query($queryMaxMin);
    while ($row = $resultMaxMin->fetch_assoc()) {
        $nilaiMax[$row['id_kriteria']] = $row['n_max'];
        $nilaiMin[$row['id_kriteria']] = $row['n_min'];
    }

    $query = "SELECT a.id_alternatif, a.nama_alternatif, n.id_kriteria, s.nilai_subkriteria AS n_sub
              FROM tbl_alternatif a
              LEFT JOIN tbl_nilai n ON a.id_alternatif = n.id_alternatif
              LEFT JOIN tbl_subkriteria s ON n.id_subkriteria = s.id_subkriteria
              ORDER BY a.id_alternatif, n.id_kriteria";

    $result = $conn->query($query);

    $alternatifData = [];
    while ($row = $result->fetch_assoc()) {
        $id_alternatif = $row['id_alternatif'];
        if (!isset($alternatifData[$id_alternatif])) {
            $alternatifData[$id_alternatif] = [
                'nama' => $row['nama_alternatif'],
                'nilai' => []
            ];
        }
        $alternatifData[$id_alternatif]['nilai'][$row['id_kriteria']] = $row['n_sub'];
    }
    $qaUpdates = [];

    $no = 1;
    foreach ($alternatifData as $id_alternatif => $data) {
        $sum_nqa = 0;
        echo "<tr>";
        echo "<td class='text-center'>{$no}</td>";
        echo "<td class='text-center'>A{$id_alternatif}</td>";
        echo "<td class='text-center'>{$data['nama']}</td>";

        foreach ($kriteria as $id_kriteria => $tipe_kriteria) {
            $nilai_sub = isset($data['nilai'][$id_kriteria]) ? $data['nilai'][$id_kriteria] : "-";

            if ($nilai_sub != "-" && isset($nilaiMax[$id_kriteria]) && isset($nilaiMin[$id_kriteria])) {
                if ($tipe_kriteria == 'Benefit') {
                    $n_nm = $nilai_sub / $nilaiMax[$id_kriteria];
                } else {
                    $n_nm = $nilaiMin[$id_kriteria] / $nilai_sub;
                }

                $norma_bobot = $bobotKriteria[$id_kriteria] / $totalBobot;
                $nqa =  $n_nm * $norma_bobot;
                $sum_nqa += $nqa;

                echo "<td class='text-center'>" . number_format($nqa, 2) . "</td>";
            } else {
                echo "<td class='text-center'>-</td>";
            }
        }

        echo "<td class='text-center'><b>" . number_format($sum_nqa, 2) . "</b></td>";
        echo "</tr>";

        $qaUpdates[$id_alternatif] = $sum_nqa;
        $no++;
    }
    ?>
</table>

<?php
foreach ($qaUpdates as $id_alternatif => $sum_nqa) {
    $updateQa = "UPDATE tbl_alternatif SET matriks_a='$sum_nqa' WHERE id_alternatif='$id_alternatif'";
    $conn->query($updateQa);
}
?>


<br>
<h5>Pembentukan Nilai Qb</h5>
<table class="table table-bordered">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">ID Alternatif</th>
        <th class="text-center">Nama Alternatif</th>
        <?php
        $kriteria = [];
        $bobotKriteria = [];
        $totalBobot = 0;

        $resultKriteria = $conn->query("SELECT id_kriteria, nama_kriteria, tipe_kriteria, bobot_kriteria FROM tbl_kriteria ORDER BY id_kriteria");
        while ($row = $resultKriteria->fetch_assoc()) {
            echo "<th class='text-center'>{$row['nama_kriteria']} - ({$row['tipe_kriteria']})</th>";
            $kriteria[$row['id_kriteria']] = $row['tipe_kriteria'];
            $bobotKriteria[$row['id_kriteria']] = $row['bobot_kriteria'];
            $totalBobot += $row['bobot_kriteria'];
        }
        ?>
        <th class="text-center">Qb</th>
    </tr>

    <?php
    $nilaiMax = [];
    $nilaiMin = [];

    $queryMaxMin = "SELECT n.id_kriteria, 
                           MAX(s.nilai_subkriteria) AS n_max, 
                           MIN(s.nilai_subkriteria) AS n_min
                    FROM tbl_nilai n
                    JOIN tbl_subkriteria s ON n.id_subkriteria = s.id_subkriteria
                    GROUP BY n.id_kriteria";

    $resultMaxMin = $conn->query($queryMaxMin);
    while ($row = $resultMaxMin->fetch_assoc()) {
        $nilaiMax[$row['id_kriteria']] = $row['n_max'];
        $nilaiMin[$row['id_kriteria']] = $row['n_min'];
    }

    $query = "SELECT a.id_alternatif, a.nama_alternatif, n.id_kriteria, s.nilai_subkriteria AS n_sub
              FROM tbl_alternatif a
              LEFT JOIN tbl_nilai n ON a.id_alternatif = n.id_alternatif
              LEFT JOIN tbl_subkriteria s ON n.id_subkriteria = s.id_subkriteria
              ORDER BY a.id_alternatif, n.id_kriteria";

    $result = $conn->query($query);

    $alternatifData = [];
    while ($row = $result->fetch_assoc()) {
        $id_alternatif = $row['id_alternatif'];
        if (!isset($alternatifData[$id_alternatif])) {
            $alternatifData[$id_alternatif] = [
                'nama' => $row['nama_alternatif'],
                'nilai' => []
            ];
        }
        $alternatifData[$id_alternatif]['nilai'][$row['id_kriteria']] = $row['n_sub'];
    }

    $qbUpdates = [];

    $no = 1;
    foreach ($alternatifData as $id_alternatif => $data) {
        $sum_nqb = 1;
        echo "<tr>";
        echo "<td class='text-center'>{$no}</td>";
        echo "<td class='text-center'>A{$id_alternatif}</td>";
        echo "<td class='text-center'>{$data['nama']}</td>";

        foreach ($kriteria as $id_kriteria => $tipe_kriteria) {
            $nilai_sub = isset($data['nilai'][$id_kriteria]) ? $data['nilai'][$id_kriteria] : "-";

            if ($nilai_sub != "-" && isset($nilaiMax[$id_kriteria]) && isset($nilaiMin[$id_kriteria])) {
                if ($tipe_kriteria == 'Benefit') {
                    $n_nm = $nilai_sub / $nilaiMax[$id_kriteria];
                } else {
                    $n_nm = $nilaiMin[$id_kriteria] / $nilai_sub;
                }

                $norma_bobot = $bobotKriteria[$id_kriteria] / $totalBobot;
                $nqb = pow($n_nm, $norma_bobot);
                $sum_nqb *= $nqb;

                echo "<td class='text-center'>" . number_format($nqb, 2) . "</td>";
            } else {
                echo "<td class='text-center'>-</td>";
            }
        }

        echo "<td class='text-center'><b>" . number_format($sum_nqb, 2) . "</b></td>";
        echo "</tr>";

        $qbUpdates[$id_alternatif] = $sum_nqb;
        $no++;
    }
    ?>
</table>

<?php
// Update nilai Qb ke database setelah perhitungan selesai
foreach ($qbUpdates as $id_alternatif => $sum_nqb) {
    $updateQb = "UPDATE tbl_alternatif SET matriks_b='$sum_nqb' WHERE id_alternatif='$id_alternatif'";
    $conn->query($updateQb);
}
?>

<br>

<?php
//hitung nilai qi
$data = "SELECT * FROM tbl_alternatif ORDER BY id_alternatif";
$ss = $conn->query($data);
while ($a = $ss->fetch_assoc()) {
    $id_alternatif = $a['id_alternatif'];
    $qa = $a['matriks_a'];
    $qb = $a['matriks_b'];
    $qi = (0.5 * $qa) + (0.5 * $qb);

    //ambil nilai Qi
    $simpan = "UPDATE tbl_alternatif SET nilai_waspas='$qi' WHERE id_alternatif='$id_alternatif'";
    $si = $conn->query($simpan);
}

//rangking nilai qi
$da = "SELECT * FROM tbl_alternatif ORDER BY nilai_waspas DESC";
$s = $conn->query($da);
$rang = 1;
while ($aa = $s->fetch_assoc()) {
    $id_alternatif = $aa['id_alternatif'];

    //rangking
    $sim = "UPDATE tbl_alternatif SET rangking='$rang' WHERE id_alternatif='$id_alternatif'";
    $sb = $conn->query($sim);
    $rang++;
}
?>

<h5>Perangkingan</h5>
<table class="table table-bordered">
    <tr>
        <th class="text-center">ID Alternatif</th> <!-- Menambahkan kolom ID Alternatif -->
        <th class="text-center">Nama Alternatif</th>
        <th class="text-center">Nilai</th>
        <th class="text-center">Ranking</th>
    </tr>
    <?php
    $sql = "SELECT * FROM tbl_alternatif ORDER BY rangking";
    $stm = $conn->query($sql);
    $no = 1;
    while ($a = $stm->fetch_assoc()) {
    ?>
        <tr>
            <td class="text-center">A<?= $a['id_alternatif'] ?></td>
            <td class="text-center"><?= $a['nama_alternatif'] ?></td>
            <td class="text-center"><?= number_format($a['nilai_waspas'], 3) ?></td>
            <td class="text-center"><?= $a['rangking'] ?></td>
        </tr>

    <?php } ?>

</table>
</div>
</div>