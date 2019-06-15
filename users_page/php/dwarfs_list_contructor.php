<?php
try{
  require_once "../../config/database.php";
  require_once "../../func/common.php";
  
  if( !$_SERVER['REQUEST_METHOD'] === 'GET' ) {
    die;
  };
 
  $availableFields = array("name", 'status');

  $filters = $_GET;

  foreach ($filters as $field => &$value) {
    if ( !in_array($field, $availableFields) ) {
      unset($value);
      unset($filters[$field]);
    }
  };

  if (isset($filters['name'])) {
    $filters['name'] = clean($filters['name']);
  }

  $name = '%'.$filters['name'].'%';

  if (isset($filters['status'])) {
    foreach ($filters['status'] as &$value) {
      $value = clean($value);
      unset($value);
    }
  }

  $sql = "SELECT users.id, name, master, race, COUNT(gems.id) as gems_count
    FROM users
    LEFT JOIN gems
      ON users.id = gems.dwarf_id OR users.id = gems.elf_id
  ";

  $vars = array($name);

  $sql .= ' AND name ~~* ?';
  
  if ( count($filters['status']) == 1 ) {
    $sql .= ' AND users.status = ?';
    array_push($vars, $filters['status'][0]);
  }


  $sql .= "WHERE race = 'dwarf' GROUP BY users.id, name, master";


  $dwarfs = DB::run($sql, $vars)->fetchAll();

  echo json_encode($dwarfs);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
  die;
};

return;

?>