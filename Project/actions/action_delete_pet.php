<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');
include_once('../database/db_pets.php');
include_once('../database/db_upload.php');

$pet_id = $_POST['pet_id'];
$username =$_SESSION['username'];

if (!isset($_POST['csrf'])) {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No CSRF found!');
  die(header('Location: ../pages/petdetails.php?pet_id='.$pet_id));
}
if (hash_equals($_POST['csrf'], $_SESSION['csrf']) === false) {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'CSRF mismatch!');
  die(header('Location: ../pages/petdetails.php?pet_id='.$pet_id));
}

if(isPetOwner($username,$pet_id, isShelter($username))){
    $pet_images = getImageFromPets($pet_id);

    foreach($pet_images as $pet_image){
        deleteSet($pet_image['pet_image_id']);
        deleteImageFromDb($pet_image['pet_image_id']);
    }
    deletePet($pet_id);
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Deleted pet successfully!');
    die(header('Location: ../pages/main.php'));
}
else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Couldn\'t delete pet!');
    die(header('Location: ../pages/petdetails.php?pet_id='.$pet_id));
}


