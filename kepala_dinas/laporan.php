<?php include "header.php"; 
    date_default_timezone_set('Asia/Jakarta');
    setlocale(LC_TIME, 'id_ID.utf8');
?>

<?php
// Ambil data kepala dinas dari database
$sql_kepala_dinas = "SELECT nama_kepala, jabatan, nip FROM tbl_kepala WHERE id_kepala = 1";
$result_kepala_dinas = $conn->query($sql_kepala_dinas);

if ($result_kepala_dinas->num_rows > 0) {
    $kepala_dinas = $result_kepala_dinas->fetch_assoc();
    $nama_kepala_dinas = $kepala_dinas['nama_kepala'];
    $jabatan_kepala_dinas = $kepala_dinas['jabatan'];
    $nip_kepala_dinas = $kepala_dinas['nip'];
} else {
    $nama_kepala_dinas = "Nama Tidak Ditemukan";
    $jabatan_kepala_dinas = "Jabatan Tidak Ditemukan";
    $nip_kepala_dinas = "NIP Tidak Ditemukan";
}
?>

<style type="text/css">
    .hr {
        border: none;
        height: 4px;
        background-color: black;
        margin-bottom: 2px;
    }
    /* ✅ Tampilan Saat Cetak */
@media print {
    .hr {
            background-color: black !important;
            -webkit-print-color-adjust: exact;
        }

        .signature {
            text-align: right !important; /* Pastikan tanda tangan di kanan */
            margin-top: 50px; /* Jarak dari konten di atas */
        }

        .print-btn-container {
            display: none; /* Sembunyikan tombol cetak saat mencetak */
        }

        .page-break {
            page-break-before: always;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 100%;
        }

        .table {
            width: 100%;
            table-layout: fixed;
        }

        .table th, .table td {
            padding: 8px;
            text-align: center;
        }

        .logo-container img {
            width: 90px;
            height: 100px;
        }

        .recommendation {
            color: blue !important;
        }

        .penjelasan {
            color: green !important;
        }

        .page-break {
            page-break-before: always;
        }
    }

    .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .logo-container img {
        margin-right: 15px;
    }

    .signature {
    text-align: right !important; 
    color: black;
}

    h6, .signature b {
        color: black;
    }

    .print-btn-container {
        text-align: center;
        margin-top: 20px;
    }

    .recommendation {
        color: blue;
    }

    .penjelasan {
        color: green;
    }

    /* Menghindari halaman terpotong saat cetak */
    .page-break {
        page-break-before: always;
    }

    .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }
    .logo-container img {
        margin-right: 15px;
    }
    .signature {
        text-align: right;
        color: black;
    }
    h6, .signature b {
        color: black;
    }
    .print-btn-container {
        text-align: center;
        margin-top: 20px;
    }
    .recommendation {
        color: blue;
    }
    .penjelasan {
        color: green;
    }
</style>

<!-- Laporan Hasil Perangkingan -->
<!-- Laporan Hasil Perangkingan -->
<div class="container" id="report-ranking">
    <center>
        <div class="logo-container" style="display: flex">
            <img src="LOGO.png" width="90" height="100">
            <h3><b>LAPORAN HASIL PERANGKINGAN PESTISIDA TERBAIK UNTUK PENCEGAHAN HAMA PADA TANAMAN PADI DI DINAS PERTANIAN KABUPATEN PASAMAN</b></h3>
        </div>
        <h6><b>Jalan 45Q9+G2W, Pauah, Kec. Lubuk Sikaping, Kab. Pasaman, Sumatera Barat 26318</b></h6>
        <hr class="hr">
    </center>
    <br>

    <table class="table table-bordered">
        <tr><b>Pasaman, 30 Januari 2025</b>
            <th class="text-center">ID Alternatif</th>
            <th class="text-center">Nama Alternatif</th>
            <th class="text-center">Nilai</th>
            <th class="text-center">Ranking</th>
        </tr>
        <?php
        $sql = "SELECT * FROM tbl_alternatif ORDER BY rangking";
        $stm = $conn->query($sql);
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

    <?php
    $sql_best = "SELECT * FROM tbl_alternatif WHERE rangking = 1";
    $result_best = $conn->query($sql_best);

    if ($result_best->num_rows > 0) {
        $best = $result_best->fetch_assoc();
        echo "<div class='recommendation'>";
        echo "<p><b>Rekomendasi Terbaik:</b></p>";
        echo "<p>- Nama Alternatif: <b>" . $best['nama_alternatif'] . "</b></p>";
        echo "<p>- ID Alternatif: <b>A" . $best['id_alternatif'] . "</b></p>";
        echo "<p>- Nilai: <b>" . number_format($best['nilai_waspas'], 3) . "</b></p>";
        echo "<p>- Ranking: <b>" . $best['rangking'] . "</b></p>";
        echo "</div>";
    } else {
        echo "<p class='recommendation'><b>Rekomendasi Terbaik:</b> Data belum tersedia atau tidak ditemukan.</p>";
    }
    ?>
</div>

<!-- Bagian Tanda Tangan -->
<div class="signature" id="signature-section" style="text-align: right">
    <b>
        Pasaman, <?php echo strftime('%d %B %Y') ?><br>
        <?php echo htmlspecialchars($jabatan_kepala_dinas); ?><br><br><br><br>
        <?php echo htmlspecialchars($nama_kepala_dinas); ?><br>
        NIP. <?php echo htmlspecialchars($nip_kepala_dinas); ?>
    </b>
</div>

<!-- Tombol Cetak untuk Laporan Ranking -->
<div class="print-btn-container">
    <button id="print-ranking-btn" class="btn btn-primary">Cetak Laporan Ranking</button><br><br><br><br>
</div>

<!-- Laporan Data Pestisida -->
<div class="container" id="report-data">
    <center>
        <div class="logo-container">
            <h3><b>DATA PESTISIDA DI DINAS PERTANIAN KABUPATEN PASAMAN</b></h3><br><br>
        </div>
    </center>

    <table class="table table-bordered">
        <tr>
            <b>Pasaman, 30 Januari 2025</b>
            <th class="text-center">No</th>
            <th class="text-center">ID Alternatif</th>
            <th class="text-center">Nama Alternatif</th>
            <th class="text-center">Jenis Hama</th>
            <th class="text-center">Bentuk Pestisida</th>
            <th class="text-center">Warna Pestisida</th>
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
        </tr>
        <?php } ?>
    </table>

    <br>
    <div class="penjelasan">
        <h5><b>Penjelasan Data Pestisida:</b></h5>
        <?php
        $sql_explanation = "SELECT * FROM tbl_alternatif ORDER BY id_alternatif";
        $stm_explanation = $conn->query($sql_explanation);
        $counter = 1;
        while ($a = $stm_explanation->fetch_assoc()) {
            echo "<p><b>" . $counter++ . ".</b> Kode A" . $a['id_alternatif'] . ": ";
            echo "Alternatif ini bernama <b>" . $a['nama_alternatif'] . "</b>, digunakan untuk mengatasi hama jenis <b>" . $a['jenis_hama'] . "</b>, dengan bentuk pestisida berupa <b>" . $a['bentuk_pestisida'] . "</b> dan warna <b>" . $a['warna_pestisida'] . "</b>.</p>";
        }
        ?>
    </div>
</div>

<!-- Tombol Cetak untuk Data Pestisida -->
<div class="print-btn-container">
    <button id="print-data-btn" class="btn btn-primary">Cetak Data Pestisida</button>
</div>

<script src="../assets/sidebar/js/jquery.min.js"></script>
<script src="../assets/sidebar/js/popper.js"></script>
<script src="../assets/sidebar/js/bootstrap.min.js"></script>
<script src="../assets/sidebar/js/main.js"></script>

<script type="text/javascript">
   document.getElementById('print-ranking-btn').addEventListener('click', function() {
    const printContents = document.getElementById('report-ranking').innerHTML;
    const signature = document.getElementById('signature-section').outerHTML; // Gunakan outerHTML agar termasuk elemen
    const originalContents = document.body.innerHTML;
    
    document.body.innerHTML = "<div>" + printContents + "<br><br>" + signature + "</div>";
    window.print();
    
    setTimeout(function() {
        document.body.innerHTML = originalContents;
        location.reload();
    }, 100);
});

document.getElementById('print-data-btn').addEventListener('click', function() {
    const printContents = document.getElementById('report-data').innerHTML;
    const signature = document.getElementById('signature-section').outerHTML;
    const originalContents = document.body.innerHTML;
    
    document.body.innerHTML = "<div>" + printContents + "<br><br>" + signature + "</div>";
    window.print();
    
    setTimeout(function() {
        document.body.innerHTML = originalContents;
        location.reload();
    }, 100);
});
</script>