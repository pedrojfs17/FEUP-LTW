<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_auth.php');

	// Verify if user is logged in
	if (isset($_SESSION['username']))
		die(header('Location: main.php'));

	$shelters = getShelters();

	draw_header(null, 'signup');
	draw_signup($shelters);
	draw_footer();
?>
