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
  
  <div id="content" class="content container list settings">

    <div class="row">
      <div class="col heading">Страничка настроек системы</div>
    </div>


    <div class="row">

      <div class="col-6">

        <form id="gems-types" class="row" action="" method="">

          <div id="gem-type-layout" class="col-12 gem-type">
            <input class="new-name input" type="text" name="" placeholder="Type's name" size="10">
            <label for="" class="type">Топаз</label>

            <i class="fa fa-times delete"></i>
            <div class="confirmation">
              Вы уверены, что хотите удалить тип "<span class="type"></span>"?<br>

              <div class="yes">Да</div>
              <div class="no">Нет</div>
            </div>

          </div>

          <div class="col-auto"><button class="button button-purple square" type="button">Изменить</button></div>
          <div class="col-auto"><button id="submit" class="button conf" type="button">Подтвердить</button></div>
          <span id="change-msg" class="msg"></span>
        </form>


      </div>

      <div class="col-6">Коэффициенты</div>

    </div>

    
    
    

    
    
      




  </div>
  <?php include_once "../_parts/footer.php" ?>
  <script src="./js/common.js"></script>
</div>





</body>
</html>