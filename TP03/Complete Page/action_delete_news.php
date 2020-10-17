<?php 
    session_start();                         // starts the session
    include_once('database/connection.php');
    include_once('database/news.php');

    if (!array_key_exists('username',$_SESSION) || empty($_SESSION['username']))
        header("Location: list_news.php");

    $id = $_POST['id'];

    deleteNews($id);

    header("Location: list_news.php");
?>