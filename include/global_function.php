<?php
include_once('koneksi.php');

function readInput($input){
  $input = trim($input);
  $input = stripcslashes($input);
  $input = htmlspecialchars($input);
  $input = mysql_real_escape_string($input);
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
      return "<script>notie.alert('info', '".$message."', 2)</script>";
      break;
  }
}

?>
