<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');
  include_once 'Database.php';
  include_once 'Team.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate player object
  $player = new Team($db);
  // Get posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set player property values
  $player->surname = $data->surname;
  $player->given_names = $data->given_names;
  $player->nationality = $data->nationality;
  $player->date_of_birth = $data->date_of_birth;
  $player->team_id = $data->team_id;

  // Add player to team
  if($player->addPlayers()){
    echo json_encode(
      array('message' => 'Player Added to Team')
    );
  } else {
    echo json_encode(
      array('message' => 'Player Not Added to Team')
    );
  }
?>
