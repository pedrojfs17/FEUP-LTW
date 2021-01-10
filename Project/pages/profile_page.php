<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');
include_once('../database/db_pets.php');
include_once('../database/db_questions.php');
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_owner.php');
include_once('../templates/tpl_cards.php');

$username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$user = $_GET['user'];

if(getUser($user)==NULL){
  die(header('Location: main.php'));
}

draw_header($username, 'profile_page');
draw_profile_page($user, $username);
draw_footer();