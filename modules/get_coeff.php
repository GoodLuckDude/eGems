<?php
try{
  require_once "../config/database.php";
  require_once "../func/common.php";
  
  if( !$_SERVER['REQUEST_METHOD'] === 'GET' ) {
    die;
  };
 
  $coeffs = DB::run("SELECT * FROM assign")->fetch();
  echo json_encode($coeffs);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
  die;
};

return;

?>