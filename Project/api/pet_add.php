<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
  
    $data = json_decode(file_get_contents("php://input"));
  
    // make sure data is not empty
    if(
        !empty($data->name) &&
        !empty($data->type) &&
        !empty($data->species) &&
        !empty($data->age) &&
        !empty($data->gender) &&
        !empty($data->size) &&
        !empty($data->weight) &&
        !empty($data->color) &&
        !empty($data->location) &&
        !empty($data->state)
    ) {
        $pet_name = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s]/", '', $data->name));
        $pet_type = preg_replace("/[^1-7]/", '', $data->type);
        $pet_species = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s\-]/", '',  $data->species));
        $pet_age = preg_replace("/[^1-4]/", '',  $data->age);
        $pet_gender = preg_replace("/[^1-2]/", '',  $data->gender);
        $pet_size = preg_replace("/[^0-9,.]/", '',  $data->size);
        $pet_weight = preg_replace("/[^0-9,.]/", '',  $data->weight);
        $pet_color = preg_match("/^[1-9]$|^1[0-5]$/", $data->color) ? $data->color : "";
        $pet_location = trim(preg_replace("/[^a-zA-ZÀ-ÿ\s\-.]/", '',  $data->location));
        $pet_state = preg_replace("/[^1-4]/", '',  $data->state);

        if (strcmp($pet_name, "") == 0|| strcmp($pet_type, "") == 0 || 
            strcmp($pet_species, "") == 0 || strcmp($pet_age, "") == 0 || 
            strcmp($pet_gender, "") == 0 || strcmp($pet_size, "") == 0 || 
            strcmp($pet_weight, "") == 0 || strcmp($pet_color, "") == 0 || 
            strcmp($pet_location, "") == 0 || strcmp($pet_state, "") == 0) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create pet."));
        }

        addPet($pet_name, $pet_type, $pet_species, $pet_age, $pet_gender, $pet_size, $pet_weight, $pet_color, $pet_location, $user, $pet_state);
    
        http_response_code(201);
        echo json_encode(array("message" => "Pet was created."));
        
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create pet. Data incomplete."));
    }
?>