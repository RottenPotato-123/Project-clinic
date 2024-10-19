<?php
session_start();
include '../db.php'; 


// Query to fetch appointment data by service
$sql = "SELECT service, COUNT(*) as count FROM appointments GROUP BY service";
$result = $conn->query($sql);

$appointments = [];
if ($result->num_rows > 0) {
    // Fetch data
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($appointments);
?>
