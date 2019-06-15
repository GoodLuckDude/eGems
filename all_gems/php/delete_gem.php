<?php
  require_once "../../config/database.php";
  require_once "../../func/common.php";

try {
  if ( !isset($_GET['gemId']) ) {
    throw new Exception ('Некорректные данные');
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