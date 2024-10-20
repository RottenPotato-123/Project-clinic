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
$client_email = $_SESSION['email'];

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
 

  $four_days_later = date('Y-m-d', strtotime($current_date) + (86400 * 4)); // Get the date four days from now

  // Check if the appointment date is today
  if ( $appointment_date === $four_days_later) {
    
  }else{
    echo "";
    echo "<script>
        alert('Error: You can only add appointments for 4 days form now and onwards  !');
        window.location.href = 'blank.php';
      </script>";
    
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
    try {
      $mail = 
      include $_SERVER['DOCUMENT_ROOT'] . '/Project-clinic/mailer.php';
        $mail = getMailer();
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($client_email, $first_name); // Send email to client

        $mail->Subject = "Appointment Confirmation";
        $mail->Body = "
            <h1>Hello $first_name,</h1>
            <p>Your appointment for <strong>$service</strong> has been scheduled on <strong>$appointment_date</strong>.</p>
            <p>Thank you for choosing our clinic!</p>
        ";

        $mail->send();
        echo "<script>
        alert('Appointment added successfully for $appointment_date!');
        window.location.href = 'blank.php';
      </script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: Email could not be sent. {$mail->ErrorInfo}');</script>";
    } 
} else {
    echo "<scri pt>alert('Error adding appointment: " . $conn->error . "');</script>";

}
}

$conn->close();
?>