<?php
// Connect to database
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "clinic";

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Function to display appointments
function displayAppointments($conn) {
  $sql = "SELECT * FROM appointments";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<div class='appointment'>";
      echo "<h2>" . $row["title"] . "</h2>";
      echo "<p>Start: " . $row["start_date"] . " " . $row["start_time"] . "</p>";
      echo "<p>End: " . $row["end_date"] . " " . $row["end_time"] . "</p>";
      echo "<p>" . $row["description"] . "</p>";
      echo "</div>";
    }
  } else {
    echo "No appointments scheduled.";
  }
}

// Function to add appointment
function addAppointment($conn) {
  if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $start_date = $_POST["start_date"];
    $start_time = $_POST["start_time"];
    $end_date = $_POST["end_date"];
    $end_time = $_POST["end_time"];
    $description = $_POST["description"];
    $sql = "INSERT INTO appointments (title, start_date, start_time, end_date, end_time, description) VALUES ('$title', '$start_date', '$start_time', '$end_date', '$end_time', '$description')";
    if ($conn->query($sql) === TRUE) {
      echo "Appointment added successfully!";
    } else {
      echo "Error adding appointment: " . $conn->error;
    }
  }
}

// Display appointments
displayAppointments($conn);

// Add appointment form
echo "<h2>Add Appointment</h2>";
echo "<form action='' method='post'>";
echo "<label for='title'>Title:</label>";
echo "<input type='text' id='title' name='title'><br><br>";
echo "<label for='start_date'>Start Date:</label>";
echo "<input type='date' id='start_date' name='start_date'><br><br>";
echo "<label for='start_time'>Start Time:</label>";
echo "<input type='time' id='start_time' name='start_time'><br><br>";
echo "<label for='end_date'>End Date:</label>";
echo "<input type='date' id='end_date' name='end_date'><br><br>";
echo "<label for='end_time'>End Time:</label>";
echo "<input type='time' id='end_time' name='end_time'><br><br>";
echo "<label for='description'>Description:</label>";
echo "<textarea id='description' name='description'></textarea><br><br>";
echo "<input type='submit' name='submit' value='Add Appointment'>";
echo "</form>";

// Close connection
$conn->close();
?>