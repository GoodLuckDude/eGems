<?php
try{
  require_once "../config/database.php";
  require_once "../func/common.php";
  
  if( !$_SERVER['REQUEST_METHOD'] === 'GET' ) {
    die;
  };
 
  $types = DB::run("SELECT id, type FROM gems_types WHERE deleted = false")->fetchALL();
  echo json_encode($types);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
  die;
};

return;

?>