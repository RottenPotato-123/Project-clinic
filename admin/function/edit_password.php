<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE users SET Password = ? WHERE Id = ?");
    $stmt->bind_param("si", $password, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error changing password.']);
    }

    $stmt->close();
    $conn->close();
}
?>
