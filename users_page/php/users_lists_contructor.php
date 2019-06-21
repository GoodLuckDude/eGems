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

  $status = "%%";
  $name = '%'.$filters['name'].'%';

  if (isset($filters['status'])) {
    foreach ($filters['status'] as &$value) {
      $value = clean($value);
      unset($value);
    }
  }

  if ( count($filters['status']) == 1 ) {
    $status = '%'.$filters['status'][0].'%';
  }

  $users = DB::run("SELECT users.id, name, users.status, master, race, COUNT(gems.id) as gems_count, favorites
    FROM users
    LEFT JOIN gems as gems
    ON (users.id = gems.dwarf_id AND gems.deleted = false) OR (users.id = gems.elf_id AND gems.status = 'подтверждена' AND gems.deleted = false)
    LEFT JOIN (select elf_id, string_agg(type, ',') as favorites from
      (select elf_id, type from wishes LEFT JOIN gems_types on id = gem_type_id order by wish desc)
      as t group by elf_id) as fav
    ON fav.elf_id = users.id
    WHERE users.name ~~* ? AND users.status ~~* ?
    GROUP BY users.id,  fav.favorites",
    [$name, $status]
  )->fetchAll();

  foreach ($users as &$user) {
    $user['favorites'] = array_slice( explode(',', $user['favorites']), 0, 3 );
    unset($user);
  };

  $response = array(
    "code" => "success",
    "users" => $users
  );

  echo json_encode($response);

} catch (Exception $e) {

  $response = array(
    "code" => "error",
    "msg" => $e->getMessage()
  );

  echo json_encode($response);
  die;
};

return;

?>