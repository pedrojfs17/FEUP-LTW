<?php
  session_start();                         // starts the session
  include_once('database/connection.php');
  include_once('database/news.php');

  $article = getArticle($_GET['id']);
  $tags = explode(',', $article['tags']);
  $comments = getComments($_GET['id']);

  include('templates/common/header.php');
  include('templates/news/view_news.php');
  include('templates/common/footer.php');
?>
