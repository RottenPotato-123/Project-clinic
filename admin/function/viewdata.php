<?php
include '../db.php'; 

header('Content-Type: application/json');

$id = mysqli_real_escape_string($conn, $_POST['id']);

$appointmentQuery = "SELECT id, FirstName, MiddleName, LastName, Age, civil_status, birth_date, 
                     birth_place, Service, appointment_date 
                     FROM appointments WHERE id = '$id'";
$appointmentResult = mysqli_query($conn, $appointmentQuery);

if (!$appointmentResult) {
    echo json_encode(array("error" => "Appointment query failed: " . mysqli_error($conn)));
    exit;
}

$appointmentData = mysqli_fetch_assoc($appointmentResult);

if (!$appointmentData) {
    echo json_encode(array("error" => "No appointment data found for id: $id"));
    exit;
}

// Query for result data
$resultQuery = "SELECT id, bp, pr, rr, temp, fh, fht, ie, aog, lmp, edc, ob_hx, ob_score, ad, 
                address, remarks FROM result WHERE id = '$id'";
$resultResult = mysqli_query($conn, $resultQuery);

if (!$resultResult) {
    echo json_encode(array("error" => "Result query failed: " . mysqli_error($conn)));
    exit;
}

$resultData = mysqli_fetch_assoc($resultResult);

// If resultData is empty, set it to null
if (!$resultData) {
    $resultData = null;
}

// Construct the response with appointment and result data
$response = array(
    "appointment" => $appointmentData,
    "result" => $resultData // This will be null if no result data was found
);

echo json_encode($response);
mysqli_close($conn);
?>
