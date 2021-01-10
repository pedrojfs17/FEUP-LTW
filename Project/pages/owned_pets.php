<?php
include_once('../includes/session.php');
include_once('../database/db_pets.php');
include_once('../database/db_user.php');
include_once('../database/db_questions.php');
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_auth.php');
include_once('../templates/tpl_owner.php');

// Verify if user is not logged in
if (!isset($_SESSION['username']))
    die(header('Location: main.php'));


if (isShelter($_SESSION['username'])) {
    $ownedPets = [];
    foreach (getCollaborators($_SESSION['username']) as $collaborator) {
        array_push($ownedPets, ...getPetsFromUser($collaborator['username']));
    }
} else
    $ownedPets = getPetsFromUser($_SESSION['username']);

    draw_header($_SESSION['username'], 'owned_pets');
    draw_owned_questions_proposals($ownedPets);
    draw_footer();
?>
