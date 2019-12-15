<?php


$status = "dosen";
$level = "Dosen";
$NIP = "199801012001020212";

include_once('../include/function.php');
include_once('../include/sidebar.php');

$arrListDosen = getAllRow('dosen');
//$selectedNip = array();

//================KODE KEGIATAN

$rowDosen = getSpesificRow('dosen','nip',$NIP);
if (checkQueryExist($rowDosen)){
  while ($dosen = $rowDosen->fetch_object()) {
    $nip = $dosen->nip;
  }
}


if(isset($_POST['tambah'])){
  //KODE KEGIATAN
  $jenis = readInput($_POST['jenis-kegiatan']);
  $tanggal = readInput($_POST['tanggal']);
  $arrtgl = explode("-",$tanggal);
  $selectedNip = $_POST['listDosen'];
  print_r($selectedNip);
  $jumlahDosen = sizeof($selectedNip);
  echo "jumlah dosen : ".$jumlahDosen;

//  $subNip = str_split($NIP,4);
  $kodeKegiatan = $jenis.$arrtgl[1].$arrtgl[2];
  $rowKegiatan  = getSpesificRow('kegiatan','id_kegiatan',$kodeKegiatan);
  $numKegiatan = countQueryKegiatan($kodeKegiatan)+1;
  $idKegiatan = $kodeKegiatan.$numKegiatan;

/*
  $numKegDos   = countQueryExist('kegiatan_dosen','nip',$NIP);
  //KODE KEGIATAN DOSEN
  $numKegDos=$numKegDos+1;
  $kodeKD = $subNip[1].$subNip[3].$subNip[4].$numKegDos;
*/
  //================INPUT DATABASE1

  $arrayKegiatan = array();//array for table kegiatan

  array_push($arrayKegiatan, $idKegiatan);
  array_push($arrayKegiatan,!empty($_POST['judul']) ? readInput($_POST['judul']) : '');
  array_push($arrayKegiatan,!empty($_POST['jenis-kegiatan']) ? $jenis : '');
  array_push($arrayKegiatan,!empty($_POST['tempat']) ? readInput($_POST['tempat']) : '');
  array_push($arrayKegiatan,!empty($_POST['tanggal']) ? $tanggal : '');
  array_push($arrayKegiatan,!empty($_POST['waktu']) ? readInput($_POST['waktu']) : '');

  if (in_array('',$arrayKegiatan)) {
    $notif = 3;//null data
    echo "null";
  }else{
    if (!checkKegiatanExist($kodeKegiatan)) {
      if (tambahKegiatan($arrayKegiatan)) {
        $notif = 1;//sukses
        echo "array1 sukses";
//        header('Location: info_dosen.php?q='$nip)
      }else {
        $notif = 2;//duplikasi
        echo "array kegiatan duplikasi";
        //include_once('../include/list_kegiatan.php');
      }
    }

  }

  for ($i=0; $i<=$jumlahDosen-1; $i++) {
    $arrayTmp = array(); //===rray for table kegiatan_dosen
    array_push($arrayTmp,!empty($_POST['listDosen']) ? $selectedNip[$i] : '');
    array_push($arrayTmp, $idKegiatan);
    if (in_array('',$arrayTmp)) {
      $notif = 3;//null data
      echo "null";
    }else
      if (tambahKegiatanDosen($arrayTmp)) {
        $notif = 1;//sukses
        echo "array2-".$i." sukses";
  //        header('Location: info_dosen.php?q='$nip)
      }
      else {
        $notif = 4;
        echo "notif 4";
      }
    print_r($arrayTmp);
    unset($arrayTmp);
  }

//  array_push($array2,$kodeKD);
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

<!-- FORM POST INPUT------------>
            <div class="row">
              <form id="kegiatans"class="col s12" method="post" enctype="multipart/form-data">

                <table align="center" style="max-width:75% ;">
                  <tr>
                    <td>Judul Kegiatan</td>
                    <td class="colon">:</td>
                    <td colspan="4"><input type="text" name="judul" maxlength="60" required></td>
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
                    <td colspan="4"><input type="text" name="tempat" maxlength="60" ></td>
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
                  <tr>
                    <td>Kontributor</td>
                    <td class="colon">:</td>
                    <td colspan="4" style="width:75%;">
                      <?php
                        include_once('../include/input_dosen.php');
                      ?>
                    </td>
                  </tr>
                </table>

                <div class="form-group kanan-align" style="margin-right:10%;">
                  <button type="submit" class="btn waves-effect waves-light gree-btn" name="tambah" >SUBMIT</button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>

    </main>

    <?php include_once('../include/footer.php'); ?>
    <script>
    $(document).ready(function(){
      $('#listDosen').selectize({plugins:['remove_button']
      });

    });
    </script>
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
