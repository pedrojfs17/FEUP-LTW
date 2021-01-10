<?php
include_once('../includes/database.php');

function getPetsQuestions($pet_id)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM question WHERE pet_id = :pet_id');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetsProposals($pet_id)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet_proposal WHERE pet_id = :pet_id ORDER BY published DESC');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getRepliedQuestions($pet_id)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT DISTINCT question.* FROM question INNER JOIN reply ON question.question_id=reply.question_id WHERE pet_id = :pet_id ORDER BY question.username');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getReply($question_id)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM reply WHERE question_id = :question_id');
  $stmt->bindParam(':question_id', $question_id);
  $stmt->execute();
  return $stmt->fetchAll();
}

function hasReplied($question_id)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM reply WHERE question_id = :question_id');
  $stmt->bindParam(':question_id', $question_id);
  $stmt->execute();
  $replied =  $stmt->fetch();
  return $replied !== false;
}

function getAllUserQuestions($user) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM question WHERE username = :user');
  $stmt->bindParam(':user', $user);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getAllUserResponses($user) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM reply WHERE username = :user');
  $stmt->bindParam(':user', $user);
  $stmt->execute();
  return $stmt->fetchAll();
}
