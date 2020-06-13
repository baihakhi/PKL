<?php
session_start();

include('../include/function.php');
include_once('../include/sidebar.php');

//--------------read q input
if (isset($_GET['q'])) {
  $q = readInput($_GET['q']);
  $row = getSpesificRow('admin','username',$q);

  if (checkQueryExist($row)) {
    while ($dosen = $row->fetch_object()) {
      $username = $dosen->username;
      $nip = $dosen->nip;
      $pass = $dosen->password;
      }
  }
  else {
    header('Location: index.php');
    //echo "row error";
  }
}
else {
  header ('Location: 404.php');
}

//------------tombol SUBMIT
if(isset($_POST['ubah'])){

  $array = array();
//-------------------INPUT-ARRAY
    array_push($array ,!empty($_POST['NIP']) ? readInput($_POST['NIP']) : '');
    array_push($array,!empty($_POST['username']) ? readInput($_POST['username']) : '');
if (!empty($_POST['password'])) {
  // code...
 $password = readInput($_POST['password']);

  if (editPassword('admin','username',$username,$passwordZ)) {
        $notif = 1;
//        print_r($array);
//       header('Location: index.php');
     }
     else {
       $notif = 2;
     }
}
elseif (empty($_POST['password'])) {
    if (editAdmin($username,$array)) {
         $notif = 1;
 //        print_r($array);
        header('Location: ../logout.php?n='.$notif.'');
      }
      else {
        $notif = 2;
      }
    }else {
      $notif = 3;
    }
    //echo "ga ada password \n";

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
            <h5 class="judul center-align">Edit Data</h5>

            <div class="row">
              <form class="col s12" method="post" enctype="multipart/form-data">

                <table align="center" style="max-width:75%;">
                  <tr>
                    <td>Username</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="text" name="username" value="<?= $username?>"></td>
                  </tr>
                  <tr>
                    <td>NIP</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="text" name="NIP" title="Nomor Induk Pegawai" value="<?= $nip?>" ></td>
                  </tr>
                  <tr>
                    <td>Kata Sandi</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="password" name="password" rows="1" cols="60"></td>
                  </tr>
                  <tr>
                    <td></td><td></td>
                    <td>
                      <div class="kanan-align">
                        <button type="submit" class="btn waves-effect waves-light" name="ubah">SIMPAN</button>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>

    </main>

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
