<?php
session_start();
if (isset($_SESSION['akses'])) {
  // code...
	switch ($_SESSION['akses']) {
		case 'admin':
			header('Location: ../admin/index.php');
			break;
		case 'dosen':
			header('Location: ../dosen/index.php');
			break;
	}
}
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include('../include/function.php');

if (isset($_GET['n'])) {
	// code...
	$notif = $_GET['n'];
}

if (isset($_POST["submit"])){
	$level= $_POST["status"];
	$username = $_POST['uname'];
	$password = $_POST['password'];
	$pass = md5($password);
	//echo "level= ".$level." username= ".$username;
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
				}
		}
		elseif ($level == kadep ) {
				$status=login($level,'username',$username,$pass);
					if ($status==true) {
					$_SESSION['username']=$username;
					$_SESSION['akses']=$level;
					$data = getKadepDosen($username);
					while ($kadep = $data->fetch_object()) {
						$_SESSION['nip'] = $kadep->nip;
						$_SESSION['nama'] = $kadep->nama;
						$_SESSION['foto'] = $kadep->foto;
						$_SESSION['pass'] = $kadep->password;
					}
					header("location: ../kadep/index.php?s=".$level."&u=".$username."");
					$notif = 1;
				}else {
					$notif = 2;
				}
		}
}
?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php include('../include/head.php') ?>
		  <!-- BOOTSTRAP STYLES-->
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
		  <!-- FONTAWESOME STYLES-->
		<link href="../assets/css/font-awesome.css" rel="stylesheet" />
		<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		  <!-- CUSTOM STYLES-->
		<link href="../assets/css/custom.css" rel="stylesheet" />
		 <!-- GOOGLE FONTS-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<style media="screen">
	body{background:url('../assets/img/bg/bg-m-edit.jpg'); background-size:100% 100vh;}
</style>
	<title>Halaman Login</title>
	</head>
	<body>
		<div class="" style="padding:5%">
		<div class=" konten bg-success text-center">
			<div class="header-sub col-md-8 text-center company__info">
					<span class="company__logo">
						<img src="../assets/img/web-profil-1.png" alt="">
						<h3 class="">Sistem Informasi <br>dan Penjadwalan Dosen</h3>

	        </span>
			</div>
			<div class="col-md-8 col-xs-12 col-sm-12 login_form ">
				<div class="container-fluid">

					<div class="row company__title" >

		          <svg class="logo-login" height="70" width="70">
		  					<rect x="16" y="8" rx="15" ry="15" style="stroke:#008080; fill:none;" height="58" width="53" />
								<image x="24.5" y="14.5" height="42" xlink:href="../assets/img/logo-undip.png">
							</svg>
						<h3>Selamat Datang</h3>
						<h5 class="">masuk ke dalam sistem</h5>
					</div>
					<div class="login-form">
						<form method="POST" class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="login">
							<div class="row diver">
								<div class="btn-group radio_akun" data-toggle="buttons">
						      <label class="btn btn-primary active">
						        <input type="radio" name="status"  value="dosen" checked> Dosen
						      </label>

									<label class="btn btn-primary">
						        <input type="radio" name="status" value="kadep" required>Departemen
						      </label>

						      <label class="btn btn-primary">
						        <input type="radio" name="status" value="admin"> Administrator
						      </label>
								</div>
							</div>
							<div class="row">
								<input type="text" name="uname" placeholder="Username" class="form-control input-lg" required/>
							</div>
							<div class="row">
								<input type="password" name="password" id="login_input" placeholder="Password" class="form-control input-lg" required/>
							</div>
							<!--
							 <div class="row">
                  <select name="status" class="form-control" id="level" required >
                      <option selected disabled>Pilih Level User</option>
                      <option value="admin">Administrator</option>
                      <option value="dosen">Dosen</option>
                  </select>
              </div>
						-->
							<button type="submit" name="submit" class="btn">Masuk</button>
						</form>
					</div>
			</div>
			</div>
		</form>
	</div>
</div>
<?php include_once('../include/footer.php'); ?>

<?php
if (isset($notif)) {
	switch ($notif) {
		case 1:
			echo showAlert($notif,'berhasil login ');
			break;
		case 2:
			echo showAlert($notif,'Username atau Password salah ');
			break;
		case 3:
			echo showAlert($notif,'Terdapat data kosong pada formulir ');
			break;
		case 4:
			echo showAlert($notif,'Masuk Kembali Menggunakan username dan password baru ');
			break;
	}
}
?>
	</body>
</html>
