<?php
    include_once('../includes/session.php');
    include_once('../database/db_pets.php');
    include_once('../database/db_user.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_auth.php');
    include_once('../templates/tpl_owner.php');

    // Verify if user is not logged in
    if (!isset($_SESSION['username']))
        die(header('Location: main.php'));


    $petID = getLastPetID();
    
    draw_header($_SESSION['username'], 'add_pet');
    draw_add_pet($petID);
    draw_footer();
?>
