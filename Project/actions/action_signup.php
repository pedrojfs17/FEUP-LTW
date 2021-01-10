<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');

$accountType = $_POST['accountType'];
$username = preg_replace ("/[\s]/", '', strtolower($_POST['username']));
$password = $_POST['password'];
$shelter = NULL;
if ($accountType == 0 && isset($_POST['shelter'])) {
  $shelter = $_POST['shelter'];
}

try {
  insertUser($username, $password, $accountType, $shelter);
  $_SESSION['username'] = $username;
  $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Signed up and logged in!');
  die(header('Location: ../pages/setup_profile.php'));
} catch (PDOException $e) {
  die($e->getMessage());
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup! Username already in exists');
  die(header('Location: ../pages/signup.php'));
}
