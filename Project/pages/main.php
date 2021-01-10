<?php 
  include_once('../includes/session.php');
  include_once('../database/db_pets.php');
  include_once('../database/db_user.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_main.php');
  include_once('../templates/tpl_cards.php');

  $cards = getRandomFeaturedPets();
  $username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

  draw_header($username, 'main');
  draw_main_page($cards);
  draw_footer();
?>
