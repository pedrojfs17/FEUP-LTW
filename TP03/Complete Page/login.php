<?php
  session_start();
  include_once('database/connection.php');
  include_once('database/news.php');

  include('templates/common/header.php');
  include('templates/users/login.php');
  include('templates/common/footer.php');
?>
