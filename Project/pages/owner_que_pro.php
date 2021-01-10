<?php
    include_once('../includes/session.php');
    include_once('../database/db_pets.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_auth.php');
    include_once('../templates/tpl_owner.php');

    // Verify if user is not logged in
    if (!isset($_SESSION['username']))
        die(header('Location: main.php'));

    draw_header($_SESSION['username'], 'owner_que_pro');
    draw_user_questions_proposals($_SESSION['username']);
    draw_footer();
?>
