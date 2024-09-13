<?php
// Start the session
session_start();
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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate user input
  if (empty($_POST["appointmentNumber"])) {
    $appointmentNumberError = "Please select an appointment number";
  } else {
    $appointmentNumber = $_POST["appointmentNumber"];
  }

  if (empty($_POST["appointmentDate"])) {
    $appointmentDateError = "Please enter an appointment date";
  } else {
    $appointmentDate = $_POST["appointmentDate"];
  }

  // Check if the appointment date is valid
  if (!empty($appointmentDate)) {
    $date = DateTime::createFromFormat("Y-m-d", $appointmentDate);
    if (!$date) {
      $appointmentDateError = "Invalid appointment date";
    }
  }

  // Book the appointment if there are no errors
  if (empty($appointmentNumberError) && empty($appointmentDateError)) {
    $user_id = $_POST["user_id"];
    // Check if the database connection is working
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    bookAppointment($conn, $user_id, $appointmentNumber, $appointmentDate);
  } else {
    // Display any error messages
    echo "Error booking appointment: ";
    if (!empty($appointmentNumberError)) {
      echo $appointmentNumberError . " ";
    }
    if (!empty($appointmentDateError)) {
      echo $appointmentDateError;
    }
  }
}

// Function to book an appointment
function bookAppointment($conn, $user_id, $appointmentNumber, $appointmentDate) {
  $sql = "INSERT INTO appointments (user_id, appointment_number, appointment_date) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iis", $user_id, $appointmentNumber, $appointmentDate);
  if ($stmt->execute()) {
    echo "Appointment booked successfully!";
  } else {
    echo "Error booking appointment: " . $conn->error;
  }
  $stmt->close();
}

// Display the form
?>

<form action="appointment.php" method="post">
  <label for="appointmentNumber">Appointment Number:</label>
  <select id="appointmentNumber" name="appointmentNumber">
    <?php
    $appointmentNumbers = displayAppointmentNumbers();
    foreach ($appointmentNumbers as $number) {
      echo "<option value='$number'>$number</option>";
    }
    ?>
  </select>
  <?php if (!empty($appointmentNumberError)) { echo "<span style='color: red;'>$appointmentNumberError</span>"; } ?><br><br>
  <label for="appointmentDate">Appointment Date:</label>
  <input type="date" id="appointmentDate" name="appointmentDate">
  <?php if (!empty($appointmentDateError)) { echo "<span style='color: red;'>$appointmentDateError</span>"; } ?><br><br>
  <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
  <input type="submit" value="Book Appointment">
</form>