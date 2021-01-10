<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once('../database/db_pets.php');
    include_once('../database/db_user.php');

    $user = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];

    $validated = checkUserPassword($user, $pass);

    if (!$validated) {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        die ("Not authorized");
    }

    if (isset($_GET['id'])) {
        $pet_id = $_GET['id'];
        $pet = getPet($pet_id);

        if (isset($pet['pet_id'])) {
            if (!isPetOwner($user, $pet_id, 0)) {
                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');
                die ("Not authorized");
            }
    
            deletePet($pet_id);

            http_response_code(200);
            echo json_encode(array("message" => "Pet was deleted."));
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Pet does not exist."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to delete pet. Pet id is needed."));
    };

?>