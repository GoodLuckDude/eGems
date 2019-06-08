<?php

require_once './database.php';
require_once '../func/common.php';

session_start();
goToLoginPage();

function changeData() {
  $validValue = array('name', 'email', 'password', 'master');
  $field = key($_POST);
  $value = clean($_POST[$field]);
  $id = $_GET['id'];

  if ( !in_array($field, $validValue) ) {
    throw new ErrorException('Некорректное поле для изменения.');
  };
  
  if (      $field == 'master' && !checkMaster()
        ||  $field != 'master' && !checkDataChangeAccess($id)) {
    throw new ErrorException('Не хватает прав!');
  };

  DB::run("UPDATE users SET ".$field." = ? WHERE id = ?",
    [$value, $id]
  );
}

try {
  changeData();
} catch (ErrorException $e) {
  echo "Ошибочка: " . $e->getMessage() . '</br>';
  die;
}

header('Location: /profile/profile.php?id='.$_GET['id']);
?>