<?php

include('../include/function.php');
include_once('../include/sidebar.php');

$arrLab = getAllRow('laboratorium');
$target_dir = "../images/";
$gambar = "no_pict23.png";

//--------------read q input
if (isset($_GET['q'])) {
  $q = readInput($_GET['q']);
  $row = getSpesificRow('dosen','NIP',$q);

  if (checkQueryExist($row)) {
    while ($dosen = $row->fetch_object()) {
      $nama = $dosen->nama;
      $nip = $dosen->NIP;
      $ttl = $dosen->TTL;
      $alamat = $dosen->alamat;
      $email = $dosen->email;
      $selectedLab = $dosen->laboratorium;
      $foto = $dosen->foto;
      if (!empty($foto)){
        $gambar = $foto;
        $target_dir = "../assets/image/";
      }
    }
  }
  else {
    header('Location: index.php');
  }
}
else {
  header ('Location: 404.php');
}


$profilPict = $target_dir . $gambar;

//-------------parsing TTL
  $TTL = explode(",",$ttl);
  $date = $TTL[1];
  $city = $TTL[0];



//------------tombol SUBMIT
if(isset($_POST['ubah'])){

  $array = array();

//------------photo calling
  $allowed_type = array("jpg", "png", "jpeg");
//  $target_dir = "assets/image/";
  $target_file = $target_dir . basename($_FILES['userfile']['name']);
  $file_type = pathinfo($target_file,PATHINFO_EXTENSION);
  $nama_file = $_POST['NIP'] .'.'. $file_type;
  $upload_ok = 1;
  $upfoto = 0;


//------------upload foto

  if(!in_array($file_type, $allowed_type)) {
      $upload_ok = 0;
  }

      if ($upload_ok == 1){
        if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
          if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $target_dir . $_POST['NIP'] .'.jpg')){
            $notif = 1;
            $upfoto = 1;
          }
          else{
            $notif = 2;
            $upfoto = 0;
          }
        }
        else{
          $notif = 2;
          $upfoto = 0;
        }
      }

//-------------------INPUT-ARRAY

  $ttl = readInput($_POST['TTL']).','.readInput($_POST['TL']);

    array_push($array ,!empty($_POST['NIP']) ? readInput($_POST['NIP']) : '');
    array_push($array,!empty($_POST['nama']) ? readInput($_POST['nama']) : '');
    array_push($array,!empty($_POST['TTL']) && !empty($_POST['TL']) ? $ttl : '');
    array_push($array,!empty($_POST['email']) ? readInput($_POST['email']) : '');
    array_push($array,!empty($_POST['alamat']) ? readInput($_POST['alamat']) : '');
  if ($upfoto == 1) {
    array_push($array,!is_null($_FILES['userfile']['name']) ? readInput($nama_file) : '' );
  }
    array_push($array,!empty($_POST['lab']) ? readInput($_POST['lab']) : '');


//--------------------LOGIC-INPUT-ARRAY
  if (in_array('',$array)) {
    $notif = 3;
  }
  elseif($upfoto == 1) {
      if (editDosen($array,$q)) {
//        $notif = 1;
//        echo $array;
        header('Location: index.php');
      }
      else {
        $notif = 2;
      }
    }
    else {
      if (editDosen2($array,$q)) {
//        $notif = 1;
//        print_r($array);
        header('Location: info_dosen.php?q='.$q);
      }
      else {
        $notif = 2;
      }
    }
}


?>

<!DOCTYPE html>
<html>
  <head>
    <?php include('../include/head.php'); ?>
  </head>
  <body>

    <main>
      <div class="row">
        <div class="main-border">
          <div class="section col s12 m12 l12">
            <h5 class="judul center-align">Edit data dosen</h5>

            <div class="row">
              <form class="col s12" method="post" enctype="multipart/form-data">

                <div  class="kanan-align">
                  <div class="center-align">
                    <img src="<?= $profilPict; ?>" alt="foto dosen" class="foto-profil" border= 5px>
                    <input type="file" name="userfile" id=foto-button class="inputfile"/>
                    <label for="foto-button" class="btn" style="margin-top:20px"><span>UBAH FOTO</span></label>
                  </div>
                </div>

                <table align="center" style="max-width:75%;">
                  <tr>
                    <td>Nama</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="text" name="nama" placeholder="Robert Wiliam" value="<?= $nama?>"></td>
                  </tr>
                  <tr>
                    <td>NIP</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="text" name="NIP" title="Nomor Induk Pegawai" value="<?= $nip?>" ></td>
                  </tr>
                  <tr>
                    <td>Tempat tanggal lahir</td>
                    <td class="colon">:</td>
                    <td><input type="text" name="TTL" placeholder="Semarang, 01 Januari 2016" value="<?= $city?>" ></td>
                    <td><input type="date" name="TL" value="<?= $date ?>"></td>
                  </tr>
                  <tr>
                    <td>email</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="email" name="email" placeholder="william_R@mail.co.id" value="<?= $email?>" ></td>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td class="colon">:</td>
                    <td colspan="2"><textarea name="alamat" rows="1" cols="60" ><?= $alamat?></textarea></td>
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

                <div class="form-group center-align">
                  <button type="submit" class="btn waves-effect waves-light" name="ubah" onClick="reloadPage()">SIMPAN</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>

    </main>
    <script>
    function reloadPage() {
    location.reload();
    }
    </script>

    <?php
    include_once('../include/footer.php');

    if (isset($notif)) {
      switch ($notif) {
        case 1:
          echo showAlert($notif,'Data berhasil diubah');
          break;
        case 2:
          echo showAlert($notif,'Terjadi kesalahan saat proses input');
          break;
        case 3:
          echo showAlert($notif,'Terdapat data kosong pada formulir');
          break;
        case 4:
          echo showAlert($notif,'Data dosen sudah ada');
          break;
      }
    }
    ?>
  </body>
</html>
