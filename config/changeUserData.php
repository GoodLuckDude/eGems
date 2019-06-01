<?php

session_start();
redirIfGuest();

require_once './database.php';
require_once '../func/common.php';


$field = key($_POST);
$value = $_POST['email'];
$id = $_GET['id'];


DB::run("UPDATE users SET ".$field." = ? WHERE id = ?",
  [$value, $id]
);

header('Location: /profile/profile.php?id='.$_GET['id']);
?>