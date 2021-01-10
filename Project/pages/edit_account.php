<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_auth.php');
include_once('../templates/tpl_secure.php');

// Verify if user is not logged in
if (!isset($_SESSION['username']))
  die(header('Location: main.php'));

  $user=$_SESSION['username'];

  draw_header($_SESSION['username'], 'edit_account');
  draw_edit_account($user);
  draw_footer();
?>
