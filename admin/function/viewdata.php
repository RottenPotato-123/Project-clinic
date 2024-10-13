<?php
// get_appointment_details.php

// Connect to database
include '../db.php'; 

// Retrieve appointment details
$id = $_POST['id'];
$query = "SELECT * FROM appointments WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  $appointmentData = mysqli_fetch_assoc($result);
  
  // Retrieve result data
  $query = "SELECT * FROM result WHERE id = '$id'";
  $result = mysqli_query($conn, $query);
  $resultData = mysqli_fetch_assoc($result);
  
  // Combine appointment data and result data
  $data = array(
    "appointment" => $appointmentData,
    "result" => $resultData
  );
  
  echo json_encode($data);
} else {
  echo json_encode(array("error" => "Appointment not found"));
}

mysqli_close($conn);
?>