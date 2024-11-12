<?php
// update_status.php

include '../db.php';

// Update status
$id = $_POST['id'];
$status = $_POST['status'];

// Add the current timestamp to the status_updated_at column
$sql = "UPDATE appointments SET status = '$status', updated_at = NOW() WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Status updated successfully with timestamp.";
} else {
    echo "Error updating status: " . $conn->error;
}

$conn->close();
?>
