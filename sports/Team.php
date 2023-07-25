<?php 
  class Team {
    // DB stuff
    private $conn;
    private $table = 'teams_table';
    private $tableP = 'players_table';
    // Post Properties
    public $team_id;
    public $name;
    public $sport;
    public $avg_age;
    public $player_id;
    public $given_names;
    public $surname;
    public $nationality;
    public $date_of_birth;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT t.team_id, t.name, t.sport, ROUND(AVG(DATEDIFF(CURDATE(), p.date_of_birth)/365), 2) as avg_age
FROM '.$this->table.' t
INNER JOIN '.$this->tableP.' p ON t.team_id = p.team_id
GROUP BY t.team_id
ORDER BY t.name';


      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();
      

      return $stmt;
    }
  public function readPlayer() {
      // Create query
      $query = 'SELECT * FROM players_table WHERE player_id = :player_id ';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':player_id', $this->player_id);
      // Execute query
      $stmt->execute();
      

      return $stmt;
    }
  public function getPlayers() {
    // Create query
    $query = 'SELECT * FROM players_table WHERE team_id = :team_id ';
      
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':team_id', $this->team_id);

    // Execute query
    $stmt->execute();

    // Return players
    return $stmt;
  }
  
  
public function addPlayers(){
    // Create query
    $query = 'INSERT INTO players_table
              SET
                surname = :surname,
                given_names = :given_names,
                nationality = :nationality,
                date_of_birth = :date_of_birth,
                team_id = :team_id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->surname = htmlspecialchars(strip_tags($this->surname));
    $this->given_names = htmlspecialchars(strip_tags($this->given_names));
    $this->nationality = htmlspecialchars(strip_tags($this->nationality));
    $this->date_of_birth = htmlspecialchars(strip_tags($this->date_of_birth));
    $this->team_id = htmlspecialchars(strip_tags($this->team_id));

    // Bind data
    $stmt->bindParam(':surname', $this->surname);
    $stmt->bindParam(':given_names', $this->given_names);
    $stmt->bindParam(':nationality', $this->nationality);
    $stmt->bindParam(':date_of_birth', $this->date_of_birth);
    $stmt->bindParam(':team_id', $this->team_id);

    // Execute query
    if($stmt->execute()){
        return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
}


public function deletePlayer(){
  // Create query
  $query = 'DELETE FROM players_table WHERE player_id = :player_id';

  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->player_id = htmlspecialchars(strip_tags($this->player_id));

  // Bind data
  $stmt->bindParam(':player_id', $this->player_id);

  // Execute query
  if($stmt->execute()){
    return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
}


public function updatePlayers(){
    // Create query
    $query = 'UPDATE ' . $this->tableP . '
              SET surname = :surname, given_names = :given_names, nationality = :nationality, date_of_birth = :date_of_birth, team_id = :team_id
              WHERE player_id = :player_id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->surname = htmlspecialchars(strip_tags($this->surname));
    $this->given_names = htmlspecialchars(strip_tags($this->given_names));
    $this->nationality = htmlspecialchars(strip_tags($this->nationality));
    $this->date_of_birth = htmlspecialchars(strip_tags($this->date_of_birth));
    $this->team_id = htmlspecialchars(strip_tags($this->team_id));
    $this->player_id = htmlspecialchars(strip_tags($this->player_id));

    // Bind data
    $stmt->bindParam(':surname', $this->surname);
    $stmt->bindParam(':given_names', $this->given_names);
    $stmt->bindParam(':nationality', $this->nationality);
    $stmt->bindParam(':date_of_birth', $this->date_of_birth);
    $stmt->bindParam(':team_id', $this->team_id);
    $stmt->bindParam(':player_id', $this->player_id);

    // Execute query
    if($stmt->execute()){
        return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
}



}

?>