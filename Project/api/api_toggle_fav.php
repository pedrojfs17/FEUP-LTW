<?php
include_once('../includes/session.php');
include_once('../database/db_pets.php');

if (!isset($_SESSION['username']))
  die(header('Location: ../pages/login.php'));

$pet_id = $_GET['pet_id'];

$response['pet_id'] = $pet_id;
$response['fav'] = toggleFavoritePet($_SESSION['username'], $pet_id);

  echo json_encode($response);
?>
