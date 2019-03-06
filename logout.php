<?php

session_start();
unset($_SESSION['user-raport']);
if (session_destroy){
  header('Location: login.php');
}
?>
