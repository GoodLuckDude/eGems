<?php
try{
  require_once "../config/database.php";
  require_once "../func/common.php";
  
  if( !$_SERVER['REQUEST_METHOD'] === 'GET' ) {
    die;
  };
 
  $usersArray = DB::run("SELECT id, name FROM users where race = 'elf'");

  $users = [];

  while ($row = $usersArray->fetch()) {
    $users[$row['name']] = $row['id'];
  }

  $responce = array('code' => 'success', 'users' => $users);
  echo json_encode($responce);

} catch (Exception $e) {
  $responce = array('code' => 'error', 'msg' => $e->getMessage());
  echo json_encode($responce);
  die;
};

return;

?>