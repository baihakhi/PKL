<?php
if (!isset($_SESSION['username'])) {
  // code...
  header('Location: ../landpage/index.php');
}
$name = $_SESSION['nama'];
$username = $_SESSION['username'];
$status = $_SESSION['akses'];
$foto = $_SESSION['foto'];
switch ($status) {
  case 'admin': $level='Administrator';
    break;
  case 'dosen': $level='Dosen';
    break;
}
//---------------------------------
  $site_name = "KIMIA"
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php $site_name ?></title>
		  <!-- BOOTSTRAP STYLES-->
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
		  <!-- FONTAWESOME STYLES-->
		<link href="../assets/css/font-awesome.css" rel="stylesheet" />
		<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		  <!-- CUSTOM STYLES-->
		<link href="../assets/css/custom.css" rel="stylesheet" />
		 <!-- GOOGLE FONTS-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
		<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" hKeloref="index.php"><i class="fa fa-thumbs-o-up"></i> <?php echo $site_name ?></a>
            </div>
			<div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">

				<a href="edit_profil.php?q=<?= $username ?>" title="ke laman utama" style="color:#fff; font-size:12px;"><i class="fa fa-lock"></i>

					<?php if($status=="admin") {echo $name." (".$level.")"; } elseif($status=="dosen") echo $name;?> </a>&nbsp;&nbsp;

				<a style="text-decoration: none; color:#fff; font-size:12px;"> <?php
					echo " ( ".date("D, Y-m-d") . " ". date("h:ia")." )&nbsp;&nbsp;";
				?>
				</a>

				<a href="../logout.php" class="btn-danger btn" style="display:inline;">Logout</a>
			</div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
					<img src="../assets/image/<?= $foto; ?>" class="user-image img-responsive" height="100px"/>
				</li>
				<li>
					<a class="active-menu" href="index.php"><i class="fa fa-dashboard fa-2x"></i> Dashboard</a>
				</li>
				<?php
				if($status=="admin"){
					echo '<li>
						<a href="#"><i class="fa fa-edit fa-2x"></i>Kelola Dosen<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="../admin/tambah_dosen.php">Input Dosen</a></li>
							<li><a href="../admin/index.php">Daftar Dosen</a></li>
						</ul>
					</li>';
				}elseif ($status=="dosen") {
					echo '<li>
						<a href="#"><i class="fa fa-edit fa-2x"></i> Kelola Kegiatan<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li><a href="tambah_kegiatan.php">Tambah Kegiatan</a></li>

						</ul>
					</li>';
				}elseif ($status=="dosen") {
					echo '<li>
						<a href="#"><i class="fa fa-edit fa-2x"></i> Kelola PKT<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">

							<li><a href="daftar_pkt.php">Daftar Mahasiswa PKT</a></li>


							<li><a href="daftar_penempatan.php">Daftar penempatan mahasiswa</a></li>

							<li><a href="daftar_bimbingan.php">Daftar bimbingan mahasiswa</a></li>
							<li><a href="daftar_input_judul.php">Input Judul Mahasiswa PKT</a></li>
							<li><a href="daftar_judul.php">Daftar Judul Mahasiswa PKT</a></li>
							<li><a href="input_nilai_pkt.php">Input Nilai PKT</a></li>
							<li><a href="nilai_pkt.php">Daftar Nilai PKT</a></li>
						</ul>
					</li>';
				}elseif ($status=="lab") {
					echo '<li>
						<a href="#"><i class="fa fa-edit fa-2x"></i> Kelola PKT<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">

							<li><a href="daftar_pkt.php">Daftar Mahasiswa PKT</a></li>
							<li><a href="bimbingan.php">Input bimbingan mahasiswa</a></li>


							<li><a href="daftar_penempatan.php">Daftar penempatan mahasiswa</a></li>

							<li><a href="daftar_bimbingan.php">Daftar bimbingan mahasiswa</a></li>
							<li><a href="daftar_judul.php">Daftar Judul Mahasiswa PKT</a></li>
							<li><a href="nilai_pkt.php">Daftar Nilai PKT</a></li>
						</ul>
					</li>';
					// <li><a href="mhs_lab.php">Input penempatan mahasiswa</a></li>
					//
				}
				?>
				<li>
						<?php
            if ($status=='dosen') {
              echo '<a href="#"><i class="fa fa-book fa-2x"></i> Kelola Karya ILmiah';
            }elseif ($status=='admin') {
              echo '<a href="#"><i class="fa fa-book fa-2x"></i> Kelola Mata Kuliah';
            }
						?>
					<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
<!--
						<?php
							if(($status=='dosen')||($status=='anggota')){
								echo '<li><a href="pendaftaran_tr1.php">Pendaftaran TR1</a></li>';
							}
						?>
						<li><a href="daftar_tr1.php">Daftar Mahasiswa TR</a></li>
						<li><a href="daftar_penempatan_tr1.php">Daftar penempatan mahasiswa</a></li>
						<li><a href="daftar_nilai_tr1_real.php">Daftar Nilai TR1</a></li>
						<li><a href="daftar_nilai_progress.php">Daftar Nilai Progress</a></li>
						<li><a href="daftar_nilai_outline.php">Daftar Nilai Outline</a></li>
-->
				<?php
					if($status=='dosen'){
						echo '<li><a href="tambah_karya_ilmiah.php">Input Karya Ilmiah</a></li>';

					}

				?>
				<?php
					if($status=='admin'){
						echo '<li><a href="daftar_mapel.php">Daftar Matakuliah</a></li>';
						echo '<li><a href="tambah_mapel.php">Tambah Matakuliah</a></li>';

					}
				?>
					</ul>
				</li>
                </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
