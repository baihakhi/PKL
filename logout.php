<?php

unset($_SESSION['user-raport']);
session_destroy();
if (session_destroy){
  header('Location: landpage/index.php');
}
?>
