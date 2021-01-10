<?php function draw_header($username, $page) { 
/**
 * Draws the header for all pages. Receives an username
 * if the user is logged in in order to draw the logout
 * link.
 */?>
  <!DOCTYPE html>
  <html>

    <head>
      <title>PetMe!</title>
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="Content-Security-Policy" content="object-src 'none'; script-src 'nonce-r4nd0m' 'strict-dynamic' https: http:; base-uri 'none';">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
      <link rel="stylesheet" href="../css/generic.css">
      <link rel="stylesheet" href="../css/header.css">
      <link rel="stylesheet" href="../css/main.css">
      <link rel="stylesheet" href="../css/authentication.css">
      <link rel="stylesheet" href="../css/ownerpage.css">
      <link rel="stylesheet" href="../css/petcards.css">
      <link rel="stylesheet" href="../css/petdetails.css">
      <link rel="stylesheet" href="../css/profile.css">
      <link rel="stylesheet" href="../css/editaccount.css">
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Lato&family=Oswald:wght@700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
      <script nonce="r4nd0m" src="../js/main.js" defer></script>
      <script nonce="r4nd0m" src="../js/security.js" defer></script>
      <script nonce="r4nd0m" src="../js/notifications.js" defer></script>
      <?php if (!is_null($username) && ($page == 'main' || $page == 'search' || $page == 'owner_favorite')) { ?>
        <script nonce="r4nd0m" src="../js/card_actions.js" defer></script>
      <?php } if ($page == 'owner_que_pro' || $page == 'owned_pets') { ?>
        <script nonce="r4nd0m" src="../js/owner_pro_que.js" defer></script>
      <?php } if ($page == 'petdetails' || $page=='add_pet') { ?>
        <script nonce="r4nd0m" src="../js/pet_details.js" defer></script> 
      <?php } if ($page == 'profile_page') { ?>
        <script nonce="r4nd0m" src="../js/profile_page.js" defer></script>
      <?php } ?>
    </head>

  <body>

    <header>
      <h1><a href="main.php">PetMe!</a></h1>
      <nav>
        <ul>
          <?php if ($username != NULL) { ?>
            <li><?= $username ?></li>
            <li><a href="../pages/owner_menu.php"><i class="fas fa-user"></i></a></li>
          <?php } else { ?>
            <li><a href="login.php">Login</li>
            <li><a href="signup.php">Register</a></li>
          <?php } ?>
        </ul>
      </nav>
    </header>
    
    <?php if (isset($_SESSION['messages'])) { ?>
      <section id="messages">
        <?php foreach ($_SESSION['messages'] as $message) { ?>
          <div class="<?= $message['type'] ?>"><?= $message['content'] ?></div>
        <?php } ?>
      </section>
    <?php unset($_SESSION['messages']);
    } ?>
    <nav></nav>
  <?php } ?>

<?php function draw_footer() { 
/**
 * Draws the footer for all pages.
 */ ?>
    <footer>
      <div class="footer-container">
        <h1><a href="main.php"><i class="fas fa-paw"></i> Pet Me!</a></h1>
        <p>Helping your pets find a forever home!</p>
        <p>Made with <i class="fas fa-heart"></i> at FEUP</p>
      </div>
      <div class="footer-container">
        <h1>Useful links</h1>
        <ul>
          <li><a href="main.php">Main page</a></li>
          <li><a href="search.php">Find a pet</a></li>
          <li><a target="_blank" rel="noopener noreferrer" href="https://sigarra.up.pt/feup/pt/ucurr_geral.ficha_uc_view?pv_ocorrencia_id=459485">Course Page</a></li>
        </ul>
      </div>
      <div class="footer-container">
        <h1>Contact us</h1>
        <ul>
          <li><a target="_blank" rel="noopener noreferrer" href="https://sigarra.up.pt/feup/pt/fest_geral.cursos_list?pv_num_unico=201806854">António Bezerra</a></li>
          <li><a target="_blank" rel="noopener noreferrer" href="https://sigarra.up.pt/feup/pt/fest_geral.cursos_list?pv_num_unico=201806451">Gonçalo Alves</a></li>
          <li><a target="_blank" rel="noopener noreferrer" href="https://sigarra.up.pt/feup/pt/fest_geral.cursos_list?pv_num_unico=201806385">Inês Silva</a></li>
          <li><a target="_blank" rel="noopener noreferrer" href="https://sigarra.up.pt/feup/pt/fest_geral.cursos_list?pv_num_unico=201806227">Pedro Seixas</a></li>
        </ul>
      </div>
    </footer>
  </body>

  </html>
<?php } ?>
