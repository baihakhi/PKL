<?php

session_start();

include('../include/function.php');
include_once('../include/sidebar.php');

$target_dir = "../images/";
$gambar = "no_pict23.png";

//--------------read q input + daftar karya
if (isset($_GET['q'])) {
//  $idKarya = array();
  $q = readInput($_GET['q']);
  $rowMapel = getSpesificRow('mapel','kode',$q);
  if (checkQueryExist($rowMapel)) {
    while ($mapel = $rowMapel->fetch_object()) {
      $namaMapel = $mapel->nama;
      $kode = $mapel->kode;
      $fak = $mapel->fakultas;
      $jurusan = $mapel->jurusan;
      $tempat = $mapel->tempat;
      $day = $mapel->hari;
      $semester = $mapel->semester;
      $timeAwal = $mapel->jamawal;
      $timeAkhir = $mapel->jamakhir;
    }
  }
switch ($semester) {
  case '1':
    $smt = "Ganjil";
    break;
  case '2':
    $smt = "Genap";
    break;
}
  $hari = castHari($day);
  $time1 = explode(':', $timeAwal);
  $time2 = explode(':', $timeAkhir);
  $jamAwal = $time1[0];
  $menitAwal = $time1[1];
  $jamAkhir = $time2[0];
  $menitAkhir = $time2[1];
}

$rowPengampu = getPengampu($q);
$gambar=array();
if (checkQueryExist($rowPengampu)) {
  while ($pengampu = $rowPengampu->fetch_object()) {
    $nip[] = $pengampu->nip;
    $nama[] = $pengampu->nama;
    $gambar[] = $pengampu->foto;
  }
  if (!empty($nip)) {
    $numDosen = count($nip);
  }else {
    $numDosen = 0;
  }
  if (!empty($foto)){
    $target_dir = "../assets/image/";
    for ($i=0; $i<$numDosen; $i++) {
      $profilPict[$i] = $gambar[$i];
    }
  }
}

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
          <div class="full-bar rect-fluid-left rect-fluid-right">
            <div class="row judul-center kapital">
              <?php echo $namaMapel; ?>
            </div>
            <div class="row kiri-align rect-fluid-left rect-fluid-right">

              <table class="center" style="max-width:780px;">

                <tr>
                  <td style="width:20%;">Kode Matakuliah</td>
                  <td class="colon">:</td>
                  <td><?php echo $kode; ?></td>
                  <td></td>
                  <td style="width:20%;">Semester</td>
                  <td class="colon">:</td>
                  <td><?php echo $smt; ?></td>
                </tr>
                <tr>
                  <td style="width:20%;">Departemen</td>
                  <td class="colon">:</td>
                  <td><?php echo $jurusan; ?></td>
                  <td></td>
                  <td style="width:20%;">Fakultas</td>
                  <td class="colon">:</td>
                  <td><?php echo $fak; ?></td>
                </tr>
                <tr>
                  <td style="width:20%;">Tempat</td>
                  <td class="colon">:</td>
                  <td><?php echo $tempat; ?></td>
                  <td></td>
                  <td style="width:20%;">Waktu</td>
                  <td class="colon">:</td>
                  <td><?php echo $jamAwal.":".$menitAwal." WIB - ".$jamAkhir.":".$menitAkhir." WIB"; ?></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="width:20%;">Hari</td>
                  <td class="colon">:</td>
                  <td><?php echo $hari; ?></td>
                </tr>
              </table>
              <div class="kanan-align">
                <div class="btn" style="width:100%">
                  <a href="edit_mapel.php?q=<?= $kode ?>" >edit</a>
                </div>
              </div>
            </div>
            <div class="row kanan-align container-fluid">
              <div class="judul-center">
                <span> Dosen Pengampu </span>
              </div>
<?php
            if($numDosen>0){
              for ($j=0; $j < $numDosen; $j++) {
                // code...
                $file[$j] = $target_dir . $profilPict[$j];
                echo "<div class='row thumbnail-dosen '>
                        <div class='foto-container'>";
                echo '    <img src="'.$file[$j].'" alt="foto dosen" border="5px" class="foto-profil">';
                echo "  </div>

                          <div class='col-75 data-popup'>
                            <div id='nama".$j."'> ".$nama[$j]."</div>
                        </div>                        ";
                echo "

                          <div class='col-75 data-popup'>
                            <div id='nip".$j."'> ".$nip[$j]."</div>
                        </div>";
                echo "</div>";
              }
            }
 ?>
            </div>
            </div>
          </div>
      </div>
    </main>
<?php include_once('../include/footer.php'); ?>
  </body>
</html>
