<?php
    include_once('../includes/session.php');
    include_once('../database/db_pets.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_cards.php');

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

    $cards = getUnadoptedPets();

    draw_header($username, 'search');
    draw_search_cards($cards);
    draw_footer();
?>
