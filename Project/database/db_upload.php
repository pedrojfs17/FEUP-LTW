<?php
include_once('../includes/database.php');

function uploadProfileImage($username, $imagetmp){
  $db = Database::instance()->db();

  $stmt = $db->prepare("SELECT * FROM user WHERE username=:username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $img_name = $stmt->fetch();

  if ($img_name['profile_image'] != "user")
    deleteSet($img_name['profile_image']);
  $image_name=$username;
  // Insert image data into database
  $stmt = $db->prepare("UPDATE user SET profile_image=:image_name WHERE username=:username");
  $stmt->bindParam(':image_name', $image_name);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  
  // Get image ID
  uploadImage($username,$imagetmp);
}

function uploadPetImage($pet_id, $imagename, $imagetmp){
  $db = Database::instance()->db();
  // Insert image data into database
  $stmt = $db->prepare("INSERT INTO pet_image VALUES(NULL,:image_name,:pet_id)");
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->bindParam(':image_name', $imagename);
  $stmt->execute();

  // Get image ID
  $id = $db->lastInsertId();

  // Get image ID
  uploadImage($id,$imagetmp);
}

function deleteImageFromDb($imageID) {
  $db = Database::instance()->db();
  $stmt = $db->prepare("DELETE FROM pet_image WHERE pet_image_id=:imageId");
  $stmt->bindParam(':imageId', $imageID);
  $stmt->execute();
}

function deleteSet($imageID){
  deleteImage('../images/originals/'.$imageID. '.jpg');
  deleteImage('../images/thumbs_medium/'.$imageID. '.jpg');
  deleteImage('../images/thumbs_small/'.$imageID. '.jpg');
}

function deleteImage($imageID){
  unlink($imageID);
}

function uploadImage($id, $imagetmp)
{

  // Generate filenames for original, small and medium files
  $originalFileName = "../images/originals/$id.jpg";
  $smallFileName = "../images/thumbs_small/$id.jpg";
  $mediumFileName = "../images/thumbs_medium/$id.jpg";

  // Move the uploaded file to its final destination
  move_uploaded_file($imagetmp, $originalFileName);

  // Crete an image representation of the original image
  $original = imagecreatefromstring(file_get_contents($originalFileName));

  $width = imagesx($original);     // width of the original image
  $height = imagesy($original);    // height of the original image
  $square = min($width, $height);  // size length of the maximum square

  // Create and save a small square thumbnail
  $small = imagecreatetruecolor(200, 200);
  imagecopyresized($small, $original, 0, 0, ($width > $square) ? ($width - $square) / 2 : 0, ($height > $square) ? ($height - $square) / 2 : 0, 200, 200, $square, $square);
  imagejpeg($small, $smallFileName);


  // Calculate width and height of medium sized image (max width: 400)
  $mediumwidth = $width;
  $mediumheight = $height;
  if ($mediumwidth > 400) {
    $mediumwidth = 400;
    $mediumheight = $mediumheight * ($mediumwidth / $width);
  }

  // Create and save a medium image
  $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
  imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
  imagejpeg($medium, $mediumFileName);
}
