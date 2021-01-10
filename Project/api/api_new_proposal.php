<?php
  include_once('../includes/session.php');
  include_once('../database/db_pets.php');

  if (!isset($_SESSION['username']))
    die(header('Location: ../pages/login.php'));

  $pet_id = $_GET['pet_id'];
  $username = $_SESSION['username'];
  $motivation =   trim(preg_replace("/[^a-zA-ZÀ-ÿ,.\-?!:;\s]/", '', $_GET['motivation']));
  
  newProposal($pet_id, $username, $motivation);
?>