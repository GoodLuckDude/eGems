<?php
require_once '../config/database.php';
require_once '../func/common.php';

preparation();

if ( !checkMaster() ) {
  redirToProfile();
} 

include_once "../_parts/header.php";
?>
 
<body>

<div id="page" class="page-flex">
  <?php include_once "../_parts/navbar.php" ?>
  
  <div id="content" class="content container list settings">

    <div class="row">
      <div class="col heading">Страничка настроек системы</div>
    </div>

    <div class="row head-small">
      <div class="col-6 text-center">Типы драгоценностей</div>
      <div class="col-6 text-center">Коэффициенты распределения</div>
    </div>

    <div class="row">

      <div class="col-6 border-r">

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

          <div  class="col-auto"><button id="change-type" class="button button-purple square" type="button">Изменить</button></div>
          <div class="col-auto"><button id="submit" class="button conf" type="button">Подтвердить</button></div>
          <span id="change-msg" class="msg"></span>
        </form>

        <div class="kill row none-border">
        <div class="col col-6">
          <button id="add-type-button" type="button" class="button">Добавить тип</button>
        </div>
        <span id="add-type-msg" class="neutral-msg col-6"></span>
        </div>

        <form id='add-type' class="row">
          <div class="col col-12">Название типа: <input calss="input" type="text" name="type" id="type" placeholder="Type's name"></div>
          <div class="col col-5 ml-auto"><button id="create-type-submit" type="button" class="button button-purple square">Подтвердить</button></div>
        </form>


      </div>

      <div class="col-6">

        <div id="range" class="range-container container">
          <div class="range"></div>
          <form id="coeff-form" class="row none-border">
            <div class="col-12"><label for="equally">Справедливое распределение: </label><input id="equally" name="equally" type="text" class="range-input" disabled/></div>
            <div class="col-12"><label for="least-one">Еженедельная радость: </label><input id="least-one" name="least_one" type="text" class="range-input" disabled/></div>
            <div class="col-12"><label for="wishes">Предпочтения эльфов: </label><input id="wishes" name="preferred" type="text" class="range-input" disabled/></div>
            <div class="col-auto"><button id="send-coeff" type="button" class="button">Подтвердить</button></div>
            <div class="col-auto ml-auto"><button id="change-coeff" type="button" class="button button-purple square">Изменить</button></div>
            <div id="coeffs-msg" class="col-12 msg"></div>
          </form>
        </div>

      </div>

    </div>



  </div>
  <?php include_once "../_parts/footer.php" ?>
  <script src="../js/jquery-ui.min-slider.js"></script>
  <script src="../js/jquery.ui.touch-punch.min.js"></script>
  <script src="./js/common.js"></script>

</div>





</body>
</html>