<?php
include_once('koneksi.php');

function readInput($input){
  global $db;
  $input = trim($input);
  $input = stripcslashes($input);
  $input = htmlspecialchars($input);
  $input = mysqli_real_escape_string($db,$input);
  return $input;
}

function validInput($input){
  if (empty($input)){
    return false;
  }
  else {
    readInput($input);
  }
}

function validInputNumeric($input){
  if (preg_match('/^[0-9]*$/',$input)){
    return $input;
  }
  return '';
}

function validInputAlphabet($input){
  if (preg_match('/^[a-zA-Z]*$/',$input)){
    return $input;
  }
  return '';
}

function validInputAlphanumeric($input){
  if (preg_match('/^[a-zA-Z0-9]*$/',$input)){
    return $input;
  }
  return '';
}

//query function
function checkQuery($query){
  if (!$query){
    return false;
  }
  return true;
}

function runQuery($query){
  if (checkQuery($query)){
    return $query;
  }
  else {
    return null;
  }
}

function checkQueryExist($query){
  if ($query) {
    if ($query->num_rows > 0){
      return true;
    }
    else {
      return false;
    }
    return false;
  }
}

function countQueryExist($table,$idKolom,$id){
  global $db;
  $query = $db->query("SELECT * FROM ".$table." WHERE ".$idKolom." = '".$id."'");
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

function queryGetRowXColoumn($query,$kolom){
  if (checkQueryExist){
    $data = $query->fetch_object();
    return $data->$kolom;
  }
  else{
    return null;
  }
}


function getAllRow($table){
  global $db;
  $row = $db->query("SELECT * FROM ".$table);
  return runQuery($row);
}

function getFirstRow($table,$idKolom) {
  global $db;
  $row = $db->query("SELECT * FROM ".$table." ORDER BY ".$idKolom." ASC LIMIT 1");
  return checkQuery($row);
}

function getSpesificRow($table,$idKolom,$id){
  global $db;
  $row = $db->query("SELECT * FROM ".$table." WHERE ".$idKolom." = '".$id."'");
  return runQuery($row);
}

function getIdKaryaRows($nip){
  global $db;
  $row = $db->query("SELECT id_lab FROM karya_dosen WHERE nip = '".$nip."'");
  return runQuery($row);
}

function getSpesificRow2($table1,$table2,$idKolom,$id){
  global $db;
  $row = $db->query("SELECT * FROM ".$table1." JOIN ".$table2."
          ON ".$table1.".".$idKolom." = ".$table2.".".$idKolom."
          WHERE ".$table1.".".$idKolom." = '".$id."'");
  return runQuery($row);
}

function getMoreSpesificRow2($table1,$table2,$idKolom1,$idKolom2,$id){
  global $db;
  $row = $db->query("SELECT karya_ilmiah.id_karya, judul, tanggal, jenis, dana, pendana, dokumen
          FROM ".$table1." JOIN ".$table2."
          ON ".$table1.".".$idKolom1." = ".$table2.".".$idKolom1."
          WHERE ".$table1.".".$idKolom2." = '".$id."'");
  return runQuery($row);
}

function getKontributorSpesificRow ($table1,$table2,$idKolom1,$idKolom2,$id){
  global $db;
  $row = $db->query("SELECT nama, foto, dosen.nip
          FROM ".$table1." JOIN ".$table2."
          ON ".$table1.".".$idKolom1." = ".$table2.".".$idKolom1."
          WHERE ".$table1.".".$idKolom2." = '".$id."'");
  return runQuery($row);
}

function getKegiatanSpesificRow ($table1,$table2,$idKolom1,$idKolom2,$id){
  global $db;
  $row = $db->query("SELECT kegiatan.id_kegiatan, judul, tanggal, waktu, jenis, tempat
          FROM ".$table1." JOIN ".$table2."
          ON ".$table1.".".$idKolom1." = ".$table2.".".$idKolom1."
          WHERE ".$table1.".".$idKolom2." = '".$id."'");
  return runQuery($row);
}

function getKbmSpesificRow ($table1,$table2,$idKolom1,$idKolom2,$id){
  global $db;
  $row = $db->query("SELECT mapel.kode, nama, fakultas, jurusan, tempat, hari, semester, jamawal, jamakhir, mengampu.tanggal
          FROM ".$table1." JOIN ".$table2."
          ON ".$table1.".".$idKolom1." = ".$table2.".".$idKolom1."
          WHERE ".$table1.".".$idKolom2." = '".$id."'");
  return runQuery($row);
}

function getROwDistinct($table,$kolom){
  global $db;
  $row = $db->query("SELECT DISTINCT ".$kolom." FROM ".$table);
  return checkQuery($row);
}

//warning message  function
function showAlert($notif,$message) {
  switch ($notif) {
    case 1:
      return "<script>notie.alert('success', '".$message."', 2)</script>";
      break;
    case 2:
      return "<script>notie.alert('error', '".$message."', 2)</script>";
      break;
    case 3:
      return "<script>notie.alert('warning', '".$message."', 2)</script>";
      break;
    case 4:
      return "<script>notie.alert('info', '".$message."', 3)</script>";
      break;
    }
}

?>
