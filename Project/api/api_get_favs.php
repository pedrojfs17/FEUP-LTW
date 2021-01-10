<?php
include_once('../includes/session.php');
include_once('../database/db_pets.php');
include_once('../templates/tpl_cards.php');

if (!isset($_SESSION['username']))
  die(header('Location: ../pages/login.php'));

  $cards = getFavoritePets($_SESSION['username']);
  draw_cards($cards, 0, count($cards),false);
?>
