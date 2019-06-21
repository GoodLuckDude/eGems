<?php
require_once '../config/database.php';
require_once '../func/common.php';

preparation();

include_once "../_parts/header.php";
?>
 
<body>

<div id="page" class="page-flex">
  <?php include_once "../_parts/navbar.php" ?>
  
  <div id="content" class="content container list">

    <div class="row">
      <div class="col heading">Страничка пользователей</div>
    </div>



    <form id='filters' class="">
      <div class="row navbar justify-content-start">
        <div class="col col-3"><span>Имя пользователя:</span><input type="text" name="name"
          class="input" placeholder="User's name">
        </div>

        <div class="col col-3">Статус:<br>
          <label for="active">Активен</label>
          <input id="active" type="checkbox" name="status[]" class="checkbox" value="active" checked>
          <label for="deleted">Удалён</label>
          <input id="deleted" type="checkbox" name="status[]" class="checkbox" value="deleted" checked>
        </div>

        <?php if ($_SESSION['loggedUser']['master'] == true) :?>
        <div id="create-user-msg" class="col-auto ml-auto msg"></div>
        <div id="add-user" class="col-auto"><button type="button" class="button">Добавить пользователя</button></div>

      </div>
    </form>

    <form id='create-user-form' action="">
      <div class="row create-user">
        <div class="col-12 head-small text-center">Введите данные нового пользователя:</div>
        <div class="col-3"><label for="email">Еmail:</label><br><input type="email" name="email" id="email" class="input" placeholder="Enter email" required></div>
        <div class="col-3"><label for="password">Пароль:</label><br><input type="password" name="password" id="password" class="input" placeholder="Enter password" required></div>
        <div class="col-3"><label for="name">Имя:</label><br><input type="text" name="name" id="name" class="input" placeholder="Enter name" required></div>
        <div class="col-3"><label for="name">Раса:</label><br>
          <label class="race" for="race-dwarf">Гном</label><input type="radio" name="race" id="race-dwarf" class="radio" value="dwarf" required>
          <label class="race" for="race-elf">Эльф</label><input type="radio" name="race" id="race-elf" class="radio" value="elf" required>
        </div>
        <div class="col-3 ml-auto submit"><button id="create-user-submit" type="submit" class="button">Подтвердить</button></div>
        <input type="hidden" name="ajax" value='true'>
      </div>
    </form>
        <?php else:?>

        </div>

        <?php endif?>





    <div class="row none-border">
      <div class="col-6 dwarfs border-r">
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

        <div id="elf-layout" class="row user elf">
          <div class="col-5 align-self-center"><a href="/profile/profile.php?" class="name"></a></div>
          <div class="col-3 align-self-center text-center gems_count"></div>
          <div class="col-4 align-self-center favorites"></div>

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