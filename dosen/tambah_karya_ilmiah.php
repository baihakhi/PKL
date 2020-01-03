<?php
session_start();

include_once('../include/function.php');
include_once('../include/sidebar.php');

$arrListDosen = getAllRow('dosen');

//================KODE KEGIATAN

$rowDosen = getSpesificRow('dosen','nip',$NIP);
if (checkQueryExist($rowDosen)){
  while ($dosen = $rowDosen->fetch_object()) {
    $nip = $dosen->nip;
  }
}


if(isset($_POST['tambah'])){
  //KODE karya ilmiah
  $jenis = readInput($_POST['jenis-karya']);
  $tanggal = readInput($_POST['tanggal']);
  $arrtgl = explode("-",$tanggal);
  $selectedNip = $_POST['listDosen'];
//  print_r($selectedNip);
  $jumlahDosen = sizeof($selectedNip);
//  echo "jumlah dosen : ".$jumlahDosen;

//  $subNip = str_split($NIP,4);
  $kodeKarya = $jenis.$arrtgl[1].$arrtgl[2];
  $rowKarya  = getSpesificRow('karya_ilmiah','id_karya',$kodeKarya);
  $numKarya = countQueryKarya($kodeKarya)+1;
  $idKarya = $kodeKarya.$numKarya;

/*
  $numKegDos   = countQueryExist('kegiatan_dosen','nip',$NIP);
  //KODE KEGIATAN DOSEN
  $numKegDos=$numKegDos+1;
  $kodeKD = $subNip[1].$subNip[3].$subNip[4].$numKegDos;
*/
  //================INPUT DATABASE1

  $arrayKarya = array();//array for table kegiatan

  array_push($arrayKarya, $idKarya);
  array_push($arrayKarya,!empty($_POST['judul']) ? readInput($_POST['judul']) : '');
  array_push($arrayKarya,!empty($_POST['jenis-karya']) ? $jenis : '');
  array_push($arrayKarya,!empty($_POST['tanggal']) ? $tanggal : '');
  array_push($arrayKarya,!empty($_POST['dana']) ? readInput($_POST['dana']) : '');
  array_push($arrayKarya,!empty($_POST['pendana']) ? readInput($_POST['pendana']) : '');
  array_push($arrayKarya,!empty($_POST['url']) ? readInput($_POST['url']) : '');

  if (in_array('',$arrayKarya)) {
    $notif = 3;//null data
//    echo "null";
//    print_r($arrayKarya);
  }else{
    if (!checkKaryaExist($kodeKarya)) {
      if (tambahKarya($arrayKarya)) {
        $notif = 1;//sukses
  //      echo "array1 sukses";
//        header('Location: info_dosen.php?q='$nip)
      }else {
        $notif = 2;//duplikasi
//        echo "array karya duplikasi";
        //include_once('../include/list_kegiatan.php');
      }
    }

  }

  for ($i=0; $i<=$jumlahDosen-1; $i++) {
    $arrayTmp = array(); //===rray for table kegiatan_dosen
    array_push($arrayTmp, !empty($_POST['listDosen']) ? $selectedNip[$i] : '');
    array_push($arrayTmp, $idKarya);
    if (in_array('',$arrayTmp) && in_array('',$arrayKarya)) {
      $notif = 3;//null data
//      echo "null";
    }else{
      if (tambahKaryaDosen($arrayTmp)) {
        $notif = 1;//sukses
//        echo "array2-".$i." sukses";
  //        header('Location: info_dosen.php?q='$nip)
      }
      else {
        $notif = 4;
//        echo "notif 4";
      }
    }
//    print_r($arrayTmp);
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
            <h5 class="judul center-align">Input Data Karya Ilmiah</h5>

<!-- FORM POST INPUT------------>
            <div class="row">
              <form id="kegiatans"class="col s12" method="post" enctype="multipart/form-data">

                <table align="center" style="max-width:75% ;">
                  <tr>
                    <td>Judul</td>
                    <td class="colon">:</td>
                    <td colspan="4"><input type="text" name="judul" maxlength="60" required></td>
                  </tr>
                  <tr>
                    <td>Jenis Karya Ilmiah</td>
                    <td class="colon">:</td>
                    <td >
                      <select id="jenis-karya" name="jenis-karya">
                        <option selected disabled value=''>- Pilih Jenis Karya Ilmiah -</option>;
                        <option value='P'>Paper</option>;
                        <option value='A'>Artikel</option>;
                        <option value='J'>Jurnal</option>;
                        <option value='M'>Modul</option>;
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Jumlah Dana</td>
                    <td class="colon">:</td>
                    <td colspan="4"><span style="width:5%; margin-right: -20px; ">Rp.</span>
                      <input type="text" step="100000" name="dana" class="dana" value="1500000" style="width:95%; display:inline-block; padding-left: 20px;" maxlength="10" ></td>
                  </tr>
                  <tr>
                    <td>Sumber Dana</td>
                    <td class="colon">:</td>
                    <td >
                      <select id="pendana" name="pendana" <?=empty($selectedPendana) ? 'required' : ''?> >
                        <option selected disabled value=''>- Pilih Sumber Dana -</option>;
                        <option value='U'>Universitas</option>;
                        <option value='J'>Jurusan</option>;
                        <option value='P'>Pribadi</option>;
                        <option value='S'>Sponsor</option>;
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Tanggal</td>
                    <td class="colon">:</td>
                    <td><input type="date" name="tanggal" value="2019-01-01"></td>
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
                  <tr>
                    <td>Link Dokumen</td>
                    <td class="colon">:</td>
                    <td colspan="4"><input type="text" name="url"></td>
                  </tr>
                  <tr>
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
      $('#listDosen').selectize({plugins:['remove_button'] });
    });
    $(document).ready(function(){
      $('.dana').mask('000.000.000.000', {reverse: true});
    });


    </script>
    <?php
    if (isset($notif)) {
      switch ($notif) {
        case 1:
          echo showAlert($notif,'Karya Ilmiah berhasil ditambahkan '.$errPict);
          break;
        case 2:
          echo showAlert($notif,'Data Karya Ilmiah sudah ada '.$errPict);
          break;
        case 3:
          echo showAlert($notif,'Terdapat data kosong pada formulir '.$errPict);
          break;
        case 4:
          echo showAlert($notif,'Terjadi kesalahan saat proses input '.$errPict);
          break;
      }
    }
    ?>

  </body>
</html>
