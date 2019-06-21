<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

  session_start();

try {

  if ( $_POST['name'] == "" ) {
    throw new Exception ('Введите новое имя');
  };

  // echo json_encode($_POST);
  // return;

  if ($_POST['userId'] != $_SESSION['loggedUser']['id']) {
    throw new Exception ('У вас не достаточно прав!');
  };


  $name = $_POST['name'];
  $userId = clean($_POST['userId']);

  $name = clean($name);

  if ( $name == "" ) {
    throw new Exception ('Некорректное имя');
  };

  DB::run("UPDATE users SET name = ? WHERE id = ?", [$name, $userId]);

  $responce = array("code" => 'success', 'name' => $name);
  echo json_encode($responce);
} catch (Exception $e) {

  $responce = array("code" => 'error', 'msg' => $e->getMessage());
  echo json_encode($responce);
}

return;


?>