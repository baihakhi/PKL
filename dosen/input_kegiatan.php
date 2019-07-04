<?php


$status = "dosen";
$level = "Dosen";
$NIP = "199801012001020212";

include_once('../include/function.php');
include_once('../include/sidebar.php');


//================KODE KEGIATAN

$rowDosen = getSpesificRow('dosen','NIP',$NIP);
if (checkQueryExist($rowDosen)){
  while ($dosen = $rowDosen->fetch_object()) {
    $nip = $dosen->NIP;
  }
}


if(isset($_POST['tambah'])){

  //KODE KEGIATAN
  $jenis = readInput($_POST['jenis-kegiatan']);
  $tanggal = readInput($_POST['tanggal']);
  $arrtgl = explode("-",$tanggal);
  $subNip = str_split($NIP,4);

  $kodeKegiatan = $jenis.$arrtgl[1].$arrtgl[2];
  $rowKegiatan  = getSpesificRow('kegiatan','id_kegiatan',$kodeKegiatan);

  $numKegiatan = countQueryKegiatan($kodeKegiatan)+1;
  $numKegDos   = countQueryExist('kegiatan_dosen','nip',$NIP);
  $idKegiatan = $kodeKegiatan.$numKegiatan;

  //KODE KEGIATAN DOSEN
  $numKegDos=$numKegDos+1;
  $kodeKD = $subNip[1].$subNip[3].$subNip[4].$numKegDos;
  //================KAMUS-MATKUL
  $array1 = array();

  array_push($array1, $idKegiatan);
  array_push($array1,!empty($_POST['judul']) ? readInput($_POST['judul']) : '');
  array_push($array1,!empty($_POST['jenis-kegiatan']) ? $jenis : '');
  array_push($array1,!empty($_POST['tempat']) ? readInput($_POST['tempat']) : '');
  array_push($array1,!empty($_POST['tanggal']) ? $tanggal : '');
  array_push($array1,!empty($_POST['waktu']) ? readInput($_POST['waktu']) : '');

  $array2 = array();

  array_push($array2,$kodeKD);
  array_push($array2,$nip);
  array_push($array2,$idKegiatan);

/*
  print_r($subNip);
  echo $subNip[1]."\t nip 1 \t";
  echo $kodeKD."\t KD \t";
  echo $nip."\t nip \t";

  print_r($array1);
  print_r($array2);
*/
  if (in_array('',$array1) && in_array('',$array2)) {
    $notif = 3;
  }else{
    if (!checkKegiatanExist($kodeKegiatan)) {
      if (tambahKegiatan($array1) && tambahKegiatanDosen($array2)) {
        $notif = 1;
  //        header('Location: info_dosen.php?q='$nip)
      }else {
        //$notif = 2;
        include_once('../include/list_kegiatan.php');
        ?>
        <script>
         document.querySelector('.bg-modal').style.display = "flex";
        </script>
        <?php
      }
    }else {
//
    }

  /*
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
    */

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
                    <td colspan="4"><input type="text" name="judul" maxlength="40" required></td>
                  </tr>
                  <tr>
                    <td>Jenis Kegiatan</td>
                    <td class="colon">:</td>
                    <td >
                      <select id="jenis-kegiatan" name="jenis-kegiatan">
                        <option selected disabled value=''>- Pilih Jenis Kegiatan -</option>;
                        <option value='R'>Rapat</option>;
                        <option value='S'>Seminar</option>;
                        <option value='P'>Pelatihan</option>;
                        <option value='K'>Kepentingan Penelitian</option>;
                      </select>
                    <!--<input type="text" name="jenis">-->
                    </td>
                  </tr>
                  <tr>
                    <td>Tempat</td>
                    <td class="colon">:</td>
                    <td colspan="4"><input type="text" name="tempat" maxlength="40" ></td>
                  </tr>
                  <tr>
                    <td>Tanggal</td>
                    <td class="colon">:</td>
                    <td><input type="date" name="tanggal" value="2019-01-01"></td>
                    <td>Jam</td>
                    <td class="colon">:</td>
                    <td >
                      <input type="time" name="waktu" style="display:inline; max-width: 100%" value="06:00">
                    </td>
                  </tr>
                </table>

                <div class="form-group kanan-align" style="margin-right:13%;">
                  <button type="submit" class="btn waves-effect waves-light gree-btn" name="tambah" style="display:contents;">SUBMIT</button>
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
