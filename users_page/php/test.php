<?php
require_once '../../config/database.php';
require_once '../../func/common.php';


session_start();
//redirIfGuest();   //в отдельную функцию

include_once "../_parts/header.php";
?>
 
<body>

<div id="page" class="page-flex">
  <?php include_once "../_parts/navbar.php" ?>

  <form action="./dwarfs_list_contructor.php" method="GET">
    <input type="checkbox" name="status[]" value="active">
    <input type="checkbox" name="status[]" value="deleted">
    <button type="submit"></button>
  </form>

  <?php include_once "../_parts/footer.php" ?>
  <script src="./js/common.js"></script>
</div>





</body>
</html>