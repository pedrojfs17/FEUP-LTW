<?php
  session_start();                         // starts the session
  include_once('database/connection.php'); // connects to the database
  include_once('database/news.php');       // loads the functions responsible
                                           // for the news table
  $articles = getAllNews();                // gets all news from the database

  include('templates/common/header.php');  // prints the initial part of the HTML document
  include('templates/news/list_news.php'); // prints the list of news in HTML
  include('templates/common/footer.php');  // prints the initial part of the HTML document
?>
