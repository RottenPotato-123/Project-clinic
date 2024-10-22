<?php
session_start();
include '../db.php'; // Ensure this file contains a valid DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    if (empty($_POST['user_id']) || empty($_POST['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'User ID and password are required.']);
        exit;
    }

    $user_id = (int) $_POST['user_id']; // Cast to integer for extra safety
    $password = $_POST['password'];

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE user SET Password = ? WHERE Id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'SQL error: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("si", $hashedPassword, $user_id);

    // Execute the query and handle the result
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error changing password: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
