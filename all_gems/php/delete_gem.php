<?php
  require_once "../../config/database.php";
  require_once "../../func/common.php";
  session_start();

try {

  if ($_SESSION['loggedUser']['master'] != true) {
    redirToProfile();
  }

  if ( !isset($_GET['gemId']) ) {
    throw new Exception ('Incorrect data');
  }

  $gemId = $_GET['gemId'];
  $gemId = clean($gemId);

  DB::run("UPDATE gems SET deleted = TRUE WHERE id = ?",
    [$gemId]
  );
  echo json_encode('Драгоценность удалена');
} catch (Exception $e) {
  echo json_encode($e->getMessage());
}

return;


?>