<?php
require_once '../config/database.php';
require_once '../func/common.php';
require_once './php/logic.php';


session_start();

// redirIfGuest();   //в отдельную функцию


include_once "../_parts/header.php";
?>

<body>

<?php include_once "../_parts/navbar.php" ?>

<div id="page">

  <div id="preview" class="container">
    <div id="" class="row justify-content-center">
      <div class="col col-4 img">
        <img src=<?php echo $profileImgRef ?> width="250px" height="250px" alt="Картинка профиля">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col col-auto name">
        <span><?php echo $dataOfUser['name']?></span>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col col-2 race">
        <span><?php echo $dataOfUser['race']?></span>
      </div>
    </div>

    <div id="lastAuthorizDate">Был в сети <?php echo $dataOfUser['authorization_date']?></div>

    <?php if ($dataOfUser['race'] == 'dwarf'): ?>
    <div id="master">
    <form action="#">
      <label class="lable" for="checkbox">Мастер:</label><input id="checkbox" type="checkbox" <?php echo $masterChecked; checkboxDisabler() ?> name="master" value="true"></div>
    </form>
    <?php endif; ?>
  </div>



  <div id="mined-gems" class="container">

    <div class="row justify-content-center label">
      <span>Добыл всего</span>
    </div>

    <div class="row navbar justify-content-between">
      <div class="col col-3">
        <button type="button" id="dropdownMenu1" class="button dropdown drop-purple" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span>Количество<i class="fa fa-angle-down"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <a class="dropdown-item" href="#!">По возрастанию</a>
          <a class="dropdown-item" href="#!">По убыванию</a>
        </div>
      </div>

      <div class="col col-3 type">
        <button type="button" id="dropdownMenu2" class="button dropdown drop-purple" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
            <span>Тип<i class="fa fa-angle-down"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <a class="dropdown-item" href="#!">Что-то</a>
            <a class="dropdown-item" href="#!">Не знаю, что</a>
          </div>
      </div>
      <div class="col col-3 ml-auto"></div>
    </div>

    <div class="owl-carousel carousel-gems">

    <?php showGems($gems); ?>

    </div>
  </div>



  <div id="other-data" class="container list">
    <div class="row justify-content-center">
      <div class="col col-11 heading">О себе</div>
    </div>

    <div class="row">
      <div class="row small-row">
        <div class="col col-12 value text-about-me"><label for="change-about-me-button" class="lable">Я Рикардо Ромити пищу....свищу<br><br><br></label></div>
        <div class="col col-2 ml-auto"><button id="change-about-me-button" class="button button-purple" type="button">Изменить</button></div>
      </div>    
    </div>


    <div class="row">
    <div class="row small-row">
      <div class="col col-3">Email: </div>
      <div class="col col-3 value"><label for="change-email-button" class="lable"><?php echo $dataOfUser['email']?></label></div>
      <div class="col col-2 ml-auto"><button id="change-email-button" class="button button-purple" type="button">Изменить</button></div>
    
    </div>


    <?php if ( checkDataChangeAccess($dataOfUser['id']) ): ?>
    <form id="change-email" class="hide" action="../config/changeUserData.php?id=<?php echo $_GET['id']?>" method="POST">
      <div class="row small-row hide">
        <div class="col col-3 change">Новый Email: </div>
        <div class="col col-3 change">
          <input class="input" type="email" name="email" placeholder="Email address" required>
          <button class="button button-submit" type="submit">Подтвердить</button>
        </div>      
      </div>
    </form>


    <?php endif; ?>


    </div>
    <div class="row">
      <div class="row small-row">
        <div class="col col-3">Пароль:</div>
        <div class="col col-3 value"><label for="change-password-button" class="lable">********</label></div>
        <div class="col col-2 ml-auto"><button id="change-password-button" class="button button-purple" type="button">Изменить</button></div>
      </div>
    

      <?php if ( checkDataChangeAccess($dataOfUser['id']) ): ?>
      <form id="change-password" class="hide" action="../config/changeUserData.php?id=<?php echo $_GET['id']?>" method="POST">
        <div class="row small-row hide">
          <div class="col col-3 change">Старый пароль: </div>
          <div class="col col-3 change">
            <input class="input" type="password" name="oldPassword" placeholder="Old password" required>
          </div>
        </div>
        <div class="row small-row hide">
          <div class="col col-3 change">Новый пароль: </div>
          <div class="col col-3 change">
            <input class="input" type="password" name="password" placeholder="New password" required>
          </div>
        </div>
        <div class="row small-row hide">
          <div class="col col-3 change">Повторите пароль: </div>
          <div class="col col-3 change">
            <input class="input" type="password" name="confirmedPassword" placeholder="Confirm password" required>
            <button class="button button-submit" type="submit">Подтвердить</button>
          </div>
        </div>
      </form>


    <?php endif; ?>
    </div>

<div class="row">
    <div class="row small-row">
      <div class="col col-3">Дата регистрации: </div>
      <div class="col col-7 value"><?php echo $dataOfUser['registration_date']?></div>
    </div>

</div>

<div class="row">
    <div class="row small-row">
      <div class="col col-3">Дата удаления: </div>
      <div class="col col-7 value"><?php echo $dataOfUser['deletion_date']?></div>
    </div>

</div>

<div class="row">
    <div class="row small-row">
      <div class="col col-3">Статус: </div>
      <div class="col col-7 value"><?php echo $dataOfUser['status']?></div>
    </div>

</div>

<div class="row">
    <div class="row row-small" style="height: 150px; border-bottom: none"></div>
  </div>
</div>


</div>


<?php include_once "../_parts/footer.php" ?>


<script src="./js/owl.carousel.min.js"></script>
<script src="./js/common.js"></script>
</body>
</html>