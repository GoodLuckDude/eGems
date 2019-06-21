<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

  session_start();

try {

  if (!checkDataChangeAccess($_POST['userId'])) {
    throw new Exception ('У вас не достаточно прав');
  };


  $email = clean($_POST['email']);
  $userId = clean($_POST['userId']);


  if ( $email == "" ) {
    throw new Exception ('Введите новый email');
  };

  DB::run("UPDATE users SET email = ? WHERE id = ?", [$email, $userId]);

  $responce = array("code" => 'success', 'msg' => "Email изменён", "email" => $email);
  echo json_encode($responce);
} catch (Exception $e) {

  $responce = array("code" => 'error', 'msg' => $e->getMessage());
  echo json_encode($responce);
}

return;


?>