<?php
  include_once('../includes/session.php');
  include_once('../database/db_pets.php');

  if (!isset($_SESSION['username']))
    die(header('Location: ../pages/login.php'));

  $pet_id = $_GET['pet_id'];
  $username = $_SESSION['username'];
  $question = trim(preg_replace("/[^a-zA-ZÀ-ÿ,.\-?!:;\s]/", '', $_GET['question']));
  
  newQuestion($pet_id, $username, $question);
?>