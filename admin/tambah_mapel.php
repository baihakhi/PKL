<?php

include_once('../include/function.php');
include_once('../include/sidebar.php');


if(isset($_POST['tambah'])){
  //kamus dosen
  $TTL    = readInput($_POST['KL']).",".readInput($_POST['TL']);

  array_push($array,!empty($_POST['id_mapel']) ? readInput($_POST['id_mapel']) : '');
  array_push($array,!empty($_POST['nama_mapel']) ? readInput($_POST['nama_mapel']) : '');
//  array_push($array,!empty($_POST['KL']) && !empty($_POST['TL']) ? $TTL : '');
array_push($array,!empty($_POST['jurusan']) ? readInput($_POST['jurusan']) : '');
array_push($array,!empty($_POST['semester']) ? readInput($_POST['semester']) : '');
  array_push($array,!empty($_POST['tempat']) ? readInput($_POST['tempat']) : '');
  array_push($array,!empty($_POST['hari']) ? readInput($_POST['hari']) : '');
  array_push($array,!empty($_POST['waktu']) ? readInput($_POST['waktu']) : '');

  if (in_array('',$array)) {
    $notif = 3;
  }
  else {
    if (!checkDosenExist($_POST['id_mapel'])) {
      if (tambahDosen($array)) {
        $notif = 1;
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
                    <td>Mata Kuliah</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="text" name="nama_mapel" placeholder="Kimia Terapan"></td>
                  </tr>
                  <tr>
                    <td>Kode Mata Kuliah</td>
                    <td class="colon">:</td>
                    <td colspan="3"><input type="text" name="id_mapel" placeholder="PAC3329"></td>
                  </tr>
                  <tr>
                    <td>Jurusan</td>
                    <td class="colon">:</td>
                    <td ><input type="text" name="jurusan" value="Kimia"></td>
                    <td >
                      <label for="smt" style="margin:0 10px 0 20px">Semester</label>
                      <input type="number" max="14" name="semester" id="smt" style="max-width:30%"></td>
                  </tr>
                  <tr>
                    <td>Ruangan</td>
                    <td class="colon">:</td>
                    <td ><input type="text" name="tempat"></td>
                    <td >
                      <label for="jam" style="margin:0 30px 0 20px">Hari</label>
                      <select name="hari">
                        <option value="senin">Senin</option>
                        <option value="selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                      </select>
                    </td>
                    <td >
                      <label for="jam" style="margin:0 30px 0 20px">Waktu</label>
                      <input type="time" autocomplete="on" name="waktu" id="jam" style="max-width:30%">
                    </td>
                  </tr>
                </table>

                <div class="form-group kanan-align" style="margin-right:10%"">
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
