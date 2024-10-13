<?php
include '../db.php'; // Correct the path to include db.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT id, FirstName, LastName, Age, civil_status, birth_date, birth_place, appointment_date,Service, status FROM appointments";
$result = $conn->query($query);

$data = array();

while ($row = $result->fetch_assoc()) {
    // Combine FirstName and LastName
    $row['FullName'] = $row['FirstName'] . ' ' . $row['LastName'];
    
    // Optionally, unset the individual first and last name if you no longer need them
    unset($row['FirstName']);
    unset($row['LastName']);

    // Add the modified row to the data array
    $data[] = $row;
}

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($data);
?>