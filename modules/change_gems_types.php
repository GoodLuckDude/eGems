<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

try {
  if ( empty($_POST) ) {
    throw new Exception ('Введите новое название типа');
  }

  $data = $_POST;

  foreach($data as $id => &$value) {
    $value = clear($value);

    DB::run("UPDATE gems_types SET type = ? WHERE id = ?",
      [$value, $id]
    );
    unset($value);
  }

  echo json_encode('Изменено!');
} catch (Exception $e) {
  echo json_encode($e->getMessage());
}

return;


?>