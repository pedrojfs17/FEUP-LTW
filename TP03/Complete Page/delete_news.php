<?php 
    session_start();                         // starts the session
    include_once('database/connection.php');
    include_once('database/news.php');
    
    if (!array_key_exists('username',$_SESSION) || empty($_SESSION['username']))
        header("Location: list_news.php");
        
    $id = $_GET['id'];

    include('templates/common/header.php');  // prints the initial part of the HTML document
    include('templates/news/delete_news.php'); // prints the list of news in HTML
    include('templates/common/footer.php');  // prints the initial part of the HTML document
?>