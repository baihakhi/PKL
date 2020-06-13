<?php

include('../include/function.php');

$today = getdate();
$year = $today['year'];

$kodeMP = readInput($_POST['id']);
$data1 = readInput($_POST['nip1']);
$data2 = readInput($_POST['nip2']);
$class = 'mengampu';
/*
$kodeMP = $_GET['id'];
$data1 = $_GET['nip1'];
$data2 = $_GET['nip2'];
*/
hapusMengampu($kodeMP);

$rowMP = getSpesificRow('mapel','kode',$kodeMP);
if (checkQueryExist($rowMP)) {
  while ($mapel = $rowMP->fetch_object()) {
    $day = $mapel->hari;
    $semester = $mapel->semester;
  }
}else{
//  echo "gagal";
}


if ($semester == 1) {
    $dateUts =$year.'-08-01';
    $dateUas =$year.'-10-01';
  }elseif ($semester == 2) {
    $dateUts =$year.'-02-01';
    $dateUas =$year.'-04-01';
  }

//echo "tanggal uts = ".$dateUts;
//echo "tanggal uas = ".$dateUas;

$kbmUts = getAllDay($day, $dateUts);
$kbmUas = getAllDay($day, $dateUas);
$jumlahDay = count($kbmUts);

for ($d=0; $d<$jumlahDay ; $d++) {
  $date1 = $kbmUts[$d];
  $date2 = $kbmUas[$d];
  $arrayTmp1 = array(); //===rray for table kegiatan_dosen
  $arrayTmp2 = array(); //===rray for table kegiatan_dosen
  array_push($arrayTmp1,!empty($data1) ? $data1 : '');
  array_push($arrayTmp1, $kodeMP);
  array_push($arrayTmp1, $date1);

  array_push($arrayTmp2,!empty($data2) ? $data2 : '');
  array_push($arrayTmp2, $kodeMP);
  array_push($arrayTmp2, $date2);

  if (in_array('',$arrayTmp1) || in_array('',$arrayTmp2)) {
    $stat = false;
  }

  else {
     tambahMengampu($arrayTmp1);
     tambahMengampu($arrayTmp2);
    $stat = true;
  }
  /*
  else
    print_r($arrayTmp1);echo "--tmp1 \n";
    print_r($arrayTmp2);echo "--tmp2 \n";
      if (tambahMengampu($arrayTmp1) && tambahMengampu($arrayTmp2)) {
        $notif = 1;//sukses
        echo "array2-".$d." sukses";
      }
      else {
        $notif = 4;
        echo "notif 4";
      }
  print_r($arrayTmp1);
  print_r($arrayTmp2);
  */
  unset($arrayTmp1);
  unset($arrayTmp2);
}
echo $stat;

?>
