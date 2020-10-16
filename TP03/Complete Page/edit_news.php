<?php 
    session_start();                         // starts the session
    include_once('database/connection.php');
    include_once('database/news.php');
  
    $id = $_GET['id'];
    $article = getArticle($id);

    include('templates/common/header.php');  // prints the initial part of the HTML document
    include('templates/news/edit_news.php'); // prints the list of news in HTML
    include('templates/common/footer.php');  // prints the initial part of the HTML document
?>