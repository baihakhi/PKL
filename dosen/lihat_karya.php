<?php
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

session_start();

$status = "admin";
$level = "Administrator";

include('../include/function.php');
include('../include/calendar.php');
include_once('../include/sidebar.php');


$target_dir = "../images/";
$gambar = "no_pict23.png";
//if level= Administrator dan dosen
/*$arrKegiatan = getAllRow('kegiatan');
while ($kegiatan = $arrKegiatan->fetch_object()) {
  $kodeK[] = $kegiatan->id_kegiatan;
  $judul[] = $kegiatan->judul;
  $tanggal[] = $kegiatan->tanggal;
  $waktu[] = $kegiatan->waktu;
  $jenis[] = $kegiatan->jenis;
  $tempat[] = $kegiatan->tempat;
}
*/



//--------------call calendar
//$dateComponents = date_create("2020-1-1");
//--------------read q input
if (isset($_GET['m'])){
  $month = $_GET['m'];
  $year = $_GET['y'];
  $firstDayOfMon = mktime(0,0,0,$month,1,$year);
  $dateComponents = getdate($firstDayOfMon);
  $monthString = $dateComponents['month'];
}else{
      $dateComponents = getdate();
      $monthString = $dateComponents['month'];
      $month = $dateComponents['mon'];
      $year = $dateComponents['year'];
}

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


    $m='';

  }
  else {
    header('Location: ../landpage/index.php');
  }
}
else {
  header ('Location: 404.php');
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
          <div class="full-bar">
            <div id='dp'>
              <?php
               echo build_previousMonth($month, $year, $monthString, $q);
               echo build_nextMonth($month,$year,$monthString, $q);
               echo build_calendar($month,$year,$dateComponents, $q);
               ?>
            </div>
            </div>
          </div>
        </div>
      </div>
    </main>

<?php include_once('../include/footer.php'); ?>
<script>
$(document).ready(function(){
  $('#import').change(function(){
    $('#form-import').submit();
  });
  $.fn.openForm = function() {
    var idk = this.attr('data-id');
    $(".form-popup").css("display","none");
    document.getElementById(idk).style.display = "block";
  };
  $.fn.closeForm = function() {
    var idk = this.parent().parent().attr('id');
    document.getElementById(idk).style.display = "none";
  };
});
</script>
  </body>
</html>
