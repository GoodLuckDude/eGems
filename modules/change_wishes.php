<?php
  require_once "../config/database.php";
  require_once "../func/common.php";
  session_start();

try {
  if ( empty($_POST) ) {
    throw new Exception ('Wishes is empty!');
  }

  if ($_SESS)

  $wishes = $_POST;
  $availableTypes = array();
  $typesId = DB::run("SELECT id FROM gems_types");

  while ($row = $typesId->fetch()) {
    $availableTypes[] = $row['id'];
  }

  $sum = 0;

  foreach ($wishes as $typeId => &$wish) {
    if (!in_array($typeId, $availableTypes)) {
      unset($wish);
      unset($wishes[$typeId]);
    }
    $wish = round($wish/100, 2);
    $sum += $wish;
    unset($wish);
  };

  if ($sum != 1) throw new Exception ('Wishes sum not equal 1!');

  if (count($wishes) != count($availableTypes)) throw new Exception ('Not enough wishes!');

  $stmt = DB::prep("UPDATE wishes SET wish = ? WHERE elf_id = ? AND gem_type_id = ?");

  foreach ($wishes as $typeId => $wish) {
    $stmt->execute(array($wish, $_SESSION['loggedUser']['id'], $typeId));
  }


  $response = array('code' => 'success', 'msg' => 'Изменено!');
  echo json_encode($response);

} catch (Exception $e) {
  $response = array('code' => 'error', 'msg' => $e->getMessge());
  echo json_encode($response);
}

return;


?>