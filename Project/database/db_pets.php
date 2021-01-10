<?php
include_once('../includes/database.php');
/**
 * Returns the lists belonging to a certain user.
 */
function getPets()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet');
  $stmt->execute(array());
  return $stmt->fetchAll();
}

function getPet($pet_id)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet WHERE pet_id = :pet_id');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->execute();
  return $stmt->fetch();
}

function getPetsFromUser($username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet WHERE username = :username');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}
function getPetsUpForAdoptionFromUser($username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet WHERE username = :username AND pet_state=2');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getAdoptedPetsFromUser($username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet WHERE username = :username AND pet_state=4');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getImageFromPets($pet_id)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet_image WHERE pet_id = :pet_id');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getUnadoptedPets() {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet WHERE pet_state <> 4');
  $stmt->execute(array());
  return $stmt->fetchAll(); 
}

function getRandomFeaturedPets() {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet WHERE pet_state <> 4 ORDER BY RANDOM() LIMIT 3');
  $stmt->execute(array());
  return $stmt->fetchAll(); 
}

function getPetTypes()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet_type');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetSpecies()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT DISTINCT pet_species FROM pet');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetAges()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet_age');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetGenders()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet_gender');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetSizes()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT DISTINCT pet_size FROM pet');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetWeights()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT DISTINCT pet_weight FROM pet');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetColors()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT DISTINCT pet_color FROM pet');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetLocations()
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT DISTINCT pet_location FROM pet');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getPetsFromUserProposals($username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT pet.* FROM pet INNER JOIN pet_proposal ON pet.pet_id=pet_proposal.pet_id WHERE pet_proposal.username = :username ORDER BY published DESC');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getUserProposals($username) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT pet_proposal.*, pet.pet_name FROM pet_proposal JOIN pet ON pet.pet_id = pet_proposal.pet_id WHERE pet_proposal.username = :username ORDER BY published DESC');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll(); 
}

function getPetsFromUserQuestions($username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT DISTINCT pet.pet_id, pet.pet_name FROM pet INNER JOIN question ON pet.pet_id=question.pet_id WHERE question.username = :username');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getUserQuestions($pet_id, $username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT question.* FROM question INNER JOIN user ON question.username=user.username WHERE question.pet_id = :pet_id AND user.username = :username');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getFavoritePets($username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT pet.* FROM pet INNER JOIN favorite_pet ON pet.pet_id=favorite_pet.pet_id WHERE favorite_pet.username = :username');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getFavoritePetIDs($username)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT pet.pet_id FROM pet INNER JOIN favorite_pet ON pet.pet_id=favorite_pet.pet_id WHERE favorite_pet.username = :username');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}

function toggleFavoritePet($username, $pet_id)
{
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM favorite_pet WHERE pet_id = :pet_id AND username = :username');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $fav = $stmt->fetch() ? true : false;
  if ($fav) {
    $stmt = $db->prepare('DELETE FROM favorite_pet WHERE pet_id = :pet_id AND username = :username');
    
  } else {
    $stmt = $db->prepare('INSERT INTO favorite_pet VALUES (NULL, :pet_id, :username)');
  }
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return !$fav;
}

function isPetOwner($username, $pet_id, $shelter)
{
  $db = Database::instance()->db();
  if ($shelter) {
    $stmt = $db->prepare('SELECT * FROM pet LEFT JOIN user ON pet.username=user.username WHERE pet.pet_id=:pet_id AND user.collaborator=:username');
  } else {
    $stmt = $db->prepare('SELECT * FROM pet WHERE pet_id=:pet_id AND username=:username');
  }
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->bindParam(':username', $username);
  $stmt->execute();

  $user = $stmt->fetch();
  return $user !== false;
}

function editPet($pet_id, $pet_type, $pet_name, $pet_species, $pet_age, $pet_gender, $pet_size, $pet_weight, $pet_color, $pet_location, $pet_state)
{

  $db = Database::instance()->db();

  $stmt = $db->prepare('UPDATE pet SET pet_name=:pet_name, pet_type=:pet_type, pet_species=:pet_species, pet_age=:pet_age, pet_gender=:pet_gender, pet_size=:pet_size, pet_weight=:pet_weight, pet_color=:pet_color, pet_location=:pet_location, pet_state=:pet_state WHERE pet_id=:pet_id');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->bindParam(':pet_type', $pet_type);
  $stmt->bindParam(':pet_name', $pet_name);
  $stmt->bindParam(':pet_species', $pet_species);
  $stmt->bindParam(':pet_age', $pet_age);
  $stmt->bindParam(':pet_gender', $pet_gender);
  $stmt->bindParam(':pet_size', $pet_size);
  $stmt->bindParam(':pet_weight', $pet_weight);
  $stmt->bindParam(':pet_color', $pet_color);
  $stmt->bindParam(':pet_location', $pet_location);
  $stmt->bindParam(':pet_state', $pet_state);
  $stmt->execute();
}

function addPet($pet_name, $pet_type, $pet_species, $pet_age, $pet_gender, $pet_size, $pet_weight, $pet_color, $pet_location, $username,$pet_state)
{

  $db = Database::instance()->db();

  $stmt = $db->prepare('INSERT INTO pet VALUES (NULL,:pet_type,:pet_name,:pet_species,:pet_age,:pet_gender,:pet_size,:pet_weight,:pet_color,:pet_location,:username,:pet_state)');
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':pet_type', $pet_type);
  $stmt->bindParam(':pet_name', $pet_name);
  $stmt->bindParam(':pet_species', $pet_species);
  $stmt->bindParam(':pet_age', $pet_age);
  $stmt->bindParam(':pet_gender', $pet_gender);
  $stmt->bindParam(':pet_size', $pet_size);
  $stmt->bindParam(':pet_weight', $pet_weight);
  $stmt->bindParam(':pet_color', $pet_color);
  $stmt->bindParam(':pet_location', $pet_location);
  $stmt->bindParam(':pet_state', $pet_state);
  $stmt->execute();
}

function deletePet($pet_id)
{

  $db = Database::instance()->db();

  $stmt = $db->prepare('DELETE FROM pet WHERE pet_id=:pet_id');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->execute();
}

function getLastPetID()
{
  $db = Database::instance()->db();

  $stmt = $db->prepare('SELECT MAX(pet_id) AS pet_id FROM pet');
  $stmt->execute();
  return $stmt->fetch();
}

function setProposalState($proposal_id, $decision, $username) {
  $db = Database::instance()->db();
  if ($decision == 1 || $decision == -1) {
    $stmt = $db->prepare('UPDATE pet_proposal SET decision=:decision
                        WHERE pet_proposal_id = :proposal_id
                        AND EXISTS(SELECT * FROM pet_proposal JOIN pet 
                                  ON pet_proposal.pet_id=pet.pet_id 
                                  WHERE pet_proposal.pet_proposal_id=:proposal_id 
                                  AND pet.username=:username)');
  } else if ($decision == 2 || $decision == -2) {
    $stmt = $db->prepare('UPDATE pet_proposal SET decision=:decision
                          WHERE pet_proposal_id = :proposal_id
                          AND :username=pet_proposal.username');
  }
  $stmt->bindParam(':proposal_id', $proposal_id);
  $stmt->bindParam(':decision', $decision);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
}

function getProposalStateCode($decision) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT decision_code FROM proposal_decision WHERE decision_id = :decision');
  $stmt->bindParam(':decision', $decision);
  $stmt->execute();
  return $stmt->fetch()['decision_code'];
}

function newProposal($pet_id, $username, $motivation) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('INSERT INTO pet_proposal (pet_id, username, motivation) VALUES (:pet_id, :username, :motivation)');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':motivation', $motivation);
  $stmt->execute();
}

function getPetStateName($pet_state) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT name FROM pet_states WHERE state_id = :pet_state');
  $stmt->bindParam(':pet_state', $pet_state);
  $stmt->execute();
  return $stmt->fetch()["name"];
}

function getPetStateDescription($pet_state) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT description FROM pet_states WHERE state_id = :pet_state');
  $stmt->bindParam(':pet_state', $pet_state);
  $stmt->execute();
  return $stmt->fetch()["description"];
}

function getPendingProposals($username) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT username FROM pet_proposal WHERE username=:username AND decision=0');
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  return $stmt->fetchAll();
}

function hasPendingProposal($username, $pet_id) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT username FROM pet_proposal WHERE username=:username AND decision=0 AND pet_id=:pet_id');
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->execute();
  return $stmt->fetch() ? true : false;
}

function newQuestion($pet_id, $username, $question) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('INSERT INTO question (pet_id, username, published, question_text) VALUES (:pet_id, :username, :published, :question)');
  $stmt->bindParam(':pet_id', $pet_id);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':published', time());
  $stmt->bindParam(':question', $question);
  $stmt->execute();
}

function newReply($question_id, $username, $reply) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('INSERT INTO reply (question_id, username, published, reply_text) VALUES (:question_id, :username, :published, :reply)');
  $stmt->bindParam(':question_id', $question_id);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':published', time());
  $stmt->bindParam(':reply', $reply);
  $stmt->execute();
}

function getPetTypeName($pet_type) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT name FROM pet_type WHERE type_id = :pet_type');
  $stmt->bindParam(':pet_type', $pet_type);
  $stmt->execute();
  return $stmt->fetch()["name"];
}

function getPetAgeName($pet_age) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT name FROM pet_age WHERE age_id = :pet_age');
  $stmt->bindParam(':pet_age', $pet_age);
  $stmt->execute();
  return $stmt->fetch()["name"];
}

function getPetAgeDescription($pet_age) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT description FROM pet_age WHERE age_id = :pet_age');
  $stmt->bindParam(':pet_age', $pet_age);
  $stmt->execute();
  return $stmt->fetch()["description"];
}

function getPetGenderName($pet_gender) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT name FROM pet_gender WHERE gender_id = :pet_gender');
  $stmt->bindParam(':pet_gender', $pet_gender);
  $stmt->execute();
  return $stmt->fetch()["name"];
}

function getColorNames() {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM color');
  $stmt->execute();
  return $stmt->fetchAll();
}

function getColorName($color_id) {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT name FROM color WHERE color_id = :color_id');
  $stmt->bindParam(':color_id', $color_id);
  $stmt->execute();
  return $stmt->fetch()["name"];
}

function getPetStates() {
  $db = Database::instance()->db();
  $stmt = $db->prepare('SELECT * FROM pet_states');
  $stmt->execute();
  return $stmt->fetchAll();
}

?>