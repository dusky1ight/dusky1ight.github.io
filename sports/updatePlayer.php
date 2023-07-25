<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

  include_once 'Database.php';
  include_once 'Team.php';


    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate player object
    $player = new Team($db);

    // Get data
    $player_id = isset($_GET['player_id']) ? $_GET['player_id'] : die();
    // Set ID
    $player->player_id = $player_id;
    
    
    $data = json_decode(file_get_contents("php://input"));

    // Set properties
    $player->surname = $data->surname;
    $player->given_names = $data->given_names;
    $player->nationality = $data->nationality;
    $player->date_of_birth = $data->date_of_birth;
    $player->team_id = $data->team_id;

    // Update player
    if ($player->updatePlayers()) {
      echo json_encode(
        array('message' => 'Player Updated')
      );
    } else {
      echo json_encode(
        array('message' => 'Player Not Updated')
      );
    }
 
?>
