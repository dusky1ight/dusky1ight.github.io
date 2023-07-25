<?php 
  class Database {
    // DB Parameters
    private $host = '';
    private $db_name = '';
    private $username = '';
    private $password = '';
    private $conn;

    // DB Connection
    public function connect() {
      $this->conn = null;

      try { 
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8mb4';
    $this->conn = new PDO($dsn, $this->username, $this->password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo 'Connection Error: ' . $e->getMessage();
  }


      return $this->conn;
    }
  }
?>