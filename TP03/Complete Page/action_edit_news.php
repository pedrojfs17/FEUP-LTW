<?php 
    session_start();                         // starts the session
    include_once('database/connection.php');
    include_once('database/news.php');

    $id = $_POST['id'];
    $title = $_POST['title'];
    $introduction = $_POST['introduction'];
    $fulltext = $_POST['fulltext'];

    updateDatabase($id, $title, $introduction, $fulltext);

    header("Location: news_item.php?id=$id");
?>