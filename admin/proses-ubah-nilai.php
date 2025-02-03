<?php
include "../assets/conn/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_alternatif'])) {
        $id_alternatif = $_POST['id_alternatif'];

        // Get all criteria
        $dkr = "SELECT * FROM tbl_kriteria ORDER BY id_kriteria";
        $k = $conn->query($dkr);
        
        while ($dk = $k->fetch_assoc()) {
            $idK = $dk['id_kriteria'];
            
            $nilai_alternatif = intval($_POST[$idK]); 
            $nilai_subkriteria = intval($_POST['nilai_kriteria_' . $idK]); 

            $query_subkriteria = "SELECT id_subkriteria FROM tbl_subkriteria 
                                 WHERE id_kriteria = ? AND nilai_subkriteria = ?
                                 LIMIT 1";
            $stmt_subkriteria = $conn->prepare($query_subkriteria);
            $stmt_subkriteria->bind_param("ii", $idK, $nilai_subkriteria);
            $stmt_subkriteria->execute();
            $result_subkriteria = $stmt_subkriteria->get_result();
            $row_subkriteria = $result_subkriteria->fetch_assoc();
            $id_subkriteria = $row_subkriteria ? $row_subkriteria['id_subkriteria'] : null;
            $stmt_subkriteria->close();

            if ($id_subkriteria) {
                $check_query = "SELECT COUNT(*) as count FROM tbl_nilai 
                               WHERE id_alternatif = ? AND id_kriteria = ?";
                $stmt_check = $conn->prepare($check_query);
                $stmt_check->bind_param("ii", $id_alternatif, $idK);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();
                $row_check = $result_check->fetch_assoc();
                $stmt_check->close();

                if ($row_check['count'] > 0) {
                    $update_query = "UPDATE tbl_nilai SET 
                                   nilai_alternatif = ?,
                                   nilai_subkriteria = ?,
                                   id_subkriteria = ?,
                                   tanggal = NOW()
                                   WHERE id_alternatif = ? AND id_kriteria = ?";
                    $stmt_update = $conn->prepare($update_query);
                    $stmt_update->bind_param("iiiii", 
                        $nilai_alternatif,
                        $nilai_subkriteria,
                        $id_subkriteria,
                        $id_alternatif,
                        $idK
                    );
                    $stmt_update->execute();
                    $stmt_update->close();
                } else {
                    $insert_query = "INSERT INTO tbl_nilai 
                                   (id_alternatif, id_kriteria, id_subkriteria, 
                                    nilai_alternatif, nilai_subkriteria, tanggal)
                                   VALUES (?, ?, ?, ?, ?, NOW())";
                    $stmt_insert = $conn->prepare($insert_query);
                    $stmt_insert->bind_param("iiiii",
                        $id_alternatif,
                        $idK,
                        $id_subkriteria,
                        $nilai_alternatif,
                        $nilai_subkriteria
                    );
                    $stmt_insert->execute();
                    $stmt_insert->close();
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