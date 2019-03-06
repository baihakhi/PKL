<?php


$status = "dosen";
$level = "Dosen";
$NIP = "199801012001020212";

include_once('../include/function.php');
include_once('../include/sidebar.php');

$arrLab = getAllRow('laboratorium');
$errPict = '';

$row = getSpesificRow('dosen','NIP',$NIP);
if (checkQueryExist($row)){
  while ($dosen = $row->fetch_object()) {
    $nip = 
  }
}
$kodeEmail = explode($NIP,)
$kode =

if(isset($_POST['tambah'])){


  //================KAMUS-MATKUL
  $array = array();

  array_push($array,!empty($_POST['kode']) ?  : '');
  array_push($array,!empty($_POST['nama']) ? readInput($_POST['judul']) : '');
  array_push($array,!empty($_POST['fakultas']) ? readInput($_POST['jenis']) : '');
  array_push($array,!empty($_POST['jurusan']) ? readInput($_POST['tempat']) : '');
  array_push($array,!empty($_POST['tempat']) ? readInput($_POST['tanggal']) : '');
  array_push($array,!empty($_POST['hari']) ? readInput($_POST['waktu']) : '');


  if (in_array('',$array)) {
    $notif = 3;
  }
  else {
    if (!checkKegiatanExist($_POST['id_kegiatan'])) {
      if (tambahKegiatan($array)) {
        $notif = 1;
//        header('Location: info_dosen.php?q='$nip)
      }
      else {
        $notif = 2;
      }
    }
    else {
      $notif = 4;
    }
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include_once('../include/head.php'); ?>
  </head>
  <body>

    <main>
      <div class="row">
        <div class="main-border">
          <div class="section col s12 m12 l12">
            <h5 class="judul center-align">Input data Kegiatan</h5>

            <div class="row">
              <form class="col s12" method="post" enctype="multipart/form-data">

                <table align="center" style="max-width:75% ;">
                  <tr>
                    <td>Judul Kegiatan</td>
                    <td class="colon">:</td>
                    <td colspan="4"><input type="text" name="judul" required></td>
                  </tr>
                  <tr>
                    <td>Jenis Kegiatan</td>
                    <td class="colon">:</td>
                    <td ><input type="text" name="jenis"></td>
                  </tr>
                  <tr>
                    <td>Tempat</td>
                    <td class="colon">:</td>
                    <td ><input type="text" name="tempat"></td>
                  </tr>
                  <tr>
                    <td>Tanggal</td>
                    <td class="colon">:</td>
                    <td><input type="date" name="tanggal" value="2019-01-01"></td>
                    <td>Jam</td>
                    <td class="colon">:</td>
                    <td >
                      <input type="time" name="waktu" style="display:inline; max-width: 45%" value="06:00">
                    </td>
                  </tr>
                </table>

                <div class="form-group kanan-align" style="margin-right:13%">
                  <button type="submit" class="btn waves-effect waves-light gree-btn" name="tambah">SUBMIT</button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>

    </main>

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
