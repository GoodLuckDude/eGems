<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

  session_start();

  if ( !checkMaster() ) {
    redirToProfile();
  }

try {
  if ( empty($_POST) ) {
    throw new Exception ('Введите коэффициенты');
  }

  $neededFields = array('equally', 'least_one', 'preferred');
  $fields = $_POST;

  foreach ($fields as $field => &$value) {
    if ( !in_array($field, $neededFields) || $value == "") {
      unset($value);
      throw new Exception ("$field");
    } else {
      $value = $value / 100;
      unset($value);
    }
  }

  DB::run("UPDATE assign SET (equally, least_one, preferred) = (?, ?, ?)",
    [$fields['equally'], $fields['least_one'], $fields['preferred']]
  );

  $response = array('code' => 'success', 'msg' => 'Изменено!');
  echo json_encode($response);

} catch (Exception $e) {
  $response = array('code' => 'error', 'msg' => $e->getMessge());
  echo json_encode($response);
}

return;


?>