<?php
if (isset($_GET['aksi'])) {
	if ($_GET['aksi'] == 'login') {
		session_start();
		include "assets/conn/config.php";

		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = "SELECT * FROM tbl_akun WHERE username='$username' AND password='$password'";
		$stm = $conn->query($query);
		$row = $stm->num_rows;

		if ($row > 0) {
			$data = $stm->fetch_assoc();
			$_SESSION['id_akun'] = $data['id_akun'];
			$_SESSION['role'] = $data['role'];

			// Redirect based on user role
			if ($data['role'] == 'admin') {
				header("location:admin/index.php");
			} elseif ($data['role'] == 'kepala_dinas') {
				header("location:kepala_dinas/index.php");
			}
		} else {
			header("location:index.php?pesan=gagal");
		}
	}
}
?>

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>SISTEM PENDUKUNG KEPUTUSAN METODE WASPAS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/login/images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/main.css">
</head>

<body style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="index.php?aksi=login" method="post">
                    <span class="login100-form-title p-b-43">
                        MASUK UNTUK MELANJUTKAN
                    </span>

                    <?php
					if (isset($_GET['pesan'])) {
						if ($_GET['pesan'] == 'gagal') {
							echo "<div class='alert alert-danger'><span class='fa fa-times'></span> &emsp; Login Gagal !!!</div>";
						}
					} ?>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="username">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Username</span>
                    </div>


                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>

                    <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>
                    </div>


                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            MASUK
                        </button>
                    </div>
                </form>

                <div class="login100-more" style="background-image: url('assets/login/images/bg-02.jpg');">
                </div>
            </div>
        </div>
    </div>






    <script src="assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/login/vendor/animsition/js/animsition.min.js"></script>
    <script src="assets/login/vendor/bootstrap/js/popper.js"></script>
    <script src="assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/login/vendor/select2/select2.min.js"></script>
    <script src="assets/login/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/login/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="assets/login/vendor/countdowntime/countdowntime.js"></script>
    <script src="assets/login/js/main.js"></script>

</body>

</html>