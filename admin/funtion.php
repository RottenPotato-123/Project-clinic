<?php
session_start();
include 'db.php'; // Include your database connection file

// Database connection already established in db.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $response = ['success' => false];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM appointments WHERE Id = ?");
    $stmt->bind_param('i', $id); // 'i' indicates the type is integer

    if ($stmt->execute()) {
        $response['success'] = true; // Deletion successful
    } else {
        $response['message'] = 'Failed to delete appointment. Error: ' . $stmt->error; // Error message
    }

    // Close the statement
    $stmt->close();

    // Return JSON response
    echo json_encode($response);
} else {
    // Handle non-POST requests
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
