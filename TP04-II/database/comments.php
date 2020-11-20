<?php
  function getCommentsByNewId($id) {
    global $db;
    $stmt = $db->prepare('SELECT id, news_id, published, text, COALESCE(name, username) as name FROM comments LEFT JOIN users USING (username) WHERE news_id = ?');
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
    $stmt = $db->prepare('SELECT id, news_id, published, text, COALESCE(name, username) as username FROM comments LEFT JOIN users USING (username) WHERE news_id = ? AND id > ?');
    $stmt->execute(array($newsID, $lastCommentID));
    return $stmt->fetchAll();
  }
?>
