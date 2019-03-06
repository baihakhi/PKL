<?php

include('include/function.php');

if(isset($_POST['tambah'])){
  $array = array();

  array_push($array,!empty($_POST['NIP']) ? readInput($_POST['NIP']) : '');
  array_push($array,!empty($_POST['nama']) ? readInput($_POST['nama']) : '');
  array_push($array,!empty($_POST['TTL']) ? readInput($_POST['TTL']) : '');
  array_push($array,!empty($_POST['email']) ? readInput($_POST['email']) : '');
  array_push($array,!empty($_POST['alamat']) ? readInput($_POST['alamat']) : '');
  array_push($array,$_POST['namaFile']);


  if (in_array('',$array)) {
    $notif = 2;
  }
  else {
    if (!checkDosenExist($array)) {
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
print_r($array);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include_once('include/head.php'); ?>
  </head>
  <body>

    <main>
      <div class="row">
        <div class="main-border">
          <div class="section col s12 m12 l12">
            <h5 class="judul center-align">Input data dosen</h5>

            <div class="row">
              <form class="isian col s12" style"" method="post">
                <table align="center" style="max-width:800px;">
                  <tr>
                    <td>Nama</td>
                    <td class="colon">:</td>
                    <td><input type="text" name="nama" placeholder="Robert Wiliam" value="Robert William"></td>
                  </tr>
                  <tr>
                    <td>NIP</td>
                    <td class="colon">:</td>
                    <td><input type="text" name="NIP" title="Nomor Induk Pegawai" value="090919990909222209"></td>
                  </tr>
                  <tr>
                    <td>Tempat tanggal lahir</td>
                    <td class="colon">:</td>
                    <td><input type="text" name="TTL" placeholder="Semarang, 01 Januari 2016" value="Semarang, 01 Januari 2016"></td>
                  </tr>
                  <tr>
                    <td>email</td>
                    <td class="colon">:</td>
                    <td><input type="email" name="email" placeholder="william_R@mail.co.id" value="william_R@mail.co.id"></td>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td class="colon">:</td>
                    <td><textarea name="alamat" rows="1" cols="60">skdjhfkjasdfkjshhf</textarea></td>
                  </tr>
                </table>
                <div class="full-bar">
                  <div class="center-align">
                    <input type="file" name="gambar" id="file" class="inputfile" data-multiple-caption="{count} files selected" multiple />
                    <label for="file" class="btn" ><span id="namaFile">PILIH FOTO</span></label>
                  </div><br/>
<!--
                  <div class="center-align">
                    <div class="prof-pict fit-content">
                      <img src="images/no_pict23.png" alt="foto dosen" height="210px ">
                    </div>
                  </div>
-->

                </div>

                <div class="form-group center-align">
                  <button type="submit" class="btn waves-effect waves-light" name="tambah">SUBMIT</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>

    </main>

    <?php
    include_once('include/footer.php');
    global $db;
//    $cek = this.document;
//    $cd = $cek->getElmentById("namaFile");
    $dberror = "".$db->error;
    echo $dberror;
    if (isset($notif)) {
      switch ($notif) {
        case 1:
          echo showAlert($notif,'Nilai berhasil ditambahkan');
          break;
        case 2:
          echo showAlert($notif,$dberror);
          break;
        case 4:
          echo showAlert($notif,'Data dosen sudah ada');
          break;
      }
    }
    ?>

  </body>
</html>
