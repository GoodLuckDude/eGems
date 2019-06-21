<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

  session_start();

  if ( !checkMaster() ) {
    redirToProfile();
  }

try {
  if ( empty($_POST) ) {
    throw new Exception ('Введите новое название типа');
  }

  $data = $_POST;

  $fullEmpty = true;

  foreach($data as $id => &$value) {
    $value = clean($value);
    if (!empty($value)) {
      DB::run("UPDATE gems_types SET type = ? WHERE id = ?",
        [$value, $id]
      );
      $fullEmpty = false;
    };
    unset($value);
  };
  
  if ($fullEmpty == true) {
    echo json_encode('Нечего изменять!');
  } else {
    echo json_encode('Изменено!');
  }
} catch (Exception $e) {
  echo json_encode($e->getMessage());
}

return;


?>