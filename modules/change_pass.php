<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

  session_start();

try {

  $oldPass = clean($_POST['oldPassword']);
  $pass    = clean($_POST['password']);
  $conf    = clean($_POST['confirmedPassword']);

  if (!checkDataChangeAccess($_POST['userId'])) {
    throw new Exception ('У вас не достаточно прав');
  };

  $hash = DB::run("SELECT password FROM users WHERE id = ?", [$_POST['userId']])->fetch();

  if ( !password_verify($oldPass,  $hash['password']) ) {
    throw new Exception ('Неверно введён старый пароль');
  };

  if ($pass != $conf) {
    throw new Exception ('Пароли не совпадают');
  };

  $userId = clean($_POST['userId']);

  if ( $pass == "" ) {
    throw new Exception ('Введите новый пароль');
  };

  $pass = password_hash($pass, PASSWORD_DEFAULT);

  DB::run("UPDATE users SET password = ? WHERE id = ?", [$pass, $userId]);

  $responce = array("code" => 'success', 'msg' => "Пароль изменён");
  echo json_encode($responce);
} catch (Exception $e) {

  $responce = array("code" => 'error', 'msg' => $e->getMessage());
  echo json_encode($responce);
}

return;


?>