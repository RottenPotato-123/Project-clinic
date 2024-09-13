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
  $appointment_date = $_POST['appointment_date'];
  $current_date = date('Y-m-d'); // Get the current date

  // Check if the appointment date is today
  if ($appointment_date !== $current_date) {
    echo "Error: You can only add appointments for today.";
    exit;
  }

  // Get the next queue number
  $sql = "SELECT MAX(queue_number) AS max_queue_number FROM appointments WHERE appointment_date = '$appointment_date'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $queue_number = $row['max_queue_number'] + 1;

  // Insert appointment
  $sql = "INSERT INTO appointments (client_id, appointment_date, queue_number) VALUES ('$client_id', '$appointment_date', '$queue_number')";
  if ($conn->query($sql) === TRUE) {
    echo "Appointment added successfully!";
  } else {
    echo "Error adding appointment: " . $conn->error;
  }
}

$conn->close();
?>