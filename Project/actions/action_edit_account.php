<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');

$oldusername = $_SESSION['username'];
$oldpassword = $_POST['oldpassword'];
$username = preg_replace ("/[\s]/", '', strtolower($_POST['username']));
$password = $_POST['password'];

if (!isset($_POST['csrf'])) {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'No CSRF found!');
  die(header('Location: ../pages/edit_account.php'));
}
if (hash_equals($_POST['csrf'], $_SESSION['csrf']) === false) {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'CSRF mismatch!');
  die(header('Location: ../pages/edit_account.php'));
}


if (checkUserPassword($oldusername, $oldpassword)) {
  try {
    editUser($oldusername, $username, $password);
    $_SESSION['username'] = $username;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Edited profile successfully!');
    die(header('Location: ../pages/main.php'));
  } catch (PDOException $e) {
    die($e->getMessage());
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to edit!');
    die(header('Location: ../pages/edit_account.php'));
  }
} else {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Previous password is incorrect!');
  die(header('Location: ../pages/edit_account.php'));
}
