<?php
//require_once "../config/database.php";

//it's func for for general use
function checkAuthorization() {
  if ( !isset($_SESSION['loggedUser']) ) {
    return false;
  }
  return true;
}

//save url's this page in'$_SESSION['neededPage']' for redirect after login
function rememberThisPage() {
  $_SESSION['neededPage'] = $_SERVER['SCRIPT_NAME']; //NOTE почему не работает php_self???
};

//redirect to login page
function goToLoginPage() {
	header("Location: http://localhost");
	die();
};

function redirIfGuest() {
  if(checkAuthorization() == false) {
    rememberThisPage();
    goToLoginPage();
  }
}

function checkOwner($id) {
  if ($_SESSION['loggedUser']['id'] == $id) {
    return true;
  }
  return false;
}

function checkMaster() {
  if ($_SESSION['loggedUser']['master'] == true) {
    return true;
  }
  return false;
}

function checkDataChangeAccess($id) {
  if ( checkOwner($id) || checkMaster() ) {
    return true;
  }
  return false;
}

function getDataOfUser($id) {
  $dataOfUser = DB::run("SELECT
        id, email, name, race, master, to_char(registration_date, 'DD.MM.YYYY') as registration_date,
        to_char(authorization_date, 'DD.MM.YYYY') as authorization_date, status,
        (deletion_date, 'DD.MM.YYYY') as deletion_date
      FROM users
      WHERE id = ?",
    [$id]
  )->fetch(PDO::FETCH_ASSOC);
  return $dataOfUser;
}

function getDwarfGems($dwarfId) {
  $gems = DB::run(" SELECT type, count(gem_type_id)
      FROM gems_types INNER JOIN gems
      ON gems_types.id = gems.gem_type_id
      WHERE gems.dwarf_id = ? AND gems_types.deleted = false
      GROUP BY gems_types.type
      ORDER BY count DESC",
    [$dwarfId]
  )->fetchAll();
  return $gems;
}

function getStash() {
  $stash = DB::run("SELECT type, gems.id, gems.gem_type_id,
        to_char(extraction_date, 'DD.MM.YYYY') as extraction_date, email
      FROM gems_types
      INNER JOIN gems ON gems_types.id = gems.gem_type_id
      INNER JOIN users ON users.id = gems.dwarf_id
      WHERE gems.status = 'не назначена'"
  )->fetchAll();
  return $stash;
}


function makeElvesCoeffs() {
  $elvesCoeffs = array();
  $elvesId = DB::run("SELECT id
    FROM users
    WHERE users.race = 'elf'"
  );

  while ($row = $elvesId->fetch()) {
    $elvesCoeffs[$row['id']] = 0;
  }
  return $elvesCoeffs;
};


function getAssignmentCoeffs() {
  $assignmentCoeffs = DB::run("SELECT * FROM assign")->fetch(PDO::FETCH_ASSOC);
  return $assignmentCoeffs;
}

function getCondition() {
  $dataOfElves = DB::run("SELECT users.id, COUNT(gems.id) 
    FROM users LEFT JOIN gems
    ON users.id = gems.elf_id
    WHERE users.race = 'elf'
    GROUP BY users.id
    ORDER BY count ASC"
  );

  $condition = array();

  while ($row = $dataOfElves->fetch()) {
    $condition[$row['id']] = $row['count'];
  }

  return $condition;
}

function getWishes($gemTypeId) {
  $wishesWthFields = DB::run("SELECT elf_id, wish FROM wishes
    WHERE gem_type_id = ?",
    [$gemTypeId]
  );

  $wishes = array();

  while ($wish = $wishesWthFields->fetch()) {
    $wishes[$wish['elf_id']] = $wish['wish'];
  }

  return $wishes;
}

function assignEqually($assignmentCoeff, $elvesCoeffs, $condition, $assignment) {  //$assignment - array:: elf's id => current gem coeff
  foreach ($assignment as $elfId => $gems) {
    $condition[$elfId] += count($gems);
  }

  $uniq = count(array_unique($condition));
  $uniq > 1 ? $step = 1/($uniq-1) : $step = 0;
  $minCount = +INF;
  $currentStep = -1;


  arsort($condition);

  foreach ($condition as $elfId => $count) {
    if($count < $minCount) {
      $minCount = $count;
      $currentStep += 1;
    };

    $elvesCoeffs[$elfId] += $step * $currentStep * $assignmentCoeff;
  };

  return $elvesCoeffs;
};

function assignAtLeastOne($assignmentCoeff, $elvesCoeffs, $condition, $assignment) {  //выкинуть обращение к бд, передавать всё чеерез параметры. И в остальных распределениях тоже.
  $luckyElvesWithField = DB::run("SELECT DISTINCT elf_id FROM gems
    WHERE status = 'назначена'"
  );

  $luckyElves = array();

  while ($elf = $luckyElvesWithField->fetch()) {
    array_push($luckyElves, $elf['elf_id']);
  }

  foreach($condition as $elfId => $count) {
    if ( !array_key_exists($elfId, $assignment) && !in_array($elfId, $luckyElves) ) {
      $elvesCoeffs[$elfId] += $assignmentCoeff;
    }
  }
//сделать нормальный $condition, чтобы подходил под все функции сразу.
  return $elvesCoeffs;
};

function assignPreferred($assignmentCoeff, $elvesCoeffs, $wishes, $gemId) {
  $uniq = count(array_unique($wishes));
  $step = 1/($uniq - 1);
  $currentStep = -1;
  $minWish = -INF;

  asort($wishes);

  foreach ($wishes as $elfId => $wish) {
    if($wish > $minWish) {
      $minWish = $wish;
      $currentStep += 1;
    };

    $elvesCoeffs[$elfId] += $step * $currentStep * $assignmentCoeff;
  }
  return $elvesCoeffs;
}

function makeAssignment($stash, $assignmentCoeffs) {
  $assignment = array();
  $condition = getCondition();

  foreach($stash as $gem) {
    $wishes = getWishes($gem['gem_type_id']);
    $elvesCoeffs = makeElvesCoeffs();

    $elvesCoeffs = assignEqually($assignmentCoeffs['equally'], $elvesCoeffs, $condition, $assignment);
    $elvesCoeffs = assignAtLeastOne($assignmentCoeffs['least_one'], $elvesCoeffs, $condition, $assignment);
    $elvesCoeffs = assignPreferred($assignmentCoeffs['preferred'], $elvesCoeffs, $wishes, $gem['type']);

    $selectedElf = array_search(max($elvesCoeffs), $elvesCoeffs);

    if ( !array_key_exists($selectedElf, $assignment) ) {
      $assignment[$selectedElf] = array();
    }
    array_push($assignment[$selectedElf], $gem['id']);
  };

  return $assignment;
}

?>