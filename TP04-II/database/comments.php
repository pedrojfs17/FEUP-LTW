<?php
  function getCommentsByNewId($id) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM comments LEFT JOIN users USING (username) WHERE news_id = ?');
    $stmt->execute(array($id));
    return $stmt->fetchAll();
  }

  function addComment($newsID, $username, $text) {
    global $db;
    $stmt = $db->prepare('INSERT INTO comments VALUES (NULL, ?, ?, ?, ?)');
    $stmt->execute(array($newsID, $username, time(), $text));
    $stmt->fetch();
  }

  function fetchComments($newsID, $lastCommentID) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM comments WHERE news_id = ? AND id > ?');
    $stmt->execute(array($newsID, $lastCommentID));
    return $stmt->fetchAll();
  }
?>
