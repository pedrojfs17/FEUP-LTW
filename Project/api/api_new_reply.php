<?php
  include_once('../includes/session.php');
  include_once('../database/db_pets.php');

  if (!isset($_SESSION['username']))
    die(header('Location: ../pages/login.php'));

  $question_id = $_GET['question_id'];
  $username = $_SESSION['username'];
  $reply = trim(preg_replace("/[^a-zA-ZÀ-ÿ,.\-?!:;\s]/", '', $_GET['reply']));
  
  newReply($question_id, $username, $reply);
?>