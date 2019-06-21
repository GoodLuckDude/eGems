<?php
try{
  require_once "../../config/database.php";
  require_once "../../func/common.php";

  session_start();

  if ($_SESSION['loggedUser']['race'] != 'dwarf') {
    redirToProfile();
  }

  if( !$_SERVER['REQUEST_METHOD'] === 'POST' ) {
    die;
  };

  $extrGems = $_POST;

  if ($extrGems['dwarf_id'] == "") {
    throw New Exception('Не получен id гнома');
  };

  $availibleField = array();

  $types = DB::run('SELECT id FROM gems_types');

  while ($row = $types->fetch()) {
    array_push($availibleField, $row['id']);
  }

  array_push($availibleField, 'dwarf_id');

  foreach ($extrGems as $field => &$value) {
    if ( !in_array($field, $availibleField) || $value < 1 ) {
      unset($extrGems[$field]);
    };
    $value = clean($value);
    unset($value);
  }

  $dwarfId = $extrGems['dwarf_id'];
  unset($extrGems['dwarf_id']);

  if ( empty($extrGems) ) {
    echo json_encode('Нет гемов для добавления');
    return;
  }


  $sql = "INSERT INTO gems (gem_type_id, dwarf_id) VALUES";
  

  //Как нормально сделать множественный insert через execute?
  foreach ($extrGems as $typeId => $amount) {
    for ($i = 0; $i < $amount; $i++) {
      $sql .= " ($typeId, $dwarfId),";
    }
  };

  $sql = substr($sql,0,-1); //убираем последнюю запятую

  DB::run($sql);
  
  echo json_encode("Успешно!");

} catch (Exception $e) {
  echo json_encode($e->getMessage());
  die;
};

return;

?>