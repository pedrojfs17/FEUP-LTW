<?php
include_once('../includes/session.php');
include_once('../database/db_user.php');

if (!isset($_SESSION['username']))
  die(header('Location: ../pages/login.php'));

$sender = $_SESSION['username'];
$receiver = $_GET['receiver'];
$text = $_GET['text'];

addNotification($sender, $receiver, $text);
