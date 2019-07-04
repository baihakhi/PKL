<?php

ob_start();

require_once ('global_function.php');


//------------------------------admin login function
function login ($table,$username,$password){
  global $db;

  $query = $db->query("SELECT * FROM ".$table." WHERE username='.$username.'");
  if ($query->num_rows > 0){

    $data = $query->fetch_object();
    if ($data->password == $password){
      return true;
    }
    else {
      return showAlert(2,"Password dan username tidak cocok");
    }
  }
  else{
    return showAlert(2,"username tidak ditemukan");
  }
  return true;
  //echo $query;
}

/*
function getAdmin ($username){

  $admin = $query->fetch_object();
  $nama = $admin->nama;
}
*/


//------------------------------FUNGSI DATA DOSEN
//input data dosen function
function checkDosenExist ($arr){
  global $db;
  $NIP = $arr[0];
  $nama = $arr[1];
  $TTL = $arr[2];
  $email = $arr[3];
  $alamat = $arr[4];
  $foto = $arr[5];

  $query = $db->query("SELECT * FROM dosen WHERE NIP='$NIP' ");
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

function tambahMapel ($arr){
  global $db;

  $query = $db->query("INSERT INTO mapel (kode, nama, fakultas, jurusan, tempat, hari, jamawal, jamakhir)
  VALUES ('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]','$arr[7]')");

  return isset($query) ? checkQuery($query) : false;
}

function editMapel($arr,$dosenID){
  global $db;

  $query = $db->query("UPDATE dosen SET NIP='".$arr[0]."', nama='".$arr[1]."', TTL='".$arr[2]."', alamat='".$arr[4]."', email='".$arr[3]."', foto='".$arr[5]."', laboratorium='".$arr[6]."' WHERE NIP = '".$dosenID."'  ");

  return isset($query) ? checkQuery($query) : false;
}

//delete data mata kuliah
function hapusMapel($id){
  global $db;

  $query = $db->query("DELETE FROM mapel WHERE kode='$id'");

  return isset($query) ? checkQuery($query) : false;
}

//DELETE DATA
function hapusData($class,$id){
  global $db;
  switch ($class) {
    case 'dosen':
      $data = 'NIP';
      break;

    case 'mapel':
      $data = 'kode';
      break;

    case 'kegiatan':
      $data = 'id_kegiatan';
      break;
  }

  $query = $db->query("DELETE FROM $class WHERE $data='$id'");

  return isset($query) ? checkQuery($query) : false;
}

//===========================FUNGSI DATA KEGIATAN DOSEN

function checkKegiatanExist ($arr){
  global $db;
  $kode = $arr[0];

  $query = $db->query("SELECT * FROM kegiatan WHERE kode LIKE ".$kode."%");
  return checkQueryExist($query);
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

function tambahKegiatan ($arr){
  global $db;

  $query = $db->query("INSERT INTO kegiatan (id_kegiatan, judul, jenis, tempat, tanggal, waktu)
  VALUES ('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]')");

  return isset($query) ? checkQuery($query) : false;
}

function tambahKegiatanDosen ($arr){
  global $db;

  $query = $db->query(
    "INSERT INTO kegiatan_dosen(id_k_dos, nip, id_kegiatan)
    VALUES ('$arr[0]','$arr[1]','$arr[2]')");

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

?>
