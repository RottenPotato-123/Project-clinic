<?php
require_once 'db.php';

// Start the session
session_start();

// Check if the client is logged in
if (!isset($_SESSION['user_id'])) {
  echo "Error: You must be logged in to add an appointment.";
  exit;
}

// Get the client's ID from their session
$client_id = $_SESSION['user_id'];

// Get the user type from the session or the GET parameter
$user_type = $_GET['role'] ?? (isset($_SESSION['userType']) ? $_SESSION['userType'] : null);

// Add appointment
if (isset($_POST['add_appointment'])) {
 
  $today = time();
  $first_name = $_POST['FirstName'];
  $middle_name = $_POST['MiddleName'];
  $last_name = $_POST['LastName'];
  $age = $_POST['Age'];
  $civilstatus = $_POST['civilstatus'];
  $birth_date =date("Y-m-d",strtotime( $_POST['date']));
  $birthplace = $_POST['Birthplace'];
  $service = $_POST['service'];
  $appointment_date = date("Y-m-d",strtotime($_POST['appointment_date']));
 
  $date = new DateTime();
  $appointment_date = $date->format("Y-m-d");
 

  // Get the next queue number
  $sql = "SELECT MAX(queue_number) AS max_queue_number FROM appointments WHERE appointment_date = '$appointment_date'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $queue_number = $row['max_queue_number'] + 1;

  // Insert appointment
  $sql = "INSERT INTO appointments VALUES (null, '$client_id', '$first_name', '$middle_name', '$last_name', '$age', '$address', '$service', '$appointment_date', '$queue_number', 'pending')";
  if ($conn->query($sql) === TRUE) {
    echo "<script>
    alert('Appointment added successfully for $appointment_date!');
    window.location.href = 'blank.php';
  </script>";
} else {
    echo "<script>alert('Error adding appointment: " . $conn->error . "');</script>";
}
}

$conn->close();
?>