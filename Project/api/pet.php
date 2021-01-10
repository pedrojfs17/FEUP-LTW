<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once('../database/db_pets.php');

    $pet_id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($pet_id == null) { // Get all the pets in the database
        $pets = getPets();
        $parsedPets = array();
        $parsedPets['pets'] = array();

        foreach($pets as $pet) {
            array_push($parsedPets['pets'], parsePet($pet));
        }

        if (count($parsedPets['pets']) > 0) {
            http_response_code(200);
            echo json_encode($parsedPets);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No pets found."));
        }
    } else { // Get the pet with id = pet_id
        $pet = getPet($pet_id);

        if (isset($pet['pet_id'])) {
            $parsedPet = parsePet($pet);
            http_response_code(200);
            echo json_encode($parsedPet);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Pet does not exist."));
        }
    }


    function parsePet($pet) {
        $parsedPet = array(
            "pet_id" => $pet['pet_id'],
            "name" => $pet['pet_name'],
            "type_id" => $pet['pet_type'],
            "type_name" => getPetTypeName($pet['pet_type']),
            "species" => $pet['pet_species'],
            "age_id" => $pet['pet_age'],
            "age" => getPetAgeName($pet['pet_age']),
            "gender_id" => $pet['pet_gender'],
            "gender" => getPetGenderName($pet['pet_gender']),
            "size" => $pet['pet_size'],
            "weight" => $pet['pet_weight'],
            "color_id" => $pet['pet_color'],
            "color" => getColorName($pet['pet_color']),
            "location" => $pet['pet_location'],
            "owner" => $pet['username'],
            "state_id" => $pet['pet_state'],
            "state" => getPetStateName($pet['pet_state'])
        );

        return $parsedPet;
    }
?>