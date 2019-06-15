<?php
//require_once '../../config/database.php';
//require_once '../../func/common.php';

session_start();
//goToLoginPage();
$_GET['id'] = 1;
$dataOfUser = getDataOfUser($_GET['id']);


if ($dataOfUser['race'] == 'dwarf') {
  $profileImgRef = '../img/dwarf.png';
} else {
  $profileImgRef = '../img/elf.png';
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

$gems = getDwarfGems($_GET['id']);

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
