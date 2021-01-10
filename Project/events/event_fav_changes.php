<?php
include_once('../includes/session.php');
include_once('../database/db_pets.php');
header("Cache-Control: no-cache");
header("Content-Type: text/event-stream");

$data['favs'] = getFavoritePetIDs($_SESSION['username']);
$data = json_encode($data);

echo "retry: 5000\n";
echo "data: $data\n\n";
flush();
