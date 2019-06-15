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
      <div class="col heading">Страничка пользователей</div>
    </div>



    <form id='filters' class="none-border">
      <div class="row navbar justify-content-start">
        <div class="col col-3"><span>Имя пользователя:</span><input type="text" name="name"
          class="input" placeholder="User's name">
        </div>

        <div class="col col-3">Статус:<br>
        <label for="active">Активен</label>
        <input id="active" type="checkbox" name="status[]" class="checkbox" value="active" checked>
        <label for="deleted">Удалён</label>
        <input id="deleted" type="checkbox" name="status[]" class="checkbox" value="deleted">
        </div>

      </div>
    </form>


    <div class="row">
      <div class="col-6 dwarfs">
        <span class="heading head-small">Гномы</span>

        <div class="row dwarf">
          <div class="col-6 text">Имя</a></div>
          <div class="col-3">Добыто</div>
          <div class="col-3">Мастер</div>
        </div>

        <div id="dwarf-layout" class="row user dwarf">
          <div class="col-6"><a href="/profile/profile.php?id=" class="name"></a></div>
          <div class="col-3 gems_count"></div>
          <div class="col-3 master"></div>

          <?php if ($_SESSION['loggedUser']['master'] == true) :?>
          <i class="fa fa-times delete"></i>
          <div class="confirmation">
            Вы уверены, что хотите удалить пользователя?<br>

            <div class="yes">Да</div>
            <div class="no">Нет</div>
          </div>
          <?php endif?>
        </div>

      </div>


      <div class="col-6 elves">
        <span class="heading head-small">Эльфы</span>
        <div class="row elf">
          <div class="col-5 align-self-center">Имя</a></div>
          <div class="col-3 align-self-center has">Получено</div>
          <div class="col-4">Любимые</div>
        </div>

        <div id="" class="row user elf">
          <div class="col-5 align-self-center"><a href="/profile/profile.php?">Машуля Свинюля</a></div>
          <div class="col-3 align-self-center has">100</div>
          <div class="col-4 align-self-center">Топаз<br>Алмаз<br>Корунд</div>

          <?php if ($_SESSION['loggedUser']['master'] == true) :?>
          <i class="fa fa-times delete"></i>
            <div class="confirmation">
              Вы уверены, что хотите удалить пользователя?<br>

              <div class="yes">Да</div>
              <div class="no">Нет</div>
            </div>
          <?php endif?>
        </div>

      </div>
    </div>


    

    <div id="msg" class="row msg neutral-msg"></div>
  </div>
  <?php include_once "../_parts/footer.php" ?>
  <script src="./js/common.js"></script>
</div>





</body>
</html>