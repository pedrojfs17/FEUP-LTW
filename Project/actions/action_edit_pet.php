<?php
include_once('../includes/session.php');
include_once('../database/db_pets.php');

$pet_id = $_POST['pet_id'];

$pet = getPet($pet_id);

$pet_name = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s]/", '',  $_POST['pet_name']));
$pet_type = preg_replace("/[^1-7]/", '',  $_POST['pet_type']);
$pet_species = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s\-]/", '',  $_POST['pet_species']));
$pet_age = preg_replace("/[^1-4]/", '',  $_POST['pet_age']);
$pet_gender = preg_replace("/[^1-2]/", '',  $_POST['pet_gender']);
$pet_size = preg_replace("/[^0-9,.]/", '',  $_POST['pet_size']);
$pet_weight = preg_replace("/[^0-9,.]/", '',  $_POST['pet_weight']);
$pet_color = preg_replace("/[^0-9]/", '',  $_POST['pet_colour']);
$pet_location = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s\-.]/", '',  $_POST['pet_location']));
$pet_state = preg_replace("/[^1-4]/", '',  $_POST['pet_state']);

if (!strcmp($pet_name, "")) $pet_name = $pet['pet_name'];
if (!strcmp($pet_type, "")) $pet_type = $pet['pet_type'];
if (!strcmp($pet_species, "")) $pet_species = $pet['pet_species'];
if (!strcmp($pet_age, "")) $pet_age = $pet['pet_age'];
if (!strcmp($pet_gender, "")) $pet_gender = $pet['pet_gender'];
if (!strcmp($pet_size, "")) $pet_size = $pet['pet_size'];
if (!strcmp($pet_weight, "")) $pet_weight = $pet['pet_weight'];
if (!strcmp($pet_color, "")) $pet_color = $pet['pet_color'];
if (!strcmp($pet_location, "")) $pet_location = $pet['pet_location'];
if (!strcmp($pet_state, "")) $pet_state = $pet['pet_state'];

try {
  editPet($pet_id, $pet_type, $pet_name, $pet_species, $pet_age, $pet_gender, $pet_size, $pet_weight, $pet_color, $pet_location, $pet_state);
  $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Edited pet successfully!');
  die(header('Location: ../pages/petdetails.php?pet_id=' . $pet_id));
} catch (PDOException $e) {
  die($e->getMessage());
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to edit!');
  die(header('Location: ../pages/signup.php'));
}
