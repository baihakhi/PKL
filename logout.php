<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['akses']);
session_destroy();
if ((isset($_GET['n'])) && (session_destroy)) {
  // code...
  header('Location: landpage/index.php?n='.$_GET['n']);
}elseif (session_destroy){
  header('Location: landpage/index.php');
}
?>
