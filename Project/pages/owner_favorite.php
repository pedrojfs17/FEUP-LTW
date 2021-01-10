<?php
    include_once('../includes/session.php');
    include_once('../database/db_pets.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_auth.php');
    include_once('../templates/tpl_cards.php');

    // Verify if user is not logged in
    if (!isset($_SESSION['username']))
        die(header('Location: main.php'));

    $cards = getFavoritePets($_SESSION['username']);

    draw_header($_SESSION['username'], 'owner_favorite');
    draw_cards($cards, 0, count($cards),false);
    draw_footer();
?>
