<?php
include_once('../includes/database.php');

/**
 * Verifies if a certain username, password combination
 * exists in the database. Use the bycrypt hashing function.
 */
function checkUserPassword($username, $password)
{
  $db = Database::instance()->db();

  $stmt = $db->prepare('SELECT * FROM user WHERE username = :username');
  $stmt->bindParam(':username', $username);
  $stmt->execute();

  $user = $stmt->fetch();
  return $user !== false && password_verify($password, $user['password']);
}

function insertUser($username, $password, $accountType, $shelter)
{
  $db = Database::instance()->db();

  $options = ['cost' => 12];

  $stmt = $db->prepare('INSERT INTO user(username,password,shelter,collaborator) VALUES(:username, :password, :account_type, :shelter)');
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT, $options));
  $stmt->bindParam(':account_type', $accountType);
  $stmt->bindParam(':shelter', $shelter);
  $stmt->execute();
}

function editUser($olduser, $username, $password)
{

  $db = Database::instance()->db();

  $options = ['cost' => 12];

  $stmt = $db->prepare('UPDATE user SET username=:username,password=:password WHERE username=:old_user');
  $stmt->bindParam(':username', $username);
  $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT, $options));
  $stmt->bindParam(':old_user', $olduser);
  $stmt->execute();
}

function deleteUser($username) {

  $db = Database::instance()->db();
  $stmt = $db->prepare('DELETE FROM user WHERE username=:username');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
}

function editProfile($username, $fullname, $age, $email, $mobile, $location, $bio)
{

  $db = Database::instance()->db();

  $stmt = $db->prepare('UPDATE user SET fullname=:fullname, age=:age, email=:email, mobile=:mobile, location=:location, bio=:bio WHERE username=:username');
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':fullname', $fullname);
  $stmt->bindParam(':age', $age);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':mobile', $mobile);
  $stmt->bindParam(':location', $location);
  $stmt->bindParam(':bio', $bio);
  $stmt->execute();
}

function isShelter($username)
{

  $db = Database::instance()->db();

  $stmt = $db->prepare('SELECT * FROM user WHERE username=:username AND shelter=1');
  $stmt->bindParam(':username', $username);
  $stmt->execute();

  $user = $stmt->fetch();
  return $user !== false;
}

function getShelters()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT username FROM user WHERE shelter=1');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getCollaborators($shelter)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM user WHERE shelter=0 AND collaborator=:shelter');
  $stmt->bindParam(':shelter', $shelter);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getNonCollaborators()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM user WHERE shelter=0 AND collaborator IS NULL');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getUser($username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM user WHERE username=:username');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetch();
}

function addNotification($sender, $receiver, $text){
  $db = Database::instance()->db();
  $stmt = $db->prepare('INSERT INTO notification VALUES(NULL, :sender, :receiver, :text, :time, 0)');
  $stmt->bindParam(':sender', $sender);
  $stmt->bindParam(':receiver', $receiver);
  $stmt->bindParam(':text', $text);
  $stmt->bindParam(':time', time());
  $stmt->execute();
}

function getUserNotifications($user) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM notification WHERE notif_receiver = :user ORDER BY published DESC');
  $stmt->bindParam(':user', $user);
  $stmt->execute();
  return $stmt->fetchAll(); 
}

function setNotificationSeen($notif_id) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('UPDATE notification SET seen=1 WHERE notif_id=:notif_id');
  $stmt->bindParam(':notif_id', $notif_id);
  $stmt->execute();
}

function getRandomShelter()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM user WHERE shelter=1 ORDER BY RANDOM() LIMIT 1;');
  $stmt->execute();
  return $stmt->fetch();
}

function getRandomUser()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM user WHERE shelter=0 ORDER BY RANDOM() LIMIT 1;');
  $stmt->execute();
  return $stmt->fetch();
}


function addCollaborator($username, $shelter) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('UPDATE user SET collaborator=:shelter WHERE username=:username');
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':shelter', $shelter);
  $stmt->execute();
  return $stmt->fetch();
}

function removeCollaborator($username, $shelter) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('UPDATE user SET collaborator=NULL WHERE username=:username AND collaborator=:shelter');
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':shelter', $shelter);
  $stmt->execute();
  return $stmt->fetch();
}