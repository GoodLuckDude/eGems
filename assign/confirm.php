<?php
require_once '../config/database.php';
require_once '../func/common.php';

session_start();

if ($_SESSION['loggedUser']['master'] != true) {
  redirToProfile();
}

try {
  if( !isset($_POST["assign"]) || empty($_POST['assign'])) {
    return;
  }
  
  $assign = json_decode($_POST["assign"], true);
  $curDate = date("d.m.Y");
  $masterId = $_SESSION['loggedUser']['id'];
  
  foreach ($assign as $gemId => $data) {
    if ( is_bool($data['by_hand']) ) {
      $data['by_hand'] = ( $data['by_hand'] ? 't' : 'f' );
    }
    DB::run("UPDATE gems SET (assignment_date, master_id, by_hand, elf_id, status)
      = (?, ?, ?, ?, ?) WHERE id = ?",
      [$curDate, $masterId, $data['by_hand'], $data['elfId'], 'назначена', $gemId]
    );
  };
  
  echo json_encode('Успешно!');

} catch (Exeption $e) {

  echo $e->getMessage();
}

return;

?>