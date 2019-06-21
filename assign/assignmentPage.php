<?php
require_once '../config/database.php';
require_once '../func/common.php';

preparation();

if ($_SESSION['loggedUser']['master'] != true) {
  redirToProfile();
}

$stash = getStash();
include_once "../_parts/header.php";
?>

<body>
<div id="page" class="page-flex">
  <?php include_once "../_parts/navbar.php" ?>
  <div class="content container list">

    <div class="row">
      <div class="col heading">Распределение драгоценностей</div>
    </div>

    <div class="row">
      <div class="col col-3">Тип драгоценности</div>
      <div class="col col-3">Дата добычи</div>
      <div class="col col-3">Добыл</div>
      <div class="col col-3">Эльф</div>
    </div>

    <form action="" method='POST'>
    <?php foreach ($stash as $key => $gem):?>
      <div class="row">
    <?php foreach ($gem as $field => $value):
    if ($field != 'id' && $field != 'gem_type_id'):?>
        <div class="col col-3"><?php echo $value ?></div>
    <?php endif; endforeach;?>
      <div id='<?php echo $gem['id']?>' class="col col-3 ">
        <input class="input email" type="text" value=''>
        <input class="input id" type="hidden" name="gem_id" value='<?php echo $gem['id'] ?>'>
        <input class="input by_hand" type="hidden" name="by_hand" value=''>
      </div>

      </div>
    <?php
    endforeach;
    ?>

      <div class="row">
        <div class="col-auto">
            <button id="assign" class="button button-purple square" type="button">Распределить драгоценности</button>
        </div>

        <div class="col-auto ml-auto">
            <button id="submit" class="button button-submit" type="button">Подтвердить распределение</button>
        </div>
      </div>

    </form>
  </div>
  <?php include_once "../_parts/footer.php" ?>
</div>





<script src="./js/common.js"></script>

</body>
</html>