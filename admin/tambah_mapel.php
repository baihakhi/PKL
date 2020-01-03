<?php

session_start();

include_once('../include/function.php');
include_once('../include/sidebar.php');

$arrLab = getAllRow('laboratorium');
$arrListDosen = getAllRow('dosen');
$today = getdate();
$year = $today['year'];


if(isset($_POST['tambah'])){

  //================KAMUS-MATKUL
  $array = array();
  $kodeMP = readInput($_POST['kode']);

  if ($_POST['smt']='ganjil') {
    // code...
    $smt = 1;
    $dateUts =$year.'-08-01';
    $dateUas =$year.'-10-01';
//    echo "SMT = ".$smt;
  }elseif ($_POST['smt']='genap') {
    // code...
    $smt = 0;
    $dateUts =$year.'-02-01';
    $dateUas =$year.'-04-01';
//    echo "SMT = ".$smt;

  }

  array_push($array,!empty($_POST['kode']) ? $kodeMP : '');
  array_push($array,!empty($_POST['nama']) ? readInput($_POST['nama']) : '');
  array_push($array,!empty($_POST['fakultas']) ? readInput($_POST['fakultas']) : '');
  array_push($array,!empty($_POST['jurusan']) ? readInput($_POST['jurusan']) : '');
  array_push($array,!empty($_POST['tempat']) ? readInput($_POST['tempat']) : '');
  array_push($array,!empty($_POST['hari']) ? readInput($_POST['hari']) : '');
  array_push($array,!empty($_POST['smt']) ? $smt : '');
  array_push($array,!empty($_POST['T1']) ? readInput($_POST['T1']) : '');
  array_push($array,!empty($_POST['T2']) ? readInput($_POST['T2']) : '');

  if (in_array('',$array)) {
    $notif = 3;
  }
  else {
    if (!checkMapelExist($kodeMP)) {
      if (tambahMapel($array)) {
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

  $selectedNip1 = readInput($_POST['listDosenUts']);
  $selectedNip2 = readInput($_POST['listDosenUas']);
  $arrayTmp1 = array(); //===rray for table kegiatan_dosen
  $arrayTmp2 = array(); //===rray for table kegiatan_dosen
  array_push($arrayTmp1,!empty($_POST['listDosenUts']) ? $selectedNip1 : '');
  array_push($arrayTmp2,!empty($_POST['listDosenUas']) ? $selectedNip2 : '');
  array_push($arrayTmp1,!empty($_POST['kode']) ? $kodeMP : '');
  array_push($arrayTmp2,!empty($_POST['kode']) ? readInput($_POST['kode']) : '');

  $kbmUts = getAllDay($_POST['hari'], $dateUts);
  $kbmUas = getAllDay($_POST['hari'], $dateUas);
  $jumlahDay = count($kbmUts);

  for ($d=0; $d<$jumlahDay ; $d++) {
//    echo "---ITERASI ".$d."---";
//    $kkb1 = date_create($kbmUts[$d]);
//    $kkb2 = date_create($kbmUas[$d]);
    $date1 = $kbmUts[$d];
    $date2 = $kbmUas[$d];
//    print_r($kkb1);
//    echo $date1."  kbm uts 1 \n";
    $arrayTmp1 = array(); //===rray for table kegiatan_dosen
    $arrayTmp2 = array(); //===rray for table kegiatan_dosen
    array_push($arrayTmp1, $selectedNip1);
    array_push($arrayTmp1, $kodeMP);
    array_push($arrayTmp1, $date1);

    array_push($arrayTmp2, $selectedNip2);
    array_push($arrayTmp2, $kodeMP);
    array_push($arrayTmp2, $date2);

    if (in_array('',$arrayTmp1) || in_array('',$arrayTmp2)) {
      $notif = 3;//null data
//      echo "null";
    }else
//    print_r($arrayTmp1);echo "--tmp1 \n";
//    print_r($arrayTmp2);echo "--tmp2 \n";
      if (tambahMengampu($arrayTmp1) && tambahMengampu($arrayTmp2)) {
        $notif = 1;//sukses
//        echo "array2-".$i." sukses";
      }
      else {
        $notif = 4;
//        echo "notif 4";
      }
    unset($arrayTmp1);
    unset($arrayTmp2);
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
            <h5 class="judul center-align">Input data Mata Kuliah</h5>

            <div class="row">
              <form class="form-horizontal col s12" method="post" enctype="multipart/form-data">

                <table align="center" style="max-width:75% ;">
                  <tr>
                    <td>Nama Matakuliah</td>
                    <td class="colon">:</td>
                    <td colspan="4"><input type="text" name="nama" required></td>
                  </tr>
                  <tr>
                    <td>Kode Matakuliah</td>
                    <td class="colon">:</td>
                    <td colspan="4"><input type="text" name="kode" id="kode" onkeyup="capslock()"/></td>
                  </tr>
                  <tr>
                    <td>Jurusan</td>
                    <td class="colon">:</td>
                    <td ><input type="text" name="jurusan" title="Nama Departen" value="Kimia" maxlenght="2"/></td>
                    <td>Fakultas</td>
                    <td class="colon">:</td>
                    <td ><input type="text" name="fakultas" title="Nama Fakultas" value="FSM" maxlenght="2"/></td>
                  </tr>
                  <tr>
                    <td>Tempat</td>
                    <td class="colon">:</td>
                    <td ><input type="text" name="tempat"></td>
                  </tr>
                  <tr>
                    <td>Waktu</td>
                    <td class="colon">:</td>
                    <td>
                      <select id="hari" class="" name="hari" required>
                        <option selected disabled value="">- Pilih Hari -</option>
                        <option value="monday">Senin</option>
                        <option value="tuesday">Selasa</option>
                        <option value="wednesday">Rabu</option>
                        <option value="thursday">Kamis</option>
                        <option value="friday">Jumat</option>

                      </select>
                    </td>
                    <td>Jam</td>
                    <td class="colon">:</td>
                    <td >
                      <input type="time" name="T1" id="T1" style="display:inline; max-width: 40%" value="06:00" onclick="minimumTime()" onkeyup="minuteChange()">
                      s/d
                      <input type="time" name="T2" id="T2" style="display:inline; max-width: 40%">
                    </td>
                  </tr>
                  <tr>
                    <td>Semester</td>
                    <td class="colon">:</td>
                    <td class="form-group">
                      <div class="col-sm-10">
                            <label class="radio-inline">
                              <input type="radio" id="ganjil" name="smt" style="left:10px; margin-left:0; opacity:1;" value="ganjil" checked> Ganjil </label>
                            <label class="radio-inline">
                              <input type="radio" id="genap" name="smt" style="left:50%; margin-left:0; opacity:1;" value="genap"> Genap </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Pengampu</td>
                    <td class="colon">:</td>
                    <td colspan="4" style="width:75%;">
                      <div class="input-field col s12">
                        <span style="display:inline;">UTS</span>
                        <select class="listDosen" name="listDosenUts" required style="margin-bottom:10px; width:93%;">
                          <?php
                          while ($lDosen = $arrListDosen->fetch_object()) {
                            $nipD[] = $lDosen->nip;
                            $namaD[] = $lDosen->nama;
                          }
                          $jumlahDosen = count($nipD);
                          for ($i=0; $i<$jumlahDosen ; $i++){
                            echo "<option value=".$nipD[$i]." ".(($nipD[$i] == $selectedDosen) ? 'selected' : '').">".$namaD[$i]."</option>";
                          }
                        ?>
                        </select>
                        <span style="display:inline;">UAS</span> <select class="listDosen" name="listDosenUas" required style="width:93%;">
                          <?php
                          for ($i=0; $i<$jumlahDosen ; $i++){
                            echo "<option value=".$nipD[$i]." ".(($nipD[$i] == $selectedDosen) ? 'selected' : '').">".$namaD[$i]."</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </td>
                  </tr>
                </table>

                <div class="form-group kanan-align" style="margin-right:10%">
                  <button type="submit" class="btn waves-effect waves-light gree-btn" name="tambah">SUBMIT</button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>

    </main>

    <?php include_once('../include/footer.php'); ?>
    <script>
    function minimumTime() {
        var x = document.getElementById("T1").value;
        var hours = x.split(":")[0];
        var minutes = x.split(":")[1];
        hours = parseInt(hours)+1;
          if (hours<10){
            hours = "0"+hours;
          }
        x = hours+":"+minutes;
        document.getElementById("T2").value= x;
    }
    function minuteChange() {
        var x = document.getElementById("T1").value;
        var hours = x.split(":")[0];
        var minutes = x.split(":")[1];
        hours = parseInt(hours)+1;
          if (hours<10){
            hours = "0"+hours;
          }
        x = hours+":"+minutes;document.getElementById("T2").value= x;
    }
    function capslock() {
      var str = document.getElementById("kode").value;
      var res = str.toUpperCase();
      document.getElementById("kode").innerHTML= res;
    }

</script>


    <?php
    if (isset($notif)) {
      switch ($notif) {
        case 1:
          echo showAlert($notif,'Nilai berhasil ditambahkan '.$errPict);
          break;
        case 2:
          echo showAlert($notif,'Data dosen sudah ada'.$errPict);
          break;
        case 3:
          echo showAlert($notif,'Terdapat data kosong pada formulir '.$errPict);
          break;
        case 4:
          echo showAlert($notif,'Terjadi kesalahan saat proses input  '.$errPict);
          break;
      }
    }
    ?>

  </body>
</html>
