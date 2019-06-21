<?php
require_once "../config/database.php";
require_once "../func/common.php";

session_start();

if ( !checkMaster() ) {
  redirToProfile();
}

try{

  if( !$_SERVER['REQUEST_METHOD'] === 'POST' ) {
    throw new Exception ('Incorrect method');
    die;
  };

  if (!isset($_POST['type']) || $_POST['type'] == "") {
    throw new Exception ('Enter new name!');
  };

  $type = clean($_POST['type']);

  if (empty($type)) throw new Exception ('Incorrect name of type!');

  DB::run("INSERT INTO gems_types (type) VALUES (?)", [$type]);
  $typeId = DB::run("SELECT id FROM gems_types WHERE type = ?", [$type])->fetch();
  $elves = DB::run("SELECT id FROM users WHERE race = 'elf'");

  $addTypeWish = DB::prep("INSERT INTO wishes (elf_id, gem_type_id, wish) VALUES (?, ?, '0')");

  foreach ( $elves as $elf ) {
    $addTypeWish->execute(array($elf['id'], $typeId['id']));
  }

  $responce = array('code' => 'success');
  echo json_encode($responce);
} catch (Exception $e) {
  $responce = array('code' => 'error', 'msg' => $e->getMessage());
  echo json_encode($responce);
  die;
};

return;

?>