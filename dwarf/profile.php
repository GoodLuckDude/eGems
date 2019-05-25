<?php
require_once '../config/database.php';
require_once '../func/common.php';

session_start();
redirIfGuest();

include_once "../_parts/header.php"
?>

<body>
<?php include_once "../_parts/navbar.php" ?>

<div id="preview" class="container">
  <div id="" class="row justify-content-center">
    <div class="col-4 img">
      <img src="../img/dwarf.png" width="300px" height="300px" alt="Картинка гнома">
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-4 name">
      <span>Имя пользователя</span>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-2 race">
      <span>Раса</span>
    </div>
  </div>
</div>

<div id="mined-gems" class="container">
  <div class="row justify-content-center">
    <span>Добыл всего</span>
  </div>
</div>

<div id="other-data" class="container">
  <div class="row justify-content-around">
    <div class="col col-3">Email: </div>
    <div class="col col-5"><label for="change-email" class="lable">em***@email.ru</label></div>
    <div class="col col-2"><button id="change-email" class="button" type="button">Изменить</button></div>
  </div>
  
  <div class="row justify-content-around">
    <div class="col col-3">Пароль:</div>
    <div class="col col-5"><label for="change-password" class="lable">********</label></div>
    <div class="col col-2"><button id="change-password" class="button" type="button">Изменить</button></div>
  </div>
</div>

</body>