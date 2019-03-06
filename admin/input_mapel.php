<?php

$status = "admin";
$level = "Administrator";

include_once('../include/function.php');
include_once('../include/sidebar.php');

$arrLab = getAllRow('laboratorium');
$errPict = '';

if(isset($_POST['tambah'])){


  //================KAMUS-MATKUL
  $array = array();

  array_push($array,!empty($_POST['kode']) ? readInput($_POST['kode']) : '');
  array_push($array,!empty($_POST['nama']) ? readInput($_POST['nama']) : '');
  array_push($array,!empty($_POST['fakultas']) ? readInput($_POST['fakultas']) : '');
  array_push($array,!empty($_POST['jurusan']) ? readInput($_POST['jurusan']) : '');
  array_push($array,!empty($_POST['tempat']) ? readInput($_POST['tempat']) : '');
  array_push($array,!empty($_POST['hari']) ? readInput($_POST['hari']) : '');
  array_push($array,!empty($_POST['T1']) ? readInput($_POST['T1']) : '');
  array_push($array,!empty($_POST['T2']) ? readInput($_POST['T2']) : '');

  if (in_array('',$array)) {
    $notif = 3;
  }
  else {
    if (!checkMapelExist($_POST['kode'])) {
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
              <form class="col s12" method="post" enctype="multipart/form-data">

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
    $(document).ready(function() {
      $('select').material_select();
      var namaLab = $('#lab').find('option:selected').text();
      $('#nama-lab').text(namaLab);
      $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
      $(".caret").css("height", "50px");
    });
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
