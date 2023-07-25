<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once 'Database.php';
  include_once 'Team.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();



 $team_id = isset($_GET['team_id']) ? $_GET['team_id'] : die();
  // Instantiate blog post object
  $team = new Team($db);
  $team->team_id = $team_id;
// Get team ID from request parameters
  
   $result = $team->getPlayers();
   $num = $result->rowCount();
   
   if($num > 0) {
  // Player array
  $players_arr = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
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