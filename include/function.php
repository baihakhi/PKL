<?php

ob_start();

require_once ('global_function.php');


//------------------------------admin login function
function login ($table,$kolom,$username,$password){
  global $db;

  $query = $db->query("SELECT * FROM ".$table." WHERE ".$kolom."='".$username."' ");
  if ($query->num_rows > 0){

    $data = $query->fetch_object();
    if ($data->password == $password){
      return true;
    }
    else {
      return false;
    }
  }
  else{
    return false;
  }
}


function getAdminDosen ($username){
  global $db;

  $query = $db->query("SELECT admin.password, dosen.nip, dosen.nama, dosen.alamat, dosen.email, dosen.foto
            FROM admin JOIN dosen
            ON admin.nip=dosen.nip
            WHERE admin.username='".$username."' ");
  return $query;
}

function getKadepDosen ($username){
  global $db;

  $query = $db->query("SELECT kadep.password, dosen.nip, dosen.nama, dosen.foto
            FROM kadep JOIN dosen
            ON kadep.nip=dosen.nip
            WHERE kadep.username='".$username."' ");
  return $query;
}

function getDosen ($username){
  global $db;

  $query = $db->query("SELECT * FROM dosen WHERE nip='".$username."' ");
  return $query;
}

function editPassword ($table, $colId, $id, $data){
  global $db;

  $query = $db->query("UPDATE ".$table." SET password='".$data."' WHERE ".$colId." = '".$id."'  ");

  return isset($query) ? checkQuery($query) : false;
}

function editAdmin($username, $arr){
  global $db;

  $query = $db->query("UPDATE admin SET username='".$arr[1]."', nip='".$arr[0]."' WHERE username = '".$username."'  ");
  return isset($query) ? checkQuery($query) : false;
}

//------------------------------FUNGSI DATA DOSEN
//input data dosen function
function checkDosenExist ($arr){
  global $db;
  $NIP = $arr[0];

  $query = $db->query("SELECT * FROM dosen WHERE nip='$NIP' ");
  return checkQueryExist($query);
}


//==============edit data dosen function
function tambahDosen ($arr){
  global $db;

  $query = $db->query("INSERT INTO dosen (NIP, nama, TTL, alamat, email, foto, password, laboratorium)
  VALUES ('$arr[0]','$arr[1]','$arr[2]','$arr[4]','$arr[3]','$arr[5]','$arr[6]','$arr[7]')");

  return isset($query) ? checkQuery($query) : false;
}

function editDosen($arr,$dosenID){
  global $db;

  $query = $db->query("UPDATE dosen SET NIP='".$arr[0]."', nama='".$arr[1]."', TTL='".$arr[2]."', alamat='".$arr[4]."', email='".$arr[3]."', foto='".$arr[5]."', laboratorium='".$arr[6]."' WHERE NIP = '".$dosenID."'  ");

  return isset($query) ? checkQuery($query) : false;
}

function editDosen2($arr,$dosenID){
  global $db;

  $query = $db->query("UPDATE dosen SET NIP='".$arr[0]."', nama='".$arr[1]."', TTL='".$arr[2]."', email='".$arr[3]."', alamat='".$arr[4]."', laboratorium='".$arr[5]."' WHERE NIP = '".$dosenID."'  ");

  return isset($query) ? checkQuery($query) : false;
}

function getLabDosen($id){
  global $db;

  $query = $db->query("SELECT * FROM laboratorium JOIN dosen
                        ON laboratorium.id_lab=dosen.laboratorium
                        WHERE dosen.laboratorium=".$id);

  return isset($query) ? runQuery($query) : false;
}

//delete data dosen
function hapusDosen($id){
  global $db;

  $query = $db->query("DELETE FROM dosen WHERE nip='$id'");

  return isset($query) ? checkQuery($query) : false;
}

//===========================FUNGSI DATA MATA KULIAH

function checkMapelExist ($arr){
  global $db;
  $kode = $arr[0];

  $query = $db->query("SELECT * FROM mapel WHERE kode='$kode' ");
  return checkQueryExist($query);
}

function checkDosenMengampuExist ($nip,$kode){
  global $db;

  $query = $db->query("SELECT * FROM mapel WHERE kode='$kode' AND nip='$nip' ");
  return checkQueryExist($query);
}
function tambahMapel ($arr){
  global $db;

  $query = $db->query("INSERT INTO mapel (kode, nama, fakultas, jurusan, tempat, hari, semester, jamawal, jamakhir)
  VALUES ('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]','$arr[7]','$arr[8]')");

  return isset($query) ? checkQuery($query) : false;
}

function getAllDay($day,$date){

    $days = array();
    $tgl = date_create($date);
    $dt = strtotime("$date $day"); // Black magic :-)
    $wk = 0;
    $m = date('n',$dt);
    $d = date('d',$dt);
    $y = $tgl->format('Y');

    while ($wk < 8) {
        $days[] = date('Y-n-d',mktime(0,0,0,$m,$d,$y));
        //echo $days[$wk]."\n";
        $d += 7;
        $wk++;
    }

    return $days;
}

function tambahMengampu ($arr){
  global $db;
  $query = $db->query(
    "INSERT INTO mengampu (nip, kode, tanggal)
    VALUES ('$arr[0]','$arr[1]','$arr[2]') ");

  return isset($query) ? checkQuery($query) : false;
}

function hapusMengampu($id){
  global $db;

  $query = $db->query("DELETE FROM mengampu WHERE kode='$id'");

  return isset($query) ? checkQuery($query) : false;
}

function hapusDosenMengampu($id){
  global $db;

  $query = $db->query("DELETE FROM mengampu WHERE kode='$id'");

  return isset($query) ? checkQuery($query) : false;
}

function editMapel($arr,$dosenID){
  global $db;

  $query = $db->query("UPDATE dosen SET NIP='".$arr[0]."', nama='".$arr[1]."', TTL='".$arr[2]."', alamat='".$arr[4]."', email='".$arr[3]."', foto='".$arr[5]."', laboratorium='".$arr[6]."'
    WHERE NIP = '".$dosenID."'  ");

  return isset($query) ? checkQuery($query) : false;
}

//DELETE DATA
function hapusData($class,$id){
  global $db;
  switch ($class) {
    case 'dosen':
      $data = 'nip';
      break;

    case 'mapel':
      $data = 'kode';
      break;

    case 'kegiatan':
      $data = 'id_kegiatan';
      break;

    case 'mengampu':
      $data = 'kode';
      break;
  }

  $query = $db->query("DELETE FROM $class WHERE $data='$id'");

  return isset($query) ? checkQuery($query) : false;
}

//===========================FUNGSI DATA KEGIATAN DOSEN

function checkKegiatanExist ($arr){
  global $db;
  $kode = $arr[0];
  $judul = $arr[1];

  $query = $db->query("SELECT * FROM kegiatan WHERE kegiatan.judul = '".$judul."'AND kegiatan.kode LIKE '".$kode."%' ");
  return checkQueryExist($query);
}

function excludeDosen ($nip){
  global $db;

  $query = $db->query("SELECT * FROM dosen WHERE nip != '$nip' ");
  return runQuery($query);
}

function getSpesificKegiatan($jenis){
  global $db;
  $row = $db->query("SELECT * FROM 'kegiatan' WHERE 'id_kegiatan' LIKE '".$jenis."%'");
  return runQuery($row);
}

function getKegiatan($id){
  global $db;

  $query = $db->query("SELECT * FROM kegiatan_dosen JOIN kegiatan
                        ON kegiatan_dosen.id_kegiatan=kegiatan.id_kegiatan
                        WHERE kegiatan.id_kegiatan LIKE '".$id."%'");

  return isset($query) ? runQuery($query) : false;
}

function getKegiatanByDay($year, $mon, $day){
  global $db;

  $query = $db->query("SELECT DISTINCT kegiatan.id_kegiatan, judul, tanggal, waktu, tempat, jenis
                        FROM kegiatan_dosen JOIN kegiatan
                        ON kegiatan_dosen.id_kegiatan=kegiatan.id_kegiatan
                        WHERE kegiatan.tanggal='".$year."-".$mon."-".$day."'");

  return isset($query) ? runQuery($query) : false;
}

function getKegiatanByHour($year, $mon, $day, $jam){
  global $db;

  $query = $db->query("SELECT DISTINCT kegiatan.id_kegiatan, judul, tanggal, waktu, tempat, jenis
                        FROM kegiatan_dosen JOIN kegiatan
                        ON kegiatan_dosen.id_kegiatan=kegiatan.id_kegiatan
                        WHERE kegiatan.tanggal='".$year."-".$mon."-".$day."'
                        AND kegiatan.waktu LIKE '".$jam."%'");

  return isset($query) ? runQuery($query) : false;
}

function getKegiatanByMonth($year, $mon){
  global $db;

  $query = $db->query("SELECT DISTINCT kegiatan.id_kegiatan, judul, kegiatan.tanggal, waktu
                        FROM kegiatan_dosen JOIN kegiatan
                        ON kegiatan_dosen.id_kegiatan=kegiatan.id_kegiatan
                        WHERE kegiatan.tanggal LIKE '".$year."-".$mon."-%'");

  return isset($query) ? runQuery($query) : false;
}

function tambahKegiatan ($arr){
  global $db;

  $query = $db->query("INSERT INTO kegiatan (id_kegiatan, judul, jenis, tempat, tanggal, waktu)
  VALUES ('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]')");

  return isset($query) ? checkQuery($query) : false;
}

function tambahKegiatanDosen ($arr){
  global $db;

  $query = $db->query(
    "INSERT INTO kegiatan_dosen (nip, id_kegiatan)
    VALUES ('$arr[0]','$arr[1]')
    ");

  return isset($query) ? checkQuery($query) : false;
}

function countQueryKegiatan($jenis){
  global $db;
  $query = $db->query("SELECT * FROM 'kegiatan' WHERE 'id_kegiatan' LIKE ".$jenis."%");
  if ($query) {
    if ($query->num_rows > 0){
      return $query->num_rows;
    }
    else {
      return false;
    }
    return false;
  }
}

//===========================FUNGSI DATA KEGIATAN DOSEN

function checkKaryaExist ($arr){
  global $db;
  $kode = $arr[0];
  $judul = $arr[1];

  $query = $db->query("SELECT * FROM karya_ilmiah WHERE karya.judul = '".$judul."'AND karya.kode LIKE '".$kode."%' ");
  return checkQueryExist($query);
}

function getSpesificKarya($jenis){
  global $db;
  $row = $db->query("SELECT * FROM 'karya_ilmiah' WHERE 'id_arya' LIKE '".$jenis."%'");
  return runQuery($row);
}

function getKarya($id){
  global $db;

  $query = $db->query("SELECT * FROM karya_ilmiah JOIN karya_dosen
                        ON karya_dosen.id_karya=karya_ilmiah.id_karya
                        WHERE karya_ilmiah.id_karya LIKE '".$id."%'");

  return isset($query) ? runQuery($query) : false;
}

function getPengampu($id){
  global $db;
  $row = $db->query("SELECT DISTINCT dosen.nip,dosen.foto,nama
          FROM mengampu JOIN dosen
          ON mengampu.nip=dosen.nip
          WHERE mengampu.kode ='".$id."'");
  return runQuery($row);
}

function getMengampuByMonth($mon, $year){
  global $db;
  $row = $db->query("SELECT DISTINCT mapel.kode, mapel.nama, jamawal, jamakhir, tanggal, hari
          FROM mengampu JOIN mapel
          ON mengampu.kode=mapel.kode
          WHERE mengampu.tanggal LIKE '".$year."-".$mon."-%'");
  return runQuery($row);

}

function getMengampuByHour($mon, $year, $day, $jam){
  global $db;
  $row = $db->query("SELECT DISTINCT mapel.kode, mapel.nama, tempat, fakultas, jurusan, jamawal, jamakhir, tanggal, hari
          FROM mengampu JOIN mapel
          ON mengampu.kode=mapel.kode
          WHERE mengampu.tanggal='".$year."-".$mon."-".$day."'
          AND mapel.jamawal LIKE '".$jam."%'");
  return runQuery($row);

}

function getMengampuByDay($mon, $year, $day){
  global $db;
  $row = $db->query("SELECT DISTINCT mapel.kode, mapel.nama, jamawal, jamakhir, tanggal, hari
          FROM mengampu JOIN mapel
          ON mengampu.kode=mapel.kode
          WHERE mengampu.tanggal='".$year."-".$mon."-".$day."'");
  return runQuery($row);

}

function tambahKarya ($arr){
  global $db;

  $query = $db->query("INSERT INTO karya_ilmiah (id_karya, judul, jenis, tanggal, dana, pendana, dokumen)
  VALUES ('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]')");

  return isset($query) ? checkQuery($query) : false;
}

function tambahKaryaDosen ($arr){
  global $db;

  $query = $db->query(
    "INSERT INTO karya_dosen (nip, id_karya)
    VALUES ('$arr[0]','$arr[1]')
    ");

  return isset($query) ? checkQuery($query) : false;
}

function countQueryKarya($jenis){
  global $db;
  $query = $db->query("SELECT * FROM 'karya_ilmiah' WHERE 'id_karya' LIKE ".$jenis."%");
  if ($query) {
    if ($query->num_rows > 0){
      return $query->num_rows;
    }
    else {
      return false;
    }
    return false;
  }
}

function castJenisKarya($jenis){
  switch ($jenis) {
    case 'P': $jenis_karya = "Paper";
    break;
    case 'A': $jenis_karya = "Artikel";
    break;
    case 'J': $jenis_karya = "Jurnal";
    break;
    case 'M': $jenis_karya = "Modul";
    break;
  }
  return $jenis_karya;
}

function castJenisKegiatan($jenis){
  switch ($jenis) {
    case 'K': $jenis_kegiatan = "Keperluan Penelitian";
    break;
    case 'P': $jenis_kegiatan = "Pelatihan/Workshop";
    break;
    case 'R': $jenis_kegiatan = "Rapat";
    break;
    case 'S': $jenis_kegiatan = "Seminar";
    break;
  }
  return $jenis_kegiatan;
}

function castPendana($pendana){
  switch ($pendana) {
    case 'U': $pAnggar = "Universitas Diponegoro";
    break;
    case 'J': $pAnggar = "Departemen Kimia";
    break;
    case 'P': $pAnggar = "Dana Pribadi";
    break;
    case 'S': $pAnggar = "Modal Sponsor";
    break;
  }
  return $pAnggar;
}

function castHari($day){
  switch ($day) {
    case "Monday": $hari = "Senin";
      break;
    case "Tuesday": $hari = "Selasa";
      break;
    case "Wednesday": $hari = "Rabu";
      break;
    case "Thursday": $hari = "Kamis";
      break;
    case "Friday": $hari = "Jumat";
      break;
    case "Saturday": $hari = "Sabtu";
      break;
    case "Sunday": $hari = "Minggu";
      break;
  }
  return $hari;
}

function castBulan($month){
  switch ($month) {
    case "January": $bulan = "Januari";
      break;
    case "February": $bulan = "Februari";
      break;
    case "March": $bulan = "Maret";
      break;
    case "April": $bulan = "April";
      break;
    case "May": $bulan = "Mei";
      break;
    case "June": $bulan = "Juni";
      break;
    case "July": $bulan = "Juli";
      break;
    case "August": $bulan = "Agustus";
      break;
    case "September": $bulan = "September";
      break;
    case "October": $bulan = "Oktober";
      break;
    case "November": $bulan = "November";
      break;
    case "December": $bulan = "Desember";
        break;

  }
  return $bulan;
}
?>
