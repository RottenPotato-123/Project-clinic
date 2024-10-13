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
  $current_date = date('Y-m-d'); // Get the current date
  $tommorow = date('Y-m-d', $today + 86400 ); // Get tom
  
  // Check if the appointment date is today
  if ($appointment_date === $current_date || $appointment_date === $tommorow) {
    
  }else{
    echo "Error: You can only add appointments for today and tommorow";
    exit;
  }

  // Get the next queue number
  $sql = "SELECT MAX(queue_number) AS max_queue_number FROM appointments WHERE appointment_date = '$appointment_date'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $queue_number = $row['max_queue_number'] + 1;

  // Insert appointment
  $sql = "INSERT INTO appointments VALUES (null, '$client_id', '$first_name', '$middle_name', '$last_name', '$age', '$civilstatus','$birth_date','$birthplace', '$service', '$appointment_date', '$queue_number', 'pending')";
  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Appointment added successfully for today!');</script>";
} else {
    echo "<scri pt>alert('Error adding appointment: " . $conn->error . "');</script>";
}
}

$conn->close();
?>