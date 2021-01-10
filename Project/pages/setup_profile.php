<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_auth.php');

// Verify if user is not logged in
if (!isset($_SESSION['username']))
  die(header('Location: main.php'));

  $user=$_SESSION['username'];

draw_header($user, 'setup_profile');
draw_edit_profile($user,1);
draw_footer();
