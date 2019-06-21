<?php
  require_once "../config/database.php";
  require_once "../func/common.php";

  session_start();

  if( !checkMaster() ) {
    redirToProfile();
  }

try {
  if ( !isset($_POST['typeId']) ) {
    throw new Exception ('Некорректные данные');
  }

  $typeId = $_POST['typeId'];
  $typeId = clean($typeId);

  DB::run("UPDATE gems_types SET deleted = TRUE WHERE id = ?",
    [$typeId]
  );

  $deletedTypeWishes = DB::run("SELECT elf_id, wish FROM wishes WHERE gem_type_id = ?",
    [$typeId]  
  )->fetchAll();

  $types = DB::run("SELECT id FROM gems_types WHERE deleted = false")->fetchAll();
  $typesCount = count($types);

  $addExtraWish = DB::prep("UPDATE wishes SET wish = wish + ? WHERE elf_id = ? AND gem_type_id = ?");


  foreach ($deletedTypeWishes as $wish) {
    if ($typesCount != 0) {
      $extraWish = $wish["wish"] / $typesCount;
      foreach ($types as $type) {
        $addExtraWish->execute(array($extraWish, $wish['elf_id'], $type['id']));
      }
    }
    DB::run("UPDATE wishes SET wish = 0 WHERE elf_id = ? AND gem_type_id = ?",
      [$wish['elf_id'], $typeId]
    );
  }

  echo json_encode('Тип удалён');
} catch (Exception $e) {
  echo json_encode($e->getMessage());
}

return;


?>