<?php
session_start();

include('../include/function.php');
include_once('../include/sidebar.php');

//--------------read q input
if (isset($_GET['q'])) {
  $q = readInput($_GET['q']);
  $row = getSpesificRow('dosen','nip',$q);

  if (checkQueryExist($row)) {
    while ($dosen = $row->fetch_object()) {
      $pass = $dosen->password;
      }
  }
  else {
    header('Location: index.php');
  }
}
else {
  header ('Location: 404.php');
}

//------------tombol SUBMIT
if(isset($_POST['ubah'])){

if (!empty($_POST['password'])) {
  // code...
 $password = md5(readInput($_POST['password']));
 if (!empty($_POST['konfirm'])) {
     if ($_POST['konfirm']==$_POST['password']) {
       if(editPassword('dosen','nip',$q,$password)) {
          $notif = 1;
       //        print_r($array);
         //header('Location: index.php');
       }
       else {
         $notif = 2;
       }
     }
     else {
       // code...
       $notif = 4;
     }
   }
   else {
     $notif = 3;
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
            <h5 class="judul center-align">Edit Password</h5>

            <div class="row">
              <form class="col s12" method="post" enctype="multipart/form-data">

                <table align="center" style="max-width:75%;">
                  <tr>
                    <td>Kata Sandi</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="password" name="password" rows="1" cols="60"></td>
                  </tr>
                  <tr>
                    <td>Konfirmasi Kata Sandi</td>
                    <td class="colon">:</td>
                    <td colspan="2"><input type="password" name="konfirm" rows="1" cols="60"></td>
                  </tr>
                </table>

                <div class="form-group center-align">
                  <button type="submit" class="btn waves-effect waves-light" name="ubah">SIMPAN</button>
                </div>

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
          echo showAlert(2,'kata sandi dan konfirmasi tidak cocok');
          break;
      }
    }
    ?>
  </body>
</html>
