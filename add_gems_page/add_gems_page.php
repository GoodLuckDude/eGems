<?php
require_once '../config/database.php';
require_once '../func/common.php';


session_start();
//redirIfGuest();   //в отдельную функцию

include_once "../_parts/header.php";
?>
 
<body>

<div id="page" class="page-flex">
  <?php include_once "../_parts/navbar.php" ?>
  
  <div id="content" class="content container list">

    <div class="row">
      <div class="col heading">Страничка добавления драгоценностей</div>
    </div>

    <form id="extracted-gems" class="row" action="" method="">

      <div id="gem-type-layout" class="col-4 gem-type">
        <input id="" class='amount' type="number" name="" min="0">
        <label for="" class="type">Алмаз</label>
      </div>

      <input type="hidden" name="dwarf_id" value="<?php echo $_SESSION['loggedUser']['id'];?>">
      <div id="submit" class="col-3 ml-auto text-center"><button type="button" class="button">Подтвердить</button><br>
        <span class="msg"></span>
      </div>

    </form>




  </div>
  <?php include_once "../_parts/footer.php" ?>
  <script src="./js/common.js"></script>
</div>





</body>
</html>