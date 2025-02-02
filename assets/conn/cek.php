<?php
if (!isset($_SESSION['id_akun'])) {
    header("location:../index.php");
    exit();
}