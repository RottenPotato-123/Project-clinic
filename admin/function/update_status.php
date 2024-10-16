<?php
// update_status.php

include '../db.php';

// Update status
$id = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE appointments SET status = '$status' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Status updated successfully!";
} else {
    echo "Error updating status: " . $conn->error;
}

$conn->close();
?>