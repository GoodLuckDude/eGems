<?php
require_once '../config/database.php';
require_once '../func/common.php';

session_start();
redirIfGuest();

include_once "../_parts/header.php";
//как не смешивать вёрстку и php если мне нужны данные из бд?
//редиректы + сессия или что-то подобное???
$dataOfUser = DB::run("SELECT
    id, email, name, race, master, registration_date,
    authorization_date, status, deletion_date
  FROM users
  WHERE id = ?",
  [$_GET['id']]
)->fetch(PDO::FETCH_ASSOC);

var_export($dataOfUser);

if ($dataOfUser['race'] == 'dwarf') {
  $profileImgRef = '../img/dwarf.png';
} else {
  $profileImgRef = '../img/elf.png';
}

if ($dataOfUser['deletion_date'] == NULL) {
  $dataOfUser['deletion_date'] = '-';
}

function checkChengeAccess() {
  if (($_SESSION['loggedUser']['id'] == $dataOfUser['id'] || $_SESSION['loggedUser']['master'] == true)) {
    return true;
  }
  return false;
}

$masterChecked = '';

if ($dataOfUser['master'] == true) $masterChecked = 'checked';

function checkboxDisabler() {
  if ( !checkChengeAccess() ) {
    echo 'disabled';
  }
}

DB::run

?>

<body>

<?php include_once "../_parts/navbar.php" ?>

<div id="profile">

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
        <button type="button" id="dropdownMenu1" class="button dropdown" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span>Количество<i class="fa fa-angle-down"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <a class="dropdown-item" href="#!">По возрастанию</a>
            <a class="dropdown-item" href="#!">По убыванию</a>
          </div>
      </div>

      <div class="col col-3 type">
        <button type="button" id="dropdownMenu2" class="button dropdown" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
            <span>Тип<i class="fa fa-angle-down"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <a class="dropdown-item" href="#!">Что-то</a>
            <a class="dropdown-item" href="#!">Не знаю, что</a>
          </div>
      </div>
      <div class="col col-3 offset-2"></div>
    </div>

    <div class="owl-carousel carousel-gems">

      <div class="carousel-gems-item">
        <div class="container">
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Свинон</span></div>
            <div class="col col-2 offset-1 value"><span>999</span> </div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Кварц</span></div>
            <div class="col col-2 offset-1 value"><span>36</span></div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Пирротиниум</span></div>
            <div class="col col-2 offset-1 value"><span>0</span></div>
          </div>
        </div>
      </div>


      <div class="carousel-gems-item">
        <div class="container">
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Свинон</span></div>
            <div class="col col-2 offset-1 value"><span>999</span> </div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Кварц</span></div>
            <div class="col col-2 offset-1 value"><span>36</span></div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Пирротиниум</span></div>
            <div class="col col-2 offset-1 value"><span>0</span></div>
          </div>
        </div>
      </div>


      <div class="carousel-gems-item">
        <div class="container">
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Свинон</span></div>
            <div class="col col-2 offset-1 value"><span>999</span> </div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Кварц</span></div>
            <div class="col col-2 offset-1 value"><span>36</span></div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Пирротиниум</span></div>
            <div class="col col-2 offset-1 value"><span>0</span></div>
          </div>
        </div>
      </div>


      <div class="carousel-gems-item">
        <div class="container">
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Свинон</span></div>
            <div class="col col-2 offset-1 value"><span>999</span> </div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Кварц</span></div>
            <div class="col col-2 offset-1 value"><span>36</span></div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Пирротиниум</span></div>
            <div class="col col-2 offset-1 value"><span>0</span></div>
          </div>
        </div>
      </div>


      <div class="carousel-gems-item">
        <div class="container">
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Свинон</span></div>
            <div class="col col-2 offset-1 value"><span>999</span> </div>
          </div>
          <div class="row">
            <div class="col col-6 offset-1 name"><span>Кварц</span></div>
            <div class="col col-2 offset-1 value"><span>36</span></div>
          </div>
        </div>
      </div>



    </div>
  </div>



  <div id="other-data" class="container">
    <div class="row justify-content-center">
      <div id="about-me-title" class="col col-11">О себе</div>
    </div>

    <div class="row">
      <div class="row small-row">
        <div class="col col-12 value text-about-me"><label for="change-about-me-button" class="lable">Я Рикардо Ромити пищу....свищу<br><br><br></label></div>
        <div class="col col-2 offset-10"><button id="change-about-me-button" class="button button-purple" type="button">Изменить</button></div>
      </div>    
    </div>


    <div class="row">
    <div class="row small-row">
      <div class="col col-3">Email: </div>
      <div class="col col-7 value"><label for="change-email-button" class="lable"><?php echo $dataOfUser['email']?></label></div>
      <div class="col col-2"><button id="change-email-button" class="button button-purple" type="button">Изменить</button></div>
    
    </div>


    <?php if ( checkChengeAccess() ): ?>
    <form id="change-email" class="hide" action="../config/changeUserData.php?id=<?php echo $_GET['id']?>" method="POST">
      <div class="row small-row hide">
        <div class="col col-3 change">Новый Email: </div>
        <div class="col col-7 change">
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
        <div class="col col-7 value"><label for="change-password-button" class="lable">********</label></div>
        <div class="col col-2"><button id="change-password-button" class="button button-purple" type="button">Изменить</button></div>
      </div>
    

      <?php if ( checkChengeAccess() ): ?>
      <form id="change-password" class="hide" action="../config/changeUserData.php?id=<?php echo $_GET['id']?>" method="POST">
        <div class="row small-row hide">
          <div class="col col-3 change">Старый пароль: </div>
          <div class="col col-7 change">
            <input class="input" type="password" name="oldPassword" placeholder="Old password" required>
          </div>
        </div>
        <div class="row small-row hide">
          <div class="col col-3 change">Новый пароль: </div>
          <div class="col col-7 change">
            <input class="input" type="password" name="password" placeholder="New password" required>
          </div>
        </div>
        <div class="row small-row hide">
          <div class="col col-3 change">Повторите пароль: </div>
          <div class="col col-7 change">
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="./js/owl.carousel.min.js"></script>
<script src="./js/common.js"></script>
</body>
</html>