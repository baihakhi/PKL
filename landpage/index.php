<?php
session_start();

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include('../include/function.php');

if (isset($_POST["submit"])){
	$level= readInput($_POST['status']);
	$username = $_POST['username'];
	$password = $_POST['password'];
	$pass = md5($password);
		if ($level == dosen) {
			$status=login($level,'nip',$username,$pass);
				if ($status==true) {
				$_SESSION['username']=$username;
				$_SESSION['akses']=$level;
				$aktor = getDosen($username);
				$dosen = $aktor->fetch_object();
					$_SESSION['nip'] = $dosen->nip;
					$_SESSION['nama'] = $dosen->nama;
					$_SESSION['alamat'] = $dosen->alamat;
					$_SESSION['email'] = $dosen->email;
					$_SESSION['foto'] = $dosen->foto;
					$_SESSION['lab'] = $dosen->laboratorium;
					$_SESSION['ttl'] = $dosen->TTL;
					$_SESSION['pass'] = $dosen->password;
				header("location: ../dosen/index.php?s=".$level."&u=".$username."");
				$notif = 1;
			}else {
				$notif = 2;
				echo "salah dosen";
			}
		}elseif ($level == admin ) {
				$status=login($level,'username',$username,$pass);
					if ($status==true) {
					$_SESSION['username']=$username;
					$_SESSION['akses']=$level;
					$data = getAdminDosen($username);
					while ($admin = $data->fetch_object()) {
						$_SESSION['nip'] = $admin->nip;
						$_SESSION['nama'] = $admin->nama;
						$_SESSION['alamat'] = $admin->alamat;
						$_SESSION['email'] = $admin->email;
						$_SESSION['foto'] = $admin->foto;
						$_SESSION['pass'] = $admin->password;
					}
					header("location: ../admin/index.php?s=".$level."&u=".$username."");
					$notif = 1;
				}else {
					$notif = 2;
					echo "salah admin";
				}
		}
	$notif = 3;
}
?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php include('../include/head.php') ?>
		<title><?php $site_name ?></title>
		  <!-- BOOTSTRAP STYLES-->
		<link href="../assets/css/bootstrap.css" rel="stylesheet" />
		  <!-- FONTAWESOME STYLES-->
		<link href="../assets/css/font-awesome.css" rel="stylesheet" />
		<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		  <!-- CUSTOM STYLES-->
		<link href="../assets/css/custom.css" rel="stylesheet" />
		 <!-- GOOGLE FONTS-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

	<title>Halaman Login</title>
	</head>
	<body>
				<div id="page-inner">
		<div class="container">
		  <div class="jumbotron" id="header">
				<h1 align="center">Sistem Informasi Dosen</h1>
		    <h3 align="center">Penjadwalan dan Karya Ilmiah</h3>
		  </div>
		</div>
		<section class="container">
					<section class="login-form">
						<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="login">
							<h4 align="center">Input Data Login</h4>
							<input type="text" name="username" placeholder="Username" class="form-control input-lg" required/>
							<input type="password" name="password" placeholder="Password" required class="form-control input-lg" />
							 <div class="form-group">
                  <select name="status" class="form-control" id="level" required >
                      <option selected disabled>Pilih Level User</option>
                      <option value="admin">Administrator</option>
                      <option value="dosen">Dosen</option>
                  </select>
              </div>
							<button type="submit" name="submit" class="btn btn-block">Masuk</button>
						</form>
					</section>
			</section>
		</form>
	</div>
</div>
<?php include_once('../include/footer.php'); ?>

<?php
if (isset($notif)) {
	switch ($notif) {
		case 1:
			echo showAlert($notif,'Nilai berhasil ditambahkan '.$errPict);
			break;
		case 2:
			echo showAlert($notif,'Terjadi kesalahan saat proses input '.$errPict);
			break;
		case 3:
			echo showAlert($notif,'Terdapat data kosong pada formulir '.$errPict);
			break;
		case 4:
			echo showAlert($notif,'Data dosen sudah ada '.$errPict);
			break;
	}
}
?>
	</body>
</html>
