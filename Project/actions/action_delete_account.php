<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');
include_once('../database/db_upload.php');

if (!isset($_POST['csrf'])) {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No CSRF found!');
  die(header('Location: ../pages/edit_account.php'));
}
if (hash_equals($_POST['csrf'], $_SESSION['csrf']) === false) {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'CSRF mismatch!');
  die(header('Location: ../pages/edit_account.php'));
}

$user = getUser($_SESSION['username']);
if ($user['profile_image'] != "user")
  deleteSet($user['profile_image']);
deleteUser($_SESSION['username']);

session_destroy();
session_start();
$_SESSION['messages'][] = array('type' => 'success', 'content' => 'Deleted profile successfully!');
die(header('Location: ../pages/main.php'));
