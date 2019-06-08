<?php
require_once '../config/database.php';
require_once '../func/common.php';


session_start();
//redirIfGuest();   //в отдельную функцию

$unassignedGems = getUnassignedGems();
include_once "../_parts/header.php";
?>

<body>

<?php include_once "../_parts/navbar.php" ?>

<div id="page">
  <div class="container list">

    <div class="row">
      <div class="col heading">Распределение драгоценностей</div>
    </div>

    <div class="row">
      <div class="col col-3">Тип драгоценности</div>
      <div class="col col-3">Дата добычи</div>
      <div class="col col-3">Добыл</div>
      <div class="col col-3">Эльф</div>
    </div>

    <form action="#" method='POST'>
    <?php foreach ($unassignedGems as $key => $gem):?>
      <div class="row">
    <?php foreach ($gem as $field => $value):
    if ($field != 'id'):?>
        <div class="col col-3"><?php echo $value ?></div>
    <?php endif; endforeach;?>
      <div class="col col-3">
        <input class="input" type="email" value='<?php $_POST['gems'][$gem['id']]?>'>
        <input class="input" type="hidden" value='<?php echo $gem['id'] ?>'>
      </div>


      </div>
    <?php
    endforeach;
    ?>

      <div class="row">
        <div class="col-auto">
            <a class="button button-purple" href="./distributor.php">Распределить драгоценности</a>
        </div>
        
        <div class="col-auto ml-auto" style="margin-bottom: 200px">
            <button class="button button-submit" type="submit">Подтвердить распределение</button>
        </div>
      </div>

    </form>
  </div>
</div>


<?php include_once "../_parts/footer.php" ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>