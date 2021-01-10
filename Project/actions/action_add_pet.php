<?php
include_once('../includes/session.php');
include_once('../database/db_pets.php');
include_once('../database/db_upload.php');

$pet_name = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s]/", '',  $_POST['pet_name']));
$pet_type = preg_replace("/[^1-7]/", '',  $_POST['pet_type']);
$pet_species = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s\-]/", '',  $_POST['pet_species']));
$pet_age = preg_replace("/[^1-4]/", '',  $_POST['pet_age']);
$pet_gender = preg_replace("/[^1-2]/", '',  $_POST['pet_gender']);
$pet_size = preg_replace("/[^0-9,.]/", '',  $_POST['pet_size']);
$pet_weight = preg_replace("/[^0-9,.]/", '',  $_POST['pet_weight']);
$pet_color = preg_match("/^[1-9]$|^1[0-5]$/", $_POST['pet_colour'])? $_POST['pet_colour'] : 1;
$pet_location = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s\-.]/", '',  $_POST['pet_location']));
$pet_state = preg_replace("/[^1-4]/", '',  $_POST['pet_state']);

if (strcmp($pet_name, "") == 0|| strcmp($pet_type, "") == 0 || 
    strcmp($pet_species, "") == 0 || strcmp($pet_age, "") == 0 || 
    strcmp($pet_gender, "") == 0 || strcmp($pet_size, "") == 0 || 
    strcmp($pet_weight, "") == 0 || strcmp($pet_color, "") == 0 || 
    strcmp($pet_location, "") == 0 || strcmp($pet_state, "") == 0) {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'All fields must be filled! Couldn\'t add pet');
  die(header("Location: ../pages/add_pets.php"));
}

$uploaded =  is_uploaded_file($_FILES['image']['tmp_name']);

if ($uploaded) {
  $count = count($_FILES['image']['name']);
  addPet($pet_name,$pet_type,$pet_species,$pet_age,$pet_gender,$pet_size,$pet_weight,$pet_color,$pet_location,$_SESSION['username'],$pet_state);
  $pet_id = getLastPetID()['pet_id'];
  for ($i = 0; $i < $count; $i++) {
    uploadPetImage($pet_id, $_FILES['image']['name'][$i], $_FILES['image']['tmp_name'][$i]);
  }
  $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Added pet successfully!');
  die(header('Location: ../pages/petdetails.php?pet_id=' . $pet_id));
} else {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No image selected! Couldn\'t add pet');
  die(header("Location: ../pages/add_pets.php"));
}
