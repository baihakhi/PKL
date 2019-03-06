<?php

define ("HOST","localhost");
define ("USER","root");
define ("PASS","");
define ("DATABASE","sipd");
define ("BASE","/PKL");

$db = new mysqli(HOST,USER,PASS,DATABASE);

if($db->connect_errno){
  echo "Koneksi ke database gagal :<br/>".$db->connect_error;
}

 ?>
