<?php
require_once '../config/database.php';
require_once '../func/common.php';
require_once './php/logic.php';

preparation();


include_once "../_parts/header.php";
?>

<body>

<?php include_once "../_parts/navbar.php" ?>

<div id="page">

  <div id="preview" class="container show-container">
    <div id="" class="row justify-content-center">
      <div class="col col-4 img">
        <img src=<?php echo $profileImgRef ?> width="100%" height="100%" alt="Картинка профиля">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col col-auto name">
        <span id="name" ><?php echo $dataOfUser['name']?></span>
        <?php if (checkDataChangeAccess($dataOfUser['id'])): ?>
        <i id="show-new-name" class="fa fa-pencil-square-o show" aria-hidden="true" title="Изменить имя"></i>
        <?php endif;?>
      </div>
    </div>
    <?php if (checkDataChangeAccess($dataOfUser['id'])): ?>
    <form id="new-name-form" class="row justify-content-center to-show">
      <div class="col col-4 offset-4 name new-name">
        <label for="new-name">Новое имя: </label>
        <input id="new-name" type="text" class="input" name="name" placeholder="New name">
        <i id="change-name" class="fa fa-check" aria-hidden="true"></i>
        <i class="fa fa-times show" aria-hidden="true"></i>
        <div id="new-name-err" class="err-msg">Некорректное имя!</div>
        <input type="hidden" name="userId" value='<?php echo $_GET['id'] ?>'>
      </div>
    </form>
    <?php endif;?>

    <div class="row justify-content-center">
      <div class="col col-2 race">
        <span><?php echo $race?></span>
      </div>
    </div>

    <div id="lastAuthorizDate">Был в сети <?php echo $dataOfUser['authorization_date']?></div>

<?php if ($dataOfUser['race'] == 'dwarf'): ?>

    <div id="master">

      <form id="master-form">
        <label class="lable" for="checkbox">Мастер:</label>
        <input id="checkbox" title="Гном <?php if (!$dataOfUser['master']) echo 'не '; ?>является мастером" type="checkbox" <?php echo $masterChecked;?> disabled name="master" value="true">
        
        <?php if ( checkMaster() ): ?>

        <i id="show-master-change" class="fa fa-pencil-square-o" aria-hidden="true" title="Изменить состояние"></i>

        <div id="send-master"><button class="button button-purple" type="button">Применить</button></div>
        <div id="suc-master" class="msg"></div>

        <?php endif; ?>
        <input type="hidden" name="userId" value="<?php echo $_GET['id'] ?>">
      </form>

    </div>
    <?php endif ?>

  </div>

  <div class="container list">

  <?php if ($dataOfUser['race'] == 'elf'): 
    if (!empty($unconfirmedGems)):?>

    <div class="row">
      <div class="col-12 text-center heading">Неподтверждённые драгоценности</div>

    <?php foreach ($unconfirmedGems as $type):?>

      <div id="<?php echo $type['id']?>" class="col-3 unconf-gems">
        <span class="name"><?php echo $type['type']?></span> (<span class="count"><?php echo $type['count']?></span> шт.)
        <?php if ( checkOwner($_GET['id']) ): ?>
        <i class="fa fa-check-circle confirm" title="Подтвердить получение"></i>
      <?php endif; ?>
      </div>

    <?php endforeach; ?>
      </div>
  <?php endif; ?>

    <form id="elf-wishes-form" class="row gems-wishes show-container">
  <?php if ($_SESSION['loggedUser']['id'] == $dataOfUser['id']):?>
      <div id="notice" class="confirmation">Сумма ваших предпочтений не равна 100%<br>Вы хотите распределить остаток автоматически?<br><div class="yes">Да</div><div class="no">Нет</div></div>
      <div class="col-2 align-self-end"><button id="change-wishes" class="button button-purple show" type="button">Изменить</button></div>
      <div class="col-2 align-self-end"><button id="send-wishes" type="button" class="button to-show">Применить</button></div>
      <div class="col-4 text-center heading">Предпочтения</div>
      <div class="col-4 text-right align-self-end"><span id="success-wishes" class="neutral-msg"></span><span class="to-show">Доступно: <span id="to-avail">0</span>%</span></div>
  <?php else: ?>

      <div class="col-12 text-center heading">Предпочтения</div>
  
  <?php endif; ?>

  <?php foreach ($elfWishes as $wish):?>

      <div id="type-<?php echo $wish['id'] ?>" class="col-4 text-center gem-wishes">
        <span class="type"><?php echo $wish['type'] ?></span><br><input type="hidden" class="gem-wish" name="" value="<?php echo $wish['wish'] ?>">
        <input class="previous-value" type="hidden" name="<?php echo $wish['id'] ?>" value=0>
        <div class="range-container-2 ">
          <div class="range-2"></div>
        </div>
      </div>

  <?php endforeach; ?>

  <?php if ($_GET['id'] == $_SESSION['loggedUser']['id']): ?>
    <div class="col-2 ml-auto align-self-end to-show"><button id="nullify" type="button" class="button button-purple">Обнулить</button></div><div class="col-1"></div>
  <?php endif;?>
    <input id="available" type="hidden" name="" value=0>
    </form>
  <?php endif;?>
  </div>


  <div id="mined-gems" class="container show-container">

    <div id="gems-count" class="row justify-content-center label show">
      <span ><?php echo $gemsMessage ?> всего <i class="fa fa-angle-up"></i></span>
    </div>

    <div class="to-show">
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
  </div>



  <div id="other-data" class="container list">
    <div class="row justify-content-center">
      <div class="col col-11 heading">О себе</div>
    </div>

    <div class="row">
      <div class="row small-row">
        <div class="col col-12 value text-about-me"><label for="change-about-me-button" class="lable">Я Рикардо Ромити пищу....свищу<br><br><br></label></div>
        <?php if ( checkDataChangeAccess($dataOfUser['id']) ): ?>
        <div class="col col-2 ml-auto"><button id="change-about-me-button" class="button button-purple" type="button">Изменить</button></div>
        <?php endif; ?>
      </div>    
    </div>


    <div class="row main show-container">
      <div class="row small-row">
        <div class="col col-3">Email: </div>
        <div class="col col-3 value"><label id="user-email" for="change-email-button" class="lable"><?php echo $dataOfUser['email']?></label></div>
        <col-4 id="suc-email" class="ml-auto msg"></col-4>
        <?php if ( checkDataChangeAccess($dataOfUser['id']) ): ?>
        <div class="col col-2 ml-auto"><button id="change-email-button" class="button button-purple show" type="button">Изменить</button></div>
        <?php endif; ?>
      </div>


    <?php if ( checkDataChangeAccess($dataOfUser['id']) ): ?>
    <form id="change-email" class="to-show">
      <div class="row small-row">
        <div class="col col-3 change">Новый Email: </div>
        <div class="col col-3 change">
          <input class="input" type="email" name="email" placeholder="Email address" required>
          <button id='send-email' class="button button-submit" type="button">Подтвердить</button>
        </div>
        <div id="err-email" class="col-3 err-msg align-self-end"></div>
      </div>
      <input type="hidden" name="userId" value=' <?php echo $_GET['id']?>' >
    </form>


    <?php endif; ?>


    </div>
    <div class="row main show-container">
      <div class="row small-row">
        <div class="col col-3">Пароль:</div>
        <div class="col col-3 value"><label for="change-password-button" class="lable">********</label></div>
        <div id="suc-passw" class="col-4 ml-auto msg"></div>
        <?php if ( checkDataChangeAccess($dataOfUser['id']) ): ?>
        <div class="col col-2"><button id="change-password-button" class="button button-purple show" type="button">Изменить</button></div>
        <?php endif; ?>
      </div>
    

      <?php if ( checkDataChangeAccess($dataOfUser['id']) ): ?>
      <form id="change-password" class="to-show" action="../config/changeUserData.php?id=<?php echo $_GET['id']?>" method="POST">
        <div class="row small-row">
          <div class="col col-3 change">Старый пароль: </div>
          <div class="col col-3 change">
            <input class="input" type="password" name="oldPassword" placeholder="Old password" required>
          </div>
        </div>
        <div class="row small-row">
          <div class="col col-3 change">Новый пароль: </div>
          <div class="col col-3 change">
            <input class="input" type="password" name="password" placeholder="New password" required>
          </div>
          <div id="err-pass" class="col-4 ml-auto err-msg align-self-center"></div>
          <div class="col-2"></div>
        </div>
        <div class="row small-row">
          <div class="col col-3 change">Повторите пароль: </div>
          <div class="col col-3 change">
            <input class="input" type="password" name="confirmedPassword" placeholder="Confirm password" required>
            <button id="send-password" class="button button-submit" type="button">Подтвердить</button>
          </div>
        </div>
        <input type="hidden" name="userId" value='<?php echo $_GET['id'] ?>'>
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
<script src="../js/jquery-ui.min-slider.js"></script>
<script src="../js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/common.js"></script>
</body>
</html>