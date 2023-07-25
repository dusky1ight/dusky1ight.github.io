
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Training session</title>
    <style>
body {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  font-family: "Gill Sans", serif;
  font-size: 16px;
  background-color: #B3B3B3;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
  border: 1px solid #ccc;
  padding: 20px;
  max-width: 400px;
  border-radius: 49px;
}

label {
  display: block;
  margin-bottom: 5px;
}

select, input[type="text"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 9px;
  box-sizing: border-box;
  margin-bottom: 10px;
  font-family: "Gill Sans", serif;
  font-size: 16px;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  align-self: center;
}

input[type="submit"]:hover {
  background-color: #45a049;
  
}

h1 {
  text-align: center;
  font-family: "Gill Sans", serif;
  margin-top: 10px;
  color: #181818;
}

.topic-label {
  font-weight: bold;
  font-size: 18px;
  color: #121212;
  margin-bottom: 10px;
  text-align: center;
}

     </style>
</head>
<body>
<?php

session_start();
// Connect to the database
$conn = new mysqli("", "", "", "");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve the topics with available sessions


// Create the topic drop-down menu

echo"<h1>IT Training Session Registration Page</h1>";
echo "<form id='sesha' method='post'>";
echo "<label class='topic-label'>Select a topic:</label> ";
echo "<select name='topic_id' onchange='this.form.submit()' >";
echo "<option value=''>-- Select a topic --</option>";

$sql = "SELECT topics.topic_id, topic_name 
        FROM topics 
        INNER JOIN sessions 
        ON topics.topic_id = sessions.topic_id 
        WHERE places_available > 0 
        GROUP BY topics.topic_id
        ORDER BY topic_name";

$result = $conn->query($sql);

foreach ($result as $row) {
  $selected = '';
            if (isset($_POST['topic_id']) && $_POST['topic_id'] == $row['topic_id']) {
                $selected = 'selected';
            }
  echo "<option value='" . $row["topic_id"] . "' $selected>" . $row["topic_name"] . "</option>";
}

echo "</select><br>";


// If a topic has been selected, retrieve the available sessions for that topic
if (isset($_POST["topic_id"])) {
  $topic_id = $_POST["topic_id"];
  $sql = "SELECT session_id, day, time 
          FROM sessions 
          WHERE topic_id = $topic_id 
          AND places_available > 0";

  $result = $conn->query($sql);
 
  
  

  // Create the session drop-down menu
  echo "<label class='topic-label'>Select a session:</label> ";
  echo "<select name='session_id'>";
  while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["session_id"] . "' >" . $row["day"] . " at " . $row["time"] . "</option>";
  }
  echo "</select><br>";

  // Add fields for the student's name and email address
  echo "<label class='topic-label'>Enter your Name:</label> ";
  echo " <input type='text' name='name' value='" . htmlspecialchars(isset($_SESSION['name']) ? $_SESSION['name'] : '') . "' required><br>";
  echo "<label class='topic-label'>Enter your Email ID:</label> ";
  echo "<input type='text' name='email' value='" . htmlspecialchars(isset($_SESSION['email']) ? $_SESSION['email'] : '') . "' required><br>";

  // Add a submit button
  echo "<input type='submit' value='Register' >";
  echo "</form>";
}




// If the form has been submitted, book the session and update the database

if (isset($_POST["session_id"]) && isset($_POST["name"]) && isset($_POST["email"]) ){

//Name and Email Validation Function
   function validateName($name) { 
           $pattern = '/^([a-zA-Z]|[\'"](?=[a-zA-Z]))[a-zA-Z\'\-\s]*([a-zA-Z]|[\'"](?=[a-zA-Z]))$/';
           if (empty($name)) {
              return "Name is required.";}
                      else if (!preg_match($pattern, $name)) {
              return "Please Enter a Valid Name";}
                       else {
              return "";}
                                }

  function validateEmail($email) {
        if (empty($email)) {
              return "Email is required.";}
                   else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              return "Please Enter a Valid Email";}
                   else {
              return "";}
                            }
//Santizing the input to prevent injection  
  $session_id = $_POST["session_id"];
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);


// Validating the input
  
  $nameError = validateName($name);
  $emailError = validateEmail($email);


  if (!empty($nameError) || !empty($emailError)) {
    // Display error messages
    echo "Error: " . $nameError;
    echo '<br>';
    echo "Error: " . $emailError;
    echo '<br><br>';
    //echo "Form will be reset in 3 seconds , Please enter valid inputs ";
    //header("Refresh:3");
    //exit;
  }
  
  else{
  
  //Begin the transaction and lock the table 
  $conn->begin_transaction();
   // Check if there are still places available for the session
  $sql = "SELECT places_available FROM sessions WHERE session_id = ? FOR UPDATE";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $session_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $places_available = $row["places_available"];
  if ($places_available > 0) {
  // update the place available in the DB
     $sql = "UPDATE sessions SET places_available = $places_available-1 WHERE session_id = ?";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("i", $session_id);
     $stmt->execute();
    // Book the session and update the database
    $sql = "INSERT INTO bookings (session_id, name, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $session_id, $name, $email);
    $stmt->execute();
    $conn->commit();
    echo "Booking successful!";
    
    // if booking is successful no need to store session variables
    unset($_SESSION["name"]);
    unset($_SESSION["email"]);
    
  } else {
  
   // Rollback condition below if Booking is failed.
    $conn->rollback();
    echo "Booking Unsuccessful: Please Try again";
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email;
  }
}}

// close the connection
$conn->close();



?>
   
</body>
</html>