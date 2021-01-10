<?php
include_once('../includes/session.php');
include_once('../database/db_pets.php');
include_once('../database/db_user.php');
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_auth.php');
include_once('../templates/tpl_collaborators.php');

// Verify if user is not logged in
if (!isset($_SESSION['username']))
    die(header('Location: main.php'));

draw_header($_SESSION['username'], 'collaborator_list');
if (isShelter($_SESSION['username']))
    draw_collaboration($_SESSION['username']);
else
    die(header('Location: main.php'));
draw_footer();
