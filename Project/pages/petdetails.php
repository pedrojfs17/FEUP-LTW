<?php
    include_once('../includes/session.php');
    include_once('../database/db_pets.php');
    include_once('../database/db_user.php');
    include_once('../database/db_questions.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_details.php');
    include_once('../templates/tpl_secure.php');

    $pet_id = $_GET['pet_id'];

    $pet = getPet($pet_id);

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

    draw_header($username, 'petdetails');
    draw_petdetails($pet,$username);
    draw_footer();
?>
