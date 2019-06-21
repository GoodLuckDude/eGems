<nav class="site-header">
  <div class="container-fluid d-flex justify-content-between">
      <a class="" href="/profile/profile.php?id=<?php echo $_SESSION['loggedUser']['id'] ?>">Ваш профиль</a>
      <a class="" href="/all_gems/all_gems.php">Драгоценности</a>
      <?php if($_SESSION['loggedUser']['race'] == 'dwarf'):?>
      <a class="" href="/add_gems_page/add_gems_page.php">Добавление</a>
      <?php endif; ?>

      <a id="users" href="/users_page/users_page.php">Пользователи</a>

      <?php if($_SESSION['loggedUser']['master'] == true):?>

      <a class="" href="/assign/assignmentPage.php">Распределение</a>

      <a class="" href="/system_settings/system_settings.php">Настройки</a>

      <?php endif; ?>


      <a id="exit" class="" href="/authorization/logout.php">Выход</a>
    </div>

</nav>