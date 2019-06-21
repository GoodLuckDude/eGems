<?php
  require_once "../config/database.php";
  require_once "../func/common.php";
  session_start();

try {
  if ( empty($_POST['typeId']) ) {
    throw new Exception ('Nothing to confirm');
  }

  $typeId = $_POST['typeId'];

  //Если будет время, то БД переделать, чтоб не было русского языка в коде.
  //Все сообщения формировать на фронте
  $as = DB::run("UPDATE gems SET (confirmation_date, status) = 
    (current_date, 'подтверждена')
    WHERE elf_id = ? AND gem_type_id = ? AND status = 'назначена' AND deleted = false",
    [ $_SESSION['loggedUser']['id'], $typeId ]  
  );

  $response = array('code' => 'success');
  echo json_encode($response);

} catch (Exception $e) {
  $response = array('code' => 'error', 'msg' => $e->getMessage());
  echo json_encode($response);
}

return;


?>