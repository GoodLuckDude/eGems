<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

  session_start();

try {

  if (!checkMaster()) {
    throw new Exception ('У вас не достаточно прав');
  };

  if( !isset($_POST['master']) ) {
    $_POST['master'] = 'f';
  };

  if (!$_POST['userId']) {
    throw new Exception ('Некорректные данные');
  };

  $userId = clean($_POST['userId']);
  $master = clean($_POST['master']);

  DB::run("UPDATE users SET master = ? WHERE id = ?", [$master, $userId]);

  $responce = array("code" => 'success', 'msg' => "Успешно!");
  echo json_encode($responce);

} catch (Exception $e) {

  $responce = array("code" => 'error', 'msg' => $e->getMessage());
  echo json_encode($responce);
}

return;


?>