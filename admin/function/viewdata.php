<?php
include '../db.php'; 

header('Content-Type: application/json'); // Set header to JSON

$id = mysqli_real_escape_string($conn, $_POST['id']); // Prevent SQL Injection

// Fetch appointment details
$appointmentQuery = "SELECT id, FirstName, MiddleName, LastName, Age, civil_status, birth_date, 
                     birth_place, Service, appointment_date 
                     FROM appointments WHERE id = '$id'";
$appointmentResult = mysqli_query($conn, $appointmentQuery);

if (!$appointmentResult) {
    echo json_encode(array("error" => "Appointment query failed: " . mysqli_error($conn)));
    exit;
}

$appointmentData = mysqli_fetch_assoc($appointmentResult);

// Fetch result details
$resultQuery = "SELECT id, bp, pr, rr, temp, fh, fht, ie, aog, lmp, edc, ob_hx, ob_score, ad, 
                address, remarks FROM result WHERE id = '$id'";
$resultResult = mysqli_query($conn, $resultQuery);

if (!$resultResult) {
    echo json_encode(array("error" => "Result query failed: " . mysqli_error($conn)));
    exit;
}

$resultData = mysqli_fetch_assoc($resultResult);

// Combine appointment and result data
$response = array(
    "appointment" => $appointmentData,
    "result" => $resultData
);

echo json_encode($response);
mysqli_close($conn);
?>
