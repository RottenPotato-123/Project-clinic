<?php
session_start();
include '../db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE user SET Email = ?, Fname = ?, Address = ?, Phone = ? WHERE Id = ?");
    $stmt->bind_param("ssssi", $email, $fname, $address, $phone, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating user.']);
    }

    $stmt->close();
    $conn->close();
}
?>
