<nav class="site-header">
  <div class="container-fluid d-flex justify-content-between">
    <a class="" href="/profile/profile.php?id=<?php echo $_SESSION['loggedUser']['id'] ?>">Ваш профиль</a>
    <a class="" href="/all_gems/all_gems.php">Драгоценности</a>
    <a class="" href="/users_page/users_page.php">Пользователи</a>
    <a id="exit" class="" href="/authorization/logout.php">Выход</a>
  </div>
</nav>