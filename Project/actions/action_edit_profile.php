<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');
include_once('../database/db_upload.php');

$username = $_POST['username'];

$user = getUser($username);

$user_fullname = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s\-]/", '',  $_POST['fullname']));
$user_age = preg_replace("/[^0-9]/", '',  $_POST['age']);
$user_email = preg_replace("/[^a-zA-Z0-9@._\+\-]/", '',  $_POST['email']);
$user_mobile = preg_replace("/[^0-9\+\-]/", '',  $_POST['mobile']);
$user_location = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s.\-]/", '',  $_POST['location']));
$user_bio = trim(preg_replace("/[^a-zA-ZÀ-ÿ,.\-?!:;\s]/", '',  $_POST['bio']));

if (!strcmp($user_fullname, "")) $user_fullname = $user['fullname'];
if (!strcmp($user_age, "")) $user_age = $user['age'];
if (!strcmp($user_email, "")) $user_email = $user['email'];
if (!strcmp($user_mobile, "")) $user_mobile = $user['mobile'];
if (!strcmp($user_location, "")) $user_location = $user['location'];
if (!strcmp($user_bio, "")) $user_bio = $user['bio'];
$count=0;

  if(isset($_FILES['profilepic']))
    $count =  $_FILES['profilepic']['size'];

try {
  editProfile($username, $user_fullname, $user_age, $user_email, $user_mobile, $user_location, $user_bio);
  if ($count > 0) {
    uploadProfileImage($username, $_FILES['profilepic']['tmp_name']);
  }
  $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Edited user successfully!');
  die(header('Location: ../pages/profile_page.php?user='.$username));
} catch (PDOException $e) {
  die($e->getMessage());
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to edit!');
  die(header('Location: ../pages/edit_account.php'));
}
