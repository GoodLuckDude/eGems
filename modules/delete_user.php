<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

  session_start();

try {

  if ( !$_SESSION['loggedUser']['master'] ) {
    throw new Exception ('Access denied');
    return;
  }

  if ( !isset($_POST['userId']) ) {
    throw new Exception ('Incorrect data');
    return;
  }

  $userId = $_POST['userId'];

  DB::run("UPDATE users SET status = 'deleted', deletion_date = current_date WHERE id = ?",
    [$userId]
  );

  $response = array(
    'code'  => 'success',
    'msg'   => 'Пользователь удалён' 
  );

  echo json_encode($response);

} catch (Exception $e) {
  $response = array(
    'code'  => 'error',
    'msg'   => $e->getMessage()
  );

  echo json_encode($response);
}

return;


?>