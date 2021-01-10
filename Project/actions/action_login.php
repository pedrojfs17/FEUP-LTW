<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');

$username = strtolower($_POST['username']);
$password = $_POST['password'];

if (checkUserPassword($username, $password)) {
  $_SESSION['username'] = $username;
  $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
  die(header('Location: ../pages/main.php'));
} else {
  $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed! Please check your username/password');
  die(header('Location: ../pages/login.php'));
}
