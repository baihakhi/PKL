<?php

$target_dir = "assets/image/";
$target_file = $target_dir . basename($_FILES['gambar']['name']);
$upload_ok = 1;
$file_type = pathinfo($target_file,PATHINFO_EXTENSION);



function getTargetFile($file){
  $target_dir = "assets/image/";
  $target_file = $target_dir . basename($_FILES[$file]['name']);

  return $target_file;
}

function uploadGambar($file){
}

function validGambar($file){
  if (uploadGambar($file)){
    return true;
  }
  else {
    switch ($err_code) {
      case 'er-copy':
        return "Terdapat file dengan nama yang sama.";
        break;

      case 'er-format':
        return "Gunakan gambar dengan format .JPG, .PNG, .GIF";
        break;

      case 'er-upload':
        return "Kesalahan saat proses upload.";
        break;
    }
  }
}

?>
