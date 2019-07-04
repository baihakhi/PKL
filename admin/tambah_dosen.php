<?php

$status = "admin";
$level = "Administrator";

include_once('../include/function.php');
include_once('../include/sidebar.php');

$arrLab = getAllRow('laboratorium');
$errPict = '';

if(isset($_POST['tambah'])){

  if ($_FILES['userfile']['error'] > 0)
  {
    switch ($_FILES['userfile']['error'])
    {
      case 1:  $errPict='File exceeded upload_max_filesize';
      case 2:  $errPict='File exceeded max_file_size';
      case 3:  $errPict='File only partially uploaded';
      case 4:  $errPict='No file uploaded';
      case 6:  $errPict='Cannot upload file: No temp directory specified';
      case 7:  $errPict='Upload failed: Cannot write to disk';
    }
  }

  //kamus foto
  $array        = array();
  $allowed_type = array("jpg", "png", "jpeg");
  $target_dir   = "../assets/image/";
  $target_file  = $target_dir . basename($_FILES['userfile']['name']);
  $file_type    = pathinfo($target_file,PATHINFO_EXTENSION);
  $nama_file    = $_POST['NIP'] .'.'. $file_type;
  $upload_ok    = 1;


  if (file_exists($target_file)) {
      $upload_ok = 0;

  }

  if(!in_array($file_type, $allowed_type)) {
      $upload_ok = 0;
  }

      if ($upload_ok != 0){
        if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
          if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $target_dir . $_POST['NIP'] .'.jpg')){
            $notif = 1;
          }
          else{
            $notif = 2;
          }
        }
        else{
          $notif = 2;
        }
      }
  //kamus dosen
  $TTL    = readInput($_POST['KL']).",".readInput($_POST['TL']);
  $nip    = readInput($_POST['NIP']);
  $psw    = md5($nip);

  array_push($array,!empty($_POST['NIP']) ? $nip : '');
  array_push($array,!empty($_POST['nama']) ? readInput($_POST['nama']) : '');
  array_push($array,!empty($_POST['KL']) && !empty($_POST['TL']) ? $TTL : '');
  array_push($array,!empty($_POST['email']) ? readInput($_POST['email']) : '');
  array_push($array,!empty($_POST['alamat']) ? readInput($_POST['alamat']) : '');
  array_push($array,!is_null($_FILES['userfile']['name']) ? readInput($nama_file) : '' );
  array_push($array, $psw );
  array_push($array,!empty($_POST['lab']) ? readInput($_POST['lab']) : '');

  if (in_array('',$array)) {
    $notif = 3;
  }
  else {
    if (!checkDosenExist($_POST['NIP'])) {
      if (tambahDosen($array)) {
        $notif = 1;
        header('Location: info_dosen.php?q=".$nip."');
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
            <h5 class="judul center-align">Input data dosen</h5>

            <div class="row">
              <form class="col s12" method="post" enctype="multipart/form-data">

                <table align="center" style="max-width:75% ;">
                  <tr>
                    <td>Nama</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="text" name="nama" placeholder="Robert Wiliam" required></td>
                  </tr>
                  <tr>
                    <td>NIP</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="text" name="NIP" title="Nomor Induk Pegawai" maxlenght="2" required/></td>
                  </tr>
                  <tr>
                    <td>Tempat Tanggal Lahir</td>
                    <td class="colon">:</td>
                    <td style="width:30%"><input type="text" name="KL" placeholder="Semarang" required></td>
                    <td><input type="date" name="TL" value="1980-01-01"></td>
                  </tr>
                  <tr>
                    <td>email</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="email" name="email" placeholder="william_R@mail.co.id" required></td>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td class="colon">:</td>
                    <td colspan="2"><textarea name="alamat" rows="2" cols="60" required></textarea></td>
                  </tr>
                  <tr>
                    <td>Laboratorium</td>
                    <td class="colon">:</td>
                    <td>
                      <?php
                        include_once('../include/input_lab.php');
                      ?>
                    </td>
                    </tr>
                </table>

                <!-- ./ INPUT FOTO DOSEN \. -->
                <div class="kiri-align" style="margin-left:12%">
                  <!--
                    <img src="<?= BASE ?>/images/no_pict23.png" alt="foto dosen" height="150px">
                  -->
                    <input type="file" name="userfile" id=foto-button class="inputfile"/>
                    <label for="foto-button" class="btn"><span>PILIH FOTO</span></label>
                </div>

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
      $("selectrequired]").css({display: "inline", height: 0, padding: 0, width: 0});
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
