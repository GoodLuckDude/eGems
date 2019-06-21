<?php
// require_once '../../config/database.php';
// require_once '../../func/common.php';

session_start();
//goToLoginPage();

$dataOfUser = getDataOfUser($_GET['id']);
$unconfirmedGems = getAllGems($dataOfUser['id'], $dataOfUser['race'], 'назначена'); //Русский язык! А-та-та
$aboutMe = DB::run("SELECT description FROM users WHERE id = ?", [$_GET['id']])->fetch();

if ($dataOfUser['race'] == 'dwarf') {
  $profileImgRef = '../img/dwarf.png';
  $gemsMessage = 'Добыл';
  $race = 'гном';
} else {
  $profileImgRef = '../img/elf.png';
  $gemsMessage = 'Получил';
  $elfWishes = getElfWishes($dataOfUser['id']);
  $race = 'эльф';
}

if ($dataOfUser['deletion_date'] == "(,DD.MM.YYYY)") {
  $dataOfUser['deletion_date'] = '-';
}

$masterChecked = '';

if ($dataOfUser['master'] == true) $masterChecked = 'checked';

function checkboxDisabler() {
  if ( !checkMaster() ) {
    echo 'disabled';
  }
}

function showElfWishes($elfWishes) {
  
};

$gemsStatus = "";
if ($dataOfUser['race'] === 'elf') $gemsStatus = "подтверждена";
$gems = getAllGems($dataOfUser['id'], $dataOfUser['race'], $gemsStatus);

function showGems($gems) {
  foreach ($gems as $key => $gem):
    if ($key % 3 == 0):?>
    <div class="carousel-gems-item">
      <div class="container">

        <div class="row">
          <div class="col col-6 offset-1 name"><span><?php echo $gem['type']?></span></div>
          <div class="col col-2 offset-1 value"><span><?php echo $gem['count']?></span></div>
        </div>

    <?php else:?>
      <div class="row">
        <div class="col col-6 offset-1 name"><span><?php echo $gem['type']?></span></div>
        <div class="col col-2 offset-1 value"><span><?php echo $gem['count']?></span></div>
      </div>

    <?php
    endif;
    if ($key % 3 == 2 || $key == count($gems)-1):?>
    </div>
    </div>

    <?php
    endif;
  endforeach;
}
?>
