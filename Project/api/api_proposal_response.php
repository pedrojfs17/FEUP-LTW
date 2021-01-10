<?php
  include_once('../includes/session.php');
  include_once('../database/db_pets.php');

  if (!isset($_SESSION['username']))
    die(header('Location: ../pages/login.php'));

  $proposal_id = $_GET['proposal_id'];
  $decision = $_GET['decision'];
  $username = $_SESSION['username'];
  
  setProposalState($proposal_id, $decision, $username);
?>