<?php

include('../include/function.php');

$id = readInput($_POST['id']);
$class = readInput($_POST['class']);

echo hapusData($class,$id);
?>
