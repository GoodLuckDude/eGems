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
      <div class="col heading">Страничка драгоценностей</div>
    </div>
  <form id='filters' class="none-border">
  <div class="row navbar first justify-content-start">

      <div class="col col-3">
        <button type="button" id="dropdownStatus" class="button dropdown drop-purple" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span>Статус<i class="fa fa-angle-down"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownStatus">
          <input id="assigned" class="radio" type="radio" name="status" value="не назначена"><label for="assigned">Не назначена</label><br>
          <input id="not-assigned" class="radio" type="radio" name="status" value="назначена"><label for="not-assigned">Назначена</label><br>
          <input id="confirmed" class="radio" type="radio" name="status" value="подтверждена"><label for="confirmed">Подтверждена</label>
        </div>
      </div>

      <div class="col col-3">
        <button type="button" id="dropdownType" class="button dropdown drop-purple" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span>Дата назначения<i class="fa fa-angle-down"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownType">
          Назначена с: <br>
          <input class="input" type="date" name="assignment_date>" value="" max="" min=""><br>
          по: <br>
          <input class="input" type="date" name="assignment_date<" value="" max="" min="">
        </div>
      </div>

      <div class="col col-3">
        <button type="button" id="dropdownType" class="button dropdown drop-purple" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span>Дата подтверждения<i class="fa fa-angle-down"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownType">
          Подтверждена с: <br>
          <input class="input" type="date" name="confirmation_date>" value="" max="" min=""><br>
          по: <br>
          <input class="input" type="date" name="confirmation_date<" value="" max="" min="">
        </div>
      </div>

      <div class="col-3"><button type="button" id="submit" class="button button-purple">Применить фильтры</button></div>
    </div>

    <div class="row navbar">

      <div class="col col-3">
        <span>Тип:</span>
        <input class="input" type="email" name="type" placeholder="Gem's type">
      </div>

      <div class="col col-3">
        <span>Мастер:</span>
        <input class="input" type="email" name="master" placeholder="Master's email">
      </div>
      
      <div class="col col-3">
        <span>Добыл:</span>
        <input class="input" type="email" name="dwarf" placeholder="Dwarf's email">
      </div>

      <div class="col col-3">
        <span>Владелец:</span>
        <input class="input" type="email" name="elf" placeholder="Elf's email">
      </div>
    </div>
  </form>
    


    <div id="gem-layout" class="row gem">
      <div class="col col-12 text-center type">Тип гема</div>
      <div class="col col-4 border-right"><span class="left">Добыл: </span> <span class="dwarf">email гнома</span></div>
      <div class="col col-4 border-right"><span class="center"> Дата добычи: </span><span class="extraction_date">dd.mm.yyyy</span></div>
      <div class="col col-4"><span class="right">Статус: </span><span class="status">(не)назначена/подтверждена</span></div>
      <div class="col col-4 border-right"><span class="left">Мастер: </span> <span class="master">email мастера</span></div>
      <div class="col col-4 border-right"><span class="center">  Дата назначения: </span><span class="assignment_date">dd.mm.yyyy</span></div>
      <div class="col col-4"><span class="right">Способ: </span><span class="method">алгоритм/вручную</span></div>
      <div class="col col-4 border-right"><span class="left">Владелец: </span> <span class="elf">email ельфа</span></div>
      <div class="col col-4 border-right"><span class="center">Дата подтверждения: </span><span class="confirmation_date">dd.mm.yyyy</span></div>
      <div class="col col-auto msg"></div>

      <?php if ($_SESSION['loggedUser']['master'] == true) :?>
      <i class="fa fa-times delete"></i>
        <div class="confirmation hide">
          Вы уверены, что хотите удалить гем?<br>

          <div class="yes">Да</div>
          <div class="no">Нет</div>
        </div>
      <?php endif?>
    </div>

    <div id="msg" class="row msg neutral-msg"></div>
  </div>
  <?php include_once "../_parts/footer.php" ?>
  <script src="./js/common.js"></script>
</div>







<!-- <script src="./js/common.js"></script> -->

</body>
</html>