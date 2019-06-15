<?php
try{
  require_once "../../config/database.php";
  require_once "../../func/common.php";
  
  if( !$_SERVER['REQUEST_METHOD'] === 'GET' ) {
    die;
  };

  $availableFields = array(
    'master', 'dwarf', 'elf', 'type', 'status', 'assignment_date>', 'assignment_date<',
    'confirmation_date>', 'confirmation_date<'
  );

  $filters = $_GET;

  foreach ($filters as $field => &$value) {
    if ( !in_array($field, $availableFields) ) {
      unset($value);
      unset($filters[$field]);
    } else {
      if ($value == "") {
        unset($value);
        unset($filters[$field]);
      } else {
        $value = clean($value);
        unset($value);
      }
    }
  };

  // foreach($filters as $field => $value) {
  //   if (!in_array($field, $availableFields)) {
  //     throw new Exception("Некорректное поле для фильтра: $field");
  //     die;
  //   }
  // }

  $sql = "SELECT
      gems.id, gems_types.type, dwarf.email as dwarf, master.email as master,
      elf.email as elf, gems.status,
      (case when gems.by_hand IS TRUE then 'вручную' else 'алгоритм' end) as method,
      to_char(gems.extraction_date, 'DD.MM.YYYY') as extraction_date,
      to_char(gems.assignment_date, 'DD.MM.YYYY') as assignment_date,
      to_char(gems.confirmation_date, 'DD.MM.YYYY') as confirmation_date
    FROM gems
    INNER JOIN gems_types ON gems.gem_type_id = gems_types.id
    INNER JOIN users as dwarf ON gems.dwarf_id = dwarf.id
    LEFT JOIN users as master ON gems.master_id = master.id
    LEFT JOIN users as elf ON gems.elf_id = elf.id
  ";

  $sqlWhere = " WHERE gems.deleted = FALSE";
  $values = array();

  foreach ($filters as $field => $value) {
    $prefix = "";
    $postfix = "";

    switch ($field) {
      case 'type':
        $prefix = 'gems_types.';
        break;
      case 'dwarf':
      case 'master':
      case 'elf':
        $postfix = ".email";
        break;
      default:
        $prefix = "gems.";
    }

    $sqlWhere .= " AND $prefix"."$field"."$postfix=?";
    array_push($values, $value);
  };

  $sql .= $sqlWhere;
  $sql .= " ORDER BY extraction_date";

  $gems = DB::run($sql, $values)->fetchAll();

  echo json_encode($gems);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
  die;
};

return;

?>