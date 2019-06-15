<?php 
require_once '../config/database.php';
require_once '../func/common.php';

session_start();

// if(!isset($_POST['assignment'])) {
//   die;
// };

//goToLoginPage();
try {
  $stash = getStash();
  $assignmentCoeffs = getAssignmentCoeffs();
  $assignment = makeAssignment($stash, $assignmentCoeffs);
  //throw new Exception('Упс, не удалось произвести распределение, попробуйте позже!');
  echo json_encode($assignment);
} catch (Exception $e) {
  echo json_encode(array("error" => $e->getMessage()));
}

return;
?>