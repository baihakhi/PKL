<?php
include('../include/function.php');
include_once('../include/sidebar.php');

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
      $foto = $dosen->foto;
      $id_lab = $dosen->laboratorium;

      $row_lab = getLabDosen($id_lab);
      while ($lab = $row_lab->fetch_object()) {
        $nama_lab = $lab->nama_lab;
      }

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

//------------photo calling
  $target_dir = "assets/image/";

//-------------parsing TTL
  $TTL = explode(",",$ttl);
  $date = date_create($TTL[1]);
  $city = $TTL[0];

?>

<!DOCTYPE html>
<html>
  <head>
    <?php include('../include/head.php') ?>
    <title></title>
  </head>
  <body>
    <main>
      <div class="row main-border">
        <div class="section col s12 l12">
          <div class="full-bar">
            <?php
            if(!empty($img)){
              $file = $direktori . $img;
            }
            else {
              $img = 'no_pict23.png';
              $direktori = 'images/';
              $file = $direktori . $img;
            } ?>
            <div class="kiri-align">
              <div class="center-align">
                <img src="<?= $profilPict; ?>" alt="foto dosen" border="5px" class="foto-profil" onerror="this.onerror=null;../images/no_pict23.png;">
              </div>
            </div>
            <div class="row">
              <table align="center" style="max-width:780px;">
                <tr>
                  <td style="width:20%;">Nama</td>
                  <td class="colon">:</td>
                  <td><?php echo $nama; ?></td>
                </tr>
                <tr>
                  <td style="width:20%;">Nomor Induk Pegawai</td>
                  <td class="colon">:</td>
                  <td><?php echo $nip; ?></td>
                </tr>
                <tr>
                  <td style="width:20%;">Tempat tanggal lahir</td>
                  <td class="colon">:</td>
                  <td><?php echo $city,", ",date_format($date, "d F Y"); ?></td>
                </tr>
                <tr>
                  <td style="width:20%;">Alamat</td>
                  <td class="colon">:</td>
                  <td><?php echo $alamat; ?></td>
                </tr>
                <tr>
                  <td style="width:20%;">Email</td>
                  <td class="colon">:</td>
                  <td><?php echo $email; ?></td>
                </tr>
                <tr>
                  <td style="width:20%;">Laboratorium</td>
                  <td class="colon">:</td>
                  <td><?php echo $nama_lab; ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
<?php include_once('../include/footer.php'); ?>
  </body>
</html>
