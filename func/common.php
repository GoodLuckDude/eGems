<?php
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
        id, email, name, race, master, registration_date,
        authorization_date, status, deletion_date
      FROM users
      WHERE id = ?",
    [$id]
  )->fetch(PDO::FETCH_ASSOC);
  return $dataOfUser;
}

function getDwarfGems($dwarfId) {
  $gems = DB::run(" SELECT type, count(gem_type_id)
      FROM gem_types INNER JOIN gems
      ON gem_types.id = gems.gem_type_id
      WHERE gems.dwarf_id = ?
      GROUP BY gem_types.type
      ORDER BY count DESC",
    [$dwarfId]
  )->fetchAll();
  return $gems;
}

function getUnassignedGems() {
  $unassignedGems = DB::run("SELECT type, gems.id, extraction_date, email
      FROM gem_types
      INNER JOIN gems ON gem_types.id = gems.gem_type_id
      INNER JOIN users ON users.id = gems.dwarf_id
      WHERE gems.status = 'не назначена'"
  )->fetchAll();
  return $unassignedGems;
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


function getAssignCoeffs() {
  $assignCoeffs = DB::run("SELECT * FROM assign")->fetch(PDO::FETCH_ASSOC);
  return $assignCoeffs;
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


function assign($gems, $condition) {

}

function assignEqually($assignCoeff, $elvesCoeffs, $condition) {  //$assignment - array:: elfId => current gem coeff
  $uniq = count(array_unique($condition));
  $step = 1/$uniq;
//мне гг
  arsort($condition);

  $minCount = +INF;
  $currentStep = 0;
  foreach ($condition as $elfId => $count) {
    if($count < $minCount) {
      $minCount = $count;
      $currentStep += 1;
    };

    $elvesCoeffs[$elfId] += $step*$currentStep * $assignCoeff;
  };

  return $elvesCoeffs;
};

function assignAtLeastOne($assignCoeff, $elvesCoeffs, $condition, $initialState) {  //выкинуть обращение к бд, передавать всё чеерез параметры. И в остальных распределениях тоже.
  $luckyElvesWithField = DB::run("SELECT DISTINCT elf_id FROM gems
    WHERE status = 'назначена'"
  );

  $luckyElves = array();

  while ($elf = $luckyElvesWithField->fetch()) {
    array_push($luckyElves, $elf['elf_id']);
  }

  foreach($condition as $elfId => $count) {
    if ( $initialState[$elfId] == $count && !in_array($elfId, $luckyElves) ) {
      $elvesCoeffs[$elfId] += $assignCoeff;
    }
  }
//сделать нормальный $condition, чтобы подходил под все функции сразу.
  return $elvesCoeffs;
};

function assignPreferred($assignCoeff, $elvesCoeffs, $condition, $gemId) {
  //вынести обращение к БД и всё такое, как обычно....
  $wishesWthFields = DB::run("SELECT elf_id, wish FROM wishes
    WHERE gem_type_id = ?",
    [$gemId]
  );

  $wishes = array();

  while ($wish = $wishesWthFields->fetch()) {
    $wishes[$wish['elf_id']] = $wish['wish'];
  }

  foreach ($wishes as $id => $wish) {
    $elvesCoeffs[$id] += $wish * $assignCoeff;
  }
  return $elvesCoeffs;
}

?>