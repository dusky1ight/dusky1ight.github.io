<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

  include_once 'Database.php';
  include_once 'Team.php';



 function deletePlayer() {
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate player object
  $player = new Team($db);

  // Get player ID from request parameters
  $player->player_id = isset($_GET['player_id']) ? $_GET['player_id'] : die();
  
  // Delete player
  if($player->deletePlayer()){
    echo json_encode(
      array('message' => 'Player deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Player not deleted')
    );
  }
}


deletePlayer();
?>
