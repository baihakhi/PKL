<?php

$status = "admin";
$level = "Administrator";

include('../include/function.php');
include_once('../include/sidebar.php');

$target_dir = "../images/";
$gambar = "no_pict23.png";

//--------------read q input
if (isset($_GET['q'])) {
  $q = readInput($_GET['q']);
  $row = getSpesificRow('dosen','nip',$q);

  if (checkQueryExist($row)) {
    while ($dosen = $row->fetch_object()) {
      $nama = $dosen->nama;
      $nip = $dosen->nip;
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
    <link type="text/css" rel="stylesheet" href="../assets/fullcal/themes/calendar_green.css" />
    <script src='../assets/fullcal/js/daypilot/daypilot-all.min.js'></script>

  </head>
  <body>
    <main>
      <div class="row main-border">
        <div class="section col s12 l12">
          <div class="full-bar">
            <div id='dp'>
            </div>

            </div>
          </div>
        </div>
      </div>
    </main>

<?php include_once('../include/footer.php'); ?>
    <script>
      var dp = new DayPilot.Calendar("dp");
      dp.viewType = "Week";
      dp.init();
    </script>

  </body>
</html>
