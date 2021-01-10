<?php
include_once('../includes/session.php');
include_once('../database/db_upload.php');
include_once('../database/db_pets.php');

$pet_id = $_POST['pet_id'];

$count =  count($_FILES['image']['name']);
$allowed_types = ["image/gif", "image/jpeg", "image/png"];
$num_picsError = 0;
if ($count > 0) {
  // Delete the previous pet images
  $pet_images = getImageFromPets($pet_id);
  foreach($pet_images as $pet_image){
      deleteSet($pet_image['pet_image_id']);
      deleteImageFromDb($pet_image['pet_image_id']);
  }

  for ($i = 0; $i < $count; $i++) {
    if (in_array(mime_content_type($_FILES['image']['tmp_name'][$i]), $allowed_types))
      uploadPetImage($pet_id, $_FILES['image']['name'][$i], $_FILES['image']['tmp_name'][$i]);
    else {
      $num_picsError++;
    }
  }
  if ($num_picsError == $count)
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Couldn\'t add images, incorrect types!');
  else if ($num_picsError == 0)
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Added pet images successfully!');
  else
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Added some images successfully! Some weren\'t the right type ');
  die(header("Location: ../pages/petdetails.php?pet_id=" . $pet_id));
} else {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No image selected!');
  die(header("Location: ../pages/petdetails.php?pet_id=" . $pet_id));
}
