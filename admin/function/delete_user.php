<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM user WHERE Id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User removed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error removing user.']);
    }

    $stmt->close();
    $conn->close();
}
?>
