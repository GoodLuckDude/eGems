<?php
require_once '../../config/database.php';
require_once '../../func/common.php';


session_start();
//redirIfGuest();   //в отдельную функцию

include_once "../../_parts/header.php";
?>
 
<body>

<div id="page" class="page-flex">
  <?php include_once "../../_parts/navbar.php" ?>
  
  <div id="content" class="content container list">

    <div class="row">
      <div class="col heading">Страничка добавления драгоценностей</div>
    </div>

    <form id="extracted-gems" class="row" action="./add_gems.php" method="POST">

      <div id="1" class="col-4 gem-type">
        <input id="g" class='amount' type="number" name="1">
        <label for="g" class="type">Алмаз</label>
      </div>

      <input type="hidden" name="dwarf_id" value="1">
      <div id="submit" class="col-3 ml-auto text-center"><button type="submit" class="button">Подтвердить</button><br>
        <span class="msg"></span>
      </div>

    </form>




  </div>
  <?php include_once "../../_parts/footer.php" ?>
</div>





</body>
</html>