<?php
session_start();
include "../assets/conn/config.php";
include "../assets/conn/cek.php";

$query = "SELECT * FROM tbl_akun WHERE id_akun='$_SESSION[id_akun]'";
$stm = $conn->query($query);
$row = $stm->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
    <title>SISTEM PENDUKUNG KEPUTUSAN METODE WASPAS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="../assets/login/images/icons/favicon.ico" />
    <link rel="stylesheet" href="../assets/sidebar/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
    .form-control {
        border: 1px solid;
    }
    </style>
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <h1><a href="index.html" class="logo">Selamat Datang, <?= $row['nama_lengkap'] ?></a></h1>
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="index.php"><i class="bx bx-home mr-3"></i> Dashboard</a>
                </li>
                <li>
                    <a href="alternatif.php"><i class='bx bxs-user-detail mr-3'></i> Alternatif</a>
                </li>
                <li>
                    <a href="kriteria.php"><i class='bx bx-list-plus mr-3'></i>Kriteria</a>
                </li>
                <li>
                    <a href="nilai.php"><i class='bx bx-file mr-3'></i> Nilai</a>
                </li>
                <li>
                    <a href="metode.php"><i class='bx bx-rocket mr-3'></i> Metode</a>
                </li>
                <li>
                    <a href="laporan.php" target="_blank"><i class='bx bx-file-find mr-3'></i> Laporan</a>
                </li>
                <li>
                <a href="form_kepala_dinas.php" target="_blank"><i class='bx bx-user mr-3'></i> Kepala Dinas</a>
                </li>
                <li>
                    <a href="logout.php"><i class='bx bx-log-out-circle mr-3'></i> Logout</a>
                </li>
            </ul>

        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">


            <script src="../assets/sidebar/js/jquery.min.js"></script>
            <script src="../assets/sidebar/js/popper.js"></script>
            <script src="../assets/sidebar/js/bootstrap.min.js"></script>
            <script src="../assets/sidebar/js/main.js"></script>
</body>

</html>