<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

try {
  if ( !isset($_POST['typeId']) ) {
    throw new Exception ('Некорректные данные');
  }

  $typeId = $_POST['typeId'];
  $typeId = clean($typeId);

  DB::run("UPDATE gems_types SET deleted = TRUE WHERE id = ?",
    [$typeId]
  );
  echo json_encode('Тип удалён');
} catch (Exception $e) {
  echo json_encode($e->getMessage());
}

return;


?>