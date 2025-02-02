<?php
include "../assets/conn/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_alternatif'])) {
        $id_alternatif = $_POST['id_alternatif'];

        $queryKriteria = "SELECT id_kriteria FROM tbl_kriteria";
        $resultKriteria = $conn->query($queryKriteria);

        while ($row = $resultKriteria->fetch_assoc()) {
            $id_kriteria = $row['id_kriteria'];

            if (isset($_POST[$id_kriteria])) {
                $nilai_alternatif = $_POST[$id_kriteria];

                $cekQuery = "SELECT COUNT(*) AS count FROM tbl_nilai WHERE id_alternatif = ? AND id_kriteria = ?";
                $stmtCek = $conn->prepare($cekQuery);
                $stmtCek->bind_param("ii", $id_alternatif, $id_kriteria);
                $stmtCek->execute();
                $resultCek = $stmtCek->get_result();
                $rowCek = $resultCek->fetch_assoc();
                $stmtCek->close();

                if ($rowCek['count'] > 0) {
                    $updateQuery = "UPDATE tbl_nilai SET nilai_alternatif = ?, tanggal = NOW() 
                                    WHERE id_alternatif = ? AND id_kriteria = ?";
                    $stmtUpdate = $conn->prepare($updateQuery);
                    $stmtUpdate->bind_param("iii", $nilai_alternatif, $id_alternatif, $id_kriteria);
                    $stmtUpdate->execute();
                    $stmtUpdate->close();
                } else {
                    $insertQuery = "INSERT INTO tbl_nilai (id_alternatif, id_kriteria, nilai_alternatif, tanggal) 
                                    VALUES (?, ?, ?, NOW())";
                    $stmtInsert = $conn->prepare($insertQuery);
                    $stmtInsert->bind_param("iii", $id_alternatif, $id_kriteria, $nilai_alternatif);
                    $stmtInsert->execute();
                    $stmtInsert->close();
                }
            }
        }

        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='nilai.php';</script>";
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan dalam memperbarui data!'); window.location.href='nilai.php';</script>";
        exit();
    }
}
?>
