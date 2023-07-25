<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require_once 'Database.php';
  require_once 'Team.php';



    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Get player ID from request parameters
   if (!isset($_GET['player_id'])) {
  echo json_encode(array('message' => 'Player ID is required'));
  http_response_code(400);
  exit();
}

$player_id = $_GET['player_id'];


    // Instantiate Team object
    $team = new Team($db);
    $team->player_id = $player_id;

    // Get player from player ID
    $result = $team->readPlayer();
    $num = $result->rowCount();

    if ($num > 0) {
      // Player array
      $players_arr = array();

      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $player_item = array(
          'player_id' => $player_id,
          'team_id' => $team_id,
          'GivenName' => $given_names,
          'Surname' => $surname,
          'Nationality' => $nationality,
          'DOB' => $date_of_birth
        );

        // Push to "data"
        array_push($players_arr, $player_item);
      }

      // Turn to JSON & output
      echo json_encode($players_arr);
    } else {
      // No Players
      echo json_encode(
        array('message' => 'No Players Found')
      );
    }
  


?>
